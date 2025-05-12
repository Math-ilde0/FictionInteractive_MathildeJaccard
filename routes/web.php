<?php
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\MetricsController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
// Public routes
Route::get('/stories', [StoryController::class, 'index']);
Route::get('/story/{id}', [StoryController::class, 'show']);
Route::get('/story/{storyId}/chapter/{chapterId}', [ChapterController::class, 'show']);
Route::get('/metrics', [MetricsController::class, 'getAllMetrics']);
Route::post('/metrics/update', [MetricsController::class, 'updateMetrics']);
Route::post('/metrics/reset', [MetricsController::class, 'resetMetrics']);
Route::apiResource('/choices', ChoiceController::class);

// Assurez-vous que ces routes sont présentes
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
// Authentication routes
require __DIR__.'/auth.php';

// Catch-all route for SPA - must be LAST
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');