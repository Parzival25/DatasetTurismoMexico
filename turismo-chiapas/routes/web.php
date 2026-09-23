<?php

use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\DatosController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

Route::get('/', InicioController::class)->name('inicio');

Route::get('/mapa', [LugarController::class, 'mapa'])->name('mapa');
Route::get('/lugares', [LugarController::class, 'index'])->name('lugares.index');
Route::get('/lugares/{slug}', [LugarController::class, 'show'])->name('lugares.show');

Route::get('/regiones', [RegionController::class, 'index'])->name('regiones.index');
Route::get('/regiones/{slug}', [RegionController::class, 'show'])->name('regiones.show');

Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{slug}', [EventoController::class, 'show'])->name('eventos.show');

Route::get('/chiapas', [ContenidoController::class, 'chiapas'])->name('chiapas');
Route::get('/gastronomia', [ContenidoController::class, 'gastronomia'])->name('gastronomia');
Route::get('/acerca', [ContenidoController::class, 'acerca'])->name('acerca');

// Datos para el mapa interactivo (el navegador solo habla con este sitio).
Route::get('/datos/mapa', [DatosController::class, 'mapa'])->name('datos.mapa');
