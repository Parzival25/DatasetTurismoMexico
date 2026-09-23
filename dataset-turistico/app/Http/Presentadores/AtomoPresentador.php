<?php

namespace App\Http\Presentadores;

use App\Models\Atomo;
use Illuminate\Support\Str;

/**
 * Forma pública de un átomo en la API y en las descargas.
 */
class AtomoPresentador
{
    public const RELACIONES = ['origen', 'categorias', 'subcategorias', 'fotos'];

    public const RELACIONES_COMPLETAS = ['origen', 'categorias', 'subcategorias', 'fotos', 'actividades'];

    public static function resumen(Atomo $atomo, ?float $distanciaKm = null): array
    {
        $portada = $atomo->fotos->first();

        return array_filter([
            'id' => $atomo->id,
            'slug' => $atomo->slug,
            'nombre' => $atomo->nombre,
            'extracto' => $atomo->descripcion ? Str::limit($atomo->descripcion, 180) : null,
            'coordenadas' => self::coordenadas($atomo),
            'activo' => $atomo->activo,
            'origen' => $atomo->origen ? [
                'id' => $atomo->origen->id,
                'slug' => $atomo->origen->slug,
                'nombre' => $atomo->origen->nombre,
            ] : null,
            'categorias' => $atomo->categorias->map(fn ($c) => CatalogoPresentador::categoriaCorta($c))->all(),
            'subcategorias' => $atomo->subcategorias->map(fn ($s) => CatalogoPresentador::subcategoriaCorta($s))->all(),
            'portada' => $portada ? FotoPresentador::corta($portada) : null,
            'total_fotos' => $atomo->fotos->count(),
            'distancia_km' => $distanciaKm !== null ? round($distanciaKm, 2) : null,
            'enlaces' => [
                'api' => route('api.atomos.show', $atomo->id),
                'ficha' => route('portal.atomo', $atomo->slug),
            ],
            'actualizado' => $atomo->updated_at?->toIso8601String(),
        ], fn ($valor, $clave) => $clave !== 'distancia_km' || $valor !== null, ARRAY_FILTER_USE_BOTH);
    }

    public static function completo(Atomo $atomo, ?float $distanciaKm = null): array
    {
        $resumen = self::resumen($atomo, $distanciaKm);

        return array_merge(
            array_slice($resumen, 0, 3),
            [
                'descripcion' => $atomo->descripcion,
                'localizacion' => $atomo->localizacion,
                'como_llegar' => $atomo->como_llegar,
            ],
            array_slice($resumen, 4),
            [
                'actividades' => $atomo->actividades->pluck('descripcion')->all(),
                'fotos' => $atomo->fotos->map(fn ($f) => FotoPresentador::completa($f))->all(),
                'legado' => [
                    'origen' => $atomo->origen_id,
                    'numero_original' => $atomo->numero_original,
                    'activo_original' => $atomo->legado_activo,
                ],
            ],
        );
    }

    public static function geojson(Atomo $atomo): array
    {
        $portada = $atomo->fotos->first();
        $principal = $atomo->categorias->first();

        return [
            'type' => 'Feature',
            'id' => $atomo->id,
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$atomo->longitud, $atomo->latitud],
            ],
            'properties' => [
                'id' => $atomo->id,
                'slug' => $atomo->slug,
                'nombre' => $atomo->nombre,
                'origen_id' => $atomo->origen_id,
                'categorias' => $atomo->categorias->pluck('id')->all(),
                'subcategorias' => $atomo->subcategorias->pluck('id')->all(),
                'color' => $principal?->color,
                'icono' => $principal?->icono,
                'miniatura' => $portada?->urlMiniatura(),
                'api' => route('api.atomos.show', $atomo->id),
            ],
        ];
    }

    private static function coordenadas(Atomo $atomo): ?array
    {
        return $atomo->tieneCoordenadas()
            ? ['latitud' => $atomo->latitud, 'longitud' => $atomo->longitud]
            : null;
    }
}
