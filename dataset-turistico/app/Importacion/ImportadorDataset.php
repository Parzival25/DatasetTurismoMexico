<?php

namespace App\Importacion;

use App\Models\Actividad;
use App\Models\Atomo;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Foto;
use App\Models\Origen;
use App\Models\Subcategoria;
use App\Support\Catalogo;
use App\Support\Geo;
use App\Support\Imagenes;
use App\Support\Texto;
use Carbon\CarbonImmutable;
use FilesystemIterator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SimpleXMLElement;
use Throwable;

/**
 * Reconstruye por completo el dataset a partir de las fuentes del Prototipo 1.
 */
class ImportadorDataset
{
    private Reporte $reporte;

    private RestauradorAcentos $acentos;

    private string $legado;

    /** @var array<string, true> */
    private array $slugs = [];

    /** @var array<int, array<string, list<string>>> índice de imágenes por origen */
    private array $indiceImagenes = [];

    /** @var array<int, true> */
    private array $idsUsados = [];

    private int $idMaximoXml = 0;

    /** @var array<int, int> subcategoria_id => categoria_id */
    private array $categoriaDeSubcategoria = [];

    /** @var (callable(string, int, int): void)|null */
    private $progreso;

    public function __construct(private bool $conFotos = true)
    {
    }

    /**
     * @param  (callable(string $etapa, int $actual, int $total): void)|null  $progreso
     */
    public function importar(?callable $progreso = null): Reporte
    {
        $this->progreso = $progreso;
        $this->reporte = new Reporte;
        $this->slugs = [];

        $xml = config('dataset.fuente_xml');
        if (! is_file($xml)) {
            throw new RuntimeException("No se encontró el XML fuente: {$xml}");
        }

        $this->legado = realpath(config('dataset.fuente_legado')) ?: '';
        if ($this->legado === '') {
            $this->reporte->aviso('general', null, '', 'No se encontró la carpeta del Prototipo 1: sin fotos, eventos ni restauración de acentos.');
        }

        $this->avisar('Construyendo diccionario de acentos', 0, 1);
        $this->acentos = RestauradorAcentos::desdeCorpus($this->legado);
        $this->reporte->sumar('palabras_en_diccionario', count($this->acentos->diccionario()));

        DB::transaction(function () use ($xml) {
            $this->vaciar();
            $this->importarCatalogo();
            $this->importarAtomos($xml);
            $this->importarEventos();
        });

        $this->detectarDuplicados();
        $this->reporte->guardar();

        return $this->reporte;
    }

    private function vaciar(): void
    {
        foreach (['fotos', 'evento_subcategoria', 'eventos', 'actividades', 'atomo_subcategoria',
            'atomo_categoria', 'atomos', 'subcategorias', 'categorias', 'origenes'] as $tabla) {
            DB::table($tabla)->delete();
        }

        if ($this->conFotos) {
            Storage::disk('fotos')->deleteDirectory('atomos');
            Storage::disk('fotos')->deleteDirectory('eventos');
        }
    }

    private function importarCatalogo(): void
    {
        foreach (Catalogo::origenes() as $id => $origen) {
            Origen::create($origen + ['id' => $id, 'carpeta_legado' => config("dataset.carpetas_origen.{$id}")]);
        }

        $orden = 1;
        foreach (Catalogo::categorias() as $id => $categoria) {
            Categoria::create($categoria + ['id' => $id, 'orden' => $orden++]);
        }

        $slugs = [];
        foreach (Catalogo::subcategorias() as $id => [$categoriaId, $nombre]) {
            Subcategoria::create([
                'id' => $id,
                'categoria_id' => $categoriaId,
                'nombre' => $nombre,
                'slug' => Texto::slugUnico($nombre, $slugs),
            ]);
            $this->categoriaDeSubcategoria[$id] = $categoriaId;
        }
    }

