<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // N'appliquer les headers de sécurité stricts que pour les médias sécurisés
        if ($request->is('secure-media/*')) {
            // Headers de sécurité stricts pour les médias
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet, noimageindex');
            
            // CSP très strict pour les médias
            $csp = "default-src 'none'; img-src 'self'; object-src 'none';";
            $response->headers->set('Content-Security-Policy', $csp);
        } else {
            // Headers de sécurité basiques pour les pages normales
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            
            // CSP plus permissive pour les pages avec CSS/JS
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://fonts.googleapis.com https://www.youtube.com http://localhost:* ws://localhost:*; " .
                   "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com http://localhost:*; " .
                   "img-src 'self' data: https: blob:; " .
                   "font-src 'self' https://fonts.gstatic.com data:; " .
                   "connect-src 'self' ws://localhost:* http://localhost:* https:; " .
                   "media-src 'self'; " .
                   "object-src 'none'; " .
                   "frame-src 'self' https://www.youtube.com; " .
                   "base-uri 'self'; " .
                   "form-action 'self';";
            $response->headers->set('Content-Security-Policy', $csp);
        }

        // Désactiver les fonctionnalités de navigateur dangereuses (pour toutes les pages)
        $response->headers->set('Permissions-Policy',
            'camera=(), microphone=(), geolocation=(), accelerometer=(), gyroscope=(), magnetometer=(), payment=(), usb=()'
        );

        return $response;
    }
}
