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
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:20',
        ]);

        $testimony = Auth::user()->testimonies()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => 'draft',
        ]);

        return response()->json([
            'message' => 'Témoignage créé avec succès et sera examiné avant publication.',
            'testimony' => $testimony
        ], 201);
    }

    /**
     * Afficher un témoignage spécifique.
     *
     * @param  \App\Models\Testimony  $testimony
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Testimony $testimony)
    {
        if ($testimony->status !== 'published' && (Auth::guest() || Auth::id() !== $testimony->user_id)) {
            abort(403, 'Ce témoignage n\'est pas encore publié.');
        }

        $testimony->load('user:id,name');

        return response()->json($testimony);
    }

    /**
     * Afficher le formulaire d'édition d'un témoignage.
     *
     * @param  \App\Models\Testimony  $testimony
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Testimony $testimony)
    {
        $this->authorize('update', $testimony);

        return response()->json([
            'message' => 'Formulaire d\'édition disponible.',
            'testimony' => $testimony
        ]);
    }

    /**
     * Retourner tous les témoignages publiés sans pagination.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Testimony::where('status', 'published')
            ->with('user:id,name')
            ->latest()
            ->get();
    }

    /**
     * Mettre à jour un témoignage existant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimony  $testimony
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function update(Request $request, Testimony $testimony)
    {
        $this->authorize('update', $testimony);

        $validated = $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:20',
        ]);

        $testimony->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => 'draft',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Témoignage mis à jour avec succès.',
                'testimony' => $testimony
            ]);
        }
    }

    /**
     * Supprimer un témoignage.
     *
     * @param  \App\Models\Testimony  $testimony
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Testimony $testimony)
    {
        $this->authorize('delete', $testimony);

        $testimony->delete();

        return response()->json([
            'message' => 'Témoignage supprimé avec succès.'
        ]);
    }

    /**
     * Afficher les témoignages de l'utilisateur actuellement connecté.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myTestimonies()
    {
        $testimonies = Auth::user()->testimonies()->latest()->paginate(10);

        return response()->json($testimonies);
    }
}
