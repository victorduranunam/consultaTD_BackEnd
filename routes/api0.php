<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AlumnoController;

Route::middleware('api')->group(function () {
    Route::get('/alumnos', [AlumnoController::class, 'index']);
    //Route::middleware('auth.apikey')->get('/alumnos', [AlumnoController::class, 'index']);
    Route::get('/alumnos/{numero_cuenta}', [AlumnoController::class, 'show']);
    Route::post('/alumnos/buscar', [AlumnoController::class, 'buscar']);
});


use App\Http\Controllers\ValidarUsuarioController;

Route::middleware('api')->group(function () {
    Route::post('/validar/buscar', [ValidarUsuarioController::class, 'buscar']);
    Route::post('/validar/verdatos', [ValidarUsuarioController::class, 'verdatos']);
});




use App\Http\Controllers\ProfesorController;

//Route::middleware('api')->group(function () {
Route::middleware(['api', 'auth.apikey'])->group(function () {
    Route::get('/profesores', [ProfesorController::class, 'index']);
    Route::get('/profesores/{rfc}', [ProfesorController::class, 'show']);
    Route::post('/profesores/buscar', [ProfesorController::class, 'buscar']);
    Route::get('/profesores/buscar_grupos/{rfc}', [ProfesorController::class, 'buscar_grupos']);
    Route::get('/profesores/obtenerMateriaPorClave/{clave_asignatura}', [ProfesorController::class, 'obtenerMateriaPorClave']);
    Route::POST('/profesores/obtenerGrupoPorAsignaturaYNumero', [ProfesorController::class, 'obtenerGrupoPorAsignaturaYNumero']);
    Route::get('/profesores/mostrar_nombre/{rfc}', [ProfesorController::class, 'mostrar_nombre']);
    Route::POST('/profesores/alumnos_grupo', [ProfesorController::class, 'alumnos_grupo']);
   

});





use App\Http\Controllers\MareriaController;

Route::middleware('api')->group(function () {
    Route::get('/materias', [MateriaController::class, 'index']);
    Route::get('/materias/{clave_asignatura}', [MateriaController::class, 'show']);
});


use App\Http\Controllers\GrupoController;

Route::middleware('api')->group(function () {
    Route::get('/grupos', [GrupoController::class, 'index']);
    Route::get('/grupos/{id_grupo}', [GrupoController::class, 'show']);
});




use App\Http\Controllers\GrupoAlumnoController;

Route::middleware('api')->group(function () {
    Route::get('/grupos_alumnos', [GrupoAlumnoController::class, 'index']);
    Route::get('/grupos_alumnos/{id_grupos_alumnos}', [GrupoAlumnoController::class, 'show']);
    Route::get('/grupos_alumnos/buscar/{numeroCuenta}', [GrupoAlumnoController::class, 'obtenerGruposPorAlumno']);
});




use App\Http\Controllers\AuthController;  

Route::middleware('api')->group(function () {
    Route::post('/verificar-usuario', [AuthController::class, 'verificarUsuario']);
});

Route::post('/login', [AuthController::class, 'login']);


use App\Http\Controllers\PrebecarioController;
Route::middleware('api')->group(function () {
    Route::post('/prebecarios/buscar', [PrebecarioController::class, 'buscar']);
});



use App\Http\Controllers\CrearUsuarioController;
Route::post('/CrearUsuario/store', [CrearUsuarioController::class, 'store']);



use App\Http\Controllers\ApiKeyController;
Route::post('/CrearToken/store', [ApiKeyController::class, 'store']);


