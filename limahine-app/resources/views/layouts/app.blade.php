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
    <header class="fixed w-full top-0 z-50 transition-all duration-300 bg-transparent">
        <nav class="container-custom">
            <div class="flex items-center justify-between h-16 md:h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('assets/unnamed.jpg') }}" alt="Limahine Logo" class="h-10 w-10 md:h-12 md:w-12 rounded-full shadow-golden">
                        <span class="text-xl md:text-2xl font-elegant font-bold text-gradient">Limahine</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                    <a href="{{ route('philosophy') }}" class="nav-link {{ request()->routeIs('philosophy') ? 'active' : '' }}">Philosophie</a>
                    <a href="{{ route('writing') }}" class="nav-link {{ request()->routeIs('writing') ? 'active' : '' }}">Publications</a>
                    <a href="{{ route('chercheurs') }}" class="nav-link {{ request()->routeIs('chercheurs') ? 'active' : '' }}">Chercheurs</a>
                    <a href="{{ route('biography') }}" class="nav-link {{ request()->routeIs('biography') ? 'active' : '' }}">Biographie</a>
                    <a href="{{ route('testimonials') }}" class="nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}">Témoignages</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button
                        type="button"
                        id="mobile-menu-button"
                        class="text-accent-700 hover:text-primary-500 focus:outline-none focus:text-primary-500 transition-colors"
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
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white/95 backdrop-blur-sm rounded-xl mt-2 shadow-golden border border-primary-100">
                    <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                    <a href="{{ route('philosophy') }}" class="mobile-nav-link {{ request()->routeIs('philosophy') ? 'active' : '' }}">Philosophie</a>
                    <a href="{{ route('writing') }}" class="mobile-nav-link {{ request()->routeIs('writing') ? 'active' : '' }}">Publications</a>
                    <a href="{{ route('chercheurs') }}" class="mobile-nav-link {{ request()->routeIs('chercheurs') ? 'active' : '' }}">Chercheurs</a>
                    <a href="{{ route('biography') }}" class="mobile-nav-link {{ request()->routeIs('biography') ? 'active' : '' }}">Biographie</a>
                    <a href="{{ route('testimonials') }}" class="mobile-nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}">Témoignages</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="relative">
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
                        <li><a href="{{ route('philosophy') }}" class="footer-link">Philosophie</a></li>
                        <li><a href="{{ route('writing') }}" class="footer-link">Publications</a></li>
                        <li><a href="{{ route('biography') }}" class="footer-link">Biographie</a></li>
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
                            <span class="text-white/80">contact@limahine.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-white/80">Dakar, Sénégal</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-white/20 mt-12 pt-8 text-center">
                <p class="text-white/60">
                    © {{ date('Y') }} Limahine. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')

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
            }
        });

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
