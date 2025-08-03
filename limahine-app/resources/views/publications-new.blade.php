@extends('layouts.app')

@section('title', 'Publications - Limahine')
@section('description', 'Découvrez les enseignements extraits des ouvrages de Cheikh Ahmadou Bamba : fiqh, tasawwuf, sîra et khassaïds.')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-amber-900 mb-6">
                    Publications
                </h1>
                <p class="text-xl text-amber-700 leading-relaxed mb-8">
                    Exploration des enseignements extraits des ouvrages de Cheikh Ahmadou Bamba,
                    présentés de manière pédagogique à travers des contenus explicatifs.
                </p>

                <!-- Recherche -->
                <div class="max-w-md mx-auto">
                    <form method="GET" action="{{ route('writing') }}" class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Rechercher une publication..."
                               class="w-full px-4 py-3 pl-12 rounded-full border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none bg-white">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        @if(request('search'))
                        <button type="button" onclick="window.location.href='{{ route('writing') }}'" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-amber-400 hover:text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Filtres par catégories --}}
    <section class="py-8 bg-white border-b border-amber-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('writing') }}"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-colors {{ !request('category') ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                    Toutes
                </a>
                @foreach($categories as $key => $label)
                <a href="{{ route('writing') }}?category={{ $key }}{{ request('search') ? '&search=' . request('search') : '' }}"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-colors {{ request('category') == $key ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Publications Vedettes (si pas de filtre) --}}
    @if(!request('category') && !request('search') && $featuredPublications->count() > 0)
    <section class="py-16 bg-amber-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-amber-900 mb-4">
                    Publications Vedettes
                </h2>
                <p class="text-amber-700">Nos contenus les plus appréciés</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredPublications as $publication)
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    @if($publication->getFirstMediaUrl('featured_image'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $publication->getFirstMediaUrl('featured_image') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">
                                {{ $publication::getCategories()[$publication->category] ?? $publication->category }}
                            </span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">
                                ⭐ Vedette
                            </span>
                        </div>
                          <h3 class="text-xl font-semibold text-amber-900 mb-3 line-clamp-2">
                            {{ $publication->getLocalizedTitle() }}
                        </h3>

                        <p class="text-amber-700 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($publication->getLocalizedExcerpt() ?? ''), 120) }}
                        </p>

                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-amber-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $publication->author->name }}
                            </div>
                            @if($publication->reading_time)
                            <span class="text-amber-500">{{ $publication->reading_time }} min</span>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-amber-100">
                            <a href="{{ route('publications.show', $publication->slug) }}"
                               class="inline-flex items-center text-amber-600 hover:text-amber-800 font-medium">
                                Lire l'article
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Liste des Publications --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            {{-- Résultats de recherche/filtre --}}
            @if(request('search') || request('category'))
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        @if(request('search'))
                        <h2 class="text-2xl font-bold text-amber-900">
                            Résultats pour "{{ request('search') }}"
                        </h2>
                        @endif
                        @if(request('category'))
                        <h2 class="text-2xl font-bold text-amber-900">
                            {{ $categories[request('category')] ?? 'Catégorie' }}
                        </h2>
                        @endif
                        <p class="text-amber-700 mt-2">
                            {{ $publications->total() }} publication(s) trouvée(s)
                        </p>
                    </div>

                    @if(request('search') || request('category'))
                    <a href="{{ route('writing') }}"
                       class="text-amber-600 hover:text-amber-800 underline">
                        Effacer les filtres
                    </a>
                    @endif
                </div>
            </div>
            @endif

            @if($publications->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($publications as $publication)
                <article class="bg-white border border-amber-100 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    @if($publication->getFirstMediaUrl('featured_image'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $publication->getFirstMediaUrl('featured_image') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-amber-200 to-orange-300 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">
                                {{ $publication::getCategories()[$publication->category] ?? $publication->category }}
                            </span>
                            @if($publication->featured)
                            <span class="text-yellow-500">⭐</span>
                            @endif
                        </div>
                          <h3 class="text-lg font-semibold text-amber-900 mb-3 line-clamp-2">
                            {{ $publication->getLocalizedTitle() }}
                        </h3>

                        @if($publication->getLocalizedExcerpt())
                        <p class="text-amber-700 mb-4 line-clamp-3 text-sm">
                            {{ Str::limit(strip_tags($publication->getLocalizedExcerpt()), 100) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-amber-600 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $publication->author->name }}
                            </div>
                            @if($publication->reading_time)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $publication->reading_time }} min
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-amber-500">
                                {{ $publication->published_at->format('d M Y') }}
                            </span>
                            <a href="{{ route('publications.show', $publication->slug) }}"
                               class="text-amber-600 hover:text-amber-800 font-medium text-sm">
                                Lire →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($publications->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $publications->withQueryString()->links() }}
            </div>
            @endif
            @else
            {{-- Aucun résultat --}}
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-amber-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-amber-900 mb-2">Aucune publication trouvée</h3>
                <p class="text-amber-700 mb-6">
                    @if(request('search'))
                    Aucun résultat pour "{{ request('search') }}". Essayez avec d'autres mots-clés.
                    @else
                    Aucune publication disponible dans cette catégorie pour le moment.
                    @endif
                </p>
                <a href="{{ route('writing') }}"
                   class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                    Voir toutes les publications
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- Call to Action --}}
    @if(!request('search') && !request('category'))
    <section class="py-16 bg-gradient-to-r from-amber-600 to-orange-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Restez Informé des Nouvelles Publications
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Découvrez régulièrement de nouveaux contenus sur les enseignements spirituels
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('testimonials') }}"
                   class="bg-white text-amber-600 hover:bg-amber-50 px-8 py-3 rounded-full font-semibold transition-colors">
                    Lire les Témoignages
                </a>
                <a href="{{ route('biography') }}"
                   class="border-2 border-white text-white hover:bg-white hover:text-amber-600 px-8 py-3 rounded-full font-semibold transition-colors">
                    Explorer la Bibliographie
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
<style>
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

