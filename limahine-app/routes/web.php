<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\VideoTrailerController;
use Illuminate\Http\Request;
use App\Models\PostArticles;

// Routes pour la gestion des langues
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');

// Route pour la page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour les pages principales
Route::get('/bibliographie', [HomeController::class, 'biography'])->name('biography');
Route::get('/publications', [HomeController::class, 'writing'])->name('writing');
Route::get('/philosophie', [HomeController::class, 'philosophy'])->name('philosophy');
Route::get('/temoignages', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/chercheurs', [HomeController::class, 'chercheurs'])->name('chercheurs');

// Routes pour les publications individuelles
Route::get('/publications/{publication:slug}', [HomeController::class, 'showPublication'])->name('publications.show');

// Maintenir les anciennes routes pour compatibilité
Route::get('/biography', [HomeController::class, 'biography']);
Route::get('/writing', [HomeController::class, 'writing']);

// Route pour l'administration (ancienne - sera remplacée par Filament)
Route::get('/admin-old', function () {
    $posts = PostArticles::all();
    return view('admin', compact('posts'));
})->name('admin.old');

// Routes pour l'ancien système de posts (compatibilité)
Route::post('/admin/posts', function (Request $request) {
    PostArticles::create($request->all());
    return redirect('/admin-old');
})->name('admin.posts.store');

Route::patch('/admin/posts/{id}/publish', function ($id) {
    $post = PostArticles::findOrFail($id);
    $post->update(['is_published' => true]);
    return redirect('/admin-old');
})->name('admin.posts.publish');

// Routes pour les Vidéo
Route::get('/trailers', [VideoTrailerController::class, 'index'])->name('trailers.index');
Route::get('/trailers/{slug}', [VideoTrailerController::class, 'show'])->name('trailers.show');
Route::get('/api/trailers', [VideoTrailerController::class, 'api'])->name('trailers.api');

// Route::get('/testimonials', function () {
//     return view('testimonials');
// });

// Route::get('/chercheurs', function () {
//     return view('chercheurs');
// });
