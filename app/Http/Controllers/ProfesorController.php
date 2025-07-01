<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Profesor;
use OpenApi\Annotations as OA;



/**
 * @OA\Tag(
 *     name="Profesores",
 *     description="Operaciones relacionadas con profesores"
 * )
 */



class ProfesorController extends Controller
{


        /**
     * @OA\Get(
     *     path="/APIeducafi/api/profesores/",
     *     summary="Obtener todos los profesores",
     *     tags={"Profesores"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de profesores",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="num_trabajador", type="string", example="T1234"),
     *                 @OA\Property(property="nombre", type="string", example="María"),
     *                 @OA\Property(property="ape_paterno", type="string", example="López"),
     *                 @OA\Property(property="correo_personal", type="string", example="maria@mail.com")
     *             )
     *         )
     *     )
     * )
     */


    // Método para obtener todos los profesores
    public function index()
    {
        $profesores = Profesor::all();
    
        if ($profesores->isEmpty()) {
            return response()->json([], 200); // respuesta vacía
        }
    
        return response()->json($profesores);
    }
    


        /**
     * @OA\Get(
     *     path="/APIeducafi/api/profesores/{num_trabajador}",
     *     summary="Obtener un profesor por número de trabajador",
     *     tags={"Profesores"},
     *     @OA\Parameter(
     *         name="num_trabajador",
     *         in="path",
     *         required=true,
     *         description="Número de trabajador del profesor",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos del profesor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="num_trabajador", type="string", example="T1234"),
     *             @OA\Property(property="nombre", type="string", example="María"),
     *             @OA\Property(property="ape_paterno", type="string", example="López"),
     *             @OA\Property(property="correo_personal", type="string", example="maria@mail.com")
     *         )
     *     )
     * )
     */


    // Método para obtener un profesor por número de trabajador
    public function show($num_trabajador)
    {
        $profesor = Profesor::where('num_trabajador', $num_trabajador)->first();
        
        if (!$profesor) {
            return response()->json([], 200); // Regreso vacío si no se encuentra
        }
        
        return response()->json($profesor);
    }

        
    


        /**
     * @OA\Post(
     *     path="/APIeducafi/api/profesores/buscar",
     *     summary="Buscar profesores por criterios",
     *     tags={"Profesores"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="María"),
     *             @OA\Property(property="ape_paterno", type="string", example="López"),
     *             @OA\Property(property="ape_materno", type="string", example="Hernández"),
     *             @OA\Property(property="correo_personal", type="string", example="maria@mail.com"),
     *             @OA\Property(property="num_trabajador", type="string", example="T1234")
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

    

    // Método para buscar profesores por varios criterios
    public function buscar(Request $request)
    {
        $nombre = $request->input('nombre');
        $apePaterno = $request->input('ape_paterno');
        $apeMaterno = $request->input('ape_materno');
        $correo = $request->input('correo_personal');
        $numTrabajador = $request->input('num_trabajador');

        // Se recomienda enviar NULL explícitamente si un campo viene vacío
        $profesores = DB::select("
            SELECT * FROM buscar_profesores(?, ?, ?, ?, ?)",
            [
                $nombre ?: null,
                $apePaterno ?: null,
                $apeMaterno ?: null,
                $correo ?: null,
                $numTrabajador ?: null
            ]
        );

        return response()->json($profesores);
    }



    /**
 * @OA\Get(
 *     path="/APIeducafi/api/profesores/buscar_grupos/{rfc}",
 *     summary="Buscar grupos del profesor por RFC",
 *     tags={"Profesores"},
 *     @OA\Parameter(
 *         name="rfc",
 *         in="path",
 *         description="RFC del profesor",
 *         required=true,
 *         @OA\Schema(type="string", example="GOML800101ABC")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de grupos del profesor",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 example={
 *                     "clave_grupo": "GPO01",
 *                     "clave_asignatura": "MAT101",
 *                     "nombre_asignatura": "Matemáticas I",
 *                     "numero_grupo": "1"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Profesor no encontrado o sin grupos"
 *     )
 * )
 */


    // Método para buscar grupos de los profesores
    public function buscar_grupos($rfc)
    {

        // Se recomienda enviar NULL explícitamente si un campo viene vacío
        $grupos = DB::select("
            SELECT * FROM profesor_grupos(?)",
            [
                $rfc ?: null,

            ]
        );

        return response()->json($grupos);
    }
    

