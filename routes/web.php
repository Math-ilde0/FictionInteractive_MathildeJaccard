<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Pour les résultats (attention au conflit potentiel)
Route::get('/result/{outcome}', function () {
    return view('welcome');
})->where('outcome', 'success|failure|warning|sleep-crisis|academic-crisis');

// Catch-all : tout sauf les routes API
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!stories$|story/|choices|metrics|result/).*');
