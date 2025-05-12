<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création de la table `choices`.
 * Représente les choix possibles depuis un chapitre donné,
 * menant potentiellement à un autre chapitre.
 */
return new class extends Migration
{
    /**
     * Crée la table `choices` avec ses clés étrangères.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->id(); // Identifiant unique du choix

            $table->unsignedBigInteger('chapter_id'); // Chapitre source (où le choix est présenté)
            $table->text('text');                     // Texte affiché à l’utilisateur
            $table->unsignedBigInteger('next_chapter_id')->nullable(); // Chapitre cible après le choix

            $table->timestamps(); // created_at / updated_at

            // Clé étrangère vers le chapitre source — supprime le choix si le chapitre est supprimé
            $table->foreign('chapter_id')
                  ->references('id')
                  ->on('chapters')
                  ->onDelete('cascade');

            // Clé étrangère vers le chapitre cible — met la valeur à null si le chapitre est supprimé
            $table->foreign('next_chapter_id')
                  ->references('id')
                  ->on('chapters')
                  ->onDelete('set null');
        });
    }

    /**
     * Supprime la table `choices`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
