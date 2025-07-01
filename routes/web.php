<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\CrearUsuarioController;

Route::get('/', function () {
    return view('welcome');
});




Route::get('usuario/token', [ApiKeyController::class, 'showForm']);
Route::post('usuario/token', [ApiKeyController::class, 'store']);


Route::get('usuario/crear',  [CrearUsuarioController::class, 'showForm']);
Route::post('usuario/crear', [CrearUsuarioController::class, 'store']);
