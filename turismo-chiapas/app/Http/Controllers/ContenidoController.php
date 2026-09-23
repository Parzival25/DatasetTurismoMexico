<?php

namespace App\Http\Controllers;

use App\Models\RegionGastronomica;
use App\Servicios\ClienteDataset;
use Illuminate\View\View;

/**
 * Contenido propio del sitio (no forma parte del dataset).
 */
class ContenidoController extends Controller
{
    public function chiapas(): View
    {
        return view('contenido.chiapas');
    }

    public function gastronomia(): View
    {
        return view('contenido.gastronomia', [
            'regiones' => RegionGastronomica::with('platillos')->orderBy('orden')->get(),
        ]);
    }

    public function acerca(ClienteDataset $dataset): View
    {
        return view('contenido.acerca', ['totales' => $dataset->indice()['totales'] ?? []]);
    }
}
