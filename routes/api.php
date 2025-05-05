<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;

// ✅ API classique
Route::get('/stories', [StoryController::class, 'index']);
Route::get('/story/{id}', [StoryController::class, 'show']);
Route::get('/story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);
Route::get('/metrics', [MetricsController::class, 'getMetrics']);
Route::post('/metrics/update', [MetricsController::class, 'updateMetrics']);
Route::post('/metrics/reset', [MetricsController::class, 'resetMetrics']);
Route::apiResource('/choices', ChoiceController::class);

// ✅ Route USER (EN DEHORS DU prefix('api'))
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Routes pour témoignages
Route::prefix('api')->group(function () {
    Route::get('/testimonies', [TestimonyController::class, 'index']);
    Route::get('/testimonies/{testimony}', [TestimonyController::class, 'show']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/testimonies', [TestimonyController::class, 'store']);
        Route::put('/testimonies/{testimony}', [TestimonyController::class, 'update']);
        Route::delete('/testimonies/{testimony}', [TestimonyController::class, 'destroy']);
        Route::get('/my-testimonies', [TestimonyController::class, 'myTestimonies']);
    });
});

// Liste des témoignages non validés
Route::get('/admin/testimonies/pending', [TestimonyController::class, 'pending'])->middleware('auth');

// Approuver un témoignage
Route::patch('/admin/testimonies/{id}/approve', [TestimonyController::class, 'approve'])->middleware('auth');
