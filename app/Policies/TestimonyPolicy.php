<?php

namespace App\Policies;

use App\Models\Testimony;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * TestimonyPolicy
 * 
 * Cette politique définit les règles d'autorisation pour accéder
 * ou manipuler des témoignages dans l'application.
 *
 * @package App\Policies
 */
class TestimonyPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des témoignages.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir un témoignage spécifique.
     * Il doit être publié ou appartenir à l'utilisateur.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Testimony  $testimony
     * @return bool
     */
    public function view(User $user, Testimony $testimony): bool
    {
        return $testimony->status === 'published' || $user->id === $testimony->user_id;
    }

    /**
     * Détermine si l'utilisateur peut créer un témoignage.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Détermine si l'utilisateur peut modifier son propre témoignage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Testimony  $testimony
     * @return bool
     */
    public function update(User $user, Testimony $testimony): bool
    {
        return $user->id === $testimony->user_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer son propre témoignage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Testimony  $testimony
     * @return bool
     */
    public function delete(User $user, Testimony $testimony): bool
    {
        return $user->id === $testimony->user_id;
    }
}
