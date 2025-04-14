<?php
namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    // Affiche une seule histoire (l'histoire avec l'ID 2)
    public function index()
    {
        $story = Story::with('chapters')->find(2);
        
        if (!$story) {
            return response()->json(['error' => 'No story found'], 404);
        }
        
        return response()->json($story);
    }

    // Affiche une histoire spécifique (l'histoire avec l'ID 2)
    public function show($id)
    {
        $story = Story::with('chapters')->find($id);
        
        if (!$story) {
            return response()->json(['error' => 'Story not found'], 404);
        }
        
        return response()->json($story);
    }
    


    // Ajoutez cette méthode à votre StoryController
    public function showResult($outcome)
    {
        return view('result', ['outcome' => $outcome]);
    }
    

}



