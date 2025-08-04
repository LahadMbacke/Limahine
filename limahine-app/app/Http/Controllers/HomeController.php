<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Temoignage;
use App\Models\Biographie;
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

        // Vidéo en vedette
        $featuredTrailers = VideoTrailer::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Statistiques pour la page d'accueil
        $stats = [
            'publications' => Publication::published()->count(),
            'temoignages' => Temoignage::published()->verified()->count(),
            'biographies' => Biographie::published()->count(),
            'trailers' => VideoTrailer::published()->count(),
        ];

        return view('home-new', compact('featuredPublications', 'featuredTestimonials', 'featuredTrailers', 'stats'));
    }

    public function biography()
    {
        $query = Biographie::published()->latest();

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

        $biographies = $query->paginate(16);
        $categories = Biographie::getCategories();
        $types = Biographie::getTypes();

        // Personnalités vedettes (uniquement si pas de filtre)
        $featuredBiographies = collect();
        if (!request('category') && !request('search') && !request('type')) {
            $featuredBiographies = Biographie::published()
                ->featured()
                ->take(6)
                ->get();
        }

        // Statistiques par catégorie
        $stats = [];
        foreach ($categories as $key => $label) {
            $stats[$key] = Biographie::published()->byCategory($key)->count();
        }

        return view('biography-new', compact('biographies', 'categories', 'types', 'featuredBiographies', 'stats'));
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
        $biographies = Biographie::published()
            ->byCategory('etudes_academiques')
            ->latest()
            ->paginate(12);

        $academicResources = Biographie::published()
            ->where(function($query) {
                $query->byType('these')
                      ->orWhere('type', 'memoire')
                      ->orWhere('type', 'conference');
            })
            ->take(6)
            ->get();

        return view('chercheurs-new', compact('biographies', 'academicResources'));
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

    public function showBiography(Biographie $biographie)
    {
        // Vérifier que la biographie est publiée
        if (!$biographie->is_published) {
            abort(404);
        }

        // Biographies similaires (même catégorie)
        $relatedBiographies = Biographie::published()
            ->where('id', '!=', $biographie->id)
            ->where('category', $biographie->category)
            ->take(4)
            ->get();

        // Si pas assez de biographies similaires, prendre d'autres biographies
        if ($relatedBiographies->count() < 4) {
            $additionalBiographies = Biographie::published()
                ->where('id', '!=', $biographie->id)
                ->whereNotIn('id', $relatedBiographies->pluck('id'))
                ->take(4 - $relatedBiographies->count())
                ->get();

            $relatedBiographies = $relatedBiographies->concat($additionalBiographies);
        }

        return view('biography-detail', compact('biographie', 'relatedBiographies'));
    }
}
