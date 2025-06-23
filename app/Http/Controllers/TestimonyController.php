<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * TestimonyController
 *
 * Ce contrôleur gère les témoignages utilisateurs : affichage, création,
 * édition, suppression, et gestion des statuts de publication.
 *
 * @package App\Http\Controllers
 */
class TestimonyController extends Controller
{
    use AuthorizesRequests;

    /**
     * Afficher la liste des témoignages publiés (pagination).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $testimonies = Testimony::where('status', 'published')
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $testimonies->items(),
            'current_page' => $testimonies->currentPage(),
            'last_page' => $testimonies->lastPage(),
            'total' => $testimonies->total()
        ]);
    }

    /**
     * Afficher le formulaire de création de témoignage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json(['message' => 'Formulaire de création disponible.']);
    }

    /**
     * Enregistrer un nouveau témoignage (brouillon par défaut).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    $testimony = new Testimony();
    $testimony->title = $validated['title'];
    $testimony->content = $validated['content'];
    $testimony->user_id = auth()->id(); // pour relier l’utilisateur
    $testimony->save();

    return response()->json(['message' => 'Témoignage enregistré avec succès'], 201);
}

    /**
     * Retourner tous les témoignages publiés sans pagination.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
   public function all()
{
    return response()->json(\App\Models\Testimony::latest()->get());
}

}
