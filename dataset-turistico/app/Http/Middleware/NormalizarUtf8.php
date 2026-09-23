<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Garantiza que el texto recibido sea UTF-8 válido. Si un cliente envía
 * Windows-1252 (común en herramientas de Windows), se convierte en lugar de
 * guardar bytes que después rompen el JSON de la API.
 */
class NormalizarUtf8
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->merge($this->normalizar($request->except(array_keys($request->allFiles()))));

        return $next($request);
    }

    private function normalizar(array $datos): array
    {
        array_walk_recursive($datos, function (&$valor) {
            if (is_string($valor) && ! mb_check_encoding($valor, 'UTF-8')) {
                $valor = mb_convert_encoding($valor, 'UTF-8', 'Windows-1252');
            }
        });

        return $datos;
    }
}
