<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création de la table `chapters`.
 * Chaque chapitre est lié à une histoire et peut contenir des impacts
 * sur le stress, le sommeil et les notes, ainsi que des conseils associés.
 */
return new class extends Migration
{
    /**
     * Crée la table `chapters` avec ses colonnes et contraintes.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id(); // Clé primaire

            $table->foreignId('story_id')
                  ->constrained()
                  ->onDelete('cascade'); // Lien avec la table `stories` (suppression en cascade)

            $table->integer('chapter_number'); // Numéro du chapitre dans l'histoire
            $table->text('content');           // Contenu narratif du chapitre

            // Impacts potentiels du chapitre
            $table->integer('stress_impact')->default(0); // Impact sur le stress
            $table->integer('sleep_impact')->default(0);  // Impact sur le sommeil
            $table->integer('grades_impact')->default(0); // Impact sur les résultats scolaires

            // Conseils associés à chaque dimension
            $table->text('stress_advice')->nullable();    // Conseil pour gérer le stress
            $table->text('sleep_advice')->nullable();     // Conseil pour améliorer le sommeil
            $table->text('grades_advice')->nullable();    // Conseil pour progresser scolairement

            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Supprime la table `chapters`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
