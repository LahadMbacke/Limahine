<?php

namespace App\Http\Controllers;

use App\Models\VideoTrailer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoTrailerController extends Controller
{
    /**
     * Affiche la liste des trailers publiés
     */
    public function index(Request $request): View
    {
        $query = VideoTrailer::published();

        // Filtrer par catégorie si spécifiée
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filtrer par recherche textuelle
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title->fr', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('title->ar', 'like', "%{$search}%")
                  ->orWhere('description->fr', 'like', "%{$search}%")
                  ->orWhere('description->en', 'like', "%{$search}%")
                  ->orWhere('description->ar', 'like', "%{$search}%");
            });
        }

        $trailers = $query->orderBy('published_at', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(12);

        $featuredTrailers = VideoTrailer::published()
                                       ->featured()
                                       ->orderBy('published_at', 'desc')
                                       ->limit(3)
                                       ->get();

        $categories = VideoTrailer::published()
                                 ->select('category')
                                 ->distinct()
                                 ->whereNotNull('category')
                                 ->pluck('category');

        return view('trailers.index', compact('trailers', 'featuredTrailers', 'categories'));
    }

    /**
     * Affiche un trailer spécifique
     */
    public function show(string $slug): View
    {
        $trailer = VideoTrailer::published()
                              ->where('slug', $slug)
                              ->firstOrFail();

        // Récupérer des trailers similaires (même catégorie)
        $relatedTrailers = VideoTrailer::published()
                                      ->where('category', $trailer->category)
                                      ->where('id', '!=', $trailer->id)
                                      ->limit(4)
                                      ->get();

        return view('trailers.show', compact('trailer', 'relatedTrailers'));
    }

    /**
     * API endpoint pour récupérer les trailers en JSON
     */
    public function api(Request $request)
    {
        $query = VideoTrailer::published();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('featured')) {
            $query->featured();
        }

        $trailers = $query->orderBy('published_at', 'desc')
                         ->limit($request->get('limit', 10))
                         ->get()
                         ->map(function ($trailer) {
                             return [
                                 'id' => $trailer->id,
                                 'title' => $trailer->getTranslation('title', app()->getLocale()),
                                 'description' => $trailer->getTranslation('description', app()->getLocale()),
                                 'slug' => $trailer->slug,
                                 'youtube_embed_url' => $trailer->youtube_embed_url,
                                 'youtube_url' => $trailer->youtube_url,
                                 'thumbnail' => $trailer->youtube_thumbnail,
                                 'duration' => $trailer->formatted_duration,
                                 'category' => $trailer->category,
                                 'published_at' => $trailer->published_at,
                             ];
                         });

        return response()->json($trailers);
    }
}
