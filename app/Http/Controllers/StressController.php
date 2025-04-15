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
        $choice = Choice::findOrFail($request->choice_id);
        // Valider les données entrantes
        $validatedData = $request->validate([
            'choice_id' => 'required|exists:choices,id',
        ]);

        $choice = Choice::findOrFail($validatedData['choice_id']);
        

        // Récupérer le chapitre suivant pour obtenir le stress_impact
        $nextChapter = null;
        if ($choice->next_chapter_id) {
            $nextChapter = Chapter::find($choice->next_chapter_id);
        }
        
        // Mettre à jour le niveau de stress en session
        $currentStress = session('stress_level', 0);
        
        // Ajouter l'impact du stress du chapitre suivant
        $stressImpact = $nextChapter ? $nextChapter->stress_impact : 0;
        $newStress = $currentStress + $stressImpact;
        
        // S'assurer que le niveau de stress reste entre 0 et 10
        $newStress = max(0, min(10, $newStress));
        
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