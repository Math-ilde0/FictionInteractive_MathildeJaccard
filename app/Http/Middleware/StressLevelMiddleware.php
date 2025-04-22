<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StressLevelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Utiliser les cookies au lieu des sessions
        $stressLevel = $request->cookie('stress_level', 0);
    
        $response = $next($request);
    
        // Vérifier si le niveau de stress dépasse 10 (burnout)
        if ($stressLevel >= 10) {
            // Si l'URL actuelle n'est pas déjà '/result/failure'
            if ($request->path() !== 'result/failure' && !$request->is('api/*')) {
                return redirect('/result/failure');
            }
        }
    
        return $response;
    }
}