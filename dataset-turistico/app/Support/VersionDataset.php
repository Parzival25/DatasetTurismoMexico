<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Huella del estado actual del dataset. Cambia cada vez que se edita algo,
 * por lo que sirve como clave de caché para las exportaciones.
 */
class VersionDataset
{
    public static function actual(): string
    {
        $partes = [];
        foreach (['atomos', 'eventos', 'fotos', 'categorias', 'subcategorias', 'actividades'] as $tabla) {
            $fila = DB::table($tabla)->selectRaw('count(*) as total, max(updated_at) as ultima')->first();
            $partes[] = "{$tabla}:{$fila->total}:{$fila->ultima}";
        }

        return substr(sha1(implode('|', $partes)), 0, 12);
    }

    public static function ultimaActualizacion(): ?string
    {
        $fechas = array_filter([
            DB::table('atomos')->max('updated_at'),
            DB::table('eventos')->max('updated_at'),
            DB::table('fotos')->max('updated_at'),
        ]);

        return $fechas ? max($fechas) : null;
    }
}
