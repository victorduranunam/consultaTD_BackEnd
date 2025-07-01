<?php

namespace App\Http\Controllers;

use App\Models\UsuarioApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioApiController extends Controller
{
    // Método para registrar un nuevo usuario
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios_api',
            'password' => 'required|string|min:6',
        ]);

        $usuario = UsuarioApi::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'usuario' => $usuario], 201);
    }

    // Método para autenticar un usuario (por ejemplo, con su email y contraseña)
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $usuario = UsuarioApi::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Aquí puedes generar un token o API key si es necesario
        return response()->json(['success' => true, 'usuario' => $usuario]);
    }
}
