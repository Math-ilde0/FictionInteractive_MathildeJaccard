<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * UpdateStressRequest
 *
 * Requête de validation utilisée pour mettre à jour les métriques de stress
 * en fonction d'un choix effectué par l'utilisateur dans l'histoire.
 *
 * @package App\Http\Requests
 */
class UpdateStressRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation appliquées à la requête.
     * Le champ `choice_id` est requis et doit exister dans la table `choices`.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'choice_id' => 'required|exists:choices,id',
        ];
    }
}
