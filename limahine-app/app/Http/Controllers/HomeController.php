<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Temoignage;
use App\Models\Bibliographie;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $publications = Publication::published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $featuredPublication = Publication::published()
            ->featured()
            ->latest('published_at')
            ->first();

        $temoignages = Temoignage::published()
            ->verified()
            ->featured()
            ->take(3)
            ->get();

        return view('welcome', compact('publications', 'featuredPublication', 'temoignages'));
    }

    public function biography()
    {
        $bibliographies = Bibliographie::published()
            ->byCategory('cheikh_ahmadou_bamba')
            ->featured()
            ->take(6)
            ->get();

        return view('biography', compact('bibliographies'));
    }

    public function writing()
    {
        $publications = Publication::published()
            ->latest('published_at')
            ->paginate(12);

        $categories = Publication::getCategories();

        $featuredPublications = Publication::published()
            ->featured()
            ->take(3)
            ->get();

        return view('writing', compact('publications', 'categories', 'featuredPublications'));
    }

    public function philosophy()
    {
        $philosophyPublications = Publication::published()
            ->byCategory('philosophy')
            ->latest('published_at')
            ->take(6)
            ->get();

        $page = Page::byType('philosophy')->published()->first();

        return view('philosophy', compact('philosophyPublications', 'page'));
    }

    public function testimonials()
    {
        $temoignages = Temoignage::published()
            ->verified()
            ->latest('published_at')
            ->paginate(9);

        $featuredTemoignages = Temoignage::published()
            ->verified()
            ->featured()
            ->take(3)
            ->get();

        return view('testimonials', compact('temoignages', 'featuredTemoignages'));
    }

    public function chercheurs()
    {
        $bibliographies = Bibliographie::published()
            ->byCategory('etudes_academiques')
            ->latest()
            ->paginate(12);

        $academicResources = Bibliographie::published()
            ->byType('these')
            ->orWhere('type', 'memoire')
            ->orWhere('type', 'conference')
            ->take(6)
            ->get();

        return view('chercheurs', compact('bibliographies', 'academicResources'));
    }

    public function publications()
    {
        $publications = Publication::published()
            ->latest('published_at')
            ->paginate(12);

        return view('publications.index', compact('publications'));
    }

    public function showPublication(Publication $publication)
    {
        if (!$publication->is_published) {
            abort(404);
        }

        $relatedPublications = Publication::published()
            ->where('category', $publication->category)
            ->where('id', '!=', $publication->id)
            ->take(3)
            ->get();

        return view('publications.show', compact('publication', 'relatedPublications'));
    }
}
