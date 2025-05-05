<?php
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;
use Illuminate\Support\Facades\Route;

// API routes - define these BEFORE the catch-all route
Route::get('/stories', [StoryController::class, 'index'])->middleware('json.response');
Route::get('/story/{id}', [StoryController::class, 'show'])->middleware('json.response');
Route::get('/story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show'])->middleware('json.response');
Route::get('/metrics', [MetricsController::class, 'getMetrics'])->middleware('json.response');
Route::post('/metrics/update', [MetricsController::class, 'updateMetrics'])->middleware('json.response');
Route::post('/metrics/reset', [MetricsController::class, 'resetMetrics'])->middleware('json.response');

// Authentication routes
require __DIR__.'/auth.php';

// Catch-all route for SPA - must be LAST
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');