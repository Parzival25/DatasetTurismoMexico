<?php

use App\Servicios\DatasetNoDisponible;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Si la API del dataset no responde y no hay copia en caché, se muestra
        // una página amable en lugar de un error genérico.
        $exceptions->render(function (DatasetNoDisponible $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['mensaje' => 'La información turística no está disponible por el momento.'], 503);
            }

            return response()->view('errores.sin-conexion', [], 503);
        });
        $exceptions->dontReport(DatasetNoDisponible::class);
    })->create();
