<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::post('/buscar', [SearchController::class, 'procesarFormulario'])->name('buscar');

Route::get('/buscar/{documento}', [SearchController::class, 'buscar'])->name('buscar.directo');