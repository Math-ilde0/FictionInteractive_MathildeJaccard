<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création des tables :
 * - `jobs` : stocke les jobs en file d'attente
 * - `job_batches` : stocke les lots de jobs (batchs)
 * - `failed_jobs` : stocke les jobs échoués pour analyse
 */
return new class extends Migration
{
    /**
     * Exécute les migrations.
     *
     * @return void
     */
    public function up(): void
    {
        /**
         * Table `jobs` :
         * Contient tous les jobs mis en file d'attente.
         */
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();                               // ID du job
            $table->string('queue')->index();           // Nom de la file (ex: 'emails')
            $table->longText('payload');                // Données sérialisées du job
            $table->unsignedTinyInteger('attempts');    // Nombre de tentatives effectuées
            $table->unsignedInteger('reserved_at')->nullable();  // Temps de réservation (UNIX timestamp)
            $table->unsignedInteger('available_at');    // Quand le job peut être traité
            $table->unsignedInteger('created_at');      // Création (UNIX timestamp)
        });

        /**
         * Table `job_batches` :
         * Contient des informations sur les lots (batchs) de jobs, gérés par `Bus::batch()`.
         */
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();            // UUID du batch
            $table->string('name');                     // Nom du batch
            $table->integer('total_jobs');              // Nombre total de jobs dans le batch
            $table->integer('pending_jobs');            // Jobs restants à traiter
            $table->integer('failed_jobs');             // Nombre de jobs échoués
            $table->longText('failed_job_ids');         // IDs des jobs échoués (JSON encodé)
            $table->mediumText('options')->nullable();  // Options personnalisées
            $table->integer('cancelled_at')->nullable();// Si annulé, timestamp d'annulation
            $table->integer('created_at');              // Timestamp de création
            $table->integer('finished_at')->nullable(); // Timestamp de fin (si terminé)
        });

        /**
         * Table `failed_jobs` :
         * Stocke les jobs échoués pour pouvoir les analyser ou les rejouer.
         */
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();                               // ID du job échoué
            $table->string('uuid')->unique();           // UUID du job
            $table->text('connection');                 // Connexion utilisée (ex: database, redis)
            $table->text('queue');                      // File d’origine
            $table->longText('payload');                // Données complètes du job
            $table->longText('exception');              // Stack trace de l'exception
            $table->timestamp('failed_at')->useCurrent(); // Date d’échec (default now)
        });
    }

    /**
     * Annule les migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
