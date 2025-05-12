<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * UserFactory
 *
 * Fabrique d'exemples pour le modèle `User`.
 * Utilisée pour générer des utilisateurs fictifs lors des tests ou du seed de la base.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Mot de passe réutilisé pour toutes les instances générées
     * afin d'éviter plusieurs appels à Hash::make().
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Définition de l'état par défaut du modèle `User`.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // mot de passe par défaut
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Déclare que l'utilisateur n'a pas vérifié son adresse email.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
