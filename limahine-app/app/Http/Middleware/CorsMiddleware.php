<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Ajouter les headers CORS pour toutes les requêtes
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN');
        $response->headers->set('Access-Control-Expose-Headers', 'Content-Type, Content-Length');
        $response->headers->set('Access-Control-Max-Age', '86400');

        // Gérer les requêtes OPTIONS (preflight)
        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(200);
        }

        return $response;
    }
}
