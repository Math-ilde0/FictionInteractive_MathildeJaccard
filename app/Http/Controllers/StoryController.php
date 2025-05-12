<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

/**
 * StoryController
 *
 * Ce contrôleur gère l'affichage des histoires disponibles,
 * de leur contenu, et de la page de résultat.
 *
 * @package App\Http\Controllers
 */
class StoryController extends Controller
{
    /**
     * Liste toutes les histoires disponibles.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stories = Story::all();

        if ($stories->isEmpty()) {
            return response()->json(['error' => 'No stories found'], 404);
        }

        return response()->json($stories);
    }

    /**
     * Affiche une histoire avec ses chapitres.
     *
     * @param  int  $id  ID de l'histoire
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $story = Story::with('chapters')->find($id);

        if (!$story) {
            return response()->json(['error' => 'Story not found'], 404);
        }

        return response()->json($story);
    }

    /**
     * Affiche une vue de résultat basée sur un scénario (succès, échec...).
     *
     * @param  string  $outcome
     * @return \Illuminate\View\View
     */
    public function showResult($outcome)
    {
        return view('result', ['outcome' => $outcome]);
    }
}
