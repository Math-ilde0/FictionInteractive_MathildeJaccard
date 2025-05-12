<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware qui vérifie les métriques de l'utilisateur dans la session
 * et redirige en cas de surcharge mentale, de manque de sommeil ou d'échec académique.
 * 
 * @package App\Http\Middleware
 */
class MetricsMiddleware
{
    /**
     * Traite la requête entrante et applique les redirections si nécessaire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        $stressLevel = session('stress_level', 3);
        $sleepLevel = session('sleep_level', 7);
        $gradesLevel = session('grades_level', 6);

        $response = $next($request);

        // Redirections selon les seuils atteints
        if ($stressLevel >= 10 && $request->path() !== 'result/failure') {
            return redirect('/result/failure');
        }

        if ($sleepLevel <= 0 && $request->path() !== 'result/sleep-crisis') {
            return redirect('/result/sleep-crisis');
        }

        if ($gradesLevel <= 0 && $request->path() !== 'result/academic-crisis') {
            return redirect('/result/academic-crisis');
        }

        return $response;
    }
}
