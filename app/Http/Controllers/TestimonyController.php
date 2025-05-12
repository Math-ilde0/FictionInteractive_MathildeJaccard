<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TestimonyController extends Controller
{
    use AuthorizesRequests;


    /**
     * Afficher la liste des témoignages publiés.
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
     */
    public function create()
{
    return response()->json(['message' => 'Formulaire de création disponible.']);
}

/**
 * Enregistrer un nouveau témoignage.
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
     */
    public function edit(Testimony $testimony)
    {
        $this->authorize('update', $testimony);
        
        return response()->json([
            'message' => 'Formulaire d\'édition disponible.',
            'testimony' => $testimony
        ]);
        
    }
    public function all()
{
    return Testimony::where('status', 'published')
        ->with('user:id,name')
        ->latest()
        ->get();
}


    /**
     * Mettre à jour un témoignage existant.
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
            'status' => 'draft', // Retour en mode brouillon après modification
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
     * Afficher les témoignages de l'utilisateur connecté.
     */
    public function myTestimonies()
    {
        $testimonies = Auth::user()->testimonies()->latest()->paginate(10);
        
        if (request()->wantsJson()) {
            return response()->json($testimonies);
        }
        
        return response()->json($testimonies);

    }
}