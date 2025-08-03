@extends('layouts.app')

@section('title', $publication->title[app()->getLocale()] ?? $publication->title['fr'])
@section('description', $publication->meta_description[app()->getLocale()] ?? $publication->excerpt[app()->getLocale()] ?? '')

@section('content')
    {{-- Hero Section pour l'article --}}
    <x-section background="gradient" class="pt-24 pb-16">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-6">
                <x-badge
                    type="primary"
                    size="lg"
                    class="mb-4"
                >
                    {{ \App\Models\Publication::getCategories()[$publication->category] ?? $publication->category }}
                </x-badge>
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-elegant font-bold text-accent-900 mb-6">
                {{ $publication->title[app()->getLocale()] ?? $publication->title['fr'] }}
            </h1>

            @if($publication->excerpt[app()->getLocale()] ?? $publication->excerpt['fr'])
                <p class="text-xl text-accent-700 mb-8 leading-relaxed">
                    {{ $publication->excerpt[app()->getLocale()] ?? $publication->excerpt['fr'] }}
                </p>
            @endif

            <div class="flex flex-wrap items-center justify-center gap-6 text-accent-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $publication->author->name }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $publication->published_at->format('d M Y') }}</span>
                </div>

                @if($publication->reading_time)
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $publication->reading_time }} min de lecture</span>
                    </div>
                @endif
            </div>
        </div>
    </x-section>

    {{-- Contenu de l'article --}}
    <x-section background="white" class="py-16">
        <div class="max-w-4xl mx-auto">
            <article class="prose prose-lg max-w-none">
                {!! $publication->content[app()->getLocale()] ?? $publication->content['fr'] !!}
            </article>

            {{-- Tags --}}
            @if($publication->tags && count($publication->tags) > 0)
                <div class="mt-12 pt-8 border-t border-neutral-200">
                    <h3 class="text-lg font-semibold text-accent-900 mb-4">Mots-clés</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($publication->tags as $tag)
                            <x-badge type="secondary" size="sm">{{ $tag }}</x-badge>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </x-section>

    {{-- Articles similaires --}}
    @if($relatedPublications->count() > 0)
        <x-section
            title="Articles <span class='text-gradient'>similaires</span>"
            subtitle="Poursuivez votre lecture"
            description="Découvrez d'autres articles sur des thématiques similaires"
            background="gradient"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedPublications as $related)
                    <x-card
                        :title="$related->title[app()->getLocale()] ?? $related->title['fr']"
                        :description="$related->excerpt[app()->getLocale()] ?? $related->excerpt['fr']"
                        :link="route('publications.show', $related)"
                        :category="\App\Models\Publication::getCategories()[$related->category] ?? $related->category"
                        :date="$related->published_at->format('M Y')"
                    />
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- Navigation précédent/suivant --}}
    <x-section background="white" class="py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-center">
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

                <div class="flex-1">
                    @if($previous)
                        <a href="{{ route('publications.show', $previous) }}" class="group flex items-center gap-3 text-accent-700 hover:text-primary-600 transition-colors">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <div>
                                <div class="text-sm text-accent-500">Article précédent</div>
                                <div class="font-medium">{{ Str::limit($previous->title[app()->getLocale()] ?? $previous->title['fr'], 40) }}</div>
                            </div>
                        </a>
                    @endif
                </div>

                <div class="flex-1 text-right">
                    @if($next)
                        <a href="{{ route('publications.show', $next) }}" class="group flex items-center gap-3 justify-end text-accent-700 hover:text-primary-600 transition-colors">
                            <div>
                                <div class="text-sm text-accent-500">Article suivant</div>
                                <div class="font-medium">{{ Str::limit($next->title[app()->getLocale()] ?? $next->title['fr'], 40) }}</div>
                            </div>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </x-section>
@endsection

@push('styles')
<style>
    .prose {
        color: #4a5568;
        max-width: none;
    }

    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #2d3748;
        font-family: 'Playfair Display', serif;
    }

    .prose p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    .prose blockquote {
        border-left: 4px solid #e8b73a;
        padding-left: 1.5rem;
        font-style: italic;
        color: #6d5650;
        background: #fefdf8;
        padding: 1.5rem;
        border-radius: 0.5rem;
    }

    .prose strong {
        color: #2d3748;
        font-weight: 600;
    }

    .prose ul, .prose ol {
        margin: 1.5rem 0;
    }

    .prose li {
        margin: 0.5rem 0;
    }
</style>
@endpush
