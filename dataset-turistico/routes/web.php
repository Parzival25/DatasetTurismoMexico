<?php

use App\Http\Controllers\Admin\AtomoController as AdminAtomoController;
use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\EventoController as AdminEventoController;
use App\Http\Controllers\Admin\FotoController as AdminFotoController;
use App\Http\Controllers\Admin\InicioController as AdminInicioController;
use App\Http\Controllers\Admin\SesionController;
use App\Http\Controllers\DescargaController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Portal público
Route::get('/', [PortalController::class, 'inicio'])->name('portal.inicio');
Route::get('/explorar', [PortalController::class, 'explorar'])->name('portal.explorar');
Route::get('/explorar/{atomo}', [PortalController::class, 'atomo'])->name('portal.atomo');
Route::get('/documentacion', [PortalController::class, 'documentacion'])->name('portal.documentacion');
Route::get('/acerca', [PortalController::class, 'acerca'])->name('portal.acerca');

// Descargas (también en la raíz, como en datasetturistico.mexmapa.com)
$archivos = 'DataSetA\.xml|DataSetB\.json|DataSetC\.csv|DataSet\.geojson';
Route::get('/descargas/{archivo}', DescargaController::class)->where('archivo', $archivos)->name('descargas');
Route::get('/{archivo}', DescargaController::class)->where('archivo', $archivos);

// Fotos
Route::get('/fotos/{foto}', [FotoController::class, 'mostrar'])->whereNumber('foto')->name('fotos.mostrar');
Route::get('/fotos/{foto}/miniatura', [FotoController::class, 'miniatura'])->whereNumber('foto')->name('fotos.miniatura');

// Panel de administración
Route::middleware('guest')->group(function () {
    Route::get('/admin/entrar', [SesionController::class, 'formulario'])->name('login');
    Route::post('/admin/entrar', [SesionController::class, 'entrar'])->middleware('throttle:10,1');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('salir', [SesionController::class, 'salir'])->name('salir');
    Route::get('/', AdminInicioController::class)->name('inicio');

    Route::resource('atomos', AdminAtomoController::class)->except('show')->parameters(['atomos' => 'atomo']);
    Route::resource('eventos', AdminEventoController::class)->except('show');

    Route::get('categorias', [AdminCategoriaController::class, 'index'])->name('categorias.index');
    Route::put('categorias/{categoria}', [AdminCategoriaController::class, 'actualizar'])->name('categorias.actualizar');
    Route::post('subcategorias', [AdminCategoriaController::class, 'crearSubcategoria'])->name('subcategorias.crear');
    Route::put('subcategorias/{subcategoria}', [AdminCategoriaController::class, 'actualizarSubcategoria'])->name('subcategorias.actualizar');

    Route::post('{tipo}/{id}/fotos', [AdminFotoController::class, 'subir'])->whereIn('tipo', ['atomo', 'evento'])->whereNumber('id')->name('fotos.subir');
    Route::put('fotos/{foto}', [AdminFotoController::class, 'actualizar'])->name('fotos.actualizar');
    Route::delete('fotos/{foto}', [AdminFotoController::class, 'eliminar'])->name('fotos.eliminar');
});
