<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra cualquier servicio de la aplicaci�n.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap cualquier servicio de la aplicaci�n.
     *
     * @return void
     */
    public function boot()
    {
        // Cargar las rutas API (en caso de que no est� registrado)

        // Route::prefix('api')
        //     ->middleware('api')
        //     ->group(base_path('routes/api.php'));
        //

        // Tambi�n cargamos las rutas web
        // Route::middleware('web')
        //  ->group(base_path('routes/web.php'));

    }
}




