<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Choice;
use App\Models\Chapter;

class StressController extends Controller
{
    /**
     * Mettre à jour le niveau de stress basé sur un choix
     */
    public function updateStress(Request $request)
    {
        // Valider les données entrantes
        $validatedData = $request->validate([
            'choice_id' => 'required|exists:choices,id',
        ]);

        $choice = Choice::findOrFail($validatedData['choice_id']);
        $chapter = Chapter::findOrFail($choice->chapter_id);
        
        // Récupérer le chapitre suivant pour obtenir le stress_impact
        $nextChapter = null;
        if ($choice->next_chapter_id) {
            $nextChapter = Chapter::find($choice->next_chapter_id);
        }
        
        // Mettre à jour le niveau de stress en session
        if (session()->has('stress_level')) {
            $currentStress = session('stress_level');
            
            // Ajouter l'impact du stress du chapitre suivant (ou 0 si pas de chapitre suivant)
            $stressImpact = $nextChapter ? $nextChapter->stress_impact : 0;
            $newStress = $currentStress + $stressImpact;
            
            // S'assurer que le niveau de stress ne descend pas en dessous de 0
            $newStress = max(0, $newStress);
            
            session(['stress_level' => $newStress]);
            
            // Vérifier si le niveau de stress a atteint 10 (burnout)
            if ($newStress >= 10) {
                return response()->json([
                    'stress_level' => $newStress,
                    'is_burnout' => true,
                    'redirect_to' => '/result/failure'
                ]);
            }
            
            return response()->json([
                'stress_level' => $newStress,
                'is_burnout' => false
            ]);
        }
        
        // Si la session n'avait pas encore de niveau de stress, initialiser à 0 + impact
        $stressImpact = $nextChapter ? $nextChapter->stress_impact : 0;
        $initialStress = max(0, $stressImpact);
        session(['stress_level' => $initialStress]);
        
        return response()->json([
            'stress_level' => $initialStress,
            'is_burnout' => $initialStress >= 10
        ]);
    }
    
    /**
     * Obtenir le niveau de stress actuel
     */
    public function getStress()
    {
        $stressLevel = session('stress_level', 0);
        
        return response()->json([
            'stress_level' => $stressLevel,
            'is_burnout' => $stressLevel >= 10
        ]);
    }
    
    /**
     * Réinitialiser le niveau de stress
     */
    public function resetStress()
    {
        session(['stress_level' => 0]);
        
        return response()->json([
            'stress_level' => 0,
            'is_burnout' => false
        ]);
    }
}