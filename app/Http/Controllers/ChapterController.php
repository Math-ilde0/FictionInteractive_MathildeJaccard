<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function show($storyId, $chapterId)
    {
        // ✅ On cherche le chapitre par story_id et id, avec les choix
        $chapter = Chapter::where('story_id', $storyId)
                          ->where('id', $chapterId)
                          ->with('choices')
                          ->first();
    
        if (!$chapter) {
            return response()->json(['error' => 'Chapter not found'], 404);
        }
    
        // Récupération des métriques actuelles
        $stressLevel = session('stress_level', 0);
        $sleepLevel = session('sleep_level', 10);
        $gradesLevel = session('grades_level', 7);
    
        // Ajout des métriques courantes au chapitre
        $chapter->current_stress_level = $stressLevel;
        $chapter->current_sleep_level = $sleepLevel;
        $chapter->current_grades_level = $gradesLevel;
    
        $chapter->is_burnout = $stressLevel >= 10;
    
        // ✅ SUPPRIMÉ : pas besoin d'avertissements sur min_sleep_level ou min_grades_level
        // ✅ SUPPRIMÉ : pas besoin de manipuler stress_level stocké en base

        // Conseils (toujours utiles)
        $chapter->stress_tip = $chapter->stress_advice;
        $chapter->sleep_tip = $chapter->sleep_advice;
        $chapter->grades_tip = $chapter->grades_advice;
    
        return response()->json($chapter);
    }
}
