<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création des tables de cache :
 * - `cache` : stocke les entrées de cache applicatif
 * - `cache_locks` : gère les verrous (locks) de cache pour synchronisation
 */
return new class extends Migration
{
    /**
     * Exécute la migration : crée les tables `cache` et `cache_locks`.
     *
     * @return void
     */
    public function up(): void
    {
        /**
         * Table `cache` :
         * Stocke les données mises en cache avec clé, valeur et expiration.
         */
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();       // Clé unique de cache
            $table->mediumText('value');            // Donnée sérialisée ou compressée
            $table->integer('expiration');          // Timestamp UNIX d'expiration
        });

        /**
         * Table `cache_locks` :
         * Sert à verrouiller temporairement certaines opérations (ex : mutex).
         */
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();       // Clé du verrou
            $table->string('owner');                // Identifiant de celui qui détient le verrou
            $table->integer('expiration');          // Timestamp UNIX d'expiration du verrou
        });
    }

    /**
     * Annule la migration : supprime les tables de cache.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
