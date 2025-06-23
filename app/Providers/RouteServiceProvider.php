<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * RouteServiceProvider
 * 
 * Ce fournisseur configure la manière dont les routes de l'application sont chargées.
 * Il définit également la route par défaut après connexion.
 *
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Chemin vers lequel les utilisateurs sont redirigés après authentification.
     * Utilisé dans les middlewares comme `RedirectIfAuthenticated`.
     *
     * @var string
     */
    public const HOME = '/testimonies';

    /**
     * Définir les routes de l'application (API et Web).
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {


            /**
             * Chargement des routes Web avec gestion de session, CSRF, etc.
             * Les routes sont définies dans `routes/web.php`.
             */
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
