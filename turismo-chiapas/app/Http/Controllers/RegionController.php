<?php

namespace App\Http\Controllers;

use App\Servicios\ClienteDataset;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function index(ClienteDataset $dataset): View
    {
        $regiones = collect($dataset->origenes())
            ->map(function (array $region) use ($dataset) {
                $conFoto = $dataset->atomos(['origen' => $region['slug'], 'con_fotos' => 1, 'por_pagina' => 1, 'orden' => 'id']) ?? [];
                $region['portada'] = $conFoto['datos'][0]['portada'] ?? null;

                return $region;
            })
            ->all();

        return view('regiones.index', ['regiones' => $regiones]);
    }

    public function show(string $slug, ClienteDataset $dataset): View
    {
        $region = $dataset->origen($slug);
        abort_if($region === null, 404);

        $lugares = $dataset->atomos(['origen' => $slug, 'por_pagina' => 500])['datos'] ?? [];

        return view('regiones.show', [
            'region' => $region,
            'lugares' => $lugares,
            'categorias' => $dataset->categorias(),
        ]);
    }
}
