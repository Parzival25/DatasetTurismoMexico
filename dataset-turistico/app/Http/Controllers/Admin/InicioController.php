<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atomo;
use App\Support\Estadisticas;
use App\Support\VersionDataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function __invoke(Request $request): View
    {
        $reporte = null;
        if (Storage::disk('reportes')->exists('importacion.json')) {
            $reporte = json_decode(Storage::disk('reportes')->get('importacion.json'), true);
        }

        $nivel = $request->query('nivel', 'revisar');
        $entradas = collect($reporte['entradas'] ?? [])
            ->when($nivel !== 'todos', fn ($c) => $c->where('nivel', $nivel))
            ->values();

        // Solo se muestran los pendientes que siguen vigentes en la base.
        $idsExistentes = Atomo::pluck('id')->flip();

        return view('admin.inicio', [
            'totales' => Estadisticas::totales(),
            'version' => VersionDataset::actual(),
            'pendientes' => [
                'sin_fotos' => Atomo::doesntHave('fotos')->count(),
                'sin_coordenadas' => Atomo::whereNull('latitud')->count(),
                'sin_descripcion' => Atomo::whereNull('descripcion')->count(),
                'sin_clasificacion' => Atomo::doesntHave('categorias')->count(),
            ],
            'reporte' => $reporte,
            'entradas' => $entradas,
            'nivel' => $nivel,
            'idsExistentes' => $idsExistentes,
        ]);
    }
}
