<?php

namespace App\Http\Controllers;

use App\Servicios\ClienteDataset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatosController extends Controller
{
    /**
     * GeoJSON de todos los lugares para el mapa interactivo. Se sirve desde
     * este sitio (y su caché) para que el navegador no dependa de la API.
     */
    public function mapa(Request $request, ClienteDataset $dataset): JsonResponse
    {
        $geojson = $dataset->mapa(array_filter(['origen' => $request->query('region')]))
            ?? ['type' => 'FeatureCollection', 'features' => []];

        return response()->json($geojson)->header('Cache-Control', 'public, max-age=300');
    }
}
