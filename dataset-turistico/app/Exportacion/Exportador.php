<?php

namespace App\Exportacion;

use App\Http\Presentadores\AtomoPresentador;
use App\Http\Presentadores\EventoPresentador;
use App\Models\Atomo;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Origen;
use App\Support\VersionDataset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use XMLWriter;

/**
 * Genera los archivos descargables del dataset. El contenido se guarda en
 * caché por versión del dataset, así que se regenera solo al editar datos.
 */
class Exportador
{
    public const ARCHIVOS = [
        'DataSetA.xml' => ['metodo' => 'xml', 'mime' => 'application/xml; charset=UTF-8',
            'descripcion' => 'XML: habitual para intercambio de datos entre sistemas (PHP, Java).'],
        'DataSetB.json' => ['metodo' => 'json', 'mime' => 'application/json; charset=UTF-8',
            'descripcion' => 'JSON: el formato natural para JavaScript y aplicaciones web o móviles.'],
        'DataSetC.csv' => ['metodo' => 'csv', 'mime' => 'text/csv; charset=UTF-8',
            'descripcion' => 'CSV separado por punto y coma: se abre directo en Excel u hojas de cálculo.'],
        'DataSet.geojson' => ['metodo' => 'geojson', 'mime' => 'application/geo+json; charset=UTF-8',
            'descripcion' => 'GeoJSON: listo para Leaflet, QGIS, Google Earth y cualquier SIG.'],
    ];

    public function contenido(string $archivo): string
    {
        $metodo = self::ARCHIVOS[$archivo]['metodo'];

        return Cache::rememberForever(
            "exportacion:{$archivo}:".VersionDataset::actual(),
            fn () => $this->{$metodo}()
        );
    }

    private function atomos(): Collection
    {
        return Atomo::query()->with(AtomoPresentador::RELACIONES_COMPLETAS)->orderBy('id')->get();
    }

    private function eventos(): Collection
    {
        return Evento::query()->with(EventoPresentador::RELACIONES)->orderBy('id')->get();
    }

    private function meta(): array
    {
        return [
            'nombre' => 'Conjunto de datos turísticos del Estado de Chiapas',
            'version' => VersionDataset::actual(),
            'generado' => now()->toIso8601String(),
            'fuente' => config('app.url'),
            'licencia' => 'Uso público sin fines de lucro. Cite la fuente: Instituto Tecnológico de Tuxtla Gutiérrez.',
        ];
    }

