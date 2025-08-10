<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LivewireUploadMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ajouter des headers CORS pour les uploads Livewire
        $response = $next($request);

        if ($request->is('livewire/*')) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN, X-Livewire');
            $response->headers->set('Access-Control-Expose-Headers', 'Content-Type, Content-Length');
            $response->headers->set('Access-Control-Max-Age', '86400');
        }

        return $response;
    }
}
