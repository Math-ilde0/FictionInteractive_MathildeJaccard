<?php
namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    // List all available stories
    public function index()
    {
        $stories = Story::all();
        
        if ($stories->isEmpty()) {
            return response()->json(['error' => 'No stories found'], 404);
        }
        
        return response()->json($stories);
    }

    // Display a single story by ID with its chapters
    public function show($id)
    {
        $story = Story::with('chapters')->find($id);
        
        if (!$story) {
            return response()->json(['error' => 'Story not found'], 404);
        }
        
        return response()->json($story);
    }

    // Route for game result
    public function showResult($outcome)
    {
        return view('result', ['outcome' => $outcome]);
    }
}