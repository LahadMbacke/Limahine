<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function biography()
    {
        return view('biography');
    }
    public function writing()
    {
        return view('writing');
    }
    public function philosophy()
    {
        return view('philosophy');
    }
    public function testimonials()
    {
        return view('testimonials');
    }
    public function chercheurs()
    {
        return view('chercheurs');
    }
}
