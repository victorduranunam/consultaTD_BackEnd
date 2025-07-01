<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener el token desde el encabezado HTTP
        $apiKey = $request->header('X-API-KEY'); // Usa el nombre estándar

        if (!$apiKey) {
            return response()->json(['error' => 'Petición Invalida'], 401);
        }

        // Verifica si existe ese token en la tabla
        $exists = DB::table('api_keys')->where('api_key', $apiKey)->exists();

        if (!$exists) {
            return response()->json(['error' => 'Petición invalida2'], 401);
        }

        // Si el token es válido, continúa con la solicitud
        return $next($request);
    }
}
