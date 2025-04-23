<?php
use Illuminate\Support\Facades\Route;

// Route d'accueil qui renvoie la vue welcome
Route::get('/', function () {
    return view('welcome');
});

// Routes pour les résultats du jeu
Route::get('/result/{outcome}', function () {
    return view('welcome');
})->where('outcome', 'success|failure|warning|sleep-crisis|academic-crisis');

// IMPORTANT: Catch-all route qui n'interfère pas avec les routes API
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!stories$|^story|^choices|^metrics).*');