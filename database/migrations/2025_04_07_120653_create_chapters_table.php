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
    });
}


    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};