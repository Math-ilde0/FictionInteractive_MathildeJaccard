<?php
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/stories', [StoryController::class, 'index']);
Route::get('/story/{id}', [StoryController::class, 'show']);
Route::get('/story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);
Route::get('/metrics', [MetricsController::class, 'getMetrics']);
Route::post('/metrics/update', [MetricsController::class, 'updateMetrics']);
Route::post('/metrics/reset', [MetricsController::class, 'resetMetrics']);
Route::apiResource('/choices', ChoiceController::class);

// Authentication routes
require __DIR__.'/auth.php';

// Catch-all route for SPA - must be LAST
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');