    private function importarAtomos(string $rutaXml): void
    {
        $xml = new SimpleXMLElement(file_get_contents($rutaXml));
        $total = count($xml->Atomo);
        $i = 0;
        $this->idsUsados = [];
        $this->idMaximoXml = 0;
        foreach ($xml->Atomo as $nodo) {
            $this->idMaximoXml = max($this->idMaximoXml, (int) $nodo['id']);
        }

        foreach ($xml->Atomo as $nodo) {
            $datos = [];
            foreach ($nodo->attributes() as $clave => $valor) {
                $datos[rtrim($clave, '-')] = (string) $valor;
            }

            $this->importarAtomo($datos);
            $this->avisar('Importando átomos', ++$i, $total);
        }

        $this->reporte->sumar('atomos', $i);
    }

    /**
     * @param  array<string, string>  $d
     */
    private function importarAtomo(array $d): void
    {
        $id = (int) $d['id'];
        $origenId = (int) $d['Origen'] ?: null;
        $nombre = $this->limpiarNombre($d['Nombre'] ?? '');

        if ($id < 1 || isset($this->idsUsados[$id])) {
            $nuevo = max($this->idMaximoXml, ...array_keys($this->idsUsados)) + 1;
            $this->reporte->aviso('atomo', $nuevo, $nombre, "El id {$id} del XML ya estaba en uso; se asignó el id {$nuevo}.");
            $id = $nuevo;
        }
        $this->idsUsados[$id] = true;

        [$lat, $lng] = $this->validarCoordenadas('atomo', $id, $nombre, $d['Latitud'] ?? '', $d['Longitud'] ?? '');

        $atomo = new Atomo([
            'id' => $id,
            'slug' => Texto::slugUnico($nombre, $this->slugs, Catalogo::origenes()[$origenId]['slug'] ?? null),
            'nombre' => $nombre,
            'descripcion' => $this->textoLargo($d['Descripcion'] ?? ''),
            'localizacion' => $this->textoLargo($d['Localizacion'] ?? ''),
            'como_llegar' => $this->textoLargo($d['ComoLLegar'] ?? ''),
            'latitud' => $lat,
            'longitud' => $lng,
            'activo' => true,
            'origen_id' => $origenId,
            'numero_original' => (int) ($d['NumOriginal'] ?? 0) ?: null,
            'legado_activo' => $d['Activo'] ?? null,
        ]);
        $atomo->save();

        [$categorias, $subcategorias] = $this->clasificacion($atomo, $d['C1'] ?? '', $d['C2'] ?? '');
        $atomo->categorias()->sync($categorias);
        $atomo->subcategorias()->sync($subcategorias);

        // Los campos de foto a veces traen actividades por columnas recorridas.
        $actividades = [];
        $fotos = [];
        for ($n = 1; $n <= 6; $n++) {
            if (isset($d["Actividad{$n}"])) {
                $actividades[] = $d["Actividad{$n}"];
            }

            $valor = trim(str_replace(['&quot;', '"'], '', $d["Foto{$n}"] ?? ''));
            if ($valor === '') {
                continue;
            }

            // Algunas rutas quedaron truncadas en el XML ("../fotos/a9904.jp").
            if (preg_match('/\.jp$/i', $valor)) {
                $valor .= 'g';
            }

            if (preg_match('/\.(jpe?g|png|gif|bmp|webp)$/i', $valor)) {
                $fotos[] = $valor;
            } else {
                $actividades[] = $valor;
                $this->reporte->info('atomo', $id, $nombre, "Texto en el campo Foto{$n} movido a actividades: \"{$valor}\"");
            }
        }

        $orden = 1;
        foreach ($actividades as $actividad) {
            $texto = $this->limpiarActividad($actividad);
            if ($texto !== null) {
                Actividad::create(['atomo_id' => $id, 'descripcion' => $texto, 'orden' => $orden++]);
            }
        }

        if (! $atomo->descripcion) {
            $this->reporte->aviso('atomo', $id, $nombre, 'Sin descripción.');
        }

        if ($this->conFotos) {
            $this->importarFotosAtomo($atomo, $fotos);
        }
    }

    /**
     * @return array{0: list<int>, 1: list<int>}
     */
    private function clasificacion(Atomo $atomo, string $c1, string $c2): array
    {
        $categorias = [];
        foreach (preg_split('/\D+/', $c1, -1, PREG_SPLIT_NO_EMPTY) as $codigo) {
            $codigo = (int) $codigo;
            if ($codigo >= 1 && $codigo <= 7) {
                $categorias[$codigo] = $codigo;
            } else {
                $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre, "Código C1 desconocido: {$codigo}");
            }
        }

