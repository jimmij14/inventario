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
use App\Http\Controllers\MovimientoController;

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
    
    Route::resource('categorias', CategoriaController::class)->except(['create','show','edit']);
Route::resource('marcas', MarcaController::class)->except(['create','show','edit']);
Route::resource('modelos', ModeloController::class)->except(['create','show','edit']);
Route::resource('colores', ColorController::class)->except(['create','show','edit']);
Route::resource('categoria_personal', CategoriaPersonalController::class)->except(['create','show','edit']);
Route::resource('estado_equipo', EstadoEquipoController::class)->except(['create','show','edit']);
Route::resource('tipo_ingreso', TipoIngresoController::class)->except(['create','show','edit']);
Route::resource('proveedores', ProveedorController::class)->except(['create','show','edit']);
Route::resource('categoria_equipos', CategoriaEquipoController::class)->except(['create','show','edit']);
Route::resource('personal', PersonalController::class)->except(['create','show','edit']);
Route::resource('areas', AreaController::class)->except(['create','show','edit']);
Route::resource('equipos', EquipoController::class)->except(['create','show','edit']);

Route::get('/inventario/codigos', [EquipoInventarioController::class, 'imprimirCodigos'])
    ->name('inventario.codigos');


Route::get('/inventario/{id}', [EquipoInventarioController::class, 'show'])
    ->name('inventario.show');


Route::resource('inventario', EquipoInventarioController::class)->except(['create','show','edit']);

Route::post('/bajas', [BajaController::class, 'store'])->name('bajas.store');
Route::get('/bajas', [BajaController::class,'index'])->name('bajas.index');
Route::put('/bajas/restaurar/{id}', [BajaController::class, 'restaurar'])
    ->name('bajas.restaurar');



Route::get('/movimientos', [MovimientoController::class, 'index'])
    ->name('movimientos.index');

Route::post('/movimientos/buscar', [MovimientoController::class, 'buscarEquipo'])
    ->name('movimientos.buscar');

Route::post('/movimientos', [MovimientoController::class, 'store'])
    ->name('movimientos.store');

Route::get('/categorias/pdf', [CategoriaController::class, 'exportarPdf'])->name('categorias.pdf');
Route::get('/categoria_equipos/pdf', [CategoriaEquipoController::class, 'exportarPdf'])->name('categoria_equipos.pdf');
Route::get('/marcas/pdf', [MarcaController::class, 'exportarPdf'])->name('marcas.pdf');
Route::get('/modelos/pdf', [ModeloController::class, 'exportarPdf'])->name('modelos.pdf');
Route::get('/colores/pdf', [ColorController::class, 'exportarPdf'])->name('colores.pdf');
Route::get('/proveedores/pdf', [ProveedorController::class, 'exportarPdf'])->name('proveedores.pdf');
Route::get('/tipo_ingreso/pdf', [TipoIngresoController::class, 'exportarPdf'])->name('tipo_ingreso.pdf');
Route::get('/estado_equipo/pdf', [EstadoEquipoController::class, 'exportarPdf'])->name('estado_equipo.pdf');
Route::get('/categoria_personal/pdf', [CategoriaPersonalController::class, 'exportarPdf'])->name('categoria_personal.pdf');
Route::get('/areas/pdf', [AreaController::class, 'exportarPdf'])->name('areas.pdf');
Route::get('/personal/pdf', [PersonalController::class, 'exportarPdf'])->name('personal.pdf');

});
