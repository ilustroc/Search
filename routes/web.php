<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ImportController;

// Vista de inicio
Route::get('/', function () { return view('welcome'); });

// Procesa el formulario (POST) y redirige
Route::post('/buscar', [SearchController::class, 'procesarFormulario'])->name('buscar');

// Muestra el resultado (GET) - AQUÍ ESTABA EL ERROR
Route::get('/buscar/{documento}', [SearchController::class, 'buscar'])->name('buscar.directo');

// Panel de Administración
Route::prefix('admin')->group(function () {
    Route::get('/import', [ImportController::class, 'index'])->name('admin.import.index');
    Route::post('/import', [ImportController::class, 'upload'])->name('admin.import.upload');
    Route::delete('/truncate', [ImportController::class, 'truncate'])->name('admin.import.truncate');
});