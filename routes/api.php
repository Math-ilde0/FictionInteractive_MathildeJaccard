<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;

// Story Routes
Route::get('stories', [StoryController::class, 'index']);
Route::get('story/{id}', [StoryController::class, 'show']);

// Chapter Routes
Route::get('story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);

// Metrics Routes
Route::get('metrics', [MetricsController::class, 'getMetrics']);
Route::post('metrics/update', [MetricsController::class, 'updateMetrics']);
Route::post('metrics/reset', [MetricsController::class, 'resetMetrics']);

// Choices Routes 
Route::apiResource('choices', ChoiceController::class);

Route::get('test-metrics/{stress}/{sleep}/{grades}', function($stress, $sleep, $grades) {
    session([
        'stress_level' => (int)$stress,
        'sleep_level' => (int)$sleep, 
        'grades_level' => (int)$grades
    ]);
    
    return response()->json([
        'message' => 'Métriques mises à jour directement',
        'stress_level' => session('stress_level'),
        'sleep_level' => session('sleep_level'),
        'grades_level' => session('grades_level')
    ]);
});