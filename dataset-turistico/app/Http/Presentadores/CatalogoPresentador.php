<?php

namespace App\Http\Presentadores;

use App\Models\Categoria;
use App\Models\Origen;
use App\Models\Subcategoria;

class CatalogoPresentador
{
    public static function categoriaCorta(Categoria $categoria): array
    {
        return [
            'id' => $categoria->id,
            'slug' => $categoria->slug,
            'nombre' => $categoria->nombre,
            'color' => $categoria->color,
            'icono' => $categoria->icono,
        ];
    }

    public static function subcategoriaCorta(Subcategoria $subcategoria): array
    {
        return [
            'id' => $subcategoria->id,
            'slug' => $subcategoria->slug,
            'nombre' => $subcategoria->nombre,
            'categoria_id' => $subcategoria->categoria_id,
        ];
    }

    /**
     * Espera categorías cargadas con withCount('atomos') y subcategorias.atomos_count.
     */
    public static function categoria(Categoria $categoria): array
    {
        return self::categoriaCorta($categoria) + [
            'descripcion' => $categoria->descripcion,
            'total_atomos' => (int) $categoria->atomos_count,
            'subcategorias' => $categoria->subcategorias->map(fn ($s) => self::subcategoriaCorta($s) + [
                'total_atomos' => (int) $s->atomos_count,
                'total_eventos' => (int) $s->eventos_count,
            ])->values()->all(),
            'enlaces' => [
                'api' => route('api.categorias.show', $categoria->slug),
                'atomos' => route('api.atomos.index', ['categoria' => $categoria->slug]),
            ],
        ];
    }

    /**
     * @param  array{total: int, lat_min: ?float, lat_max: ?float, lng_min: ?float, lng_max: ?float}  $resumen
     */
    public static function origen(Origen $origen, array $resumen): array
    {
        $tieneLimites = $resumen['lat_min'] !== null;

        return [
            'id' => $origen->id,
            'slug' => $origen->slug,
            'nombre' => $origen->nombre,
            'descripcion' => $origen->descripcion,
            'total_atomos' => (int) $resumen['total'],
            'centro' => $tieneLimites ? [
                'latitud' => round(($resumen['lat_min'] + $resumen['lat_max']) / 2, 6),
                'longitud' => round(($resumen['lng_min'] + $resumen['lng_max']) / 2, 6),
            ] : null,
            'limites' => $tieneLimites ? [
                'lat_min' => (float) $resumen['lat_min'],
                'lat_max' => (float) $resumen['lat_max'],
                'lng_min' => (float) $resumen['lng_min'],
                'lng_max' => (float) $resumen['lng_max'],
            ] : null,
            'enlaces' => [
                'api' => route('api.origenes.show', $origen->slug),
                'atomos' => route('api.atomos.index', ['origen' => $origen->slug]),
            ],
        ];
    }
}
