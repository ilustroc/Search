<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ImportController;

// Vista de inicio
Route::get('/', function () { return view('welcome'); });

/**
 * Búsqueda de Clientes (Rutas Separadas)
 */
// Recibe el POST del header o buscador principal
Route::post('/buscar', [SearchController::class, 'buscar'])->name('buscar');

// Muestra el resultado final con URL limpia /buscar/XXXXXXXX
Route::get('/buscar/{documento}', [SearchController::class, 'buscar'])->name('buscar.directo');

// Panel de Administración
Route::prefix('admin')->group(function () {
    Route::get('/import', [ImportController::class, 'index'])->name('admin.import.index');
    Route::post('/import/{tipo}', [ImportController::class, 'upload'])->name('admin.import.upload');
    Route::delete('/truncate/{tabla}', [ImportController::class, 'truncate'])->name('admin.import.truncate');
});