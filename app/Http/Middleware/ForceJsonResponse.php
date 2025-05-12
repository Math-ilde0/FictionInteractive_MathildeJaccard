<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware qui force toutes les requêtes à accepter des réponses JSON.
 * 
 * @package App\Http\Middleware
 */
class ForceJsonResponse
{
    /**
     * Modifie les en-têtes de la requête pour forcer le JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Forcez l'en-tête Accept à application/json
        $request->headers->set('Accept', 'application/json');

        // Ajoutez aussi Content-Type si nécessaire
        $request->headers->set('Content-Type', 'application/json');

        return $next($request);
    }
}
