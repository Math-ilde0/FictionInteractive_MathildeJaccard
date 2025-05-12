<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 *
 * Classe principale appelée par la commande `php artisan db:seed`.
 * Elle permet d’exécuter les seeders nécessaires pour peupler la base de données avec des données de test.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Exécute tous les seeders de l'application.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            StoriesTableSeeder::class,
            UserSeeder::class,
            TestimonySeeder::class,
        ]);
    }
    
    }

