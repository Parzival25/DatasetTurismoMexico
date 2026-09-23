<?php

namespace App\Support;

use App\Models\Categoria;
use App\Models\Origen;
use App\Models\Subcategoria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Filtros comunes para listar átomos (API, mapa y portal).
 *
 *   activo=1|0|todos           por omisión solo activos
 *   categoria=1,3 | slug       C1 (cualquiera de las indicadas)
 *   subcategoria=42 | slug     C2 (cualquiera de las indicadas)
 *   origen=5 | san-cristobal   proyecto de origen
 *   q=texto                    búsqueda sin importar acentos
 *   bbox=lng1,lat1,lng2,lat2   caja geográfica
 *   con_fotos=1                solo átomos con al menos una foto
 */
class ConsultaAtomos
{
    public static function aplicar(Builder $consulta, Request $request): Builder
    {
        $activo = $request->query('activo', '1');
        if ($activo !== 'todos') {
            $consulta->where('activo', filter_var($activo, FILTER_VALIDATE_BOOLEAN));
        }

        if ($valor = $request->query('categoria')) {
            $ids = self::resolver(Categoria::class, $valor, 'categoria');
            $consulta->whereHas('categorias', fn ($q) => $q->whereIn('categorias.id', $ids));
        }

        if ($valor = $request->query('subcategoria')) {
            $ids = self::resolver(Subcategoria::class, $valor, 'subcategoria');
            $consulta->whereHas('subcategorias', fn ($q) => $q->whereIn('subcategorias.id', $ids));
        }

        if ($valor = $request->query('origen')) {
            $consulta->whereIn('origen_id', self::resolver(Origen::class, $valor, 'origen'));
        }

        if ($texto = trim((string) $request->query('q'))) {
            foreach (explode(' ', Texto::normalizar($texto)) as $termino) {
                $consulta->where('busqueda', 'like', '%'.addcslashes($termino, '%_\\').'%');
            }
        }

        if ($bbox = $request->query('bbox')) {
            $partes = array_map('trim', explode(',', $bbox));
            if (count($partes) !== 4 || array_filter($partes, fn ($p) => ! is_numeric($p))) {
                throw ValidationException::withMessages(['bbox' => 'Formato esperado: lng_min,lat_min,lng_max,lat_max']);
            }
            [$lngMin, $latMin, $lngMax, $latMax] = array_map('floatval', $partes);
            $consulta->whereBetween('latitud', [min($latMin, $latMax), max($latMin, $latMax)])
                ->whereBetween('longitud', [min($lngMin, $lngMax), max($lngMin, $lngMax)]);
        }

        if ($request->boolean('con_fotos')) {
            $consulta->has('fotos');
        }

        return $consulta;
    }

    /**
     * Interpreta "cerca=lat,lng" y "radio" (km).
     *
     * @return array{lat: float, lng: float, radio: float}|null
     */
    public static function cerca(Request $request): ?array
    {
        $cerca = $request->query('cerca');
        if (! $cerca) {
            return null;
        }

        $partes = array_map('trim', explode(',', $cerca));
        if (count($partes) !== 2 || ! is_numeric($partes[0]) || ! is_numeric($partes[1])) {
            throw ValidationException::withMessages(['cerca' => 'Formato esperado: latitud,longitud']);
        }

        $radio = (float) $request->query('radio', 25);
        if ($radio <= 0 || $radio > 1000) {
            throw ValidationException::withMessages(['radio' => 'El radio debe estar entre 0 y 1000 km.']);
        }

        return ['lat' => (float) $partes[0], 'lng' => (float) $partes[1], 'radio' => $radio];
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelo
     * @return list<int>
     */
    private static function resolver(string $modelo, string $valor, string $campo): array
    {
        $valores = array_filter(array_map('trim', explode(',', $valor)));
        $numeros = array_filter($valores, 'ctype_digit');
        $slugs = array_diff($valores, $numeros);

        $ids = $modelo::query()
            ->where(fn ($q) => $q->whereIn('id', $numeros)->orWhereIn('slug', $slugs))
            ->pluck('id')
            ->all();

        if (! $ids) {
            throw ValidationException::withMessages([$campo => "No existe: {$valor}"]);
        }

        return $ids;
    }
}
