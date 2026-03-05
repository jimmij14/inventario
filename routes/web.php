<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CategoriaPersonalController;
use App\Http\Controllers\EstadoEquipoController;
use App\Http\Controllers\TipoIngresoController;
use App\Http\Controllers\ProveedorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/administrador', function () {
    return view('administrador.dashboard');
});

Route::resource('categorias', CategoriaController::class);
Route::resource('marcas', MarcaController::class);
Route::resource('modelos', ModeloController::class);
Route::resource('colores', ColorController::class);
Route::resource('categoria_personal', CategoriaPersonalController::class);
Route::resource('estado_equipo', EstadoEquipoController::class);
Route::resource('tipo_ingreso', TipoIngresoController::class);
Route::resource('proveedores', ProveedorController::class);