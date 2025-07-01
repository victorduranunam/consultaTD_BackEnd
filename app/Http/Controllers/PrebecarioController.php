<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;


/**
 * @OA\Tag(
 *     name="Prebecarios",
 *     description="Operaciones relacionadas con prebecarios"
 * )
 */



class PrebecarioController extends Controller
{


    /**
 * @OA\Post(
 *     path="/APIeducafi/api/prebecarios/buscar",
 *     summary="Buscar candidatos a prebecarios",
 *     tags={"Prebecarios"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Filtros opcionales para buscar candidatos a prebecarios",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="avance_min",
 *                 type="number",
 *                 format="float",
 *                 example=50,
 *                 description="Porcentaje mínimo de avance"
 *             ),
 *             @OA\Property(
 *                 property="avance_max",
 *                 type="number",
 *                 format="float",
 *                 example=100,
 *                 description="Porcentaje máximo de avance"
 *             ),
 *             @OA\Property(
 *                 property="carrera",
 *                 type="string",
 *                 example="Ingeniería en Computación",
 *                 description="Nombre de la carrera"
 *             ),
 *             @OA\Property(
 *                 property="promedio_min",
 *                 type="number",
 *                 format="float",
 *                 example=8.0,
 *                 description="Promedio mínimo"
 *             ),
 *             @OA\Property(
 *                 property="promedio_max",
 *                 type="number",
 *                 format="float",
 *                 example=10.0,
 *                 description="Promedio máximo"
 *             ),
 *             @OA\Property(
 *                 property="semestre_ingreso",
 *                 type="string",
 *                 example="2023-2",
 *                 description="Semestre de ingreso (formato: AAAA-N)"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de candidatos encontrados",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 example={
 *                     "nombre": "Ana Torres López",
 *                     "carrera": "Ingeniería en Computación",
 *                     "promedio": 9.2,
 *                     "avance": 75,
 *                     "semestre_ingreso": "2022-1"
 *                 }
 *             )
 *         )
 *     )
 * )
 */


    public function buscar(Request $request)
    {
        $avance_min = $request->input('avance_min');
        $avance_max = $request->input('avance_max');
        $carrera = $request->input('carrera');
        $promedio_min = $request->input('promedio_min');
        $promedio_max = $request->input('promedio_max');
        $semestre_ingreso = $request->input('semestre_ingreso');

        $resultados = DB::select("
            SELECT * FROM buscar_candidatos_prebecarios(?, ?, ?, ?, ?, ?)
        ", [
            $avance_min,
            $avance_max,
            $carrera,
            $promedio_min,
            $promedio_max,
            $semestre_ingreso,
        ]);

        return response()->json($resultados);
    }
}
