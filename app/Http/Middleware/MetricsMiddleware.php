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
        // Initialiser les métriques si elles n'existent pas encore
        if (!session()->has('stress_level')) {
            session(['stress_level' => 0]);
        }
        
        if (!session()->has('sleep_level')) {
            session(['sleep_level' => 10]); // 10 = bien reposé
        }
        
        if (!session()->has('grades_level')) {
            session(['grades_level' => 7]); // 7 = bonnes notes
        }

        $response = $next($request);

        // Vérifier si les métriques ont atteint des niveaux critiques
        
        // Burnout (stress trop élevé)
        if (session('stress_level') >= 10) {
            // Si l'URL actuelle n'est pas déjà '/result/failure'
            if ($request->path() !== 'result/failure' && !$request->is('api/*')) {
                return redirect('/result/failure');
            }
        }
        
        // Crise de sommeil (sommeil trop bas)
        if (session('sleep_level') <= 1) {
            // Si l'URL actuelle n'est pas déjà '/result/sleep-crisis'
            if ($request->path() !== 'result/sleep-crisis' && !$request->is('api/*')) {
                return redirect('/result/sleep-crisis');
            }
        }
        
        // Crise académique (notes trop basses)
        if (session('grades_level') <= 1) {
            // Si l'URL actuelle n'est pas déjà '/result/academic-crisis'
            if ($request->path() !== 'result/academic-crisis' && !$request->is('api/*')) {
                return redirect('/result/academic-crisis');
            }
        }

        return $response;
    }
}