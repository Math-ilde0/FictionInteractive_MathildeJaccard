<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration de création des tables utilisateurs, tokens de réinitialisation, et sessions.
 * 
 * Tables créées :
 * - users
 * - password_reset_tokens
 * - sessions
 */
return new class extends Migration
{
    /**
     * Exécute les migrations : création des tables nécessaires.
     *
     * @return void
     */
    public function up(): void
    {
        /**
         * Table `users` : stocke les comptes utilisateurs.
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('name'); // Nom de l'utilisateur
            $table->string('email')->unique(); // Email unique
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification (si activée)
            $table->string('password'); // Mot de passe hashé
            $table->rememberToken(); // Token pour "remember me"
            $table->timestamps(); // created_at / updated_at
        });

        /**
         * Table `password_reset_tokens` : gère la réinitialisation de mot de passe.
         */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Clé primaire : email
            $table->string('token'); // Token de réinitialisation
            $table->timestamp('created_at')->nullable(); // Date de création du token
        });

        /**
         * Table `sessions` : stocke les données de session utilisateur.
         */
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID unique de la session
            $table->foreignId('user_id')->nullable()->index(); // Clé étrangère vers users
            $table->string('ip_address', 45)->nullable(); // Adresse IP de connexion
            $table->text('user_agent')->nullable(); // Infos navigateur
            $table->longText('payload'); // Données sérialisées de session
            $table->integer('last_activity')->index(); // Dernière activité
        });
    }

    /**
     * Annule les migrations : suppression des tables.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
