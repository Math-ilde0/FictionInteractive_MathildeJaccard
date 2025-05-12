<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Http\Request;

/**
 * ChapterController
 * 
 * Ce contrôleur gère l'affichage d'un chapitre d'une histoire interactive,
 * y compris les choix possibles et les métriques de progression.
 * 
 * @package App\Http\Controllers
 */
class ChapterController extends Controller
{
    /**
     * Affiche un chapitre spécifique avec ses choix et les niveaux de métriques courants.
     *
     * @param  int  $storyId  ID de l'histoire à laquelle appartient le chapitre
     * @param  int|string  $chapterId  ID ou numéro du chapitre à afficher
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($storyId, $chapterId)
    {
        // ✅ On cherche le chapitre par story_id et id, avec les choix
        $chapter = Chapter::where('story_id', $storyId)
                          ->where('id', $chapterId)
                          ->with('choices')
                          ->first();

        if (!$chapter) {
            // Si non trouvé par ID, on essaie par numéro de chapitre
            $chapter = Chapter::where('story_id', $storyId)
                              ->where('chapter_number', $chapterId)
                              ->with('choices')
                              ->first();

            if (!$chapter) {
                return response()->json(['error' => 'Chapter not found'], 404);
            }
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

        // Conseils (toujours utiles)
        $chapter->stress_tip = $chapter->stress_advice;
        $chapter->sleep_tip = $chapter->sleep_advice;
        $chapter->grades_tip = $chapter->grades_advice;

        return response()->json($chapter);
    }
}
