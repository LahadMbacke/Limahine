@extends('layouts.app')

@section('title', $trailer->getTranslation('title', app()->getLocale()) . ' - Trailers Limahine')

@section('meta')
<meta name="description" content="{{ $trailer->getTranslation('meta_description', app()->getLocale()) ?: Str::limit($trailer->getTranslation('description', app()->getLocale()), 160) }}">
<meta property="og:title" content="{{ $trailer->getTranslation('title', app()->getLocale()) }}">
<meta property="og:description" content="{{ $trailer->getTranslation('meta_description', app()->getLocale()) ?: Str::limit($trailer->getTranslation('description', app()->getLocale()), 160) }}">
<meta property="og:image" content="{{ $trailer->youtube_thumbnail }}">
<meta property="og:video" content="{{ $trailer->youtube_url }}">
<meta property="og:type" content="video.other">
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-amber-600">{{ is_array(__('Accueil')) ? 'Accueil' : __('Accueil') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('trailers.index') }}" class="hover:text-amber-600">{{ is_array(__('Trailers')) ? 'Trailers' : __('Trailers') }}</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-amber-900 font-medium">{{ $trailer->getTranslation('title', app()->getLocale()) }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <!-- Video Section -->
            <div class="relative bg-black">
                <div class="aspect-video">
                    <iframe
                        src="{{ $trailer->youtube_embed_url }}&autoplay=0&rel=0&modestbranding=1"
                        class="w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6 lg:p-8">

                <!-- Header -->
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
                    <div class="flex-1">
                        <h1 class="text-2xl lg:text-3xl font-bold text-amber-900 mb-3">
                            {{ $trailer->getTranslation('title', app()->getLocale()) }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-amber-600 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ is_array(__('Durée :')) ? 'Durée :' : __('Durée :') }} {{ $trailer->formatted_duration }}
                            </span>

                            @if($trailer->category)
                                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                                    {{ ucfirst($trailer->category) }}
                                </span>
                            @endif

                            @if($trailer->featured)
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                                    {{ is_array(__('En vedette')) ? 'En vedette' : __('En vedette') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($trailer->getTranslation('description', app()->getLocale()))
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-amber-900 mb-3">{{ is_array(__('Description')) ? 'Description' : __('Description') }}</h2>
                        <div class="prose prose-amber max-w-none">
                            <p class="text-amber-700 leading-relaxed">
                                {{ $trailer->getTranslation('description', app()->getLocale()) }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Tags -->
                @if($trailer->tags && count($trailer->tags) > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-amber-900 mb-3">{{ __('Mots-clés') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($trailer->tags as $tag)
                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8">
                    <a href="{{ $trailer->youtube_url }}"
                       target="_blank"
                       class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        {{ __('Voir sur YouTube') }}
                    </a>

                    <a href="https://www.youtube.com/@limaahinetv2949"
                       target="_blank"
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        {{ __('Découvrir Limahine TV') }}
                    </a>

                    <button onclick="shareVideo()"
                            class="inline-flex items-center justify-center px-6 py-3 bg-green-100 text-green-700 font-medium rounded-lg hover:bg-green-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                        </svg>
                        {{ __('Partager') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Trailers -->
        @if($relatedTrailers->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('Trailers similaires') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedTrailers as $relatedTrailer)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="relative">
                                <img src="{{ $relatedTrailer->youtube_thumbnail }}"
                                     alt="{{ $relatedTrailer->getTranslation('title', app()->getLocale()) }}"
                                     class="w-full h-32 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('trailers.show', $relatedTrailer->slug) }}"
                                       class="bg-white text-green-600 rounded-full p-2 hover:bg-green-600 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 5v10l7-5z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-gray-900 text-sm mb-2 line-clamp-2">
                                    {{ $relatedTrailer->getTranslation('title', app()->getLocale()) }}
                                </h3>
                                <div class="text-xs text-gray-500">
                                    {{ $relatedTrailer->formatted_duration }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function shareVideo() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $trailer->getTranslation('title', app()->getLocale()) }}',
            text: '{{ $trailer->getTranslation('description', app()->getLocale()) ?: 'Découvrez ce trailer vidéo sur Limahine' }}',
            url: window.location.href
        });
    } else {
        // Fallback: copier l'URL dans le presse-papiers
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('{{ __('Lien copié dans le presse-papiers !') }}');
        });
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
