<?php

namespace App\Http\Presentadores;

use App\Models\Foto;

class FotoPresentador
{
    public static function corta(Foto $foto): array
    {
        return [
            'url' => $foto->url(),
            'miniatura' => $foto->urlMiniatura(),
        ];
    }

    public static function completa(Foto $foto): array
    {
        return [
            'id' => $foto->id,
            'url' => $foto->url(),
            'miniatura' => $foto->urlMiniatura(),
            'ancho' => $foto->ancho,
            'alto' => $foto->alto,
            'bytes' => $foto->bytes,
            'credito' => $foto->credito,
        ];
    }
}
