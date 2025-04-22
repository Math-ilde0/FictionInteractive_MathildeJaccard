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
/**
 * Mettre à jour les métriques basées sur un choix
 */
public function updateMetrics(Request $request)
{
    \Log::info('updateMetrics appelé avec:', $request->all());
    
    // Si nous recevons directement un niveau de stress (pour la reprise d'une partie sauvegardée)
    if ($request->has('stress_level') || $request->has('sleep_level') || $request->has('grades_level')) {
        \Log::info('Mise à jour directe des métriques:', [
            'stress_level' => $request->stress_level,
            'sleep_level' => $request->sleep_level,
            'grades_level' => $request->grades_level
        ]);
        
        $stressLevel = $request->stress_level ?? $request->cookie('stress_level', 0);
        $sleepLevel = $request->sleep_level ?? $request->cookie('sleep_level', 10);
        $gradesLevel = $request->grades_level ?? $request->cookie('grades_level', 7);
        
        $minutes = 60 * 24 * 30; // Cookie valide 30 jours
        
        $response = response()->json([
            'stress_level' => $stressLevel,
            'sleep_level' => $sleepLevel,
            'grades_level' => $gradesLevel,
            'is_burnout' => $stressLevel >= 10,
            'sleep_crisis' => $sleepLevel <= 0,
            'academic_crisis' => $gradesLevel <= 0
        ]);
        
        $response->cookie('stress_level', $stressLevel, $minutes);
        $response->cookie('sleep_level', $sleepLevel, $minutes);
        $response->cookie('grades_level', $gradesLevel, $minutes);
        
        return $response;
    }
    
    // Valider les données entrantes
    $validatedData = $request->validate([
        'choice_id' => 'required|exists:choices,id',
    ]);

    // Trouver le choix
    $choice = Choice::findOrFail($validatedData['choice_id']);
    \Log::info('Choix trouvé:', $choice->toArray());
    
    // Récupérer le chapitre suivant pour obtenir les impacts
    $nextChapter = null;
    if ($choice->next_chapter_id) {
        $nextChapter = Chapter::find($choice->next_chapter_id);
        \Log::info('Chapitre suivant trouvé:', $nextChapter ? $nextChapter->toArray() : 'null');
    }
    
    // Récupérer les métriques actuelles depuis les cookies
    $currentStress = $request->cookie('stress_level', 0);
    $currentSleep = $request->cookie('sleep_level', 10);
    $currentGrades = $request->cookie('grades_level', 7);
    
    \Log::info('Métriques actuelles depuis les cookies:', [
        'stress_level' => $currentStress,
        'sleep_level' => $currentSleep,
        'grades_level' => $currentGrades
    ]);
    
    $newStress = $currentStress;
    $newSleep = $currentSleep;
    $newGrades = $currentGrades;
    
    if ($nextChapter) {
        // Calculer les nouvelles valeurs des métriques
        $newStress = max(0, min(10, $currentStress + ($nextChapter->stress_impact ?? 0)));
        $newSleep = max(0, min(10, $currentSleep + ($nextChapter->sleep_impact ?? 0)));
        $newGrades = max(0, min(10, $currentGrades + ($nextChapter->grades_impact ?? 0)));
        
        \Log::info('Nouvelles métriques calculées:', [
            'newStress' => $newStress,
            'newSleep' => $newSleep,
            'newGrades' => $newGrades,
            'stress_impact' => $nextChapter->stress_impact ?? 0,
            'sleep_impact' => $nextChapter->sleep_impact ?? 0,
            'grades_impact' => $nextChapter->grades_impact ?? 0
        ]);
    }
    
    $minutes = 60 * 24 * 30; // Cookie valide 30 jours
    
    $response = response()->json([
        'stress_level' => $newStress,
        'sleep_level' => $newSleep,
        'grades_level' => $newGrades,
        'is_burnout' => $newStress >= 10,
        'sleep_crisis' => $newSleep <= 0,
        'academic_crisis' => $newGrades <= 0
    ]);
    
    // Ajouter les cookies à la réponse
    $response->cookie('stress_level', $newStress, $minutes);
    $response->cookie('sleep_level', $newSleep, $minutes);
    $response->cookie('grades_level', $newGrades, $minutes);
    
    \Log::info('Réponse finale avec cookies:', [
        'stress_level' => $newStress,
        'sleep_level' => $newSleep,
        'grades_level' => $newGrades
    ]);
    
    return $response;
}
    
    /**
     * Obtenir les valeurs actuelles des métriques
     */
    public function getMetrics()
    {
        return response()->json([
            'stress_level' => session('stress_level', 0),
            'sleep_level' => session('sleep_level', 10),
            'grades_level' => session('grades_level', 7),
            'is_burnout' => session('stress_level', 0) >= 10,
            'sleep_crisis' => session('sleep_level', 10) <= 0,
            'academic_crisis' => session('grades_level', 7) <= 0
        ]);
    }
    
    /**
     * Réinitialiser toutes les métriques
     */
    public function resetMetrics()
    {
        session([
            'stress_level' => 0,
            'sleep_level' => 10,
            'grades_level' => 7
        ]);
        
        return response()->json([
            'stress_level' => 0,
            'sleep_level' => 10,
            'grades_level' => 7,
            'is_burnout' => false,
            'sleep_crisis' => false,
            'academic_crisis' => false
        ]);
    }
}