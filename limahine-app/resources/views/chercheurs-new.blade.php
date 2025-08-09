@extends('layouts.app')

@section('title', 'Chercheurs - Limahine')
@section('description', 'Espace dédié aux chercheurs, étudiants et passionnés,            @if($biographies->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $biographies->links() }}
            </div>
            @endifoupant des ressources académiques, publications spécialisées et documents d\'analyse sur la pensée de Cheikh Ahmadou Bamba.')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-purple-50 via-violet-50 to-indigo-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-purple-900 mb-6">
                    Espace Chercheurs
                </h1>
                <p class="text-xl text-purple-700 leading-relaxed mb-8">
                    Ressources académiques, publications spécialisées et documents d'analyse
                    sur la pensée de Cheikh Ahmadou Bamba, destinés aux chercheurs, étudiants et passionnés.
                </p>

                <div class="flex items-center justify-center space-x-6 text-purple-600 mb-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Recherche académique
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Publications spécialisées
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Sources primaires
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Navigation des sections --}}
    <section class="py-8 bg-white border-b border-purple-100 sticky top-16 z-40">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#academic-resources" class="px-6 py-2 rounded-full text-sm font-medium bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                    Ressources Académiques
                </a>
                <a href="#theses-memoires" class="px-6 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                    Thèses & Mémoires
                </a>
                <a href="#conferences" class="px-6 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                    Conférences
                </a>
                <a href="#methodologie" class="px-6 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                    Méthodologie
                </a>
            </div>
        </div>
    </section>


    {{-- Thèses et Mémoires --}}
    <section id="theses-memoires" class="py-20 bg-purple-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-purple-900 mb-6">
                    Thèses et Mémoires
                </h2>
                <p class="text-xl text-purple-700 max-w-3xl mx-auto leading-relaxed">
                    Travaux universitaires approfondis sur différents aspects
                    de la pensée et de l'œuvre de Cheikh Ahmadou Bamba.
                </p>
            </div>

            @if($academicResources->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($academicResources as $academic)
                <article class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-purple-100">
                    <div class="flex items-center justify-between mb-6">
                        <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-4 py-2 rounded-full">
                            {{ $academic::getTypes()[$academic->type] ?? $academic->type }}
                        </span>
                        @if($academic->date_publication)
                        <span class="text-purple-500 text-sm">{{ $academic->date_publication->format('Y') }}</span>
                        @endif
                    </div>

                    <h3 class="text-2xl font-bold text-purple-900 mb-4">
                        {{ $academic->getLocalizedTitle() }}
                    </h3>

                    <p class="text-purple-700 font-semibold mb-4">
                        {{ $academic->author_name[app()->getLocale()] ?? $academic->author_name['fr'] }}
                    </p>

                    @if($academic->description[app()->getLocale()] ?? $academic->description['fr'])
                    <p class="text-purple-600 mb-6 leading-relaxed">
                        {{ Str::limit(strip_tags($academic->description[app()->getLocale()] ?? $academic->description['fr']), 200) }}
                    </p>
                    @endif

                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-purple-500">
                            @if($academic->langue)
                            <span class="mr-4">📖 {{ $academic->langue }}</span>
                            @endif
                            @if($academic->pages)
                            <span>📄 {{ $academic->pages }} pages</span>
                            @endif
                        </div>

                        @if($academic->disponible_en_ligne && $academic->url_telechargement)
                        <a href="{{ $academic->url_telechargement }}"
                           target="_blank"
                           class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Consulter
                        </a>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-purple-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-purple-900 mb-2">Bientôt Disponible</h3>
                <p class="text-purple-700">Les thèses et mémoires seront prochainement ajoutés à notre collection.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- Domaines de Recherche --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-purple-900 mb-6">
                    Domaines de Recherche
                </h2>
                <p class="text-xl text-purple-700 max-w-3xl mx-auto leading-relaxed">
                    Axes de recherche privilégiés pour l'étude approfondie
                    de l'héritage intellectuel et spirituel mouride.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Théologie et Spiritualité -->
                <div class="bg-gradient-to-br from-purple-100 to-indigo-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 12v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Théologie et Spiritualité</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Étude des concepts théologiques, des pratiques spirituelles
                        et de la mystique dans l'œuvre du Cheikh.
                    </p>
                </div>

                <!-- Histoire et Société -->
                <div class="bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Histoire et Société</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Contexte historique, impact social et transformation
                        de la société sénégalaise par le mouridisme.
                    </p>
                </div>

                <!-- Littérature et Poésie -->
                <div class="bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4v16a2 2 0 002 2h6a2 2 0 002-2V4M11 6h2M10 10h4M10 14h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Littérature et Poésie</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Analyse littéraire des khassaïds, étude stylistique
                        et poétique de l'œuvre écrite.
                    </p>
                </div>

                <!-- Philosophie et Éthique -->
                <div class="bg-gradient-to-br from-cyan-100 to-teal-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Philosophie et Éthique</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Systèmes de pensée, éthique du travail et philosophie
                        de l'éducation dans l'enseignement mouride.
                    </p>
                </div>

                <!-- Économie et Développement -->
                <div class="bg-gradient-to-br from-teal-100 to-green-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-teal-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Économie et Développement</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Modèle économique mouride, développement rural
                        et innovation sociale dans les communautés.
                    </p>
                </div>

                <!-- Études Comparatives -->
                <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Études Comparatives</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Comparaisons avec d'autres traditions soufies,
                        influences et échanges intellectuels.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Méthodologie de Recherche --}}
    <section id="methodologie" class="py-20 bg-purple-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-purple-900 mb-6">
                    Méthodologie de Recherche
                </h2>
                <p class="text-xl text-purple-700 max-w-3xl mx-auto leading-relaxed">
                    Orientations méthodologiques pour mener des recherches rigoureuses
                    et respectueuses sur l'héritage mouride.
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Sources Primaires -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-purple-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Sources Primaires
                        </h3>
                        <ul class="text-purple-700 space-y-3">
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Œuvres complètes de Cheikh Ahmadou Bamba
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Correspondances et lettres historiques
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Témoignages directs et récits authentifiés
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Archives coloniales et documents administratifs
                            </li>
                        </ul>
                    </div>

                    <!-- Approches Méthodologiques -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-purple-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Approches Disciplinaires
                        </h3>
                        <ul class="text-purple-700 space-y-3">
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Analyse historique contextuelle
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Herméneutique textuelle et linguistique
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Anthropologie religieuse et sociale
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Analyse littéraire et poétique
                            </li>
                        </ul>
                    </div>

                    <!-- Considérations Éthiques -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-purple-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Considérations Éthiques
                        </h3>
                        <ul class="text-purple-700 space-y-3">
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Respect de la dimension sacrée du patrimoine
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Collaboration avec la communauté mouride
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Validation par les autorités religieuses
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Restitution des résultats à la communauté
                            </li>
                        </ul>
                    </div>

                    <!-- Outils et Ressources -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-purple-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            Outils et Ressources
                        </h3>
                        <ul class="text-purple-700 space-y-3">
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Bases de données numériques spécialisées
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Outils d'analyse textuelle et linguistique
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Logiciels de gestion bibliographique
                            </li>
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-purple-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                Plateformes de collaboration académique
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Collaboration et Contact --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-purple-900 mb-6">
                    Collaboration Académique
                </h2>
                <p class="text-xl text-purple-700 max-w-3xl mx-auto leading-relaxed">
                    Nous encourageons la collaboration entre chercheurs, institutions académiques
                    et la communauté mouride pour enrichir la recherche.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Partenariats Universitaires -->
                <div class="text-center bg-purple-50 rounded-2xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Partenariats Universitaires</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Collaboration avec les universités sénégalaises et internationales
                        pour des projets de recherche conjoints.
                    </p>
                </div>

                <!-- Réseau de Chercheurs -->
                <div class="text-center bg-purple-50 rounded-2xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Réseau de Chercheurs</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Mise en relation des chercheurs travaillant sur des thématiques
                        similaires pour favoriser les échanges.
                    </p>
                </div>

                <!-- Publications Collaboratives -->
                <div class="text-center bg-purple-50 rounded-2xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-purple-900 mb-4">Publications Collaboratives</h3>
                    <p class="text-purple-700 text-sm leading-relaxed">
                        Plateforme pour la publication et la diffusion
                        des travaux de recherche validés.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-20 bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">
                Rejoignez la Communauté de Recherche
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-3xl mx-auto">
                Contribuez à l'approfondissement et à la diffusion de la connaissance
                sur l'héritage intellectuel et spirituel mouride.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('writing') }}"
                   class="bg-white text-purple-600 hover:bg-purple-50 px-8 py-4 rounded-full font-semibold transition-colors">
                    Explorer les Publications
                </a>

            </div>
        </div>
    </section>
@endsection

