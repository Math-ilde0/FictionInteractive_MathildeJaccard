<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;

// Story Routes
Route::get('stories', [StoryController::class, 'index']);
Route::get('story/{id}', [StoryController::class, 'show']);

// Chapter Routes
// Dans routes/api.php
Route::get('story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);
Route::apiResource('choices', ChoiceController::class);
