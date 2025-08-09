<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle($request, Closure $next)
{
    // Vérifiez qu'il n'y a pas de code ici qui génère des URL
    if ($request->session()->has('locale')) {
        $locale = $request->session()->get('locale');
        if (in_array($locale, ['fr', 'en', 'ar'])) {
            App::setLocale($locale);
        }
    }
    
    return $next($request);
}
}
