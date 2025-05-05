<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * L'itinéraire vers lequel les utilisateurs sont redirigés après l'authentification.
     *
     * @var string
     */
    public const HOME = '/testimonies';
    /**
     * Définir les routes de l'application.
     */
    public function boot()
{
    $this->routes(function () {
        // API routes without 'api' prefix
        Route::middleware(['api', \App\Http\Middleware\ForceJsonResponse::class])
            ->group(base_path('routes/api.php'));

        // Web routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}
}
