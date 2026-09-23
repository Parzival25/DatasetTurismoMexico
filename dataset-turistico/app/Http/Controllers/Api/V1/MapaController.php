<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Presentadores\AtomoPresentador;
use App\Models\Atomo;
use App\Support\ConsultaAtomos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Todos los átomos con coordenadas en formato GeoJSON ligero, pensado para
 * dibujar marcadores. Acepta los mismos filtros que /atomos.
 */
class MapaController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $atomos = ConsultaAtomos::aplicar(Atomo::query(), $request)
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->with(['categorias', 'subcategorias', 'fotos'])
            ->orderBy('id')
            ->get();

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $atomos->map(fn (Atomo $a) => AtomoPresentador::geojson($a))->values(),
        ], 200, ['Content-Type' => 'application/geo+json']);
    }
}
