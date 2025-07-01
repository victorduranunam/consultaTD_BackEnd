<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;


/**
 * @OA\Tag(
 *     name="ApiKeyController",
 *     description="Generar token para un desarrollador"
 * )
 */


class ApiKeyController extends Controller
{
    public function showForm()
    {
        //return view('crear_desarrollador');
        return view('usuario.token');
    }


       /**
     * @OA\Post(
     *     path="/APIeducafi/api/CrearToken/store",
     *     tags={"Crear Token"},
     *     summary="Generar nuevo token de desarrollador",
     *     description="Crea una nueva API key asociada a un nombre proporcionado.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="apiKey", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="api_key", type="string", example="f3h4g...1234")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apiKey = ApiKey::create([
            'name' => $request->name,
            'api_key' => Str::random(32),
        ]);

        return view('usuario.token', [
            'success' => true,
            'apiKey' => $apiKey,
        ]);
    }
}
