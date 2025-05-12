<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware qui vérifie le niveau de stress à partir des cookies.
 * Redirige vers la page d'échec si le seuil de burnout est dépassé.
 * 
 * @package App\Http\Middleware
 */
class StressLevelMiddleware
{
    /**
     * Traite la requête entrante et redirige si le stress est trop élevé.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        $stressLevel = $request->cookie('stress_level', 0);

        $response = $next($request);

        if ($stressLevel >= 10 && $request->path() !== 'result/failure') {
            return redirect('/result/failure');
        }

        return $response;
    }
}
