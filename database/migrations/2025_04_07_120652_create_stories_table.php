<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création de la table `stories`.
 * Représente les histoires interactives créées dans l'application.
 */
return new class extends Migration
{
    /**
     * Exécute la migration : crée la table `stories`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();                               // ID unique de l'histoire
            $table->string('title');                    // Titre de l'histoire
            $table->text('summary');                    // Résumé ou description de l'histoire
            $table->unsignedBigInteger('author_id')->nullable(); // ID de l'auteur (utilisateur)
            $table->timestamps();                       // created_at / updated_at
        });

        // Ajout de la contrainte de clé étrangère vers la table `users`
        Schema::table('stories', function (Blueprint $table) {
            $table->foreign('author_id')
                  ->references('id')->on('users')
                  ->onDelete('set null'); // Si l'utilisateur est supprimé, on garde la story sans auteur
        });
    }

    /**
     * Annule la migration : supprime la table `stories`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