        $equivalencias = Catalogo::equivalenciasLegado()[$atomo->origen_id] ?? [];
        $subcategorias = [];

        foreach (preg_split('/\D+/', $c2, -1, PREG_SPLIT_NO_EMPTY) as $token) {
            $codigo = (int) $token;

            if ($codigo >= 124 && $codigo <= 129) {
                if (isset($equivalencias[$codigo])) {
                    $subcategorias[] = $equivalencias[$codigo];
                } else {
                    $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre,
                        "Código C2 {$codigo} sin significado conocido para este origen; se omitió.");
                }
                continue;
            }

            if ($codigo <= 123 && isset($this->categoriaDeSubcategoria[$codigo])) {
                $subcategorias[] = $codigo;
                continue;
            }

            $division = $this->dividirCodigoPegado($token, $categorias);
            if ($division) {
                array_push($subcategorias, ...$division);
                $this->reporte->info('atomo', $atomo->id, $atomo->nombre,
                    "Código C2 \"{$token}\" separado como ".implode(', ', $division).'.');
            } else {
                $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre, "Código C2 no reconocido: {$token}");
            }
        }

        $subcategorias = array_values(array_unique($subcategorias));

        // Toda subcategoría implica su categoría C1.
        foreach ($subcategorias as $subcategoria) {
            $categoria = $this->categoriaDeSubcategoria[$subcategoria];
            if (! isset($categorias[$categoria])) {
                $categorias[$categoria] = $categoria;
                $this->reporte->info('atomo', $atomo->id, $atomo->nombre,
                    "Se agregó la categoría C1 {$categoria} implicada por la subcategoría {$subcategoria}.");
            }
        }

        if (! $categorias) {
            $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre, 'Sin clasificación C1 ni C2.');
        }

        ksort($categorias);

        return [array_values($categorias), $subcategorias];
    }

    /**
     * Separa códigos que perdieron la coma ("62108" => 62, 108) eligiendo la
     * única división cuyas categorías coinciden con las C1 del átomo.
     *
     * @param  array<int, int>  $categorias
     * @return list<int>|null
     */
    private function dividirCodigoPegado(string $token, array $categorias): ?array
    {
        $validas = array_filter(
            $this->divisiones($token),
            fn ($partes) => count($partes) > 1
                && count(array_unique($partes)) === count($partes)
                && (! $categorias || collect($partes)->every(
                    fn ($p) => isset($categorias[$this->categoriaDeSubcategoria[$p]])
                ))
        );

        if (! $validas) {
            return null;
        }

        // Se prefiere la división con menos partes (3112 => 3, 112 y no 3, 1, 1, 2).
        $minimo = min(array_map('count', $validas));
        $validas = array_values(array_filter($validas, fn ($partes) => count($partes) === $minimo));

        return count($validas) === 1 ? $validas[0] : null;
    }

    /**
     * @return list<list<int>>
     */
    private function divisiones(string $cadena): array
    {
        if ($cadena === '') {
            return [[]];
        }

        $resultado = [];
        for ($largo = 1; $largo <= min(3, strlen($cadena)); $largo++) {
            $parte = substr($cadena, 0, $largo);
            if ($parte[0] === '0' || ! isset($this->categoriaDeSubcategoria[(int) $parte]) || (int) $parte > 123) {
                continue;
            }
            foreach ($this->divisiones(substr($cadena, $largo)) as $resto) {
                $resultado[] = [(int) $parte, ...$resto];
            }
        }

        return array_values(array_filter($resultado, fn ($r) => count($r) > 1 || strlen($cadena) <= 3));
    }

    /**
     * @return array{0: float|null, 1: float|null}
     */
    private function validarCoordenadas(string $tipo, int $id, string $nombre, string $latTexto, string $lngTexto): array
    {
        $lat = is_numeric($latTexto) ? (float) $latTexto : null;
        $lng = is_numeric($lngTexto) ? (float) $lngTexto : null;

        if (! $lat || ! $lng) {
            $this->reporte->aviso($tipo, $id, $nombre, 'Sin coordenadas.');

            return [null, null];
        }

        if (Geo::dentroDeChiapas($lat, $lng)) {
            return [$lat, $lng];
        }

        foreach ([[$lat, -abs($lng)], [$lng, $lat], [$lng, -abs($lat)]] as [$la, $ln]) {
            if (Geo::dentroDeChiapas($la, $ln)) {
                $this->reporte->info($tipo, $id, $nombre, "Coordenadas corregidas de ({$lat}, {$lng}) a ({$la}, {$ln}).");

                return [$la, $ln];
            }
        }

        $this->reporte->aviso($tipo, $id, $nombre, "Coordenadas fuera de Chiapas ({$lat}, {$lng}); se dejaron vacías para capturarlas de nuevo.");

        return [null, null];
    }

    /**
     * @param  list<string>  $rutas
     */
    private function importarFotosAtomo(Atomo $atomo, array $rutas): void
    {
        $carpeta = $this->carpetaOrigen($atomo->origen_id);
        $archivos = [];

        foreach ($rutas as $ruta) {
            $archivo = $this->resolverImagen($atomo->origen_id, $carpeta, $ruta);
            if ($archivo) {
                $archivos[] = [$archivo, $ruta];
            } else {
                $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre, "Foto no encontrada: {$ruta}");
                $this->reporte->sumar('fotos_no_encontradas');
            }
        }

        // Si el XML no trae fotos, se intenta con las imágenes de la ficha HTML.
        if (! $archivos && $carpeta && $atomo->numero_original) {
            $ficha = LectorLegado::leerFicha("{$carpeta}/{$atomo->numero_original}.html");
            foreach ($ficha['imagenes'] ?? [] as $ruta) {
                if (preg_match('#(fotos|multimedia)/#i', $ruta) && ($archivo = $this->resolverImagen($atomo->origen_id, $carpeta, $ruta))) {
                    $archivos[] = [$archivo, $ruta];
                }
            }
            if ($archivos) {
                $this->reporte->info('atomo', $atomo->id, $atomo->nombre, 'Fotos tomadas de la ficha HTML original ('.count($archivos).').');
            }
        }

        $this->guardarFotos($atomo, 'atomos', $archivos);

        if (! $atomo->fotos()->exists()) {
            $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre, 'Sin fotos.');
        }
    }

    /**
     * @param  list<array{0: string, 1: string}>  $archivos  [ruta absoluta, ruta original]
     */
    private function guardarFotos(Atomo|Evento $modelo, string $carpeta, array $archivos): void
    {
        $vistas = [];
        $orden = 1;
        $disco = Storage::disk('fotos');

        foreach ($archivos as [$archivo, $original]) {
            $huella = md5_file($archivo);
            if (isset($vistas[$huella])) {
                continue;
            }
            $vistas[$huella] = true;

            $nombre = str_pad((string) $orden, 2, '0', STR_PAD_LEFT).'.jpg';
            $ruta = "{$carpeta}/{$modelo->id}/{$nombre}";
            $miniatura = "{$carpeta}/{$modelo->id}/mini/{$nombre}";

            try {
                $info = Imagenes::procesar($archivo, $disco->path($ruta), $disco->path($miniatura));
            } catch (Throwable $e) {
                $this->reporte->aviso($carpeta === 'atomos' ? 'atomo' : 'evento', $modelo->id, $modelo->nombre,
                    "Foto dañada u omitida ({$original}): {$e->getMessage()}");

                continue;
            }

            $modelo->fotos()->create([
                'ruta' => $ruta,
                'ruta_miniatura' => $miniatura,
                'mime' => $info['mime'],
                'ancho' => $info['ancho'],
                'alto' => $info['alto'],
                'bytes' => $info['bytes'],
                'orden' => $orden++,
                'archivo_original' => Str::after(str_replace('\\', '/', $archivo), str_replace('\\', '/', $this->legado).'/'),
            ]);

            $this->reporte->sumar('fotos');
        }
    }

    private function resolverImagen(?int $origenId, ?string $carpeta, string $ruta): ?string
    {
        if (! $carpeta) {
            return null;
        }

        $ruta = str_replace('\\', '/', $ruta);
        $candidatas = ["{$carpeta}/{$ruta}"];
        if (str_starts_with($ruta, './')) {
            $candidatas[] = "{$carpeta}/.{$ruta}";
        }

        foreach ($candidatas as $candidata) {
            if (is_file($candidata)) {
                return realpath($candidata);
            }
        }

        // Último recurso: buscar el nombre del archivo dentro del subproyecto.
        $coincidencias = $this->indiceImagenes($origenId)[strtolower(basename($ruta))] ?? [];
        if ($coincidencias) {
            usort($coincidencias, fn ($a, $b) => (int) ! str_contains(strtolower($a), 'fotos') <=> (int) ! str_contains(strtolower($b), 'fotos'));

            return $coincidencias[0];
        }

        return null;
    }

    /**
     * @return array<string, list<string>>
     */
    private function indiceImagenes(?int $origenId): array
    {
        if (isset($this->indiceImagenes[$origenId])) {
            return $this->indiceImagenes[$origenId];
        }

        $indice = [];
        $carpeta = $this->carpetaOrigen($origenId);
        $raiz = $carpeta ? dirname($carpeta) : null;

        if ($raiz && is_dir($raiz)) {
            // El origen 1 vive en la raíz de turismo_chiapas: solo se indexa su carpeta de fotos.
            $raiz = $origenId === 1 ? "{$raiz}/fotos" : $raiz;
            $iterador = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($raiz, FilesystemIterator::SKIP_DOTS));
            foreach ($iterador as $archivo) {
                if (preg_match('/\.(jpe?g|png|gif|bmp|webp)$/i', $archivo->getFilename())) {
                    $indice[strtolower($archivo->getFilename())][] = $archivo->getPathname();
                }
            }
        }

        return $this->indiceImagenes[$origenId] = $indice;
    }

    private function carpetaOrigen(?int $origenId): ?string
    {
        $relativa = config("dataset.carpetas_origen.{$origenId}");

        return ($this->legado && $relativa) ? $this->legado.'/'.$relativa : null;
    }

    private function importarEventos(): void
    {
        $archivoSql = $this->legado ? $this->legado.'/'.config('dataset.eventos_sql') : null;

        if (! $archivoSql || ! is_file($archivoSql)) {
            $this->reporte->aviso('general', null, '', 'No se encontró el volcado SQL de átomos temporales; no se importaron eventos.');

            return;
        }

        $filas = LectorLegado::leerInsertsSql(LectorLegado::leerTexto($archivoSql), 'atomos_temporales');
        $carpeta = $this->legado.'/'.config('dataset.eventos_carpeta');
        $slugs = [];
        $i = 0;

        foreach ($filas as $fila) {
            $id = (int) $fila['AT_ID'];
            $ficha = LectorLegado::leerFicha("{$carpeta}/at{$id}.html");
            $secciones = $ficha['secciones'] ?? [];
            $nombre = $this->limpiarNombre($fila['AT_NOMBRE']);

            [$lat, $lng] = $this->validarCoordenadas('evento', $id, $nombre, (string) $fila['AT_LATITUD'], (string) $fila['AT_LONGITUD']);

            $fecha = null;
            try {
                $fecha = $fila['AT_FECHA'] && $fila['AT_FECHA'] !== '0000-00-00' ? CarbonImmutable::parse($fila['AT_FECHA']) : null;
            } catch (Throwable) {
                $this->reporte->aviso('evento', $id, $nombre, "Fecha inválida: {$fila['AT_FECHA']}");
            }

            $evento = Evento::create([
                'id' => $id,
                'slug' => Texto::slugUnico($nombre, $slugs),
                'nombre' => $nombre,
                'descripcion' => $this->textoLargo($secciones[0] ?? $fila['AT_DESCRIPCION'] ?? ''),
                'localizacion' => $this->textoLargo($secciones[1] ?? ''),
                'como_llegar' => $this->textoLargo($secciones[2] ?? $fila['AT_COMO_LLEGAR'] ?? ''),
                'actividades' => $this->textoLargo($secciones[3] ?? $fila['AT_ACTIVIDADES'] ?? ''),
                'latitud' => $lat,
                'longitud' => $lng,
                'fecha' => $fecha,
                'periodo' => Texto::limpiar($fila['AT_PERIODO'] ?? '') ?: null,
                'recurrente' => true,
                'activo' => true,
            ]);

            $subcategorias = array_values(array_filter(
                array_map('intval', preg_split('/\D+/', (string) $fila['AT_C2'], -1, PREG_SPLIT_NO_EMPTY)),
                fn ($c) => isset($this->categoriaDeSubcategoria[$c])
            ));
            $evento->subcategorias()->sync($subcategorias);

            if (! $ficha) {
                $this->reporte->aviso('evento', $id, $nombre, 'Sin ficha HTML: el evento no tiene descripción.');
            }

            if ($this->conFotos && $ficha) {
                $archivos = [];
                foreach ($ficha['imagenes'] as $ruta) {
                    $archivo = "{$carpeta}/{$ruta}";
                    if (is_file($archivo)) {
                        $archivos[] = [realpath($archivo), $ruta];
                    }
                }
                $this->guardarFotos($evento, 'eventos', $archivos);
            }

            $this->avisar('Importando eventos', ++$i, count($filas));
        }

        $this->reporte->sumar('eventos', $i);
    }

    private function detectarDuplicados(): void
    {
        $atomos = Atomo::query()->get(['id', 'nombre', 'latitud', 'longitud', 'origen_id']);

        // Mismo nombre a menos de 5 km: probablemente el mismo lugar capturado
        // por dos subproyectos. Nombres genéricos en pueblos distintos no cuentan.
        foreach ($atomos->groupBy(fn ($a) => Texto::normalizar($a->nombre)) as $grupo) {
            foreach ($grupo as $atomo) {
                $otros = $grupo->filter(fn ($otro) => $otro->id !== $atomo->id && (
                    ! $atomo->latitud || ! $otro->latitud
                    || Geo::distanciaKm($atomo->latitud, $atomo->longitud, $otro->latitud, $otro->longitud) < 5
                ));
                if ($otros->isNotEmpty() && $atomo->id < $otros->min('id')) {
                    $this->reporte->aviso('atomo', $atomo->id, $atomo->nombre,
                        'Posible duplicado (mismo nombre y cercano) de: '.$otros->pluck('id')->implode(', '));
                }
            }
        }

        $conCoordenadas = $atomos->filter(fn ($a) => $a->latitud && $a->longitud)->values();
        // Solo pares con nombres distintos: los de mismo nombre ya se reportaron arriba.
        foreach ($conCoordenadas as $i => $a) {
            foreach ($conCoordenadas->slice($i + 1) as $b) {
                if (Texto::normalizar($a->nombre) !== Texto::normalizar($b->nombre)
                    && Geo::distanciaKm($a->latitud, $a->longitud, $b->latitud, $b->longitud) < 0.02) {
                    $this->reporte->aviso('atomo', $a->id, $a->nombre, "Mismas coordenadas que el átomo {$b->id} ({$b->nombre}).");
                }
            }
        }
    }

    private function limpiarNombre(string $nombre): string
    {
        $nombre = rtrim(Texto::limpiar($this->acentos->restaurar($nombre)), '.');

        return $nombre === '' ? 'Sin nombre' : mb_strtoupper(mb_substr($nombre, 0, 1)).mb_substr($nombre, 1);
    }

    private function textoLargo(?string $texto): ?string
    {
        $texto = Texto::limpiar($this->acentos->restaurar((string) $texto));

        return $texto === '' ? null : $texto;
    }

    private function limpiarActividad(string $texto): ?string
    {
        $texto = Texto::limpiar($this->acentos->restaurar($texto));
        $texto = trim(preg_replace('/^[\s*\-•·]+/u', '', $texto));
        $texto = rtrim($texto, " .;,");

        if (mb_strlen($texto) < 2) {
            return null;
        }

        return mb_strtoupper(mb_substr($texto, 0, 1)).mb_substr($texto, 1);
    }

    private function avisar(string $etapa, int $actual, int $total): void
    {
        if ($this->progreso) {
            ($this->progreso)($etapa, $actual, $total);
        }
    }
}
