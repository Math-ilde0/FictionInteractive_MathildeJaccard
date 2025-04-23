<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Définir les routes de l'application.
     */
    public function boot()
    {
        $this->routes(function () {
            // Routes API sans préfixe "api"
            Route::middleware(['api']) // Retirez 'json.response' d'ici
                ->group(base_path('routes/api.php'));

            // Routes web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}