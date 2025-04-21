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

// Choices Routes
Route::apiResource('choices', ChoiceController::class);

Route::get('metrics', [MetricsController::class, 'getMetrics']);
Route::post('metrics/update', [MetricsController::class, 'updateMetrics']);
Route::post('metrics/reset', [MetricsController::class, 'resetMetrics']);

// Pour la rétrocompatibilité (puisque le front-end utilise ces routes)
Route::get('stress', [MetricsController::class, 'getMetrics']);
Route::post('stress/update', [MetricsController::class, 'updateMetrics']);
Route::post('stress/reset', [MetricsController::class, 'resetMetrics']);