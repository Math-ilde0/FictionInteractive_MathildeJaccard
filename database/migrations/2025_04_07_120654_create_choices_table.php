<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chapter_id'); // Foreign key to chapters table
            $table->text('text');
            $table->unsignedBigInteger('next_chapter_id')->nullable(); // Foreign key to chapters table
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
            $table->foreign('next_chapter_id')->references('id')->on('chapters')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};