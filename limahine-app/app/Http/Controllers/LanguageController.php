<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Change la langue de l'application
     */
    public function switch(Request $request): JsonResponse
    {
        $request->validate([
            'locale' => 'required|string|in:fr,en,ar'
        ]);

        $locale = $request->input('locale');

        // Sauvegarder la langue dans la session
        Session::put('locale', $locale);

        // Définir la locale pour cette requête
        App::setLocale($locale);

        return response()->json([
            'success' => true,
            'locale' => $locale,
            'message' => __('Langue changée avec succès')
        ]);
    }

    /**
     * Retourne la langue actuelle
     */
    public function current(): JsonResponse
    {
        return response()->json([
            'locale' => App::getLocale()
        ]);
    }
}
