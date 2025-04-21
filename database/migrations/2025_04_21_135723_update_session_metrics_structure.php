<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sessions', function (Blueprint $table) {
            // Ajout des clés dans les données de session pour les nouvelles métriques
            // Note: Les données de session sont stockées en JSON, donc nous ne modifions pas 
            // directement le schéma mais nous nous assurons que notre code gère ces valeurs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pas besoin de supprimer quoi que ce soit car nous n'avons pas modifié le schéma
    }
};