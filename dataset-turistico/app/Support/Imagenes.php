<?php

namespace App\Support;

use RuntimeException;

/**
 * Procesa fotos con GD: normaliza el tamaño máximo y genera miniaturas JPEG.
 */
class Imagenes
{
    /**
     * Guarda $origen en $destino (ruta absoluta) reduciéndola si excede el ancho
     * máximo, y crea la miniatura en $destinoMiniatura.
     *
     * @return array{ancho: int, alto: int, bytes: int, mime: string}
     */
    public static function procesar(string $origen, string $destino, string $destinoMiniatura): array
    {
        $info = @getimagesize($origen);
        if (! $info) {
            throw new RuntimeException("No es una imagen válida: {$origen}");
        }

        [$ancho, $alto] = $info;
        $mime = $info['mime'];
        $cfg = config('dataset.fotos');

        self::asegurarDirectorio($destino);
        self::asegurarDirectorio($destinoMiniatura);

        $imagen = self::abrir($origen, $mime);

        if ($ancho > $cfg['ancho_maximo']) {
            $reducida = self::redimensionar($imagen, $ancho, $alto, $cfg['ancho_maximo']);
            imagejpeg($reducida, $destino, $cfg['calidad']);
            [$ancho, $alto] = [imagesx($reducida), imagesy($reducida)];
            imagedestroy($reducida);
            $mime = 'image/jpeg';
        } elseif ($mime === 'image/jpeg') {
            copy($origen, $destino);
        } else {
            imagejpeg(self::sobreFondoBlanco($imagen), $destino, $cfg['calidad']);
            $mime = 'image/jpeg';
        }

        $mini = self::redimensionar($imagen, imagesx($imagen), imagesy($imagen), $cfg['ancho_miniatura']);
        imagejpeg($mini, $destinoMiniatura, 78);
        imagedestroy($mini);
        imagedestroy($imagen);

        return ['ancho' => $ancho, 'alto' => $alto, 'bytes' => filesize($destino), 'mime' => $mime];
    }

    private static function abrir(string $ruta, string $mime): \GdImage
    {
        $imagen = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($ruta),
            'image/png' => @imagecreatefrompng($ruta),
            'image/gif' => @imagecreatefromgif($ruta),
            'image/webp' => @imagecreatefromwebp($ruta),
            'image/bmp', 'image/x-ms-bmp' => @imagecreatefrombmp($ruta),
            default => false,
        };

        if (! $imagen) {
            throw new RuntimeException("Formato de imagen no soportado ({$mime}): {$ruta}");
        }

        return $imagen;
    }

    private static function redimensionar(\GdImage $imagen, int $ancho, int $alto, int $anchoNuevo): \GdImage
    {
        $anchoNuevo = min($anchoNuevo, $ancho);
        $altoNuevo = max(1, (int) round($alto * $anchoNuevo / $ancho));

        $lienzo = imagecreatetruecolor($anchoNuevo, $altoNuevo);
        imagefill($lienzo, 0, 0, imagecolorallocate($lienzo, 255, 255, 255));
        imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $ancho, $alto);

        return $lienzo;
    }

    private static function sobreFondoBlanco(\GdImage $imagen): \GdImage
    {
        return self::redimensionar($imagen, imagesx($imagen), imagesy($imagen), imagesx($imagen));
    }

    private static function asegurarDirectorio(string $archivo): void
    {
        $dir = dirname($archivo);
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}
