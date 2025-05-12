<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

/**
 * RegisteredUserController
 *
 * Ce contrôleur gère l'affichage du formulaire d'inscription
 * et la création d'un nouvel utilisateur dans le système.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription via Inertia.
     *
     * @return \Inertia\Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Traite la requête d'enregistrement d'un nouvel utilisateur.
     * Valide les données, crée le compte, le connecte et déclenche l'événement Registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Retourner JSON au lieu de rediriger
        return response()->json(['user' => $user], 201);
    }
}
