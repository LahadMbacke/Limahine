<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersDev
{
    /**
     * Version de développement du middleware de sécurité
     * Plus permissive pour permettre le bon fonctionnement des styles
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Seulement pour les médias sécurisés, appliquer la sécurité stricte
        if ($request->is('secure-media/*')) {
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet, noimageindex');
            
            // CSP très strict pour les médias uniquement
            $csp = "default-src 'none'; img-src 'self'; object-src 'none';";
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
