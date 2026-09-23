<?php

namespace App\Support;

use Illuminate\Support\Str;

class Texto
{
    /**
     * Minúsculas y sin acentos: sirve para búsquedas y comparaciones.
     */
    public static function normalizar(?string $texto): string
    {
        return trim(preg_replace('/\s+/u', ' ', Str::lower(Str::ascii((string) $texto))));
    }

    /**
     * Quita espacios repetidos, saltos de línea y espacios en los extremos.
     */
    public static function limpiar(?string $texto): string
    {
        $texto = str_replace(["\u{00A0}", "\u{FEFF}"], ' ', (string) $texto);

        return trim(preg_replace('/\s+/u', ' ', $texto));
    }

    /**
     * Genera un slug que no exista todavía en $usados.
     *
     * @param  array<string, true>  $usados
     */
    public static function slugUnico(string $nombre, array &$usados, ?string $sufijo = null): string
    {
        $base = Str::slug($nombre) ?: 'sin-nombre';
        $slug = $base;

        if (isset($usados[$slug]) && $sufijo) {
            $slug = $base.'-'.Str::slug($sufijo);
        }

        $i = 2;
        while (isset($usados[$slug])) {
            $slug = $base.'-'.$i++;
        }

        $usados[$slug] = true;

        return $slug;
    }
}
