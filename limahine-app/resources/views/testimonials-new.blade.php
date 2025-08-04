@extends('layouts.app')

@section('title', 'Témoignages - Limahine')
@section('description', 'Découvrez les récits authentiques sur la vie de Cheikh Ahmadou Bamba et de ses khalifes, rapportés par des personnalités crédibles de la communauté mouride.')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-emerald-900 mb-6">
                    Témoignages Authentiques
                </h1>
                <p class="text-xl text-emerald-700 leading-relaxed mb-8">
                    Récits vérifiés et authentiques sur la vie de Cheikh Ahmadou Bamba et de ses khalifes,
                    retraçant des faits marquants et des expériences spirituelles vécues.
                </p>

                <div class="flex items-center justify-center space-x-4 text-emerald-600">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Témoignages vérifiés
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Sources crédibles
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Témoignages Vedettes --}}
    @if($featuredTemoignages->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Récits Marquants
                </h2>
                <p class="text-emerald-700">Les témoignages les plus significatifs et émouvants de notre collection</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                @foreach($featuredTemoignages->take(2) as $featured)
                <article class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-8 border border-emerald-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between mb-6">
                        <span class="bg-emerald-100 text-emerald-800 text-sm font-medium px-4 py-2 rounded-full flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Témoignage Vérifié
                        </span>
                        <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
                            ⭐ Vedette
                        </span>
                    </div>                    <h3 class="text-2xl font-bold text-emerald-900 mb-4">
                        {{ $featured->getLocalizedTitle() ?? 'Témoignage' }}
                    </h3>

                    <blockquote class="text-emerald-700 mb-6 leading-relaxed text-lg italic">
                        "{{ Str::limit(strip_tags($featured->getLocalizedContent() ?? ''), 200) }}"
                    </blockquote>

                    <div class="border-t border-emerald-200 pt-6">
                        <div class="flex items-start space-x-4">
                            @if($featured->getFirstMediaUrl('author_photo'))
                            <img src="{{ $featured->getFirstMediaUrl('author_photo') }}"
                                 alt="{{ $featured->author_name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            @else
                            <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center">
                                <span class="text-emerald-700 font-semibold text-lg">
                                    {{ substr($featured->author_name, 0, 1) }}
                                </span>
                            </div>
                            @endif
                              <div class="flex-1">
                                <div class="font-semibold text-emerald-900">{{ $featured->author_name }}</div>
                                @if($featured->getLocalizedAuthorTitle())
                                <div class="text-sm text-emerald-600">{{ $featured->getLocalizedAuthorTitle() }}</div>
                                @endif
                                <div class="flex items-center mt-2 text-sm text-emerald-500">
                                    @if($featured->location)
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $featured->location }}
                                    @endif
                                    @if($featured->date_temoignage)
                                    <span class="mx-2">•</span>
                                    {{ $featured->date_temoignage->format('Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Tous les Témoignages --}}
    <section class="py-16 bg-emerald-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Tous les Témoignages
                </h2>
                <p class="text-emerald-700">
                    {{ $temoignages->total() }} témoignage(s) authentique(s) dans notre collection
                </p>
            </div>

            @if($temoignages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($temoignages as $temoignage)
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    <div class="p-6">
                        {{-- Badges de statut --}}
                        <div class="flex justify-between items-start mb-4">
                            @if($temoignage->verified)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Vérifié
                            </span>
                            @endif
                            @if($temoignage->featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">
                                ⭐ Vedette
                            </span>
                            @endif
                        </div>                        {{-- Titre --}}
                        <h3 class="text-xl font-semibold text-emerald-900 mb-3">
                            {{ $temoignage->getLocalizedTitle() ?? 'Témoignage' }}
                        </h3>

                        {{-- Extrait du contenu --}}
                        <blockquote class="text-emerald-700 mb-4 leading-relaxed italic">
                            "{{ Str::limit(strip_tags($temoignage->getLocalizedContent() ?? ''), 150) }}"
                        </blockquote>

                        {{-- Informations sur l'auteur --}}
                        <div class="border-t border-emerald-100 pt-4">
                            <div class="flex items-center space-x-3">
                                @if($temoignage->getFirstMediaUrl('author_photo'))
                                <img src="{{ $temoignage->getFirstMediaUrl('author_photo') }}"
                                     alt="{{ $temoignage->author_name }}"
                                     class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 bg-emerald-200 rounded-full flex items-center justify-center">
                                    <span class="text-emerald-700 font-semibold">
                                        {{ substr($temoignage->author_name, 0, 1) }}
                                    </span>
                                </div>
                                @endif
                                  <div class="flex-1">
                                    <div class="font-semibold text-emerald-900 text-sm">{{ $temoignage->author_name }}</div>
                                    @if($temoignage->getLocalizedAuthorTitle())
                                    <div class="text-xs text-emerald-600">{{ $temoignage->getLocalizedAuthorTitle() }}</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Métadonnées --}}
                            <div class="flex items-center justify-between mt-4 text-xs text-emerald-500">
                                <div class="flex items-center">
                                    @if($temoignage->location)
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $temoignage->location }}
                                    @endif
                                </div>
                                @if($temoignage->date_temoignage)
                                <span>{{ $temoignage->date_temoignage->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($temoignages->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $temoignages->links() }}
            </div>
            @endif
            @else
            {{-- Aucun témoignage --}}
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-emerald-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-emerald-900 mb-2">Aucun témoignage disponible</h3>
                <p class="text-emerald-700 mb-6">Les témoignages seront bientôt disponibles.</p>
                <a href="{{ route('home') }}"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                    Retour à l'accueil
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- À propos des témoignages --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-emerald-900 mb-6">
                        À Propos de Ces Témoignages
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-emerald-900 mb-2">Authenticité</h3>
                        <p class="text-emerald-700 text-sm">
                            Tous les témoignages sont vérifiés et proviennent de sources crédibles de la communauté mouride.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-emerald-900 mb-2">Crédibilité</h3>
                        <p class="text-emerald-700 text-sm">
                            Les témoins sont des personnalités respectées qui ont côtoyé Cheikh Ahmadou Bamba ou ses khalifes.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-emerald-900 mb-2">Préservation</h3>
                        <p class="text-emerald-700 text-sm">
                            Ces récits préservent la mémoire collective et transmettent l'héritage spirituel aux générations futures.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-16 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Contribuez à la Préservation de l'Héritage
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Si vous possédez des témoignages authentiques, nous serions honorés de les intégrer à notre collection.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('writing') }}"
                   class="bg-white text-emerald-600 hover:bg-emerald-50 px-8 py-3 rounded-full font-semibold transition-colors">
                    Lire les Publications
                </a>
                <a href="{{ route('biography') }}"
                   class="border-2 border-white text-white hover:bg-white hover:text-emerald-600 px-8 py-3 rounded-full font-semibold transition-colors">
                    Explorer la Biographie
                </a>
            </div>
        </div>
    </section>
@endsection

