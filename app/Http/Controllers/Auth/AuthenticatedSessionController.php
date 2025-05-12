<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

/**
 * AuthenticatedSessionController
 *
 * Ce contrôleur gère la connexion et la déconnexion de l'utilisateur
 * dans une application Laravel avec authentification par session.
 * Utilisé dans un contexte d'API ou de SPA (Single Page Application).
 *
 * @package App\Http\Controllers\Auth
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la page de connexion.
     * Dans une SPA, on retourne une réponse JSON au lieu d'une vue.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        // Comme tu as un SPA (Vue.js), on n'a pas besoin d'une vraie vue ici.
        return response()->json(['message' => 'Page de connexion']);
    }

    /**
     * Traite une tentative de connexion utilisateur.
     * Authentifie l'utilisateur, régénère la session, et renvoie les infos utilisateur.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Déconnecte l'utilisateur en cours.
     * Invalide la session et régénère le token CSRF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // ou rediriger où tu veux
    }
}