    public function obtenerMateriaPorClave($clave_asignatura)
    {
        // Validamos que la clave de asignatura esté presente
        if (empty($clave_asignatura)) {
            return response()->json(['error' => 'Clave de asignatura es requerida'], 400);
        }

        // Ejecutamos la función en la base de datos usando DB::select
        $resultado = DB::select('SELECT * FROM public.obtener_materia_por_clave(:clave_asignatura)', [
            'clave_asignatura' => $clave_asignatura,
        ]);

        // Si no hay resultados, devolvemos un arreglo vacío
        if (empty($resultado)) {
            return response()->json([]);
        }

        // Retornamos el resultado como una respuesta JSON
        return response()->json($resultado);
    }





/**
 * @OA\Post(
 *     path="/APIeducafi/api/profesores/obtenerGrupoPorAsignaturaYNumero",
 *     summary="Obtener grupo por clave de asignatura y número de grupo",
 *     tags={"Profesores"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos necesarios para buscar el grupo",
 *         @OA\JsonContent(
 *             required={"clave_asignatura", "numero_grupo"},
 *             @OA\Property(
 *                 property="clave_asignatura",
 *                 type="string",
 *                 example="MAT101"
 *             ),
 *             @OA\Property(
 *                 property="numero_grupo",
 *                 type="string",
 *                 example="02"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Información del grupo",
 *         @OA\JsonContent(
 *             type="object",
 *             example={
 *                 "clave_asignatura": "MAT101",
 *                 "numero_grupo": "02",
 *                 "nombre_profesor": "María López",
 *                 "salon": "B203"
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Faltan parámetros requeridos"
 *     )
 * )
 */

    public function obtenerGrupoPorAsignaturaYNumero(Request $request)
    {
        // Validamos que los parámetros necesarios estén presentes en el cuerpo de la solicitud
        $request->validate([
            'clave_asignatura' => 'required|string',
            'numero_grupo' => 'required|string',
        ]);
    
        // Extraemos los datos del cuerpo de la solicitud
        $clave_asignatura = $request->input('clave_asignatura');
        $numero_grupo = $request->input('numero_grupo');
    
        // Ejecutamos la función en la base de datos usando DB::select
        $resultado = DB::select('SELECT * FROM public.obtener_grupo_por_asignatura_y_numero(:clave_asignatura, :numero_grupo)', [
            'clave_asignatura' => $clave_asignatura,
            'numero_grupo' => $numero_grupo,
        ]);
    
        // Si no hay resultados, devolvemos un arreglo vacío
        if (empty($resultado)) {
            return response()->json([]);
        }
    
        // Retornamos el resultado como respuesta JSON
        return response()->json($resultado);
    }
    



    /**
 * @OA\Get(
 *     path="/APIeducafi/api/profesores/mostrar_nombre/{rfc}",
 *     summary="Obtener el nombre de un profesor por su RFC",
 *     tags={"Profesores"},
 *     @OA\Parameter(
 *         name="rfc",
 *         in="path",
 *         description="RFC del profesor",
 *         required=true,
 *         @OA\Schema(type="string", example="GOML800101A12")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nombre del profesor",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 example={
 *                     "nombre": "Luis Gómez Martínez"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="RFC inválido o no proporcionado"
 *     )
 * )
 */



    // Método para buscar datos de los profesores 
    public function mostrar_nombre($rfc)
        {
    
            // Se recomienda enviar NULL explícitamente si un campo viene vacío
            $grupos = DB::select("
                SELECT * FROM nombre_profesor (?)",
                [
                    $rfc ?: null,
    
                ]
            );
    
            return response()->json($grupos);
        }

    

    /**
 * @OA\Post(
 *     path="/APIeducafi/api/profesores/alumnos_grupo",
 *     summary="Obtener alumnos por clave de asignatura y número de grupo",
 *     tags={"Profesores"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Datos para identificar el grupo",
 *         @OA\JsonContent(
 *             required={"clave_asignatura", "numero_grupo"},
 *             @OA\Property(
 *                 property="clave_asignatura",
 *                 type="string",
 *                 example="MAT101"
 *             ),
 *             @OA\Property(
 *                 property="numero_grupo",
 *                 type="string",
 *                 example="02"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de alumnos",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 example={
 *                     "matricula": "202045678",
 *                     "nombre_completo": "Juan Pérez Rodríguez"
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Faltan parámetros requeridos"
 *     )
 * )
 */


    
    // Método para buscar alumnos por grupo 
    public function alumnos_grupo(Request $request)
    {
        // Validamos que se envíen los parámetros necesarios
        $request->validate([
            'clave_asignatura' => 'required|string',
            'numero_grupo' => 'required|string',
        ]);

        // Capturamos los datos del request
        $claveAsignatura = $request->input('clave_asignatura');
        $numeroGrupo = $request->input('numero_grupo');

        // Llamamos a la función SQL de PostgreSQL
        $alumnos = DB::select(
            'SELECT * FROM public.obtener_alumnos_por_grupo_asignatura(?, ?)', 
            [$claveAsignatura, $numeroGrupo]
        );

        // Retornamos la respuesta en formato JSON
        return response()->json($alumnos);
    }

    

    
}
