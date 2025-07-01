<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;

class GrupoController extends Controller
{
    public function index()
    {
        return response()->json(Grupo::all());
    }

    public function show($id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return response()->json([]);
        }

        return response()->json($grupo);
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'clave_asignatura' => 'nullable|string',
            'rfc' => 'nullable|string',
            'numero_grupo' => 'nullable|string',
            'modalidad' => 'nullable|string',
            'estatus_grupo' => 'nullable|integer',
        ]);

        if (
            !$request->filled('clave_asignatura') &&
            !$request->filled('rfc') &&
            !$request->filled('numero_grupo') &&
            !$request->filled('modalidad') &&
            !$request->filled('estatus_grupo')
        ) {
            return response()->json([]);
        }

        $query = Grupo::query();

        if ($request->filled('clave_asignatura')) {
            $query->where('clave_asignatura', $request->clave_asignatura);
        }

        if ($request->filled('rfc')) {
            $query->where('rfc', $request->rfc);
        }

        if ($request->filled('numero_grupo')) {
            $query->where('numero_grupo', $request->numero_grupo);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', 'ILIKE', '%' . $request->modalidad . '%');
        }

        if ($request->filled('estatus_grupo')) {
            $query->where('estatus_grupo', $request->estatus_grupo);
        }

        $resultados = $query->get();

        if ($resultados->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($resultados);
    }
}
