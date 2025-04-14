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

        // Charger explicitement les choix avec leur relation next_chapter_id
        $chapter->load('choices');
        
        // Mettre à jour le niveau de stress en session
        // L'impact du stress du chapitre actuel est ajouté au niveau existant
        if (session()->has('stress_level')) {
            $currentStress = session('stress_level');
            $newStress = $currentStress + $chapter->stress_impact;
            
            // S'assurer que le niveau de stress ne descend pas en dessous de 0
            $newStress = max(0, $newStress);
            
            session(['stress_level' => $newStress]);
            
            // Ajouter le niveau de stress actuel à la réponse JSON
            $chapter->current_stress_level = $newStress;
        }
        
        // Vérifier si le niveau de stress a atteint 10 (burnout)
        if (session('stress_level') >= 10) {
            $chapter->is_burnout = true;
        } else {
            $chapter->is_burnout = false;
        }

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