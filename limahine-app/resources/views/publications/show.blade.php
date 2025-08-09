@extends('layouts.app')

@section('title', $publication->getLocalizedTitle())
@section('description', $publication->getTranslation('meta_description', app()->getLocale()) ?: $publication->getLocalizedExcerpt())

@section('content')
    {{-- Hero Section Modern pour l'article --}}
    <div class="relative min-h-[60vh] bg-gradient-to-br from-primary-50 via-white to-accent-50 overflow-hidden">
        {{-- Éléments décoratifs --}}
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute top-40 right-10 w-96 h-96 bg-accent-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-8 left-20 w-80 h-80 bg-secondary-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="relative z-10 pt-32 pb-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                {{-- Breadcrumb --}}
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-accent-600 hover:text-primary-600 transition-colors">Accueil</a></li>
                        <li><span class="text-accent-400">/</span></li>
                        <li><a href="{{ route('writing') }}" class="text-accent-600 hover:text-primary-600 transition-colors">Publications</a></li>
                        <li><span class="text-accent-400">/</span></li>
                        <li class="text-accent-500">{{ Str::limit($publication->getLocalizedTitle(), 30) }}</li>
                    </ol>
                </nav>

                {{-- Badge de catégorie --}}
                <div class="mb-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-primary-100 text-primary-800 border border-primary-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        {{ \App\Models\Publication::getCategories()[$publication->category] ?? $publication->category }}
                    </span>
                </div>

                {{-- Titre principal --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-elegant font-bold text-accent-900 mb-6 leading-tight">
                    {{ $publication->getLocalizedTitle() }}
                </h1>

                {{-- Extrait --}}
                @if($publication->getLocalizedExcerpt())
                    <p class="text-xl md:text-2xl text-accent-700 mb-10 leading-relaxed font-light max-w-3xl">
                        {{ $publication->getLocalizedExcerpt() }}
                    </p>
                @endif

                {{-- Métadonnées --}}
                <div class="flex flex-wrap items-center gap-6 text-accent-600">
                    @if($publication->author)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-accent-500">Auteur</div>
                                <div class="font-medium text-accent-800">{{ $publication->author->name }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-accent-400 to-accent-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-accent-500">Publié le</div>
                            <div class="font-medium text-accent-800">{{ $publication->published_at->format('d M Y') }}</div>
                        </div>
                    </div>

                    @if($publication->reading_time)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-secondary-400 to-secondary-600 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-accent-500">Temps de lecture</div>
                                <div class="font-medium text-accent-800">{{ $publication->reading_time }} min</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Contenu de l'article --}}
    <div class="bg-white py-16 lg:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Barre de progression de lecture --}}
            <div class="fixed top-0 left-0 w-full h-1 bg-neutral-200 z-50">
                <div id="reading-progress" class="h-full bg-gradient-to-r from-primary-500 to-accent-500 transition-all duration-300" style="width: 0%"></div>
            </div>

            {{-- Table des matières (si l'article est long) --}}
            <div class="mb-12 p-6 bg-gradient-to-r from-neutral-50 to-neutral-100 rounded-2xl border border-neutral-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-accent-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                        </svg>
                        Table des matières
                    </h3>
                    <button onclick="toggleToc()" class="text-accent-600 hover:text-primary-600 transition-colors">
                        <svg id="toc-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                        </svg>
                    </button>
                </div>
                <div id="toc-content" class="mt-4 space-y-2 hidden">
                    <!-- La table des matières sera générée dynamiquement -->
                </div>
            </div>

            {{-- Contenu principal --}}
            <article class="prose prose-lg prose-accent max-w-none">
                <div class="article-content">
                    {!! $publication->getLocalizedContent() !!}
                </div>
            </article>

            {{-- Section d'engagement --}}
            <div class="mt-16 p-8 bg-gradient-to-br from-primary-50 via-white to-accent-50 rounded-3xl border border-primary-100">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-accent-900 mb-4">Cet article vous a plu ?</h3>
                    <p class="text-accent-600 mb-6 max-w-2xl mx-auto">
                        Découvrez d'autres articles sur des thématiques similaires et restez informé de nos dernières publications.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('writing') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 text-white font-medium rounded-full hover:bg-primary-700 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Voir toutes les publications
                        </a>
                        <button onclick="shareArticle()" class="inline-flex items-center justify-center px-6 py-3 border-2 border-primary-600 text-primary-600 font-medium rounded-full hover:bg-primary-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                            </svg>
                            Partager l'article
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tags avec style amélioré --}}
            @if($publication->tags && count($publication->tags) > 0)
                <div class="mt-12 pt-8 border-t border-neutral-200">
                    <h3 class="text-xl font-bold text-accent-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.707 9.293l-5-5a1 1 0 00-1.414 0l-5 5a1 1 0 001.414 1.414L11 7.414V15a1 1 0 102 0V7.414l3.293 3.293a1 1 0 001.414-1.414z"></path>
                        </svg>
                        Mots-clés
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($publication->tags as $tag)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white border-2 border-primary-200 text-primary-700 hover:border-primary-300 hover:bg-primary-50 transition-colors cursor-pointer">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Articles similaires avec design amélioré --}}
    @if($relatedPublications->count() > 0)
        <div class="bg-gradient-to-br from-neutral-50 via-white to-primary-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-accent-900 mb-4">
                        Articles <span class="bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">similaires</span>
                    </h2>
                    <p class="text-xl text-accent-600 max-w-2xl mx-auto">
                        Poursuivez votre exploration avec ces articles sur des thématiques connexes
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedPublications as $related)
                        <article class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-neutral-100 overflow-hidden">
                            {{-- Header de la carte --}}
                            <div class="p-6 pb-4">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                        {{ \App\Models\Publication::getCategories()[$related->category] ?? $related->category }}
                                    </span>
                                    <time class="text-sm text-accent-500">
                                        {{ $related->published_at->format('M Y') }}
                                    </time>
                                </div>

                                <h3 class="text-xl font-bold text-accent-900 mb-3 group-hover:text-primary-600 transition-colors leading-tight">
                                    <a href="{{ route('publications.show', $related) }}" class="block">
                                        {{ $related->getLocalizedTitle() }}
                                    </a>
                                </h3>

                                @if($related->getLocalizedExcerpt())
                                    <p class="text-accent-600 text-sm leading-relaxed mb-4 line-clamp-3">
                                        {{ $related->getLocalizedExcerpt() }}
                                    </p>
                                @endif
                            </div>

                            {{-- Footer de la carte --}}
                            <div class="px-6 pb-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-sm text-accent-500">
                                        @if($related->reading_time)
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                                            </svg>
                                            {{ $related->reading_time }} min
                                        @endif
                                    </div>

                                    <a href="{{ route('publications.show', $related) }}"
                                       class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium text-sm group-hover:translate-x-1 transition-all">
                                        Lire l'article
                                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Navigation précédent/suivant améliorée --}}
    <div class="bg-white py-16 border-t border-neutral-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $previous = \App\Models\Publication::published()
                    ->where('published_at', '<', $publication->published_at)
                    ->orderBy('published_at', 'desc')
                    ->first();
                $next = \App\Models\Publication::published()
                    ->where('published_at', '>', $publication->published_at)
                    ->orderBy('published_at', 'asc')
                    ->first();
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Article précédent --}}
                <div class="group">
                    @if($previous)
                        <a href="{{ route('publications.show', $previous) }}"
                           class="block p-8 bg-gradient-to-br from-neutral-50 to-white rounded-2xl border-2 border-neutral-100 hover:border-primary-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-primary-600 mb-1 uppercase tracking-wide">
                                        Article précédent
                                    </div>
                                    <h3 class="text-lg font-bold text-accent-900 group-hover:text-primary-600 transition-colors leading-tight mb-2">
                                        {{ $previous->getLocalizedTitle() }}
                                    </h3>
                                    @if($previous->getLocalizedExcerpt())
                                        <p class="text-sm text-accent-600 line-clamp-2 leading-relaxed">
                                            {{ Str::limit($previous->getLocalizedExcerpt(), 120) }}
                                        </p>
                                    @endif
                                    <div class="mt-3 flex items-center gap-2 text-xs text-accent-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z"></path>
                                        </svg>
                                        {{ $previous->published_at->format('d M Y') }}
                                        @if($previous->reading_time)
                                            <span class="mx-1">•</span>
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                                            </svg>
                                            {{ $previous->reading_time }} min
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <div class="p-8 bg-neutral-50 rounded-2xl border-2 border-dashed border-neutral-200 text-center">
                            <div class="w-12 h-12 bg-neutral-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"></path>
                                </svg>
                            </div>
                            <p class="text-neutral-500 text-sm">Aucun article précédent</p>
                        </div>
                    @endif
                </div>

                {{-- Article suivant --}}
                <div class="group">
                    @if($next)
                        <a href="{{ route('publications.show', $next) }}"
                           class="block p-8 bg-gradient-to-bl from-neutral-50 to-white rounded-2xl border-2 border-neutral-100 hover:border-primary-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-start gap-4">
                                <div class="flex-1 min-w-0 text-right">
                                    <div class="text-sm font-medium text-primary-600 mb-1 uppercase tracking-wide">
                                        Article suivant
                                    </div>
                                    <h3 class="text-lg font-bold text-accent-900 group-hover:text-primary-600 transition-colors leading-tight mb-2">
                                        {{ $next->getLocalizedTitle() }}
                                    </h3>
                                    @if($next->getLocalizedExcerpt())
                                        <p class="text-sm text-accent-600 line-clamp-2 leading-relaxed">
                                            {{ Str::limit($next->getLocalizedExcerpt(), 120) }}
                                        </p>
                                    @endif
                                    <div class="mt-3 flex items-center justify-end gap-2 text-xs text-accent-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zM4 8h12v8H4V8z"></path>
                                        </svg>
                                        {{ $next->published_at->format('d M Y') }}
                                        @if($next->reading_time)
                                            <span class="mx-1">•</span>
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                                            </svg>
                                            {{ $next->reading_time }} min
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-bl from-accent-500 to-accent-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <div class="p-8 bg-neutral-50 rounded-2xl border-2 border-dashed border-neutral-200 text-center">
                            <div class="w-12 h-12 bg-neutral-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                                </svg>
                            </div>
                            <p class="text-neutral-500 text-sm">Aucun article suivant</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Retour à la liste --}}
            {{--  <div class="text-center mt-12">
                <a href="{{ route('writing') }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-600 to-accent-600 text-white font-semibold rounded-full hover:from-primary-700 hover:to-accent-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Voir toutes les publications
                </a>
            </div>  --}}
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Amélioration de la prose */
    .prose {
        color: #4a5568;
        max-width: none;
        line-height: 1.8;
    }

    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #2d3748;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        scroll-margin-top: 100px;
    }

    .prose h1 { font-size: 2.5rem; }
    .prose h2 { font-size: 2rem; }
    .prose h3 { font-size: 1.75rem; }
    .prose h4 { font-size: 1.5rem; }

    .prose p {
        margin-bottom: 1.75rem;
        line-height: 1.8;
        text-align: justify;
    }

    .prose blockquote {
        border-left: 4px solid #e8b73a;
        padding: 2rem;
        margin: 2rem 0;
        font-style: italic;
        color: #6d5650;
        background: linear-gradient(135deg, #fefdf8 0%, #faf8f1 100%);
        border-radius: 12px;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .prose blockquote::before {
        content: '"';
        font-size: 4rem;
        color: #e8b73a;
        position: absolute;
        top: -10px;
        left: 20px;
        font-family: serif;
        opacity: 0.5;
    }

    .prose strong {
        color: #2d3748;
        font-weight: 600;
    }

    .prose ul, .prose ol {
        margin: 1.5rem 0;
        padding-left: 1.5rem;
    }

    .prose li {
        margin: 0.75rem 0;
        line-height: 1.7;
    }

    .prose ul li::marker {
        color: #e8b73a;
    }

    .prose a {
        color: #3182ce;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: all 0.3s ease;
    }

    .prose a:hover {
        color: #2c5282;
        border-bottom-color: #3182ce;
    }

    .prose img {
        border-radius: 12px;
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
    }

    .prose code {
        background: #f7fafc;
        color: #2d3748;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.875em;
        border: 1px solid #e2e8f0;
    }

    .prose pre {
        background: #2d3748;
        color: #f7fafc;
        border-radius: 12px;
        padding: 1.5rem;
        overflow-x: auto;
        margin: 2rem 0;
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
    }

    .prose pre code {
        background: none;
        color: inherit;
        padding: 0;
        border: none;
    }

    /* Styles responsive pour les tables */
    .prose table {
        border-collapse: collapse;
        margin: 2rem 0;
        width: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .prose th, .prose td {
        border: 1px solid #e2e8f0;
        padding: 1rem;
        text-align: left;
    }

    .prose th {
        background: #f7fafc;
        font-weight: 600;
        color: #2d3748;
    }

    /* Animation pour les éléments qui apparaissent */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Styles pour la table des matières */
    .toc-link {
        display: block;
        padding: 0.5rem 0;
        color: #4a5568;
        text-decoration: none;
        border-left: 3px solid transparent;
        padding-left: 1rem;
        transition: all 0.3s ease;
    }

    .toc-link:hover {
        color: #3182ce;
        border-left-color: #3182ce;
        padding-left: 1.5rem;
    }

    .toc-link.active {
        color: #3182ce;
        border-left-color: #3182ce;
        background: #ebf8ff;
        border-radius: 0 6px 6px 0;
    }

    /* Amélioration des line-clamp */
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

    /* Styles responsives */
    @media (max-width: 768px) {
        .prose h1 { font-size: 2rem; }
        .prose h2 { font-size: 1.75rem; }
        .prose h3 { font-size: 1.5rem; }
        .prose h4 { font-size: 1.25rem; }

        .prose blockquote {
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .prose p {
            text-align: left;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Barre de progression de lecture
        function updateReadingProgress() {
            const article = document.querySelector('.article-content');
            const progressBar = document.getElementById('reading-progress');

            if (article && progressBar) {
                const articleHeight = article.offsetHeight;
                const articleTop = article.offsetTop;
                const scrolled = window.scrollY;
                const windowHeight = window.innerHeight;

                const progress = Math.min(100, Math.max(0,
                    ((scrolled - articleTop + windowHeight) / articleHeight) * 100
                ));

                progressBar.style.width = progress + '%';
            }
        }

        // Génération automatique de la table des matières
        function generateTOC() {
            const headings = document.querySelectorAll('.article-content h1, .article-content h2, .article-content h3, .article-content h4');
            const tocContent = document.getElementById('toc-content');

            if (headings.length > 0 && tocContent) {
                headings.forEach((heading, index) => {
                    // Ajouter un ID si nécessaire
                    if (!heading.id) {
                        heading.id = 'heading-' + index;
                    }

                    // Créer le lien dans la TOC
                    const link = document.createElement('a');
                    link.href = '#' + heading.id;
                    link.textContent = heading.textContent;
                    link.className = 'toc-link text-sm';
                    link.style.paddingLeft = (parseInt(heading.tagName.charAt(1)) - 1) * 1 + 'rem';

                    // Navigation fluide
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        heading.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });

                    tocContent.appendChild(link);
                });

                // Afficher la TOC si elle contient du contenu
                document.querySelector('#toc-content').classList.remove('hidden');
            } else {
                // Masquer la section TOC si pas de headings
                document.querySelector('.mb-12.p-6').style.display = 'none';
            }
        }

        // Mise à jour des liens actifs dans la TOC
        function updateActiveTOCLink() {
            const headings = document.querySelectorAll('.article-content h1, .article-content h2, .article-content h3, .article-content h4');
            const tocLinks = document.querySelectorAll('.toc-link');

            let activeHeading = null;
            headings.forEach(heading => {
                const rect = heading.getBoundingClientRect();
                if (rect.top <= 150) {
                    activeHeading = heading;
                }
            });

            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (activeHeading && link.href.includes(activeHeading.id)) {
                    link.classList.add('active');
                }
            });
        }

        // Animation des éléments au scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('[class*="group"], .prose p, .prose h2, .prose h3');
            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    element.classList.add('fade-in');
                }
            });
        }

        // Événements de scroll
        window.addEventListener('scroll', function() {
            updateReadingProgress();
            updateActiveTOCLink();
            animateOnScroll();
        });

        // Initialisation
        generateTOC();
        updateReadingProgress();
        animateOnScroll();
    });

    // Fonction pour basculer la table des matières
    function toggleToc() {
        const tocContent = document.getElementById('toc-content');
        const tocIcon = document.getElementById('toc-icon');

        tocContent.classList.toggle('hidden');

        if (tocContent.classList.contains('hidden')) {
            tocIcon.style.transform = 'rotate(0deg)';
        } else {
            tocIcon.style.transform = 'rotate(180deg)';
        }
    }

    // Fonction de partage
    function shareArticle() {
        if (navigator.share) {
            navigator.share({
                title: document.title,
                url: window.location.href
            });
        } else {
            // Fallback: copier l'URL
            navigator.clipboard.writeText(window.location.href).then(() => {
                // Afficher une notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                notification.textContent = 'Lien copié dans le presse-papiers !';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
        }
    }
</script>
@endpush

