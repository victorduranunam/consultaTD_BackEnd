<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ValidarUsuarioController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\GrupoAlumnoController;
use App\Http\Controllers\AuthController;  
use App\Http\Controllers\PrebecarioController;
use App\Http\Controllers\CrearUsuarioController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\MateriaController;


Route::get('/ping', function () {
    return response()->json([
        'status'  => 'OK',
        'message' => 'API está activa',
        'time'    => now()->toIso8601String(),
    ], 200);
});


//use App\Http\Middleware\TestMiddleware;
//Route::middleware(TestMiddleware::class)->get('/test-middleware', function () {
//    return response()->json(['mensaje' => 'Middleware funciona']);
//});




Route::middleware(ApiKeyMiddleware::class)->group(function () {

    // Rutas de alumnos
    Route::get('/alumnos', [AlumnoController::class, 'index']);
    Route::get('/alumnos/{numero_cuenta}', [AlumnoController::class, 'show']);
    Route::post('/alumnos/buscar', [AlumnoController::class, 'buscar']);

    // Rutas de profesores
    Route::get('/profesores', [ProfesorController::class, 'index']);
    Route::get('/profesores/{rfc}', [ProfesorController::class, 'show']);
    Route::post('/profesores/buscar', [ProfesorController::class, 'buscar']);
    Route::get('/profesores/buscar_grupos/{rfc}', [ProfesorController::class, 'buscar_grupos']);
    Route::get('/profesores/obtenerMateriaPorClave/{clave_asignatura}', [ProfesorController::class, 'obtenerMateriaPorClave']);
    Route::post('/profesores/obtenerGrupoPorAsignaturaYNumero', [ProfesorController::class, 'obtenerGrupoPorAsignaturaYNumero']);
    Route::get('/profesores/mostrar_nombre/{rfc}', [ProfesorController::class, 'mostrar_nombre']);
    Route::post('/profesores/alumnos_grupo', [ProfesorController::class, 'alumnos_grupo']);


    // Rutas de grupos
    Route::get('/grupos', [GrupoController::class, 'index']);
    Route::get('/grupos/{id_grupo}', [GrupoController::class, 'show']);


    // Rutas de grupos_alumnos
    Route::get('/grupos_alumnos', [GrupoAlumnoController::class, 'index']);
    Route::get('/grupos_alumnos/{id_grupos_alumnos}', [GrupoAlumnoController::class, 'show']);
    Route::get('/grupos_alumnos/buscar/{numeroCuenta}', [GrupoAlumnoController::class, 'obtenerGruposPorAlumno']);


    // Rutas de prebecarios
    Route::post('/prebecarios/buscar', [PrebecarioController::class, 'buscar']);

    // Rutas de materias
    Route::get('/materias', [MateriaController::class, 'index']);
    Route::get('/materias/{clave_asignatura}', [MateriaController::class, 'show']);



});




Route::middleware('api')->group(function () {
    Route::post('/validar/buscar', [ValidarUsuarioController::class, 'buscar']);
    Route::post('/validar/verdatos', [ValidarUsuarioController::class, 'verdatos']);
});




Route::middleware('api')->group(function () {
    Route::post('/verificar-usuario', [AuthController::class, 'verificarUsuario']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/CrearUsuario/store', [CrearUsuarioController::class, 'store']);
Route::post('/CrearToken/store', [ApiKeyController::class, 'store']);


