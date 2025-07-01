<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GrupoAlumno;

class GrupoAlumnoController extends Controller
{
    /**
     * Mostrar todos los registros de grupos_alumnos.
     */
    public function index()
    {
        return response()->json(GrupoAlumno::all());
    }

    /**
     * Mostrar el registro especifico de grupo_alumno.
     */
    public function show(string $id_grupos_alumnos)
    {
        return response()->json(GrupoAlumno::findOrFail($id_grupos_alumnos));
    }



    public function obtenerGruposPorAlumno($numeroCuenta)
    {
        $resultado = DB::select('SELECT * FROM public.obtener_grupos_alumno(?)', [$numeroCuenta]);
    
        if (empty($resultado)) {
            return response()->json((object)[]); // Esto devuelve {}
        }
    
        return response()->json($resultado);
    }
    

}
