<?php

use Illuminate\Support\Facades\Route;

Route::get('/administrador', function () {
    return view('administrador.dashboard');
});

