<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création de la table `testimonies`.
 * Contient les témoignages soumis par les utilisateurs.
 */
return new class extends Migration
{
    /**
     * Crée la table `testimonies` avec ses colonnes et sa relation utilisateur.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('testimonies', function (Blueprint $table) {
            $table->id(); // Clé primaire

            // Lien avec la table users (auteur du témoignage)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); // Suppression automatique des témoignages si l'utilisateur est supprimé

            $table->string('title');   // Titre du témoignage
            $table->text('content');   // Contenu textuel

            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Supprime la table `testimonies`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonies');
    }
};