    private function json(): string
    {
        $atomos = $this->atomos();
        $eventos = $this->eventos();

        return json_encode([
            'meta' => $this->meta() + ['total_atomos' => $atomos->count(), 'total_eventos' => $eventos->count()],
            'categorias' => Categoria::with('subcategorias')->orderBy('orden')->get()->map(fn ($c) => [
                'id' => $c->id, 'slug' => $c->slug, 'nombre' => $c->nombre, 'color' => $c->color, 'icono' => $c->icono,
                'subcategorias' => $c->subcategorias->map(fn ($s) => ['id' => $s->id, 'slug' => $s->slug, 'nombre' => $s->nombre])->values(),
            ]),
            'origenes' => Origen::orderBy('id')->get(['id', 'slug', 'nombre', 'descripcion']),
            'atomos' => $atomos->map(fn ($a) => AtomoPresentador::completo($a))->values(),
            'eventos' => $eventos->map(fn ($e) => EventoPresentador::completo($e))->values(),
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function geojson(): string
    {
        return json_encode([
            'type' => 'FeatureCollection',
            'metadata' => $this->meta(),
            'features' => $this->atomos()
                ->filter(fn (Atomo $a) => $a->tieneCoordenadas())
                ->map(function (Atomo $a) {
                    $feature = AtomoPresentador::geojson($a);
                    $feature['properties'] += [
                        'activo' => $a->activo,
                        'descripcion' => $a->descripcion,
                        'localizacion' => $a->localizacion,
                        'como_llegar' => $a->como_llegar,
                        'fotos' => $a->fotos->map->url()->values(),
                    ];

                    return $feature;
                })
                ->values(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function csv(): string
    {
        $salida = fopen('php://temp', 'w+');
        fwrite($salida, "\xEF\xBB\xBF");

        fputcsv($salida, [
            'id', 'slug', 'nombre', 'activo', 'origen_id', 'origen', 'numero_original', 'latitud', 'longitud',
            'c1', 'c2', 'categorias', 'subcategorias', 'descripcion', 'localizacion', 'como_llegar',
            'actividades', 'fotos',
        ], ';');

        foreach ($this->atomos() as $a) {
            fputcsv($salida, [
                $a->id, $a->slug, $a->nombre, $a->activo ? 1 : 0, $a->origen_id, $a->origen?->nombre,
                $a->numero_original, $a->latitud, $a->longitud,
                $a->categorias->pluck('id')->implode(','),
                $a->subcategorias->pluck('id')->implode(','),
                $a->categorias->pluck('nombre')->implode(' | '),
                $a->subcategorias->pluck('nombre')->implode(' | '),
                $a->descripcion, $a->localizacion, $a->como_llegar,
                $a->actividades->pluck('descripcion')->implode(' | '),
                $a->fotos->map->url()->implode(' | '),
            ], ';');
        }

        rewind($salida);
        $csv = stream_get_contents($salida);
        fclose($salida);

        return $csv;
    }

    private function xml(): string
    {
        $x = new XMLWriter;
        $x->openMemory();
        $x->setIndent(true);
        $x->setIndentString('  ');
        $x->startDocument('1.0', 'UTF-8');

        $x->startElement('dataset');
        foreach ($this->meta() as $clave => $valor) {
            $x->writeAttribute($clave, (string) $valor);
        }

        $x->startElement('atomos');
        foreach ($this->atomos() as $a) {
            $x->startElement('atomo');
            $x->writeAttribute('id', (string) $a->id);
            $x->writeAttribute('slug', $a->slug);
            $x->writeAttribute('activo', $a->activo ? '1' : '0');
            $x->writeElement('nombre', $a->nombre);
            $x->startElement('origen');
            $x->writeAttribute('id', (string) $a->origen_id);
            $x->writeAttribute('numero_original', (string) $a->numero_original);
            $x->text((string) $a->origen?->nombre);
            $x->endElement();
            if ($a->tieneCoordenadas()) {
                $x->startElement('coordenadas');
                $x->writeAttribute('latitud', (string) $a->latitud);
                $x->writeAttribute('longitud', (string) $a->longitud);
                $x->endElement();
            }
            $x->writeElement('descripcion', (string) $a->descripcion);
            $x->writeElement('localizacion', (string) $a->localizacion);
            $x->writeElement('como_llegar', (string) $a->como_llegar);

            $x->startElement('categorias');
            foreach ($a->categorias as $c) {
                $x->startElement('categoria');
                $x->writeAttribute('id', (string) $c->id);
                $x->text($c->nombre);
                $x->endElement();
            }
            $x->endElement();

            $x->startElement('subcategorias');
            foreach ($a->subcategorias as $s) {
                $x->startElement('subcategoria');
                $x->writeAttribute('id', (string) $s->id);
                $x->writeAttribute('categoria_id', (string) $s->categoria_id);
                $x->text($s->nombre);
                $x->endElement();
            }
            $x->endElement();

            $x->startElement('actividades');
            foreach ($a->actividades as $actividad) {
                $x->writeElement('actividad', $actividad->descripcion);
            }
            $x->endElement();

            $x->startElement('fotos');
            foreach ($a->fotos as $foto) {
                $x->startElement('foto');
                $x->writeAttribute('miniatura', $foto->urlMiniatura());
                $x->text($foto->url());
                $x->endElement();
            }
            $x->endElement();

            $x->endElement();
        }
        $x->endElement();

        $x->startElement('eventos');
        foreach ($this->eventos() as $e) {
            $x->startElement('evento');
            $x->writeAttribute('id', (string) $e->id);
            $x->writeAttribute('slug', $e->slug);
            $x->writeAttribute('fecha', (string) $e->fecha?->toDateString());
            $x->writeElement('nombre', $e->nombre);
            if ($e->latitud !== null) {
                $x->startElement('coordenadas');
                $x->writeAttribute('latitud', (string) $e->latitud);
                $x->writeAttribute('longitud', (string) $e->longitud);
                $x->endElement();
            }
            $x->writeElement('descripcion', (string) $e->descripcion);
            $x->writeElement('localizacion', (string) $e->localizacion);
            $x->writeElement('como_llegar', (string) $e->como_llegar);
            $x->writeElement('actividades', (string) $e->actividades);
            $x->startElement('fotos');
            foreach ($e->fotos as $foto) {
                $x->startElement('foto');
                $x->writeAttribute('miniatura', $foto->urlMiniatura());
                $x->text($foto->url());
                $x->endElement();
            }
            $x->endElement();
            $x->endElement();
        }
        $x->endElement();

        $x->endElement();
        $x->endDocument();

        return $x->outputMemory();
    }
}
