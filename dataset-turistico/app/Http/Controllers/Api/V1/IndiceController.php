<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\Estadisticas;
use App\Support\VersionDataset;
use Illuminate\Http\JsonResponse;

class IndiceController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'nombre' => 'Conjunto de datos turísticos del Estado de Chiapas',
            'descripcion' => 'API pública de solo lectura con los átomos turísticos (lugares), eventos, clasificaciones y fotos.',
            'version_api' => 'v1',
            'version_datos' => VersionDataset::actual(),
            'actualizado' => VersionDataset::ultimaActualizacion(),
            'totales' => Estadisticas::totales(),
            'recursos' => [
                'atomos' => route('api.atomos.index'),
                'atomo' => url('/api/v1/atomos/{id|slug}'),
                'cercanos' => url('/api/v1/atomos/{id|slug}/cercanos'),
                'mapa' => route('api.mapa'),
                'categorias' => route('api.categorias.index'),
                'origenes' => route('api.origenes.index'),
                'eventos' => route('api.eventos.index'),
            ],
            'descargas' => [
                'xml' => route('descargas', 'DataSetA.xml'),
                'json' => route('descargas', 'DataSetB.json'),
                'csv' => route('descargas', 'DataSetC.csv'),
                'geojson' => route('descargas', 'DataSet.geojson'),
            ],
            'documentacion' => route('portal.documentacion'),
            'licencia' => 'Uso público sin fines de lucro. Cite la fuente: Instituto Tecnológico de Tuxtla Gutiérrez.',
        ]);
    }
}
