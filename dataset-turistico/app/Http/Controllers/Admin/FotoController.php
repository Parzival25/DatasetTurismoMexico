<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atomo;
use App\Models\Evento;
use App\Models\Foto;
use App\Support\Imagenes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class FotoController extends Controller
{
    public function subir(Request $request, string $tipo, int $id): RedirectResponse
    {
        $modelo = $tipo === 'atomo' ? Atomo::findOrFail($id) : Evento::findOrFail($id);
        $carpeta = $tipo === 'atomo' ? 'atomos' : 'eventos';

        $request->validate([
            'fotos' => ['required', 'array', 'max:20'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:12288'],
            'credito' => ['nullable', 'string', 'max:255'],
        ], [], ['fotos.*' => 'foto']);

        $disco = Storage::disk('fotos');
        $orden = (int) $modelo->fotos()->max('orden');
        $subidas = 0;

        foreach ($request->file('fotos') as $archivo) {
            $nombre = Str::lower(Str::random(10)).'.jpg';
            $ruta = "{$carpeta}/{$modelo->id}/{$nombre}";
            $miniatura = "{$carpeta}/{$modelo->id}/mini/{$nombre}";

            try {
                $info = Imagenes::procesar($archivo->getRealPath(), $disco->path($ruta), $disco->path($miniatura));
            } catch (Throwable $e) {
                return back()->withErrors(['fotos' => "No se pudo procesar {$archivo->getClientOriginalName()}: {$e->getMessage()}"]);
            }

            $modelo->fotos()->create([
                'ruta' => $ruta,
                'ruta_miniatura' => $miniatura,
                'mime' => $info['mime'],
                'ancho' => $info['ancho'],
                'alto' => $info['alto'],
                'bytes' => $info['bytes'],
                'orden' => ++$orden,
                'credito' => $request->input('credito'),
                'archivo_original' => $archivo->getClientOriginalName(),
            ]);
            $subidas++;
        }

        $modelo->touch();

        return back()->with('exito', $subidas === 1 ? 'Se agregó 1 foto.' : "Se agregaron {$subidas} fotos.");
    }

    public function actualizar(Request $request, Foto $foto): RedirectResponse
    {
        $foto->update($request->validate([
            'orden' => ['required', 'integer', 'min:0', 'max:999'],
            'credito' => ['nullable', 'string', 'max:255'],
        ]));

        return back()->with('exito', 'Foto actualizada.');
    }

    public function eliminar(Foto $foto): RedirectResponse
    {
        $foto->delete();

        return back()->with('exito', 'Foto eliminada.');
    }
}
