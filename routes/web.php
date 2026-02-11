<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Vista principal
Route::get('/', function () {
    return view('welcome');
});

// Ruta de búsqueda (Acepta el documento como parte de la URL)
Route::get('/buscar/{documento}', [SearchController::class, 'buscar'])->name('buscar.directo');

// Ruta para el formulario POST
Route::post('/buscar', [SearchController::class, 'procesarFormulario'])->name('buscar');