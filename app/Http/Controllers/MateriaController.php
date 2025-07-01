<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        return response()->json(Materia::all());
    }

    public function show($id)
    {
        $materia = Materia::find($id);

        if (!$materia) {
            return response()->json([]);
        }

        return response()->json($materia);
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'clave_asignatura' => 'nullable|string',
            'nombre_asignatura' => 'nullable|string',
            'plan_estudios' => 'nullable|string',
            'division' => 'nullable|string',
        ]);

        if (
            !$request->filled('clave_asignatura') &&
            !$request->filled('nombre_asignatura') &&
            !$request->filled('plan_estudios') &&
            !$request->filled('division')
        ) {
            return response()->json([]);
        }

        $query = Materia::query();

        if ($request->filled('clave_asignatura')) {
            $query->where('clave_asignatura', $request->clave_asignatura);
        }

        if ($request->filled('nombre_asignatura')) {
            $query->where('nombre_asignatura', 'ILIKE', '%' . $request->nombre_asignatura . '%');
        }

        if ($request->filled('plan_estudios')) {
            $query->where('plan_estudios', $request->plan_estudios);
        }

        if ($request->filled('division')) {
            $query->where('division', 'ILIKE', '%' . $request->division . '%');
        }

        $resultados = $query->get();

        if ($resultados->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($resultados);
    }
}
