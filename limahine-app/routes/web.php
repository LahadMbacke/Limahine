<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\VideoTrailerController;

// Routes pour la gestion des langues
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');

// Route pour la page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour les pages principales
Route::get('/biographie', [HomeController::class, 'biography'])->name('biography');
Route::get('/biographie/{biographie:slug}', [HomeController::class, 'showBiography'])->name('biography.show');
Route::get('/publications', [HomeController::class, 'writing'])->name('writing');
Route::get('/philosophie', [HomeController::class, 'philosophy'])->name('philosophy');
Route::get('/temoignages', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/chercheurs', [HomeController::class, 'chercheurs'])->name('chercheurs');

// Routes pour les publications individuelles
Route::get('/publications/{publication:slug}', [HomeController::class, 'showPublication'])->name('publications.show');

// Routes pour les Vidéo
Route::get('/trailers', [VideoTrailerController::class, 'index'])->name('trailers.index');
Route::get('/trailers/{slug}', [VideoTrailerController::class, 'show'])->name('trailers.show');
Route::get('/api/trailers', [VideoTrailerController::class, 'api'])->name('trailers.api');
