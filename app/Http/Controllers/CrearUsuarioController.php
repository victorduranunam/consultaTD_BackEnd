<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioApi;
/**
 * @OA\Tag(
 *     name="CrearUsuarioControllerr",
 *     description="Generar un usuario"
 * )
 */

class CrearUsuarioController extends Controller
{
    public function showForm()
    {
        return view('usuario.crear');
    }


       /**
     * @OA\Post(
     *     path="/APIeducafi/api/CrearUsuario/store",
     *     tags={"Crear Usuario"},
     *     summary="Crear un nuevo usuario",
     *     description="Registra un nuevo usuario con nombre, usuario, email y contraseña en la base de datos.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "name", "email", "password"},
     *             @OA\Property(property="username", type="string", example="dev123"),
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secreto123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Usuario creado exitosamente y redireccionado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */


    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'username' => 'required|string|max:255|unique:usuarios_api', // Se ajusta la validación para username
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios_api,email',
            'password' => 'required|string|min:8',
        ]);
    
        // Crear el usuario, el campo 'password' se encripta automáticamente 
        $usuario = UsuarioApi::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);
        
    
        // Redirigir a una ruta con un mensaje de éxito
        return redirect()->back();

    }
}

