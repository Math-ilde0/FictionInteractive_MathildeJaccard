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
        // Si nous recevons directement un niveau de stress (pour la reprise d'une partie sauvegardée)
        if ($request->has('stress_level') || $request->has('sleep_level') || $request->has('grades_level')) {
            session([
                'stress_level' => $request->stress_level ?? session('stress_level', 0),
                'sleep_level' => $request->sleep_level ?? session('sleep_level', 10),
                'grades_level' => $request->grades_level ?? session('grades_level', 7)
            ]);
            
            return $this->getMetrics();
        }
        
        // Valider les données entrantes
        $validatedData = $request->validate([
            'choice_id' => 'required|exists:choices,id',
        ]);

        // Trouver le choix
        $choice = Choice::findOrFail($validatedData['choice_id']);
        
        // Récupérer le chapitre suivant pour obtenir les impacts
        $nextChapter = null;
        if ($choice->next_chapter_id) {
            $nextChapter = Chapter::find($choice->next_chapter_id);
        }
        
        // Mettre à jour les métriques en session
        $currentStress = session('stress_level', 0);
        $currentSleep = session('sleep_level', 10); // Commence à 10 (bien reposé)
        $currentGrades = session('grades_level', 7); // Commence à 7 (moyenne correcte)
        
        if ($nextChapter) {
            // Calculer les nouvelles valeurs des métriques
            $newStress = max(0, min(10, $currentStress + ($nextChapter->stress_impact ?? 0)));
            $newSleep = max(0, min(10, $currentSleep + ($nextChapter->sleep_impact ?? 0)));
            $newGrades = max(0, min(10, $currentGrades + ($nextChapter->grades_impact ?? 0)));
            
            // Stocker les valeurs en session
            session([
                'stress_level' => $newStress,
                'sleep_level' => $newSleep,
                'grades_level' => $newGrades
            ]);
            
            // Vérifier si le niveau de stress a atteint 10 (burnout)
            if ($newStress >= 10) {
                return response()->json([
                    'stress_level' => $newStress,
                    'sleep_level' => $newSleep,
                    'grades_level' => $newGrades,
                    'is_burnout' => true,
                    'redirect_to' => '/result/failure'
                ]);
            }
            
            // Vérifier si le niveau de sommeil est trop bas
            if ($newSleep <= 0) {
                return response()->json([
                    'stress_level' => $newStress,
                    'sleep_level' => $newSleep,
                    'grades_level' => $newGrades,
                    'sleep_crisis' => true,
                    'message' => 'Votre manque de sommeil affecte votre santé!',
                    'redirect_to' => '/result/sleep-crisis'
                ]);
            }
            
            // Vérifier si les notes sont trop basses
            if ($newGrades <= 0) {
                return response()->json([
                    'stress_level' => $newStress,
                    'sleep_level' => $newSleep,
                    'grades_level' => $newGrades,
                    'academic_crisis' => true,
                    'message' => 'Attention, vos notes sont en chute libre!',
                    'redirect_to' => '/result/academic-crisis'
                ]);
            }
        }
        
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