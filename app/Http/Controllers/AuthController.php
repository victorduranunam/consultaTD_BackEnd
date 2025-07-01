<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\UsuarioApi;

class AuthController extends Controller
{
    public function verificarUsuario(Request $request)
    {
        // Validar entrada (sin api_key en el cuerpo)
        $request->validate([
            'usuario' => 'required|string',
            'clave' => 'required|string',
        ]);

        // Leer api_key desde el header
        $apiKey = $request->header('x-api-key');
        if (!$apiKey || !$this->isValidApiKey($apiKey)) {
            return response()->json(['error' => 'API Key inválida'], 401);
        }

        // Buscar usuario por email o nombre de usuario
        $usuario = DB::table('usuarios_api')
            ->where('email', $request->usuario)
            ->first();

        if (!$usuario || !Hash::check($request->clave, $usuario->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return response()->json([
            'mensaje' => 'Autenticación exitosa',
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'email' => $usuario->email,
            ]
        ]);
    }

    public function login(Request $request)
    {
        // Validar entrada (sin api_key en el cuerpo)
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Leer api_key desde el header
        $apiKey = $request->header('x-api-key');
        if (!$apiKey || !$this->isValidApiKey($apiKey)) {
            return response()->json(['success' => false, 'message' => 'Invalid API key'], 403);
        }

        // Buscar usuario por nombre de usuario
        $user = UsuarioApi::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        // Crear token con Sanctum
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,  
            ]
        ]);
    }

    // Método privado para validar la API Key
    private function isValidApiKey($apiKey)
    {
        return DB::table('api_keys')->where('api_key', $apiKey)->exists();
    }
}
