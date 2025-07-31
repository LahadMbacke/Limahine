<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/biography', function () {
    return view('biography');
});

Route::get('/writing', function () {
    return view('writing');
});

Route::get('/philosophy', function () {
    return view('philosophy');
});

Route::get('/testimonials', function () {
    return view('testimonials');
});

Route::get('/chercheurs', function () {
    return view('chercheurs');
});