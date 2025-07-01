<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Validar",
 *     description="Operaciones para validar alumnos y profesores"
 * )
 */



class ValidarUsuarioController extends Controller
{

  /**
 * @OA\Post(
 *     path="/APIeducafi/api/validar/buscar",
 *     summary="Buscar alumnos y profesores por criterios",
 *     tags={"Validar"},
 *     @OA\RequestBody(
 *         required=true,
 *         content={
 *             @OA\MediaType(
 *                 mediaType="application/json",
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="nombre", type="string", example="Juan"),
 *                     @OA\Property(property="apellido_paterno", type="string", example="Pérez"),
 *                     @OA\Property(property="apellido_materno", type="string", example="García"),
 *                     @OA\Property(property="correo_personal", type="string", example="juan@mail.com"),
 *                     @OA\Property(property="identificador", type="string", example="12345678")
 *                 )
 *             )
 *         }
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
        'identificador' => 'nullable|string',
    ]);

    // Asegura que al menos un campo esté presente
    if (
        !$request->filled('nombre') &&
        !$request->filled('apellido_paterno') &&
        !$request->filled('apellido_materno') &&
        !$request->filled('correo_personal') &&
        !$request->filled('identificador')
    ) {
        return response()->json(['error' => 'Debe enviar al menos un campo para buscar.'], 400);
    }

    try {
        // Ejecutar el procedimiento almacenado y obtener los resultados
        $resultados = DB::select('
            SELECT * FROM validar_usuarios_actuales(?, ?, ?, ?, ?)', [
                $request->nombre ?? null, // Si no existe, pasa null
                $request->apellido_paterno ?? null, 
                $request->apellido_materno ?? null,
                $request->correo_personal ?? null,
                $request->identificador ?? null
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



 /**
     * @OA\Get(
     *     path="/APIeducafi/api/validar/verdatos",
     *     summary="Obtiene los datos validados de un usuario",
     *     tags={"Validar"},
     *     @OA\Parameter(
     *         name="identificador",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="Datos del profesor o Alumno validados"
     *     ),
     *     @OA\Parameter(
     *         name="tipo_usuario",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"Profesor", "Alumno"}),
     *         description="Tipo de usuario: Profesor o Alumno"
     *     ),
     *     @OA\Response(response=200, description="Datos del usuario"),
     *     @OA\Response(response=400, description="Parámetros faltantes o inválidos"),
     *     @OA\Response(response=500, description="Error al ejecutar la función")
     * )
     */
    public function verdatos(Request $request)
    {
        Log::info('Datos recibidos en verdatos:', $request->all());

        $request->validate([
            'identificador' => 'required|string',
            'tipo_usuario' => 'required|string|in:Profesor,Alumno',
        ]);

        try {
            $datos = DB::select('SELECT * FROM obtener_datos_usuario_validado(?, ?)', [
                $request->identificador,
                $request->tipo_usuario
            ]);
        } catch (\Exception $e) {
            Log::error('Error en verdatos: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un error al obtener los datos.'], 500);
        }

        return response()->json($datos);
    }



}
