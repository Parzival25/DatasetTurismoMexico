<?php

namespace App\Http\Controllers;

use App\Servicios\ClienteDataset;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class LugarController extends Controller
{
    public function index(Request $request, ClienteDataset $dataset): View
    {
        $filtros = array_filter($request->only(['q', 'categoria', 'subcategoria', 'region']));
        $pagina = max(1, (int) $request->query('pagina', 1));

        $respuesta = $dataset->atomos([
            'q' => $filtros['q'] ?? null,
            'categoria' => $filtros['categoria'] ?? null,
            'subcategoria' => $filtros['subcategoria'] ?? null,
            'origen' => $filtros['region'] ?? null,
            'por_pagina' => 24,
            'pagina' => $pagina,
        ]);

        $filtroInvalido = $respuesta === null;
        $respuesta ??= ['datos' => [], 'meta' => ['total' => 0, 'por_pagina' => 24, 'pagina' => 1]];

        $lugares = new LengthAwarePaginator(
            $respuesta['datos'],
            $respuesta['meta']['total'],
            $respuesta['meta']['por_pagina'],
            $respuesta['meta']['pagina'],
            ['path' => route('lugares.index'), 'pageName' => 'pagina', 'query' => $filtros]
        );

        $categorias = $dataset->categorias();
        $categoriaActual = collect($categorias)->firstWhere('slug', $filtros['categoria'] ?? null);

        return view('lugares.index', [
            'lugares' => $lugares,
            'filtros' => $filtros,
            'filtroInvalido' => $filtroInvalido,
            'categorias' => $categorias,
            'categoriaActual' => $categoriaActual,
            'regiones' => $dataset->origenes(),
        ]);
    }

    public function show(string $slug, ClienteDataset $dataset): View
    {
        $lugar = $dataset->atomo($slug);
        abort_if($lugar === null, 404);

        return view('lugares.show', [
            'lugar' => $lugar,
            'cercanos' => $dataset->cercanos($lugar['id'], 6),
            'colorPrincipal' => $lugar['categorias'][0]['color'] ?? '#1c4a38',
        ]);
    }

    public function mapa(ClienteDataset $dataset): View
    {
        return view('lugares.mapa', ['categorias' => $dataset->categorias()]);
    }
}
