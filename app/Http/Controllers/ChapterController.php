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
        // Retrieve the chapter for the given storyId and chapterId
        $chapter = Chapter::where('story_id', $storyId)->find($chapterId);

        if (!$chapter) {
            return response()->json(['error' => 'Chapter not found'], 404);
        }

        // Load the choices associated with this chapter
        $chapter->load('choices');

        // Return the chapter as a JSON response
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