<?php

namespace App\Http\Controllers;

use App\Exportacion\Exportador;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DescargaController extends Controller
{
    public function __invoke(Request $request, Exportador $exportador, string $archivo): Response
    {
        abort_unless(isset(Exportador::ARCHIVOS[$archivo]), 404);

        $contenido = $exportador->contenido($archivo);
        $cabeceras = [
            'Content-Type' => Exportador::ARCHIVOS[$archivo]['mime'],
            'Access-Control-Allow-Origin' => '*',
            'Cache-Control' => 'public, max-age=300',
            'ETag' => '"'.md5($contenido).'"',
        ];

        if ($request->boolean('descargar')) {
            $cabeceras['Content-Disposition'] = 'attachment; filename="'.$archivo.'"';
        }

        if ($request->header('If-None-Match') === $cabeceras['ETag']) {
            return response('', 304, $cabeceras);
        }

        return response($contenido, 200, $cabeceras);
    }
}
