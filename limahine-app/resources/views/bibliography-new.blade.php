@extends('layouts.app')

@section('title', 'Bibliographie - Limahine')
@section('description', 'Découvrez la bibliographie exhaustive de Cheikh Ahmadou Bamba Mbacké, de ses khalifes et de ses fils, ainsi que leurs contributions spirituelles et sociales.')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-indigo-900 mb-6">
                    Bibliographie
                </h1>
                <p class="text-xl text-indigo-700 leading-relaxed mb-8">
                    Bibliographie exhaustive de Cheikh Ahmadou Bamba Mbacké, de ses khalifes et de ses fils,
                    présentant leurs ouvrages, contributions spirituelles et impact historique.
                </p>

                <!-- Recherche -->
                <div class="max-w-md mx-auto">
                    <form method="GET" action="{{ route('biography') }}" class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Rechercher un ouvrage ou auteur..."
                               class="w-full px-4 py-3 pl-12 rounded-full border border-indigo-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none bg-white">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Filtres par catégorie --}}
    <section class="py-8 bg-white border-b border-indigo-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('biography') }}"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-colors {{ !request('category') && !request('type') ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-800 hover:bg-indigo-200' }}">
                    Tous
                </a>
                @foreach($categories as $key => $label)
                <a href="{{ route('biography') }}?category={{ $key }}{{ request('search') ? '&search=' . request('search') : '' }}"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-colors {{ request('category') == $key ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-800 hover:bg-indigo-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>

            <!-- Filtres par type -->
            <div class="flex flex-wrap justify-center gap-3 mt-4">
                @foreach($types as $key => $label)
                <a href="{{ route('biography') }}?type={{ $key }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('category') ? '&category=' . request('category') : '' }}"
                   class="px-4 py-1 rounded-full text-xs font-medium transition-colors {{ request('type') == $key ? 'bg-purple-600 text-white' : 'bg-purple-100 text-purple-800 hover:bg-purple-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ouvrages Vedettes --}}
    @if(!request('category') && !request('search') && !request('type') && $featuredBibliographies->count() > 0)
    <section class="py-16 bg-indigo-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-indigo-900 mb-4">
                    Ouvrages Vedettes
                </h2>
                <p class="text-indigo-700">Œuvres majeures et références incontournables</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredBibliographies as $bibliography)
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    @if($bibliography->getFirstMediaUrl('cover'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $bibliography->getFirstMediaUrl('cover') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-3 py-1 rounded-full">
                                {{ $bibliography::getTypes()[$bibliography->type] ?? $bibliography->type }}
                            </span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">
                                ⭐ Vedette
                            </span>
                        </div>
                          <h3 class="text-xl font-semibold text-indigo-900 mb-3">
                            {{ $bibliography->getLocalizedTitle() }}
                        </h3>

                        <p class="text-indigo-700 font-medium mb-3">
                            {{ $bibliography->getLocalizedAuthorName() }}
                        </p>

                        @if($bibliography->getLocalizedDescription())                        <p class="text-indigo-600 mb-4 text-sm line-clamp-3">
                            {{ Str::limit(strip_tags($bibliography->getLocalizedDescription()), 120) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-indigo-500 mb-4">
                            @if($bibliography->langue)
                            <span>{{ $bibliography->langue }}</span>
                            @endif
                            @if($bibliography->date_publication)
                            <span>{{ $bibliography->date_publication->format('Y') }}</span>
                            @endif
                        </div>

                        @if($bibliography->disponible_en_ligne)
                        <div class="flex items-center text-green-600 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Disponible en ligne
                        </div>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Liste complète --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            {{-- Résultats de recherche/filtre --}}
            @if(request('search') || request('category') || request('type'))
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        @if(request('search'))
                        <h2 class="text-2xl font-bold text-indigo-900">
                            Résultats pour "{{ request('search') }}"
                        </h2>
                        @endif
                        @if(request('category'))
                        <h2 class="text-2xl font-bold text-indigo-900">
                            {{ $categories[request('category')] ?? 'Catégorie' }}
                        </h2>
                        @endif
                        @if(request('type'))
                        <h2 class="text-2xl font-bold text-indigo-900">
                            {{ $types[request('type')] ?? 'Type' }}
                        </h2>
                        @endif
                        <p class="text-indigo-700 mt-2">
                            {{ $bibliographies->total() }} ouvrage(s) trouvé(s)
                        </p>
                    </div>

                    <a href="{{ route('biography') }}"
                       class="text-indigo-600 hover:text-indigo-800 underline">
                        Effacer les filtres
                    </a>
                </div>
            </div>
            @endif

            @if($bibliographies->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($bibliographies as $bibliography)
                <article class="bg-white border border-indigo-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    @if($bibliography->getFirstMediaUrl('cover'))
                    <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $bibliography->getFirstMediaUrl('cover') }}')"></div>
                    @else
                    <div class="h-40 bg-gradient-to-br from-indigo-300 to-purple-400 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded">
                                {{ $bibliography::getTypes()[$bibliography->type] ?? $bibliography->type }}
                            </span>
                            @if($bibliography->featured)
                            <span class="text-yellow-500 text-xs">⭐</span>
                            @endif
                        </div>
                          <h3 class="text-lg font-semibold text-indigo-900 mb-2 line-clamp-2">
                            {{ $bibliography->getLocalizedTitle() }}
                        </h3>

                        <p class="text-indigo-700 font-medium mb-2 text-sm">
                            {{ $bibliography->getLocalizedAuthorName() }}
                        </p>

                        @if($bibliography->getLocalizedDescription())
                        <p class="text-indigo-600 mb-3 text-xs line-clamp-2">
                            {{ Str::limit(strip_tags($bibliography->getLocalizedDescription()), 80) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between text-xs text-indigo-500 mb-3">
                            @if($bibliography->langue)
                            <span>{{ $bibliography->langue }}</span>
                            @endif
                            @if($bibliography->date_publication)
                            <span>{{ $bibliography->date_publication->format('Y') }}</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            @if($bibliography->disponible_en_ligne)
                            <span class="flex items-center text-green-600 text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                En ligne
                            </span>
                            @else
                            <span class="text-indigo-400 text-xs">Physique</span>
                            @endif

                            @if($bibliography->pages)
                            <span class="text-indigo-400 text-xs">{{ $bibliography->pages }} p.</span>
                            @endif
                        </div>

                        @if($bibliography->disponible_en_ligne && $bibliography->url_telechargement)
                        <div class="mt-3 pt-3 border-t border-indigo-100">
                            <a href="{{ $bibliography->url_telechargement }}"
                               target="_blank"
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-xs font-medium">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Télécharger
                            </a>
                        </div>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($bibliographies->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $bibliographies->withQueryString()->links() }}
            </div>
            @endif
            @else
            {{-- Aucun résultat --}}
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-indigo-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="text-xl font-semibold text-indigo-900 mb-2">Aucun ouvrage trouvé</h3>
                <p class="text-indigo-700 mb-6">
                    @if(request('search'))
                    Aucun résultat pour "{{ request('search') }}". Essayez avec d'autres mots-clés.
                    @else
                    Aucun ouvrage disponible dans cette catégorie pour le moment.
                    @endif
                </p>
                <a href="{{ route('biography') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                    Voir tous les ouvrages
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- Statistiques --}}
    <section class="py-16 bg-indigo-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-indigo-900 mb-4">
                    Collection Bibliographique
                </h2>
                <p class="text-indigo-700">Un patrimoine littéraire et spirituel exceptionnel</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                @foreach($categories as $key => $label)
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-800 mb-2">
                        {{ $stats[$key] ?? 0 }}
                    </div>
                    <div class="text-indigo-600 text-sm">{{ $label }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- À propos de la bibliographie --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-indigo-900 mb-6">
                        À Propos de Cette Bibliographie
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-indigo-900 mb-2">Exhaustivité</h3>
                        <p class="text-indigo-700 text-sm">
                            Répertoire complet des œuvres de Cheikh Ahmadou Bamba, de ses khalifes et de ses fils.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-indigo-900 mb-2">Vérification</h3>
                        <p class="text-indigo-700 text-sm">
                            Toutes les références sont vérifiées et documentées par des sources académiques fiables.
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-indigo-900 mb-2">Accessibilité</h3>
                        <p class="text-indigo-700 text-sm">
                            Nombreux documents disponibles en ligne pour faciliter l'accès aux chercheurs du monde entier.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Explorez le Patrimoine Littéraire Mouride
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Plongez dans l'immense richesse intellectuelle et spirituelle de la tradition mouride.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('writing') }}"
                   class="bg-white text-indigo-600 hover:bg-indigo-50 px-8 py-3 rounded-full font-semibold transition-colors">
                    Lire les Publications
                </a>
                <a href="{{ route('chercheurs') }}"
                   class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-full font-semibold transition-colors">
                    Ressources Chercheurs
                </a>
            </div>
        </div>
    </section>
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

