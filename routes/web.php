<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ImportController;

// Vista de inicio
Route::get('/', function () { 
    return view('welcome'); 
})->name('home');

/**
 * Búsqueda de Clientes
 * Usamos GET para que la URL sea: /buscar?documento=XXXXXXXX
 */
Route::get('/buscar', [SearchController::class, 'buscar'])->name('buscar');

// Mantenemos el POST por compatibilidad con el formulario actual del header
Route::post('/buscar', [SearchController::class, 'buscar']);

// Panel de Administración
Route::prefix('admin')->group(function () {
    Route::get('/import', [ImportController::class, 'index'])->name('admin.import.index');
    Route::post('/import/{tipo}', [ImportController::class, 'upload'])->name('admin.import.upload');
    Route::delete('/truncate/{tabla}', [ImportController::class, 'truncate'])->name('admin.import.truncate');
});