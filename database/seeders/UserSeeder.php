<?php

/**
 * Seeder pour la table `users`.
 *
 * Ce fichier insère un utilisateur de test par défaut dans la base de données.
 * Il est utile pour les environnements de développement ou de démonstration.
 *
 * ➤ L’utilisateur inséré :
 *    - Nom : Utilisateur Test
 *    - Email : test@example.com
 *    - Mot de passe : password (crypté via Hash::make)
 *
 * ⚠️ À ne pas utiliser tel quel en production.
 *
 * Exécution via : php artisan db:seed --class=UserSeeder
 */


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Utilisateur Test',
                'password' => Hash::make('password'),
            ]
        );
        
    }
}
