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
    \Log::info('updateMetrics appelé avec:', $request->all());
    
    // Si nous recevons directement un niveau de stress (pour la reprise d'une partie sauvegardée)
    if ($request->has('stress_level') || $request->has('sleep_level') || $request->has('grades_level')) {
        \Log::info('Mise à jour directe des métriques:', [
            'stress_level' => $request->stress_level,
            'sleep_level' => $request->sleep_level,
            'grades_level' => $request->grades_level
        ]);
        
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
    \Log::info('Choix trouvé:', $choice->toArray());
    
    // Récupérer le chapitre suivant pour obtenir les impacts
    $nextChapter = null;
    if ($choice->next_chapter_id) {
        $nextChapter = Chapter::find($choice->next_chapter_id);
        \Log::info('Chapitre suivant trouvé:', $nextChapter ? $nextChapter->toArray() : 'null');
    }
    
    // Mettre à jour les métriques en session
    $currentStress = session('stress_level', 0);
    $currentSleep = session('sleep_level', 10);
    $currentGrades = session('grades_level', 7);
    
    \Log::info('Métriques actuelles:', [
        'stress_level' => $currentStress,
        'sleep_level' => $currentSleep,
        'grades_level' => $currentGrades
    ]);
    
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
        
        // Stocker les valeurs en session
        session([
            'stress_level' => $newStress,
            'sleep_level' => $newSleep,
            'grades_level' => $newGrades
        ]);
        
        // Vérifier si les niveaux critiques sont atteints
        if ($newStress >= 10) {
            return response()->json([
                'stress_level' => $newStress,
                'sleep_level' => $newSleep,
                'grades_level' => $newGrades,
                'is_burnout' => true,
                'redirect_to' => '/result/failure'
            ]);
        }
        
        // [autres vérifications...]
    }
    
    $response = [
        'stress_level' => session('stress_level', 0),
        'sleep_level' => session('sleep_level', 10),
        'grades_level' => session('grades_level', 7),
        'is_burnout' => session('stress_level', 0) >= 10,
        'sleep_crisis' => session('sleep_level', 10) <= 0,
        'academic_crisis' => session('grades_level', 7) <= 0
    ];
    
    \Log::info('Réponse finale:', $response);
    
    return response()->json($response);
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