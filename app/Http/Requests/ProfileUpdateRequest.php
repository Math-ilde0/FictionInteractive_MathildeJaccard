<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * ProfileUpdateRequest
 * 
 * Gère la validation des données lors de la mise à jour du profil utilisateur.
 * Vérifie que le nom est présent et que l'email est unique (hors utilisateur courant).
 * 
 * @package App\Http\Requests
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Règles de validation appliquées à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Ignore l'utilisateur actuel pour éviter l'erreur d'unicité lors d'une mise à jour
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
