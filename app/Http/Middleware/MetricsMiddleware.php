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
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer les métriques depuis les cookies, ou utiliser les valeurs par défaut
        $stressLevel = $request->cookie('stress_level', 3);
        $sleepLevel = $request->cookie('sleep_level', 7);
        $gradesLevel = $request->cookie('grades_level', 6);

        $response = $next($request);

        // Burnout (stress trop élevé)
        if ($stressLevel >= 10) {
            // Si l'URL actuelle n'est pas déjà '/result/failure'
            if ($request->path() !== 'result/failure') {
                return redirect('/result/failure');
            }
        }

        // Crise de sommeil (sommeil trop bas)
        if ($sleepLevel <= 0) {
            // Si l'URL actuelle n'est pas déjà '/result/sleep-crisis'
            if ($request->path() !== 'result/sleep-crisis') {
                return redirect('/result/sleep-crisis');
            }
        }

        // Crise académique (notes trop basses)
        if ($gradesLevel <= 0) {
            // Si l'URL actuelle n'est pas déjà '/result/academic-crisis'
            if ($request->path() !== 'result/academic-crisis') {
                return redirect('/result/academic-crisis');
            }
        }

        return $response;
    }
}