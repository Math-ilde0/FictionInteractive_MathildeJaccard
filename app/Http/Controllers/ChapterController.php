<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function show($storyId, $chapterId)
    {
        // Récupérer le chapitre spécifique pour l'histoire donnée
        $chapter = Chapter::where('story_id', $storyId)
                          ->where('chapter_number', $chapterId)
                          ->first();

        if (!$chapter) {
            return response()->json(['error' => 'Chapter not found'], 404);
        }

        // Charger explicitement les choix avec leurs next_chapter_id
        $choices = Choice::where('chapter_id', $chapter->id)
                         ->select('id', 'text', 'next_chapter_id')
                         ->get();

        // Récupérer les niveaux actuels des métriques
        $stressLevel = session('stress_level', 0);
        $sleepLevel = session('sleep_level', 10);
        $gradesLevel = session('grades_level', 7);
        
        // Transformer le chapitre en tableau pour pouvoir ajouter des propriétés
        $chapterData = $chapter->toArray();
        
        // Ajouter les métriques actuelles
        $chapterData['current_stress_level'] = $stressLevel;
        $chapterData['current_sleep_level'] = $sleepLevel;
        $chapterData['current_grades_level'] = $gradesLevel;
        
        // Ajouter les choix
        $chapterData['choices'] = $choices;
        
        // Vérifier si le niveau de stress a atteint 10 (burnout)
        $chapterData['is_burnout'] = $stressLevel >= 10;
        
        // Vérifier si le chapitre actuel a des exigences minimales pour certaines métriques
        $chapterData['sleep_warning'] = $sleepLevel < ($chapter->min_sleep_level ?? 0);
        $chapterData['grades_warning'] = $gradesLevel < ($chapter->min_grades_level ?? 0);
        
        // Ajouter les conseils pour chaque métrique si disponibles
        $chapterData['stress_tip'] = $chapter->stress_advice;
        $chapterData['sleep_tip'] = $chapter->sleep_advice;
        $chapterData['grades_tip'] = $chapter->grades_advice;

        return response()->json($chapterData);
    }
}