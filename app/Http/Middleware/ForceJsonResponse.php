<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Forcer toutes les réponses à être en JSON
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // Dans app/Http/Middleware/ForceJsonResponse.php
public function handle(Request $request, Closure $next)
{
    // Forcez l'en-tête Accept à application/json
    $request->headers->set('Accept', 'application/json');
    
    // Vous pouvez aussi ajouter cette ligne pour être sûr
    $request->headers->set('Content-Type', 'application/json');
    
    return $next($request);
}
}