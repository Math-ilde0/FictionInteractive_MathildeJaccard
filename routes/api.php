<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\StressController;

// Story Routes
Route::get('stories', [StoryController::class, 'index']);
Route::get('story/{id}', [StoryController::class, 'show']);

// Chapter Routes
Route::get('story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);

// Choices Routes
Route::apiResource('choices', ChoiceController::class);

// Stress Management Routes
Route::get('stress', [StressController::class, 'getStress']);
Route::post('stress/update', [StressController::class, 'updateStress']);
Route::post('stress/reset', [StressController::class, 'resetStress']);