@extends('layouts.app')

@section('title', 'Limahine - Enseignements de Cheikh Ahmadou Bamba Mbacké')
@section('description', 'Découvrez la plateforme Limahine dédiée à la vulgarisation et transmission des enseignements spirituels de Cheikh Ahmadou Bamba Mbacké, guide suprême de la voie mouride.')

@section('content')
    {{-- Hero Section Spirituel --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-14 md:pt-16 lg:pt-18">
        <!-- Background avec dégradé spirituel -->
        <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50"></div>

        <!-- Motifs géométriques islamiques (cachés sur mobile pour éviter débordement) -->
        <div class="absolute inset-0 opacity-5 hidden lg:block">
            <div class="absolute top-20 left-20 w-32 h-32 border-2 border-amber-400 rotate-45 transform"></div>
            <div class="absolute top-40 right-32 w-24 h-24 border-2 border-yellow-400 rotate-12 transform"></div>
            <div class="absolute bottom-32 left-40 w-20 h-20 border-2 border-orange-400 rotate-45 transform"></div>
        </div>

        <div class="relative z-10 container-fluid text-center">
            <!-- Logo et Titre Principal -->
            <div class="mb-6 md:mb-8">
                <div class="flex justify-center mb-4 md:mb-6">
                    <img src="{{ asset('assets/unnamed.jpg') }}"
                         alt="Limahine"
                         class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 lg:w-32 lg:h-32 rounded-full shadow-2xl border-4 border-amber-200">
                </div>
                <h1 class="text-responsive-3xl font-bold text-amber-900 mb-3 md:mb-4">
                    Limahine
                </h1>
                <div class="text-responsive-lg text-amber-800 mb-4 md:mb-6 font-arabic">
                    ليماهين
                </div>
            </div>

            <!-- Sous-titre spirituel -->
            <div class="max-w-4xl mx-auto mb-8 md:mb-12">
                <h2 class="text-responsive-xl font-light text-amber-900 mb-4 md:mb-6 leading-relaxed">
                    Transmission des Enseignements de
                    <span class="font-semibold text-amber-800">Cheikh Ahmadou Bamba Mbacké</span>
                </h2>
                <p class="text-responsive-base text-amber-700 max-w-2xl mx-auto leading-relaxed">
                    Guide spirituel suprême de la voie mouride (Tarîqa soufie Mouridiyya)
                </p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center mb-12 md:mb-16">
                <a href="{{ route('philosophy') }}"
                   class="bg-amber-600 hover:bg-amber-700 text-white px-6 md:px-8 py-3 md:py-4 rounded-full text-sm md:text-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Découvrir la Philosophie
                </a>
                <a href="{{ route('writing') }}"
                   class="bg-white hover:bg-amber-50 text-amber-800 border-2 border-amber-600 px-6 md:px-8 py-3 md:py-4 rounded-full text-sm md:text-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Lire les Publications
                </a>
            </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-xl sm:text-2xl md:text-3xl font-bold text-amber-800 mb-1 md:mb-2">{{ $stats['publications'] ?? 0 }}</div>
                    <div class="text-amber-600 text-xs sm:text-sm">Publications</div>
                </div>
                <div class="text-center">
                    <div class="text-xl sm:text-2xl md:text-3xl font-bold text-amber-800 mb-1 md:mb-2">{{ $stats['temoignages'] ?? 0 }}</div>
                    <div class="text-amber-600 text-xs sm:text-sm">Témoignages</div>
                </div>
                <div class="text-center">
                    <div class="text-xl sm:text-2xl md:text-3xl font-bold text-amber-800 mb-1 md:mb-2">{{ $stats['bibliographies'] ?? 0 }}</div>
                    <div class="text-amber-600 text-xs sm:text-sm">Ouvrages</div>
                </div>
                <div class="text-center">
                    <div class="text-xl sm:text-2xl md:text-3xl font-bold text-amber-800 mb-1 md:mb-2">3</div>
                    <div class="text-amber-600 text-xs sm:text-sm">Langues</div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-6 md:bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce hidden sm:block">
            <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- Mission et Valeurs --}}
    <section class="spacing-y-responsive bg-white">
        <div class="container-fluid">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-responsive-2xl font-bold text-amber-900 mb-3 md:mb-6">
                    Notre Mission
                </h2>
                <p class="text-responsive-lg text-amber-700 max-w-3xl mx-auto leading-relaxed">
                    Rendre accessible à un large public l'héritage intellectuel, spirituel et historique
                    du fondateur du mouridisme à travers une plateforme moderne et inclusive.
                </p>
            </div>

            <div class="grid-responsive">
                <!-- Vulgarisation -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-200 transition-colors">
                        <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">Vulgarisation</h3>
                    <p class="text-amber-700 leading-relaxed">
                        Rendre les enseignements complexes accessibles à tous,
                        initiés comme profanes, à travers des contenus pédagogiques.
                    </p>
                </div>

                <!-- Transmission -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-200 transition-colors">
                        <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">Transmission</h3>
                    <p class="text-amber-700 leading-relaxed">
                        Préserver et transmettre fidèlement l'héritage spirituel
                        et intellectuel aux générations futures.
                    </p>
                </div>

                <!-- Innovation -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-amber-200 transition-colors">
                        <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-amber-900 mb-4">Innovation</h3>
                    <p class="text-amber-700 leading-relaxed">
                        Utiliser les technologies modernes pour créer une plateforme
                        internationale et multilingue.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Publications Vedettes --}}
    @if($featuredPublications->count() > 0)
    <section class="py-20 bg-amber-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-amber-900 mb-6">
                    Publications Vedettes
                </h2>
                <p class="text-xl text-amber-700 max-w-2xl mx-auto">
                    Découvrez nos dernières publications sur les enseignements spirituels
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredPublications as $publication)
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    @if($publication->getFirstMediaUrl('featured_image'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $publication->getFirstMediaUrl('featured_image') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-amber-400 to-orange-500"></div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">
                                {{ $publication::getCategories()[$publication->category] ?? $publication->category }}
                            </span>
                            @if($publication->reading_time)
                            <span class="text-amber-600 text-sm">{{ $publication->reading_time }} min</span>
                            @endif
                        </div>                        <h3 class="text-xl font-semibold text-amber-900 mb-3 line-clamp-2">
                            {{ $publication->getLocalizedTitle() }}
                        </h3>

                        <p class="text-amber-700 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($publication->getLocalizedExcerpt() ?? ''), 120) }}
                        </p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-amber-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $publication->author->name }}
                            </div>
                            <a href="{{ route('publications.show', $publication->slug) }}"
                               class="text-amber-600 hover:text-amber-800 font-medium">
                                Lire →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('writing') }}"
                   class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                    Voir toutes les publications
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Vidéo en Vedette --}}
    @if($featuredTrailers->count() > 0)
    <section class="py-20 bg-gradient-to-br from-red-50 to-pink-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-red-900 mb-6">
                    Vidéo
                </h2>
                <p class="text-xl text-red-700 max-w-3xl mx-auto">
                    Découvrez des extraits de nos enseignements vidéo sur la chaîne YouTube Limahine TV
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredTrailers as $trailer)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative group">
                        <img src="{{ $trailer->youtube_thumbnail }}"
                             alt="{{ $trailer->getTranslation('title', app()->getLocale()) }}"
                             class="w-full h-48 object-cover">

                        <!-- Overlay avec bouton play -->
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('trailers.show', $trailer->slug) }}"
                               class="bg-red-600 text-white rounded-full p-4 hover:bg-red-700 transition-colors">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 5v10l7-5z"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Badge durée -->
                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded text-sm">
                            {{ $trailer->formatted_duration }}
                        </div>

                        <!-- Badge catégorie -->
                        @if($trailer->category)
                        <div class="absolute top-2 left-2">
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded-full">
                                {{ ucfirst($trailer->category) }}
                            </span>
                        </div>
                        @endif

                        <!-- Badge en vedette -->
                        @if($trailer->featured)
                        <div class="absolute top-2 right-2">
                            <span class="bg-yellow-500 text-white text-xs font-medium px-2 py-1 rounded">
                                ⭐ En vedette
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-red-900 mb-3 line-clamp-2">
                            {{ $trailer->getTranslation('title', app()->getLocale()) }}
                        </h3>

                        @if($trailer->getTranslation('description', app()->getLocale()))
                        <p class="text-red-700 mb-4 line-clamp-3">
                            {{ Str::limit($trailer->getTranslation('description', app()->getLocale()), 120) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-red-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                YouTube
                            </div>
                            <a href="{{ route('trailers.show', $trailer->slug) }}"
                               class="text-red-600 hover:text-red-800 font-medium">
                                Regarder →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('trailers.index') }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                        Voir tous les trailers
                    </a>
                    <a href="https://www.youtube.com/@limaahinetv2949"
                       target="_blank"
                       class="bg-gray-100 hover:bg-gray-200 text-red-600 px-8 py-3 rounded-full font-medium transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        Chaîne YouTube
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Thématiques Principales --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-amber-900 mb-6">
                    Thématiques Principales
                </h2>
                <p class="text-xl text-amber-700 max-w-2xl mx-auto">
                    Explorez les différents domaines d'enseignement de Cheikh Ahmadou Bamba
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Fiqh -->
                <div class="text-center group cursor-pointer" onclick="window.location.href='{{ route('writing') }}?category=fiqh'">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v0M7 12h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">Fiqh</h3>
                    <p class="text-amber-700 text-sm">Jurisprudence islamique</p>
                </div>

                <!-- Tasawwuf -->
                <div class="text-center group cursor-pointer" onclick="window.location.href='{{ route('writing') }}?category=tasawwuf'">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">Tasawwuf</h3>
                    <p class="text-amber-700 text-sm">Éducation spirituelle</p>
                </div>

                <!-- Sîra -->
                <div class="text-center group cursor-pointer" onclick="window.location.href='{{ route('writing') }}?category=sira'">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">Sîra</h3>
                    <p class="text-amber-700 text-sm">Biographie du Prophète ﷺ</p>
                </div>

                <!-- Khassaïds -->
                <div class="text-center group cursor-pointer" onclick="window.location.href='{{ route('writing') }}?category=khassaids'">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4v16a2 2 0 002 2h6a2 2 0 002-2V4M11 6h2M10 10h4M10 14h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">Khassaïds</h3>
                    <p class="text-amber-700 text-sm">Poésies spirituelles</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Témoignages --}}
    @if($featuredTestimonials->count() > 0)
    <section class="py-20 bg-amber-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-amber-900 mb-6">
                    Témoignages Authentiques
                </h2>
                <p class="text-xl text-amber-700 max-w-2xl mx-auto">
                    Récits vérifiés sur la vie de Cheikh Ahmadou Bamba et ses khalifes
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredTestimonials as $testimonial)
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-6">
                        @if($testimonial->verified)
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">
                            ✓ Vérifié
                        </span>
                        @endif
                    </div>                    <blockquote class="text-amber-700 mb-6 leading-relaxed italic">
                        "{{ Str::limit(strip_tags($testimonial->getLocalizedContent() ?? ''), 150) }}"
                    </blockquote>

                    <div class="border-t border-amber-100 pt-6">
                        <div class="font-semibold text-amber-900">{{ $testimonial->author_name }}</div>
                        @if($testimonial->getLocalizedAuthorTitle())
                        <div class="text-sm text-amber-600">{{ $testimonial->getLocalizedAuthorTitle() }}</div>
                        @endif
                        @if($testimonial->location)
                        <div class="text-sm text-amber-500 mt-1">{{ $testimonial->location }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('testimonials') }}"
                   class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                    Lire tous les témoignages
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Multilingue --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-amber-900 mb-6">
                    Plateforme Multilingue
                </h2>
                <p class="text-xl text-amber-700 max-w-2xl mx-auto">
                    Accessible au public international dans trois langues
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🇫🇷</span>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">Français</h3>
                    <p class="text-amber-700">Langue par défaut</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🇬🇧</span>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">English</h3>
                    <p class="text-amber-700">International audience</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-arabic">العربية</span>
                    </div>
                    <h3 class="text-lg font-semibold text-amber-900 mb-2">العربية</h3>
                    <p class="text-amber-700">اللغة العربية</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Final --}}
    <section class="py-20 bg-gradient-to-br from-amber-600 to-orange-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Rejoignez la Communauté Limahine
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto opacity-90">
                Découvrez un patrimoine spirituel riche et authentique,
                accessible à tous dans un esprit d'ouverture et de partage.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('writing') }}"
                   class="bg-white text-amber-600 hover:bg-amber-50 px-8 py-4 rounded-full font-semibold transition-colors">
                    Explorer les Publications
                </a>
                <a href="{{ route('testimonials') }}"
                   class="border-2 border-white text-white hover:bg-white hover:text-amber-600 px-8 py-4 rounded-full font-semibold transition-colors">
                    Lire les Témoignages
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .font-arabic {
        font-family: 'Amiri', 'Times New Roman', serif;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

