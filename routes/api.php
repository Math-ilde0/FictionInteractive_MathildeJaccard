<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;

// Route publique pour obtenir les témoignages
Route::get('/testimonies', [TestimonyController::class, 'index']);
// Routes nécessitant une authentification
Route::middleware('auth:sanctum')->group(function () {
    // Route utilisateur
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Route pour enregistrer un témoignage
    Route::post('/testimonies', [TestimonyController::class, 'store']);
});