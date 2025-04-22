<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;

// Main application route
Route::get('/', function () {
    return view('welcome');
});

// Routes for different game results
Route::get('/result/{outcome}', function () {
    return view('welcome');
})->where('outcome', 'success|failure|warning|sleep-crisis|academic-crisis');

// Catch-all route for Vue router
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*');