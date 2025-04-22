<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MetricsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Ignorer les routes API
    if ($request->is('api/*')) {
        return $next($request);
    }
        // Récupérer les métriques depuis les cookies, ou utiliser les valeurs par défaut
        $stressLevel = $request->cookie('stress_level', 0);
        $sleepLevel = $request->cookie('sleep_level', 10);
        $gradesLevel = $request->cookie('grades_level', 7);

        $response = $next($request);

        // Vérifier si les métriques ont atteint des niveaux critiques
        
        // Burnout (stress trop élevé)
        if ($stressLevel >= 10) {
            // Si l'URL actuelle n'est pas déjà '/result/failure'
            if ($request->path() !== 'result/failure' && !$request->is('api/*')) {
                return redirect('/result/failure');
            }
        }
        
        // Crise de sommeil (sommeil trop bas)
        if ($sleepLevel <= 0) {
            // Si l'URL actuelle n'est pas déjà '/result/sleep-crisis'
            if ($request->path() !== 'result/sleep-crisis' && !$request->is('api/*')) {
                return redirect('/result/sleep-crisis');
            }
        }
        
        // Crise académique (notes trop basses)
        if ($gradesLevel <= 0) {
            // Si l'URL actuelle n'est pas déjà '/result/academic-crisis'
            if ($request->path() !== 'result/academic-crisis' && !$request->is('api/*')) {
                return redirect('/result/academic-crisis');
            }
        }

        return $response;
    }
}