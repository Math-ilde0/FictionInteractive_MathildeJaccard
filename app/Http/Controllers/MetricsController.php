<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Choice;
use App\Models\Chapter;

/**
 * MetricsController
 *
 * Ce contrôleur gère les mises à jour, la récupération
 * et la réinitialisation des métriques (stress, sommeil, notes).
 * 
 * @package App\Http\Controllers
 */
class MetricsController extends Controller
{
    /**
     * Met à jour les métriques d'après les données reçues ou selon un choix effectué.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMetrics(Request $request)
    {
        \Log::info('updateMetrics appelé avec:', $request->all());

        // Si on reçoit des métriques depuis le frontend
        if ($request->has('stress_level') || $request->has('sleep_level') || $request->has('grades_level')) {
            $stressLevel = $request->stress_level ?? 3;
            $sleepLevel = $request->sleep_level ?? 7;
            $gradesLevel = $request->grades_level ?? 6;

            if ($request->has('choice_id')) {
                $choice = Choice::findOrFail($request->choice_id);
                $nextChapter = $choice->next_chapter_id ? Chapter::find($choice->next_chapter_id) : null;

                if ($nextChapter) {
                    $stressImpact = min(max($nextChapter->stress_impact ?? 0, -2), 2);
                    $sleepImpact = min(max($nextChapter->sleep_impact ?? 0, -2), 2);
                    $gradesImpact = min(max($nextChapter->grades_impact ?? 0, -2), 2);

                    \Log::info('Impacts calculés:', [
                        'stress_impact' => $stressImpact,
                        'sleep_impact' => $sleepImpact,
                        'grades_impact' => $gradesImpact
                    ]);

                    $stressLevel = max(0, min(10, $stressLevel + $stressImpact));
                    $sleepLevel = max(0, min(10, $sleepLevel + $sleepImpact));
                    $gradesLevel = max(0, min(10, $gradesLevel + $gradesImpact));
                }
            }

            session([
                'stress_level' => $stressLevel,
                'sleep_level' => $sleepLevel,
                'grades_level' => $gradesLevel
            ]);

            \Log::info('Nouvelles valeurs après impacts:', [
                'stress_level' => $stressLevel,
                'sleep_level' => $sleepLevel,
                'grades_level' => $gradesLevel
            ]);

            return response()->json([
                'stress_level' => $stressLevel,
                'sleep_level' => $sleepLevel,
                'grades_level' => $gradesLevel,
                'is_burnout' => $stressLevel >= 10,
                'sleep_crisis' => $sleepLevel <= 0,
                'academic_crisis' => $gradesLevel <= 0
            ]);
        }

        // Cas sans envoi initial de métriques, on se base sur la session
        $choice = Choice::findOrFail($request->choice_id);
        $nextChapter = $choice->next_chapter_id ? Chapter::find($choice->next_chapter_id) : null;

        $currentStress = session('stress_level', 3);
        $currentSleep = session('sleep_level', 7);
        $currentGrades = session('grades_level', 6);

        $newStress = $currentStress;
        $newSleep = $currentSleep;
        $newGrades = $currentGrades;

        if ($nextChapter) {
            $stressImpact = min(max($nextChapter->stress_impact ?? 0, -2), 2);
            $sleepImpact = min(max($nextChapter->sleep_impact ?? 0, -2), 2);
            $gradesImpact = min(max($nextChapter->grades_impact ?? 0, -2), 2);

            $newStress = max(0, min(10, $currentStress + $stressImpact));
            $newSleep = max(0, min(10, $currentSleep + $sleepImpact));
            $newGrades = max(0, min(10, $currentGrades + $gradesImpact));
        }

        session([
            'stress_level' => $newStress,
            'sleep_level' => $newSleep,
            'grades_level' => $newGrades
        ]);

        return response()->json([
            'stress_level' => $newStress,
            'sleep_level' => $newSleep,
            'grades_level' => $newGrades,
            'is_burnout' => $newStress >= 10,
            'sleep_crisis' => $newSleep <= 0,
            'academic_crisis' => $newGrades <= 0
        ]);
    }

    /**
     * Récupère les métriques actuelles depuis la session.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMetrics()
    {
        return response()->json([
            'stress_level' => session('stress_level', 3),
            'sleep_level' => session('sleep_level', 7),
            'grades_level' => session('grades_level', 6),
            'is_burnout' => session('stress_level', 3) >= 10,
            'sleep_crisis' => session('sleep_level', 7) <= 0,
            'academic_crisis' => session('grades_level', 6) <= 0
        ]);
    }

    /**
     * Réinitialise toutes les métriques aux valeurs par défaut.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetMetrics(Request $request)
    {
        \Log::info('resetMetrics appelé');

        session([
            'stress_level' => 3,
            'sleep_level' => 7,
            'grades_level' => 6
        ]);

        return response()->json([
            'stress_level' => 3,
            'sleep_level' => 7,
            'grades_level' => 6,
            'is_burnout' => false,
            'sleep_crisis' => false,
            'academic_crisis' => false
        ]);
    }
}
