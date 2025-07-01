<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Alumnos",
 *     description="Operaciones relacionadas con alumnos"
 * )
 */

class AlumnoController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/alumnos",
     *     summary="Listar todos los alumnos",
     *     tags={"Alumnos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de alumnos"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Alumno::all());
    }





    /**
     * @OA\Get(
     *     path="/api/alumnos/{numero_cuenta}",
     *     summary="Mostrar un alumno por número de cuenta",
     *     tags={"Alumnos"},
     *     @OA\Parameter(
     *         name="numero_cuenta",
     *         in="path",
     *         required=true,
     *         description="Número de cuenta del alumno",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos del alumno"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alumno no encontrado"
     *     )
     * )
     */
    public function show(string $numero_cuenta)
    {
        $alumno = Alumno::find($numero_cuenta);

        if (!$alumno) {
          return response()->json(null); // También puedes usar: []
        }

        return response()->json($alumno);
    }




   /**
     * @OA\Post(
     *     path="/api/alumnos/buscar",
     *     summary="Buscar alumnos por criterios",
     *     tags={"Alumnos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan"),
     *             @OA\Property(property="apellido_paterno", type="string", example="Pérez"),
     *             @OA\Property(property="apellido_materno", type="string", example="García"),
     *             @OA\Property(property="correo_personal", type="string", example="juan@mail.com"),
     *             @OA\Property(property="numero_cuenta", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resultados de la búsqueda"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Debe enviar al menos un campo para buscar"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al ejecutar la consulta"
     *     )
     * )
     */

   public function buscar(Request $request)
{
    // Log para depuración
    Log::info('Datos recibidos en buscar:', $request->all());

    // Validación de los campos
    $request->validate([
        'nombre' => 'nullable|string',
        'apellido_paterno' => 'nullable|string',
        'apellido_materno' => 'nullable|string',
        'correo_personal' => 'nullable|string',
        'numero_cuenta' => 'nullable|string',
    ]);

    // Asegura que al menos un campo esté presente
    if (
        !$request->filled('nombre') &&
        !$request->filled('apellido_paterno') &&
        !$request->filled('apellido_materno') &&
        !$request->filled('correo_personal') &&
        !$request->filled('numero_cuenta')
    ) {
        return response()->json(['error' => 'Debe enviar al menos un campo para buscar.'], 400);
    }

    try {
        // Ejecutar el procedimiento almacenado y obtener los resultados
        $resultados = DB::select('
            SELECT * FROM buscar_alumnos(?, ?, ?, ?, ?)', [
                $request->nombre ?? null, // Si no existe, pasa null
                $request->apellido_paterno ?? null,
                $request->apellido_materno ?? null,
                $request->correo_personal ?? null,
                $request->numero_cuenta ?? null
            ]);
    } catch (\Exception $e) {
        // Log para depuración del error
        Log::error('Error al ejecutar la consulta: ' . $e->getMessage());
        return response()->json(['error' => 'Hubo un error en la consulta.'], 500);
    }

    // Si no se encontraron resultados, devolver un array vacío
    if (empty($resultados)) {
        return response()->json([]);
    }

    // Devolver los resultados encontrados
    return response()->json($resultados);
}






}
