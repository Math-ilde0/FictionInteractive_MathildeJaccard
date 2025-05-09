<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Choice;
use App\Models\Chapter;

class MetricsController extends Controller
{
    /**
     * Mettre à jour les métriques basées sur un choix
     */
// Modification de la méthode updateMetrics dans app/Http/Controllers/MetricsController.php
public function updateMetrics(Request $request)
{
    \Log::info('updateMetrics appelé avec:', $request->all());
    
    // Si nous recevons directement des niveaux de métriques (depuis localStorage)
    if ($request->has('stress_level') || $request->has('sleep_level') || $request->has('grades_level')) {
        // Utiliser les valeurs reçues ou les valeurs par défaut
        $stressLevel = $request->stress_level ?? 3;
        $sleepLevel = $request->sleep_level ?? 7;
        $gradesLevel = $request->grades_level ?? 6;
        
        // Seulement si choice_id est aussi présent, appliquer les impacts
        if ($request->has('choice_id')) {
            // Trouver le choix
            $choice = Choice::findOrFail($request->choice_id);
            
            // Récupérer le chapitre suivant pour obtenir les impacts
            $nextChapter = null;
            if ($choice->next_chapter_id) {
                $nextChapter = Chapter::find($choice->next_chapter_id);
            }
            
            // Appliquer les impacts si le chapitre suivant existe
            if ($nextChapter) {
                // Limiter les impacts à ±2
                $stressImpact = min(max($nextChapter->stress_impact ?? 0, -2), 2);
                $sleepImpact = min(max($nextChapter->sleep_impact ?? 0, -2), 2);
                $gradesImpact = min(max($nextChapter->grades_impact ?? 0, -2), 2);
                
                // Log des impacts pour débogage
                \Log::info('Impacts calculés:', [
                    'stress_impact' => $stressImpact,
                    'sleep_impact' => $sleepImpact,
                    'grades_impact' => $gradesImpact
                ]);
                
                // Appliquer les impacts avec limites
                $stressLevel = max(0, min(10, $stressLevel + $stressImpact));
                $sleepLevel = max(0, min(10, $sleepLevel + $sleepImpact));
                $gradesLevel = max(0, min(10, $gradesLevel + $gradesImpact));
            }
        }
        
        // Stocker dans la session pour compatibilité avec les middlewares
        session([
            'stress_level' => $stressLevel,
            'sleep_level' => $sleepLevel,
            'grades_level' => $gradesLevel
        ]);
        
        // Log des nouvelles valeurs
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
    
    // Code original (pour compatibilité)
    // Trouver le choix
    $choice = Choice::findOrFail($request->choice_id);
    
    // Récupérer le chapitre suivant pour obtenir les impacts
    $nextChapter = null;
    if ($choice->next_chapter_id) {
        $nextChapter = Chapter::find($choice->next_chapter_id);
    }
    
    // Récupérer les métriques actuelles
    $currentStress = session('stress_level', 3);
    $currentSleep = session('sleep_level', 7);
    $currentGrades = session('grades_level', 6);
    
    $newStress = $currentStress;
    $newSleep = $currentSleep;
    $newGrades = $currentGrades;
    
    if ($nextChapter) {
        // Limiter les impacts à ±2
        $stressImpact = min(max($nextChapter->stress_impact ?? 0, -2), 2);
        $sleepImpact = min(max($nextChapter->sleep_impact ?? 0, -2), 2);
        $gradesImpact = min(max($nextChapter->grades_impact ?? 0, -2), 2);
        
        $newStress = max(0, min(10, $currentStress + $stressImpact));
        $newSleep = max(0, min(10, $currentSleep + $sleepImpact));
        $newGrades = max(0, min(10, $currentGrades + $gradesImpact));
    }
    
    // Stocker dans la session
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
     * Réinitialiser toutes les métriques
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