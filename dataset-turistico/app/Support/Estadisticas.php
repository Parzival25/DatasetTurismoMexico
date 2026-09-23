<?php

namespace App\Support;

use App\Models\Atomo;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Foto;
use App\Models\Origen;
use App\Models\Subcategoria;

class Estadisticas
{
    /**
     * @return array<string, int>
     */
    public static function totales(): array
    {
        return [
            'atomos' => Atomo::activos()->count(),
            'atomos_inactivos' => Atomo::where('activo', false)->count(),
            'eventos' => Evento::activos()->count(),
            'fotos' => Foto::count(),
            'categorias' => Categoria::count(),
            'subcategorias' => Subcategoria::count(),
            'origenes' => Origen::count(),
        ];
    }
}
