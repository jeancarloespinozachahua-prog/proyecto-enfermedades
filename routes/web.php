<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EnfermoController;

// Ruta principal
Route::get('/', function () {
    return view('home');
});

// Rutas del módulo de enfermedades
Route::resource('enfermedades', EnfermoController::class);

// Ruta para enfermedades por región
Route::get('/enfermedades/region/{region}', [EnfermoController::class, 'porRegion'])->name('enfermedades.region');

// Rutas del módulo de logins (solo index)
Route::resource('logins', LoginController::class)->only(['index']);
