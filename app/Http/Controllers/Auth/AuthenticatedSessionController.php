<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher la page de connexion.
     */
    public function create()
    {
        // Comme tu as un SPA (Vue.js), on n'a pas besoin d'une vraie vue ici.
        // Donc juste une simple réponse JSON pour dire "OK"
        return response()->json(['message' => 'Page de connexion']);
    }

    /**
     * Traiter une tentative de connexion.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
{
    $request->authenticate();

    $request->session()->regenerate();
    
    // Assurons-nous que la session est correctement persistée
    $request->session()->save();

    return response()->json([
        'user' => $request->user(),
        'message' => 'Logged in successfully'
    ]);
}

    /**
     * Déconnexion de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // ou rediriger où tu veux
    }
}
