<?php
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('StoryList');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour les témoignages
// Voir les témoignages publics (accessible à tous)
Route::resource('testimonies', TestimonyController::class)->only(['index', 'show']);

// Actions réservées aux utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::resource('testimonies', TestimonyController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/my-testimonies', [TestimonyController::class, 'myTestimonies'])->name('testimonies.my');
});


require __DIR__.'/auth.php';
