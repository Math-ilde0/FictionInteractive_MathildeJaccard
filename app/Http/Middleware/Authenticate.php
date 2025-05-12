<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * Middleware d'authentification.
 * Redirige les utilisateurs non authentifiés vers la page de connexion,
 * sauf si la requête attend une réponse JSON.
 * 
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Détermine vers quelle route rediriger si l'utilisateur n'est pas authentifié.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return '/login';
        }
    }
}
