<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Temoignage;
use App\Models\Bibliographie;
use App\Models\VideoTrailer;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        // Publications vedettes
        $featuredPublications = Publication::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Témoignages vedettes
        $featuredTestimonials = Temoignage::published()
            ->verified()
            ->featured()
            ->take(3)
            ->get();

        // Trailers vidéo en vedette
        $featuredTrailers = VideoTrailer::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Statistiques pour la page d'accueil
        $stats = [
            'publications' => Publication::published()->count(),
            'temoignages' => Temoignage::published()->verified()->count(),
            'bibliographies' => Bibliographie::published()->count(),
            'trailers' => VideoTrailer::published()->count(),
        ];

        return view('home-new', compact('featuredPublications', 'featuredTestimonials', 'featuredTrailers', 'stats'));
    }

    public function biography()
    {
        $query = Bibliographie::published()->latest();

        // Filtrage par catégorie
        if (request('category')) {
            $query->byCategory(request('category'));
        }

        // Filtrage par type
        if (request('type')) {
            $query->byType(request('type'));
        }

        // Recherche textuelle
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->whereJsonContains('title->fr', $searchTerm)
                  ->orWhereJsonContains('title->en', $searchTerm)
                  ->orWhereJsonContains('title->ar', $searchTerm)
                  ->orWhereJsonContains('author_name->fr', $searchTerm)
                  ->orWhereJsonContains('author_name->en', $searchTerm)
                  ->orWhereJsonContains('author_name->ar', $searchTerm)
                  ->orWhereJsonContains('description->fr', $searchTerm)
                  ->orWhereJsonContains('description->en', $searchTerm)
                  ->orWhereJsonContains('description->ar', $searchTerm);
            });
        }

        $bibliographies = $query->paginate(16);
        $categories = Bibliographie::getCategories();
        $types = Bibliographie::getTypes();

        // Ouvrages vedettes (uniquement si pas de filtre)
        $featuredBibliographies = collect();
        if (!request('category') && !request('search') && !request('type')) {
            $featuredBibliographies = Bibliographie::published()
                ->featured()
                ->take(6)
                ->get();
        }

        // Statistiques par catégorie
        $stats = [];
        foreach ($categories as $key => $label) {
            $stats[$key] = Bibliographie::published()->byCategory($key)->count();
        }

        return view('bibliography-new', compact('bibliographies', 'categories', 'types', 'featuredBibliographies', 'stats'));
    }

    public function writing()
    {
        $query = Publication::published()->latest('published_at');

        // Filtrage par catégorie
        if (request('category')) {
            $query->byCategory(request('category'));
        }

        // Recherche textuelle
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->whereJsonContains('title->fr', $searchTerm)
                  ->orWhereJsonContains('title->en', $searchTerm)
                  ->orWhereJsonContains('title->ar', $searchTerm)
                  ->orWhereJsonContains('content->fr', $searchTerm)
                  ->orWhereJsonContains('content->en', $searchTerm)
                  ->orWhereJsonContains('content->ar', $searchTerm)
                  ->orWhereJsonContains('excerpt->fr', $searchTerm)
                  ->orWhereJsonContains('excerpt->en', $searchTerm)
                  ->orWhereJsonContains('excerpt->ar', $searchTerm)
                  ->orWhere('tags', 'like', '%' . $searchTerm . '%');
            });
        }

        $publications = $query->paginate(12);
        $categories = Publication::getCategories();

        // Publications vedettes (uniquement si pas de filtre)
        $featuredPublications = collect();
        if (!request('category') && !request('search')) {
            $featuredPublications = Publication::published()
                ->featured()
                ->take(3)
                ->get();
        }

        return view('publications-new', compact('publications', 'categories', 'featuredPublications'));
    }

    public function philosophy()
    {
        $philosophyPublications = Publication::published()
            ->byCategory('philosophy')
            ->latest('published_at')
            ->take(6)
            ->get();

        $page = Page::where('page_type', 'philosophy')->published()->first();

        return view('philosophy-new', compact('philosophyPublications', 'page'));
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

        return view('testimonials-new', compact('temoignages', 'featuredTemoignages'));
    }

    public function chercheurs()
    {
        $bibliographies = Bibliographie::published()
            ->byCategory('etudes_academiques')
            ->latest()
            ->paginate(12);

        $academicResources = Bibliographie::published()
            ->where(function($query) {
                $query->byType('these')
                      ->orWhere('type', 'memoire')
                      ->orWhere('type', 'conference');
            })
            ->take(6)
            ->get();

        return view('chercheurs-new', compact('bibliographies', 'academicResources'));
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
