<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Limahine - Plateforme d\'Excellence')</title>
    <meta name="description" content="@yield('description', 'Découvrez Limahine, une plateforme dédiée à l\'excellence et à l\'innovation.')">

    <!-- Anti-FOUC Script (doit être en premier) -->
    <script>
        (function() {
            'use strict';
            document.documentElement.style.visibility = 'hidden';
            document.documentElement.style.opacity = '0';
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Style inline pour éviter FOUC -->
    <style>
        html {
            visibility: hidden;
            opacity: 0;
        }
        html.content-loaded {
            visibility: visible !important;
            opacity: 1 !important;
            transition: opacity 0.3s ease-in-out;
        }
        /* Loader de base */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #fefdf8 0%, #fdf9e8 50%, #fbf1c5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease-in-out;
        }
        .page-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>

    @stack('styles')

    <!-- Protection contre le clic droit et les raccourcis clavier - DÉSACTIVÉE EN DÉVELOPPEMENT -->
    <style>
        @if(config('app.env') === 'production')
        /* Désactiver la sélection de texte */
        * {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-touch-callout: none;
            -webkit-tap-highlight-color: transparent;
        }

        /* Permettre la sélection pour les inputs et textareas */
        input, textarea, [contenteditable="true"] {
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
            user-select: text !important;
        }
        @else
        /* Mode développement : sélection de texte autorisée partout */
        * {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
        @endif

        /* Masquer les éléments en cas d'outils de développement ouverts */
        .dev-tools-warning {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            color: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999999;
            font-size: 24px;
            text-align: center;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Page Loader -->
    <div id="pageLoader" class="page-loader">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4">
                <div class="w-8 h-8 border-4 border-primary-200 border-t-primary-500 rounded-full animate-spin"></div>
            </div>
            <p class="text-accent-600 font-medium">Chargement...</p>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="fixed w-full top-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 md:h-16 lg:h-18">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('assets/unnamed.jpg') }}" alt="Limahine Logo" class="h-8 w-8 md:h-10 md:w-10 lg:h-12 lg:w-12 rounded-full shadow-md">
                        <div class="flex flex-col">
                            <span class="text-lg md:text-xl lg:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Limahine</span>
                            <!-- <span class="text-xs md:text-sm text-amber-600 hidden md:block">التعليم الروحي</span> -->
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-2 xl:space-x-4">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="text-sm font-medium">Accueil</span>
                    </a>
                    <a href="{{ route('philosophy') }}" class="nav-link {{ request()->routeIs('philosophy') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 12v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Mouridisme</span>
                    </a>
                    <a href="{{ route('writing') }}" class="nav-link {{ request()->routeIs('writing') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="text-sm font-medium">Publications</span>
                    </a>
                    <a href="{{ route('trailers.index') }}" class="nav-link {{ request()->routeIs('trailers.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Vidéo</span>
                    </a>
                    <a href="{{ route('chercheurs') }}" class="nav-link {{ request()->routeIs('chercheurs') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Chercheurs</span>
                    </a>

                    <a href="{{ route('testimonials') }}" class="nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span class="text-sm font-medium">Témoignages</span>
                    </a>
                </div>

                <!-- Language Selector & Mobile Menu -->
                <div class="flex items-center space-x-3">
                    <!-- Language Selector -->
                    <div class="relative hidden md:block">
                        <button id="language-button" class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-200 transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                            <span class="font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div id="language-dropdown" class="absolute right-0 top-full mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="py-1">
                                <a href="#" onclick="switchLanguage('fr')" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <span class="mr-3">🇫🇷</span>
                                    Français
                                </a>
                                <a href="#" onclick="switchLanguage('en')" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <span class="mr-3">🇬🇧</span>
                                    English
                                </a>
                                <a href="#" onclick="switchLanguage('ar')" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <span class="mr-3">🇸🇦</span>
                                    العربية
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button
                        type="button"
                        id="mobile-menu-button"
                        class="lg:hidden text-amber-700 hover:text-amber-900 focus:outline-none focus:text-amber-900 transition-colors p-2"
                        aria-label="Menu"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden">
                <div class="px-4 pt-4 pb-6 space-y-2 bg-white/95 backdrop-blur-sm rounded-xl mt-3 shadow-lg border border-amber-100">
                    <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Accueil
                    </a>
                    <a href="{{ route('philosophy') }}" class="mobile-nav-link {{ request()->routeIs('philosophy') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 12v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Mouridisme
                    </a>
                    <a href="{{ route('writing') }}" class="mobile-nav-link {{ request()->routeIs('writing') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Publications
                    </a>
                    <a href="{{ route('trailers.index') }}" class="mobile-nav-link {{ request()->routeIs('trailers.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Vidéo
                    </a>
                    <a href="{{ route('chercheurs') }}" class="mobile-nav-link {{ request()->routeIs('chercheurs') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Chercheurs
                    </a>

                    <a href="{{ route('testimonials') }}" class="mobile-nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Témoignages
                    </a>

                    <!-- Mobile Language Selector -->
                    <div class="pt-3 border-t border-amber-100">
                        <div class="text-xs font-semibold text-amber-700 mb-2 px-2">Langues :</div>
                        <div class="flex space-x-2">
                            <button onclick="switchLanguage('fr')" class="flex items-center px-3 py-2 text-sm bg-amber-50 text-amber-800 rounded-lg hover:bg-amber-100">
                                🇫🇷 FR
                            </button>
                            <button onclick="switchLanguage('en')" class="flex items-center px-3 py-2 text-sm bg-amber-50 text-amber-800 rounded-lg hover:bg-amber-100">
                                🇬🇧 EN
                            </button>
                            <button onclick="switchLanguage('ar')" class="flex items-center px-3 py-2 text-sm bg-amber-50 text-amber-800 rounded-lg hover:bg-amber-100">
                                🇸🇦 AR
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="relative pt-14 md:pt-16 lg:pt-18">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-accent-900 text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><circle cx=\"30\" cy=\"30\" r=\"1\"/></g></g></svg>')"></div>
        </div>

        <div class="relative container-custom py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo et Description -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('assets/unnamed.jpg') }}" alt="Limahine Logo" class="h-12 w-12 rounded-full shadow-golden">
                        <span class="text-2xl font-elegant font-bold text-gradient-light">Limahine</span>
                    </div>
                    <p class="text-white/80 leading-relaxed mb-6">
                        Une plateforme dédiée à l'excellence académique et à l'innovation. Nous nous engageons à promouvoir la recherche de qualité et le partage des connaissances.
                    </p>
                    <!-- Social Links -->
                    <div class="flex space-x-4">
                        <a href="#" class="social-link" aria-label="Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation Rapide -->
                <div>
                    <h3 class="text-lg font-elegant font-semibold mb-4 text-gradient-light">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="footer-link">Accueil</a></li>
                        <li><a href="{{ route('philosophy') }}" class="footer-link">Mouridisme</a></li>
                        <li><a href="{{ route('writing') }}" class="footer-link">Publications</a></li>
                        <li><a href="{{ route('trailers.index') }}" class="footer-link">Vidéo</a></li>
                    </ul>
                </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-elegant font-semibold mb-4 text-gradient-light">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-white/80">limaahinebachiir@gmail.com</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-white/80">+330601328022</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="text-white/80">+221778593165</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-white/80">Touba, Sénégal</span>
                    </li>
                </ul>
            </div>

            <!-- Copyright -->
            <div class="col-span-1 md:col-span-4 border-t border-white/20 mt-12 pt-8">
                <p class="text-white/60 text-center mx-auto max-w-lg">
                    © {{ date('Y') }} Limahine. Tous droits réservés.
                </p>
            </div>
    </footer>

    @stack('scripts')

    <!-- Scripts de protection contre l'inspection et le clic droit - DÉSACTIVÉS EN DÉVELOPPEMENT -->
    <script>
        @if(config('app.env') === 'production')
        (function() {
            'use strict';

            // Protection contre le clic droit
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });

            // Protection contre la sélection de texte par glisser-déposer
            document.addEventListener('selectstart', function(e) {
                e.preventDefault();
                return false;
            });

            // Protection contre les raccourcis clavier de développement
            document.addEventListener('keydown', function(e) {
                // F12 (Outils de développement)
                if (e.key === 'F12') {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+Shift+I (Outils de développement)
                if (e.ctrlKey && e.shiftKey && e.key === 'I') {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+Shift+C (Inspecteur d'éléments)
                if (e.ctrlKey && e.shiftKey && e.key === 'C') {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+Shift+J (Console)
                if (e.ctrlKey && e.shiftKey && e.key === 'J') {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+U (Afficher la source)
                if (e.ctrlKey && e.key === 'u') {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+S (Sauvegarder)
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+A (Sélectionner tout) - sauf dans les inputs
                if (e.ctrlKey && e.key === 'a' && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                    e.preventDefault();
                    return false;
                }

                // Ctrl+P (Imprimer)
                if (e.ctrlKey && e.key === 'p') {
                    e.preventDefault();
                    return false;
                }
            });

            // Détection des outils de développement (méthode basique)
            let devtools = {open: false, orientation: null};
            const threshold = 160;

            setInterval(function() {
                if (window.outerHeight - window.innerHeight > threshold ||
                    window.outerWidth - window.innerWidth > threshold) {
                    if (!devtools.open) {
                        devtools.open = true;
                        // Masquer le contenu ou rediriger
                        document.body.innerHTML = '<div style="position:fixed;top:0;left:0;width:100%;height:100%;background:#000;color:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;z-index:999999;"><div style="text-align:center;"><h1>Accès non autorisé</h1><p>Veuillez fermer les outils de développement pour continuer.</p></div></div>';
                    }
                } else {
                    devtools.open = false;
                }
            }, 500);

            // Protection contre l'impression
            window.addEventListener('beforeprint', function(e) {
                e.preventDefault();
                alert('L\'impression de ce contenu n\'est pas autorisée.');
                return false;
            });

            // Désactiver le glisser-déposer d'images
            document.addEventListener('dragstart', function(e) {
                if (e.target.tagName === 'IMG') {
                    e.preventDefault();
                    return false;
                }
            });

            // Protection contre la copie
            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', '');
                e.preventDefault();
                return false;
            });

            // Masquer le contenu lors de tentatives de capture d'écran (Chrome)
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    document.body.style.filter = 'blur(10px)';
                } else {
                    document.body.style.filter = 'none';
                }
            });

            // Console warning
            console.clear();
            console.log('%cSTOP!', 'color: red; font-size: 50px; font-weight: bold;');
            console.log('%cCeci est une fonctionnalité du navigateur destinée aux développeurs. Si quelqu\'un vous a dit de copier-coller quelque chose ici pour activer une fonctionnalité ou "pirater" le compte de quelqu\'un d\'autre, il s\'agit d\'une arnaque et cela lui donnera accès à votre compte.', 'color: red; font-size: 16px;');

        })();
        @else
        // Mode développement : outils de développement autorisés
        console.log('%cMode développement activé', 'color: green; font-size: 16px; font-weight: bold;');
        console.log('%cLes outils de développement sont autorisés pour le diagnostic.', 'color: green; font-size: 14px;');
        @endif
    </script>

    <!-- Scripts globaux -->
    <script>
        // Script anti-FOUC
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('pageLoader');

            setTimeout(() => {
                document.documentElement.classList.add('content-loaded');
                document.documentElement.style.visibility = 'visible';
                document.documentElement.style.opacity = '1';

                if (loader) {
                    loader.classList.add('hidden');
                    setTimeout(() => {
                        loader.remove();
                    }, 300);
                }
            }, 100);
        });

        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });

                // Fermer le menu mobile quand on clique sur un lien
                const mobileLinks = mobileMenu.querySelectorAll('a');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                    });
                });
            }

            // Language dropdown toggle
            const languageButton = document.getElementById('language-button');
            const languageDropdown = document.getElementById('language-dropdown');

            if (languageButton && languageDropdown) {
                languageButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    languageDropdown.classList.toggle('hidden');
                });

                // Fermer le dropdown quand on clique ailleurs
                document.addEventListener('click', function() {
                    languageDropdown.classList.add('hidden');
                });
            }
        });

        // Fonction switchLanguage pour les boutons de langue
        window.switchLanguage = function(locale) {
            fetch('/language/switch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ locale })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                // Erreur silencieuse - peut être loggée côté serveur si nécessaire
            });
        };

        // Scroll header effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('bg-white/95', 'backdrop-blur-sm', 'shadow-golden');
                header.classList.remove('bg-transparent');
            } else {
                header.classList.remove('bg-white/95', 'backdrop-blur-sm', 'shadow-golden');
                header.classList.add('bg-transparent');
            }
        });
    </script>
</body>
</html>

