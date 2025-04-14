<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('chapters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('story_id')->constrained()->onDelete('cascade');  // Associe chaque chapitre à une histoire
        $table->integer('chapter_number');  // Le numéro du chapitre
        $table->text('content');  // Le contenu du chapitre
        $table->integer('stress_level')->default(5); // Valeur par défaut à 5 sur 10
        $table->timestamps();  // Ajoute created_at et updated_at
        $table->integer('stress_impact')->default(0); // Impact de stress du chapitre
            $table->boolean('is_recovery_point')->default(false); // Point de récupération
            $table->text('stress_advice')->nullable(); // Conseil de gestion du stress
    });
}


public function down(): void
{
    Schema::table('chapters', function (Blueprint $table) {
        $table->dropColumn(['stress_impact', 'is_recovery_point', 'stress_advice']);
    });
}
};