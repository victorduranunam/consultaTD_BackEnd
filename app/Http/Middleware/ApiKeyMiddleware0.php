<?php

namespace App\Http\Middleware; // <-- ¡Este namespace debe ser exacto!

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiKeyMiddleware // <-- ¡Este nombre de clase debe ser exacto!
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('x-api-key');

        if (!$apiKey) {
            return response()->json([], 401);
        }

        // Asegúrate de que tu tabla 'api_keys' y la columna 'api_key' existen.
        $existe = DB::table('api_keys')->where('api_key', $apiKey)->exists();

        if (!$existe) {
            return response()->json([], 401);
        }

        return $next($request);
    }
}