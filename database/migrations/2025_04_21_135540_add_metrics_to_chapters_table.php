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
        Schema::table('chapters', function (Blueprint $table) {
            // ✅ Garde uniquement les colonnes encore utilisées
            $table->integer('sleep_impact')->default(0);
            $table->integer('grades_impact')->default(0);
            $table->text('sleep_advice')->nullable();
            $table->text('grades_advice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chapters', function (Blueprint $table) {
            $table->dropColumn([
                'sleep_impact',
                'grades_impact',
                'sleep_advice',
                'grades_advice'
            ]);
        });
    }
};
