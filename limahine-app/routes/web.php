<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request; // Assurez-vous d'importer cette classe en haut du fichier

use App\Models\PostArticles;


Route::get('/', HomeController::class . '@index');

Route::get('/biography', HomeController::class . '@biography');

Route::get('/writing', HomeController::class . '@writing');
Route::get('/philosophy', HomeController::class . '@philosophy');
Route::get('/testimonials', HomeController::class . '@testimonials');
Route::get('/chercheurs', HomeController::class . '@chercheurs');


Route::get('/admin', function () {
    $posts = PostArticles::all();
    return view('admin', compact('posts'));
});

Route::get('/', function () {
    $posts = PostArticles::where('is_published', true)->latest()->take(3)->get(); // Récupérer les 3 derniers articles publiés
    return view('welcome', compact('posts')); // Transmettre $posts à la vue
});

Route::post('/admin/posts', function (Request $request) {
    PostArticles::create($request->all());
    return redirect('/admin');
});

Route::patch('/admin/posts/{id}/publish', function ($id) {
    $post = PostArticles::findOrFail($id);
    $post->update(['is_published' => true]);
    return redirect('/admin');
});


// Route::get('/', function () {
//     $posts = Post::where('is_published', true)->latest()->take(3)->get();
//     return view('welcome', compact('posts'));
// });



// Route::get('/philosophy', function () {
//     return view('philosophy');
// });

// Route::get('/testimonials', function () {
//     return view('testimonials');
// });

// Route::get('/chercheurs', function () {
//     return view('chercheurs');
// });