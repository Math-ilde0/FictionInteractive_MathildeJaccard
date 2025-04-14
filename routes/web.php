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

// Route for game result
Route::get('/result/{outcome}', function () {
    return view('welcome');
});

// Catch-all route for Vue router
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*');