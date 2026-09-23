<?php

use App\Http\Controllers\Api\V1\AtomoController;
use App\Http\Controllers\Api\V1\CatalogoController;
use App\Http\Controllers\Api\V1\EventoController;
use App\Http\Controllers\Api\V1\IndiceController;
use App\Http\Controllers\Api\V1\MapaController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.')
    ->middleware(['throttle:api', 'cache.headers:public;max_age=120;etag'])
    ->group(function () {
        Route::get('/', IndiceController::class)->name('indice');

        Route::get('atomos', [AtomoController::class, 'index'])->name('atomos.index');
        Route::get('atomos/{atomo}', [AtomoController::class, 'show'])->name('atomos.show');
        Route::get('atomos/{atomo}/cercanos', [AtomoController::class, 'cercanos'])->name('atomos.cercanos');

        Route::get('mapa', MapaController::class)->name('mapa');

        Route::get('categorias', [CatalogoController::class, 'categorias'])->name('categorias.index');
        Route::get('categorias/{categoria}', [CatalogoController::class, 'categoria'])->name('categorias.show');
        Route::get('origenes', [CatalogoController::class, 'origenes'])->name('origenes.index');
        Route::get('origenes/{origen}', [CatalogoController::class, 'origen'])->name('origenes.show');

        Route::get('eventos', [EventoController::class, 'index'])->name('eventos.index');
        Route::get('eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');
    });
