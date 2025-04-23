<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function show($storyId, $chapterId)
    {
        // ✅ Corrigé : on cherche le chapitre par story_id et id
        $chapter = Chapter::where('story_id', $storyId)
                          ->where('id', $chapterId)
                          ->with('choices') // Charger les choix en même temps
                          ->first();
    
        if (!$chapter) {
            return response()->json(['error' => 'Chapter not found'], 404);
        }
    
        // Récupération des métriques
        $stressLevel = session('stress_level', 0);
        $sleepLevel = session('sleep_level', 10);
        $gradesLevel = session('grades_level', 7);
    
        $chapter->current_stress_level = $stressLevel;
        $chapter->current_sleep_level = $sleepLevel;
        $chapter->current_grades_level = $gradesLevel;
    
        $chapter->is_burnout = $stressLevel >= 10;
    
        $chapter->sleep_warning = $sleepLevel < ($chapter->min_sleep_level ?? 0);
        $chapter->grades_warning = $gradesLevel < ($chapter->min_grades_level ?? 0);
    
        $chapter->stress_tip = $chapter->stress_advice;
        $chapter->sleep_tip = $chapter->sleep_advice;
        $chapter->grades_tip = $chapter->grades_advice;
    
        return response()->json($chapter);
    }
    
}