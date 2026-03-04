<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/administrador', function () {
    return view('administrador.dashboard');
});

Route::resource('categorias', CategoriaController::class);