@extends('layouts.app')

@section('title', __('Vidéo - Enseignements de Cheikh Ahmadou Bamba'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    {{ __('Vidéo') }}
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    {{ __('Découvrez des extraits de nos enseignements vidéo sur la chaîne YouTube Limahine TV. Chaque trailer vous donne un aperçu des précieux enseignements de Cheikh Ahmadou Bamba.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Filtres et recherche -->
        <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
            <form method="GET" action="{{ route('trailers.index') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="{{ __('Rechercher des trailers...') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">{{ __('Toutes les catégories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    {{ __('Filtrer') }}
                </button>
            </form>
        </div>

        <!-- Trailers en vedette -->
        @if($featuredTrailers->count() > 0 && !request()->filled('search') && !request()->filled('category'))
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('En Vedette') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredTrailers as $trailer)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="relative">
                            <img src="{{ $trailer->youtube_thumbnail }}"
                                 alt="{{ $trailer->getTranslation('title', app()->getLocale()) }}"
                                 class="w-full h-48 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('trailers.show', $trailer->slug) }}"
                                   class="bg-white text-green-600 rounded-full p-4 hover:bg-green-600 hover:text-white transition-colors">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 5v10l7-5z"/>
                                    </svg>
                                </a>
                            </div>
                            <span class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-sm font-medium">
                                {{ __('En vedette') }}
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2">
                                {{ $trailer->getTranslation('title', app()->getLocale()) }}
                            </h3>
                            @if($trailer->getTranslation('description', app()->getLocale()))
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                                    {{ $trailer->getTranslation('description', app()->getLocale()) }}
                                </p>
                            @endif
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $trailer->formatted_duration }}</span>
                                @if($trailer->category)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded">
                                        {{ ucfirst($trailer->category) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Tous les trailers -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                {{ __('Tous les Trailers') }}
                @if(request()->filled('search') || request()->filled('category'))
                    <span class="text-lg font-normal text-gray-600">
                        ({{ $trailers->total() }} {{ __('résultats') }})
                    </span>
                @endif
            </h2>

            @if($trailers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($trailers as $trailer)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="relative">
                                <img src="{{ $trailer->youtube_thumbnail }}"
                                     alt="{{ $trailer->getTranslation('title', app()->getLocale()) }}"
                                     class="w-full h-40 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('trailers.show', $trailer->slug) }}"
                                       class="bg-white text-green-600 rounded-full p-3 hover:bg-green-600 hover:text-white transition-colors">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 5v10l7-5z"/>
                                        </svg>
                                    </a>
                                </div>
                                @if($trailer->featured)
                                    <span class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">
                                        {{ __('En vedette') }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $trailer->getTranslation('title', app()->getLocale()) }}
                                </h3>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ $trailer->formatted_duration }}</span>
                                    @if($trailer->category)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                            {{ ucfirst($trailer->category) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $trailers->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Aucun trailer trouvé') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ __('Essayez de modifier vos critères de recherche.') }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Lien vers la chaîne YouTube -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
            <div class="flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-red-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                <h3 class="text-lg font-semibold text-red-800">{{ __('Découvrez plus sur notre chaîne YouTube') }}</h3>
            </div>
            <p class="text-red-700 mb-4">
                {{ __('Retrouvez l\'intégralité de nos enseignements et bien plus encore sur Limahine TV') }}
            </p>
            <a href="https://www.youtube.com/@limaahinetv2949"
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                {{ __('Visiter Limahine TV') }}
            </a>
        </div>
    </div>
</div>

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
@endsection
