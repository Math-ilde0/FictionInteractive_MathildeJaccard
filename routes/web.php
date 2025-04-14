<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;

// Main application route
Route::get('/', function () {
    return view('welcome');
});

// Route for game result
Route::get('/result/{outcome}', function () {
    return view('welcome');
});

// Catch-all route for Vue router
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*');