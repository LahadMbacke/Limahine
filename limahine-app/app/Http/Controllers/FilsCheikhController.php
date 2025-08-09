<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilsCheikh;
use App\Models\Publication;

class FilsCheikhController extends Controller
{
    /**
     * Affiche la liste des fils de Cheikh Ahmadou Bamba
     */
    public function index()
    {
        // Khalifs (ordonnés par succession)
        $khalifs = FilsCheikh::published()
            ->khalifs()
            ->get();

        // Autres fils (non-Khalifs)
        $autres_fils = FilsCheikh::published()
            ->nonKhalifs()
            ->orderBy('name->fr')
            ->get();

        // Publications récentes de la catégorie découverte
        $recent_publications = Publication::published()
            ->byCategory('decouverte')
            ->with('filsCheikh')
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('decouverte.index', compact('khalifs', 'autres_fils', 'recent_publications'));
    }

    /**
     * Affiche le détail d'un fils de Cheikh
     */
    public function show(FilsCheikh $filsCheikh)
    {
        if (!$filsCheikh->is_published) {
            abort(404);
        }

        // Publications associées à ce fils de Cheikh
        $publications = Publication::published()
            ->where('fils_cheikh_id', $filsCheikh->id)
            ->latest('published_at')
            ->paginate(12);

        // Autres fils de Cheikh (suggestions)
        $autres_fils = FilsCheikh::published()
            ->where('id', '!=', $filsCheikh->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('decouverte.show', compact('filsCheikh', 'publications', 'autres_fils'));
    }

    /**
     * Affiche les publications d'un fils de Cheikh spécifique
     */
    public function publications(FilsCheikh $filsCheikh)
    {
        if (!$filsCheikh->is_published) {
            abort(404);
        }

        $query = Publication::published()
            ->where('fils_cheikh_id', $filsCheikh->id)
            ->latest('published_at');

        // Recherche textuelle
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->whereJsonContains('title->fr', $searchTerm)
                  ->orWhereJsonContains('title->en', $searchTerm)
                  ->orWhereJsonContains('title->ar', $searchTerm)
                  ->orWhereJsonContains('content->fr', $searchTerm)
                  ->orWhereJsonContains('content->en', $searchTerm)
                  ->orWhereJsonContains('content->ar', $searchTerm);
            });
        }

        $publications = $query->paginate(12);

        return view('decouverte.publications', compact('filsCheikh', 'publications'));
    }
}
