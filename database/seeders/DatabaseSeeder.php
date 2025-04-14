<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Appeler les seeders spécifiques
        $this->call([
            StoriesTableSeeder::class,
        ]);
    }
}
