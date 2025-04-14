<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;

// Main application route
Route::get('/', function () {
    return view('welcome');
});

// Story API routes
Route::get('/api/stories', [StoryController::class, 'index']);
Route::get('/api/story/{id}', [StoryController::class, 'show']);
Route::get('/story/1', [StoryController::class, 'show'])->name('story.show');

// Route for game result
Route::get('/result/{outcome}', function ($outcome) {
    return view('result', ['outcome' => $outcome]);
});

// Catch-all route for Vue router
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');