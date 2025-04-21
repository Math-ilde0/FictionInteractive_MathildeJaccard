<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    // Display all chapters (not used in this case, but provided as part of API resource)
    public function index()
    {
        return Chapter::all();
    }

    // Store a newly created chapter (not used in this case)
    public function store(Request $request)
    {
        return Chapter::create($request->all());
    }

    // Fetch and display a specific chapter by storyId and chapterId
    public function show($storyId, $chapterId)
{
    // Récupérer le chapitre
    $chapter = Chapter::where('story_id', $storyId)->find($chapterId);

    if (!$chapter) {
        return response()->json(['error' => 'Chapter not found'], 404);
    }

    // Charger explicitement les choix
    $chapter->load('choices');
    
    // Récupérer les niveaux actuels des métriques
    $stressLevel = session('stress_level', 0);
    $sleepLevel = session('sleep_level', 10);
    $gradesLevel = session('grades_level', 7);
    
    // Ajouter les niveaux des métriques à la réponse JSON
    $chapter->current_stress_level = $stressLevel;
    $chapter->current_sleep_level = $sleepLevel;
    $chapter->current_grades_level = $gradesLevel;
    
    // Vérifier si le niveau de stress a atteint 10 (burnout)
    $chapter->is_burnout = $stressLevel >= 10;
    
    // Vérifier si le chapitre actuel a des exigences minimales pour certaines métriques
    $chapter->sleep_warning = $sleepLevel < ($chapter->min_sleep_level ?? 0);
    $chapter->grades_warning = $gradesLevel < ($chapter->min_grades_level ?? 0);
    
    // Ajouter les conseils pour chaque métrique si disponibles
    $chapter->stress_tip = $chapter->stress_advice;
    $chapter->sleep_tip = $chapter->sleep_advice;
    $chapter->grades_tip = $chapter->grades_advice;

    // Retourner le chapitre en tant que réponse JSON
    return response()->json($chapter);
}

    // Update a chapter (not used in this case)
    public function update(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->update($request->all());
        return $chapter;
    }

    // Delete a chapter (not used in this case)
    public function destroy($id)
    {
        return Chapter::destroy($id);
    }
}