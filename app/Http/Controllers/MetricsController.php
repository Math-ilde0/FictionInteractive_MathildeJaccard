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
    public function updateMetrics(Request $request)
    {
        // Valider les données entrantes
        $validatedData = $request->validate([
            'choice_id' => 'required|exists:choices,id',
        ]);

        // Trouver le choix
        $choice = Choice::findOrFail($validatedData['choice_id']);
        
        // Récupérer le chapitre suivant
        $nextChapter = null;
        if ($choice->next_chapter_id) {
            $nextChapter = Chapter::find($choice->next_chapter_id);
        }
        
        // Métriques actuelles avec valeurs par défaut
        $currentStress = session('stress_level', 0);
        $currentSleep = session('sleep_level', 10); 
        $currentGrades = session('grades_level', 7); 
        
        // Calculer les nouvelles valeurs
        $newStress = max(0, min(10, $currentStress + ($nextChapter->stress_impact ?? 0)));
        $newSleep = max(0, min(10, $currentSleep + ($nextChapter->sleep_impact ?? 0)));
        $newGrades = max(0, min(10, $currentGrades + ($nextChapter->grades_impact ?? 0)));
        
        // Stocker les valeurs en session
        session([
            'stress_level' => $newStress,
            'sleep_level' => $newSleep,
            'grades_level' => $newGrades
        ]);
        
        // Conditions de fin
        $isFailure = $newStress >= 10;
        $isSleepCrisis = $newSleep <= 0;
        $isAcademicCrisis = $newGrades <= 0;
        
        // Redirect si conditions de fin
        $redirectUrl = null;
        if ($isFailure) {
            $redirectUrl = '/result/failure';
        } elseif ($isSleepCrisis) {
            $redirectUrl = '/result/sleep-crisis';
        } elseif ($isAcademicCrisis) {
            $redirectUrl = '/result/academic-crisis';
        }
        
        // Retourner les métriques et une potentielle redirection
        return response()->json([
            'stress_level' => $newStress,
            'sleep_level' => $newSleep,
            'grades_level' => $newGrades,
            'is_burnout' => $isFailure,
            'sleep_crisis' => $isSleepCrisis,
            'academic_crisis' => $isAcademicCrisis,
            'redirect_to' => $redirectUrl
        ]);
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