<?php

namespace App\Http\Controllers;

use App\Servicios\ClienteDataset;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function __invoke(ClienteDataset $dataset): View
    {
        // Los destacados rotan cada día entre los lugares que tienen fotos.
        $porPagina = 8;
        $primera = $dataset->atomos(['con_fotos' => 1, 'por_pagina' => $porPagina, 'orden' => 'id']) ?? [];
        $paginas = max(1, $primera['meta']['paginas'] ?? 1);
        $pagina = (now()->dayOfYear % $paginas) + 1;
        $destacados = $pagina === 1
            ? ($primera['datos'] ?? [])
            : ($dataset->atomos(['con_fotos' => 1, 'por_pagina' => $porPagina, 'orden' => 'id', 'pagina' => $pagina])['datos'] ?? []);

        $indice = $dataset->indice();

        return view('inicio', [
            'totales' => $indice['totales'] ?? [],
            'categorias' => $dataset->categorias(),
            'destacados' => $destacados,
            'mosaico' => array_slice($destacados, 0, 5),
            'eventos' => array_slice($dataset->eventos(['orden' => 'proximos']), 0, 4),
            'regiones' => $dataset->origenes(),
        ]);
    }
}
