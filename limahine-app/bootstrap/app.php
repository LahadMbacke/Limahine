<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\SecurityHeadersDev::class, // Version dev plus permissive
            \App\Http\Middleware\CorsMiddleware::class, // Ajouter CORS pour résoudre les problèmes cross-origin
            \App\Http\Middleware\LivewireUploadMiddleware::class, // Middleware pour uploads Livewire
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
