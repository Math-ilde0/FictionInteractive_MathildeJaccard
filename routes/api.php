<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;

Route::middleware(['web', 'session'])->group(function () {
    // Stories
    Route::get('/stories', [StoryController::class, 'index']);
    Route::get('/story/{id}', [StoryController::class, 'show']);

    // Chapters
    Route::get('/story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);

    // Metrics
    Route::get('/metrics', [MetricsController::class, 'getMetrics']);
    Route::post('/metrics/update', [MetricsController::class, 'updateMetrics']);
    Route::post('/metrics/reset', [MetricsController::class, 'resetMetrics']);

    // Choices
    Route::apiResource('/choices', ChoiceController::class);
});
