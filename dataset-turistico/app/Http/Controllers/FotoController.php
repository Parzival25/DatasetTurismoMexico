<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FotoController extends Controller
{
    public function mostrar(Foto $foto): BinaryFileResponse
    {
        return $this->servir($foto, $foto->ruta);
    }

    public function miniatura(Foto $foto): BinaryFileResponse
    {
        return $this->servir($foto, $foto->ruta_miniatura ?: $foto->ruta);
    }

    private function servir(Foto $foto, string $ruta): BinaryFileResponse
    {
        $disco = Storage::disk('fotos');
        abort_unless($disco->exists($ruta), 404);

        return response()->file($disco->path($ruta), [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'public, max-age=604800',
            'Access-Control-Allow-Origin' => '*',
        ])->setAutoEtag();
    }
}
