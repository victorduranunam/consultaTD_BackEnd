<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidarApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey || !DB::table('api_keys')->where('api_key', $apiKey)->exists()) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        return $next($request);
    }
}
