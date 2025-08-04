@extends('layouts.app')

@section('title', $biographie->getLocalizedTitle() . ' - Limahine')
@section('description', Str::limit(strip_tags($biographie->getLocalizedDescription()), 160))

@section('content')
    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                {{-- Breadcrumb --}}
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-indigo-600">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-800">Accueil</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li><a href="{{ route('biography') }}" class="hover:text-indigo-800">Biographie</a></li>
                        <li><span class="mx-2">/</span></li>
                        <li class="text-indigo-800 font-medium">{{ $biographie->getLocalizedTitle() }}</li>
                    </ol>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Image de couverture --}}
                    <div class="lg:col-span-1">
                        @if($biographie->cover_url)
                        <div class="aspect-[3/4] bg-cover bg-center rounded-2xl shadow-lg"
                             style="background-image: url('{{ $biographie->cover_url }}')">
                        </div>
                        @else
                        <div class="aspect-[3/4] bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl shadow-lg flex items-center justify-center">
                            <svg class="w-20 h-20 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Informations principales --}}
                    <div class="lg:col-span-2">
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                                {{ $biographie::getCategories()[$biographie->category] ?? $biographie->category }}
                            </span>
                            <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                                {{ $biographie::getTypes()[$biographie->type] ?? $biographie->type }}
                            </span>
                            @if($biographie->featured)
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
                                ⭐ Vedette
                            </span>
                            @endif
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-indigo-900 mb-4">
                            {{ $biographie->getLocalizedTitle() }}
                        </h1>

                        <p class="text-xl text-indigo-700 font-medium mb-6">
                            {{ $biographie->getLocalizedAuthorName() }}
                        </p>

                        {{-- Métadonnées --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            @if($biographie->langue)
                            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-indigo-600 font-medium">Langue</div>
                                <div class="text-indigo-900">{{ $biographie->langue }}</div>
                            </div>
                            @endif

                            @if($biographie->date_publication)
                            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-indigo-600 font-medium">Publication</div>
                                <div class="text-indigo-900">{{ $biographie->date_publication->format('Y') }}</div>
                            </div>
                            @endif

                            @if($biographie->pages)
                            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-indigo-600 font-medium">Pages</div>
                                <div class="text-indigo-900">{{ $biographie->pages }}</div>
                            </div>
                            @endif

                            @if($biographie->editeur)
                            <div class="text-center p-3 bg-white rounded-lg shadow-sm">
                                <div class="text-sm text-indigo-600 font-medium">Éditeur</div>
                                <div class="text-indigo-900 text-sm">{{ $biographie->editeur }}</div>
                            </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-wrap gap-4">
                            @if($biographie->disponible_en_ligne && $biographie->url_telechargement)
                            <a href="{{ $biographie->url_telechargement }}" target="_blank"
                               class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Télécharger
                            </a>
                            @endif

                            @if($biographie->getFirstMediaUrl('document'))
                            <a href="{{ $biographie->getFirstMediaUrl('document') }}" target="_blank"
                               class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                Consulter le document
                            </a>
                            @endif

                            <button onclick="window.print()"
                                    class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Imprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenu principal --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                @if($biographie->getLocalizedDescription())
                <div class="prose prose-lg prose-indigo max-w-none">
                    <h2 class="text-2xl font-bold text-indigo-900 mb-6">Description</h2>
                    <div class="text-gray-800 leading-relaxed">
                        {!! $biographie->getLocalizedDescriptionHtml() !!}
                    </div>
                </div>
                @endif

                {{-- Informations supplémentaires --}}
                @if($biographie->isbn || $biographie->editeur)
                <div class="mt-12 p-6 bg-gray-50 rounded-2xl">
                    <h3 class="text-xl font-bold text-indigo-900 mb-4">Informations bibliographiques</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($biographie->isbn)
                        <div>
                            <span class="font-medium text-indigo-700">ISBN :</span>
                            <span class="text-gray-800">{{ $biographie->isbn }}</span>
                        </div>
                        @endif
                        @if($biographie->editeur)
                        <div>
                            <span class="font-medium text-indigo-700">Éditeur :</span>
                            <span class="text-gray-800">{{ $biographie->editeur }}</span>
                        </div>
                        @endif
                        @if($biographie->date_publication)
                        <div>
                            <span class="font-medium text-indigo-700">Date de publication :</span>
                            <span class="text-gray-800">{{ $biographie->date_publication->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        @if($biographie->pages)
                        <div>
                            <span class="font-medium text-indigo-700">Nombre de pages :</span>
                            <span class="text-gray-800">{{ $biographie->pages }} pages</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Biographies similaires --}}
    @if($relatedBiographies->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-indigo-900 text-center mb-12">
                    Personnalités similaires
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedBiographies as $related)
                    <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                        <a href="{{ route('biography.show', $related->slug) }}">
                            @if($related->getFirstMediaUrl('cover'))
                            <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $related->getFirstMediaUrl('cover') }}')"></div>
                            @else
                            <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            @endif

                            <div class="p-4">
                                <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2 py-1 rounded-full">
                                    {{ $related::getTypes()[$related->type] ?? $related->type }}
                                </span>

                                <h3 class="text-lg font-semibold text-indigo-900 mt-3 mb-2 line-clamp-2">
                                    {{ $related->getLocalizedTitle() }}
                                </h3>

                                <p class="text-indigo-700 font-medium text-sm mb-2">
                                    {{ $related->getLocalizedAuthorName() }}
                                </p>

                                @if($related->getLocalizedDescription())
                                <p class="text-indigo-600 text-sm line-clamp-3">
                                    {{ Str::limit(strip_tags($related->getLocalizedDescription()), 80) }}
                                </p>
                                @endif
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('biography') }}"
                       class="inline-flex items-center bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                        Voir toutes les biographies
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
<style>
    .prose h2 {
        @apply text-2xl font-bold text-indigo-900 mt-8 mb-4;
    }
    .prose h3 {
        @apply text-xl font-bold text-indigo-800 mt-6 mb-3;
    }
    .prose p {
        @apply mb-4 text-gray-800;
    }
    .prose ul, .prose ol {
        @apply mb-4 ml-6;
    }
    .prose li {
        @apply mb-2;
    }
    .prose blockquote {
        @apply border-l-4 border-indigo-500 pl-4 italic text-indigo-700 bg-indigo-50 p-4 rounded-r-lg my-6;
    }
    .prose a {
        @apply text-indigo-600 hover:text-indigo-800 underline;
    }
    .prose strong {
        @apply font-bold text-indigo-900;
    }
    .prose em {
        @apply italic;
    }
    .prose code {
        @apply bg-gray-100 px-2 py-1 rounded text-sm;
    }

    @media print {
        .no-print {
            display: none !important;
        }
        .prose {
            color: black !important;
        }
    }
</style>
@endpush
