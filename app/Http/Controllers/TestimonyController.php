<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class TestimonyController extends Controller
{
    /**
     * Constructeur avec middleware d'authentification
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);

    }

    /**
     * Afficher la liste des témoignages publiés.
     */
    public function index()
    {
        $testimonies = Testimony::where('status', 'published')
            ->with('user:id,name')
            ->latest()
            ->paginate(10);
            
        return response()->json($testimonies);
    }

    /**
     * Afficher le formulaire de création de témoignage.
     */
    public function create()
    {
        return view('testimonies.create');
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
            'status' => 'draft', // Les témoignages sont d'abord en mode brouillon
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Témoignage créé avec succès.',
                'testimony' => $testimony
            ], 201);
        }

        return redirect()->route('testimonies.show', $testimony)
            ->with('success', 'Votre témoignage a été soumis avec succès et sera examiné avant publication.');
    }

    /**
     * Afficher un témoignage spécifique.
     */
    public function show(Testimony $testimony)
    {
        // Vérifier si le témoignage est publié ou appartient à l'utilisateur connecté
        if ($testimony->status !== 'published' && 
            (Auth::guest() || Auth::id() !== $testimony->user_id)) {
            abort(403, 'Ce témoignage n\'est pas encore publié.');
        }

        $testimony->load('user:id,name');
        
        if (request()->wantsJson()) {
            return response()->json($testimony);
        }
        
        return view('testimonies.show', compact('testimony'));
    }

    /**
     * Afficher le formulaire d'édition d'un témoignage.
     */
    public function edit(Testimony $testimony)
    {
        $this->authorize('update', $testimony);
        
        return view('testimonies.edit', compact('testimony'));
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

        return redirect()->route('testimonies.show', $testimony)
            ->with('success', 'Votre témoignage a été mis à jour avec succès.');
    }

    /**
     * Supprimer un témoignage.
     */
    public function destroy(Testimony $testimony)
    {
        $this->authorize('delete', $testimony);
        
        $testimony->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Témoignage supprimé avec succès.'
            ]);
        }

        return redirect()->route('testimonies.index')
            ->with('success', 'Témoignage supprimé avec succès.');
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
        
        return view('testimonies.my-testimonies', compact('testimonies'));
    }
}