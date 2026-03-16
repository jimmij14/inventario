<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CategoriaPersonalController;
use App\Http\Controllers\EstadoEquipoController;
use App\Http\Controllers\TipoIngresoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaEquipoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EquipoInventarioController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\BajaController;


Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/administrador', function () {
    return view('administrador.dashboard');
});


  
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    
    Route::resource('categorias', CategoriaController::class);
Route::resource('marcas', MarcaController::class);
Route::resource('modelos', ModeloController::class);
Route::resource('colores', ColorController::class);
Route::resource('categoria_personal', CategoriaPersonalController::class);
Route::resource('estado_equipo', EstadoEquipoController::class);
Route::resource('tipo_ingreso', TipoIngresoController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('categoria_equipos', CategoriaEquipoController::class);
route::resource('personal', PersonalController::class);
Route::resource('areas', AreaController::class);
Route::resource('equipos', EquipoController::class);


Route::get('/inventario/{id}', [EquipoInventarioController::class, 'show'])
    ->name('inventario.show');

    
Route::get('/inventario/codigos', [EquipoInventarioController::class, 'imprimirCodigos'])
    ->name('inventario.codigos');


Route::resource('inventario', EquipoInventarioController::class);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::post('/bajas', [BajaController::class, 'store'])->name('bajas.store');
Route::get('/bajas', [BajaController::class,'index'])->name('bajas.index');
Route::put('/bajas/restaurar/{id}', [BajaController::class, 'restaurar'])
    ->name('bajas.restaurar');

