@extends('layouts.app')

@section('title', $filsCheikh->getLocalizedName() . ' - Fils de Cheikh Ahmadou Bamba - Limahine')
@section('description', $filsCheikh->getLocalizedDescription() ?: 'Découvrez la vie et les enseignements de ' . $filsCheikh->getLocalizedName() . ', fils de Cheikh Ahmadou Bamba.')

@section('content')
    {{-- Header avec image de couverture --}}
    <section class="relative pt-20">
        @if($filsCheikh->getFirstMediaUrl('cover_image'))
        <div class="h-96 bg-cover bg-center relative" style="background-image: url('{{ $filsCheikh->getFirstMediaUrl('cover_image') }}')">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>
        @else
        <div class="h-96 bg-gradient-to-br from-emerald-600 to-teal-700 relative">
            <div class="absolute inset-0 bg-black opacity-30"></div>
        </div>
        @endif

        <div class="absolute inset-0 flex items-end pb-12">
            <div class="container mx-auto px-6">
                <div class="flex items-end space-x-8">
                    {{-- Photo portrait --}}
                    @if($filsCheikh->getFirstMediaUrl('portrait'))
                    <div class="w-32 h-32 rounded-full border-4 border-white overflow-hidden shadow-lg bg-white">
                        <img src="{{ $filsCheikh->getFirstMediaUrl('portrait') }}"
                             alt="{{ $filsCheikh->getLocalizedName() }}"
                             class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-32 h-32 rounded-full border-4 border-white overflow-hidden shadow-lg bg-emerald-100 flex items-center justify-center">
                        <svg class="w-16 h-16 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @endif

                    {{-- Informations principales --}}
                    <div class="flex-1 text-white">
                        @if($filsCheikh->is_khalif)
                        <div class="mb-2">
                            <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center w-fit">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Khalif {{ $filsCheikh->order_of_succession ?? '' }}
                            </span>
                        </div>
                        @endif

                        <h1 class="text-4xl md:text-5xl font-bold mb-4">
                            {{ $filsCheikh->getLocalizedName() }}
                        </h1>

                        <div class="flex items-center space-x-6 text-lg">
                            @if($filsCheikh->birth_date)
                            <span>Né en {{ $filsCheikh->birth_date->format('Y') }}</span>
                            @endif
                            @if($filsCheikh->death_date)
                            <span>Décédé en {{ $filsCheikh->death_date->format('Y') }}</span>
                            @elseif($filsCheikh->birth_date)
                            <span class="text-green-300 font-medium">Vivant</span>
                            @endif
                            @if($filsCheikh->getAge())
                            <span>({{ $filsCheikh->getAge() }} ans{{ $filsCheikh->isAlive() ? '' : ' au décès' }})</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Description et Navigation --}}
    <section class="py-8 bg-white border-b border-emerald-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="flex-1 lg:pr-8">
                    @if($filsCheikh->getLocalizedDescription())
                    <p class="text-lg text-emerald-700 leading-relaxed">
                        {{ $filsCheikh->getLocalizedDescription() }}
                    </p>
                    @endif
                </div>

                <div class="mt-6 lg:mt-0 flex space-x-4">
                    <span class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-lg font-medium">
                        {{ $publications->total() }} publication(s)
                    </span>
                    @if($publications->count() > 0)
                    <a href="{{ route('decouverte.publications', $filsCheikh->slug) }}"
                       class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                        Voir toutes les publications
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Biographie --}}
    @if($filsCheikh->getLocalizedBiography())
    <section class="py-16 bg-emerald-50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-emerald-900 mb-8 text-center">
                    Biographie
                </h2>
                <div class="prose prose-lg prose-emerald max-w-none">
                    {!! $filsCheikh->getLocalizedBiography() !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Publications --}}
    @if($publications->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Publications
                </h2>
                <p class="text-emerald-700">Les enseignements et contenus liés à {{ $filsCheikh->getLocalizedName() }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($publications->take(6) as $publication)
                <article class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-emerald-100">
                    @if($publication->getFirstMediaUrl('featured_image'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $publication->getFirstMediaUrl('featured_image') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-medium px-3 py-1 rounded-full">
                                Découverte
                            </span>
                            @if($publication->reading_time)
                            <span class="text-emerald-600 text-xs">
                                {{ $publication->reading_time }} min
                            </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-semibold text-emerald-900 mb-3 line-clamp-2">
                            {{ $publication->getLocalizedTitle() }}
                        </h3>

                        <p class="text-emerald-700 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($publication->getLocalizedExcerpt() ?? ''), 120) }}
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-emerald-600">
                                {{ $publication->published_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('publications.show', $publication->slug) }}"
                               class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                                Lire
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            @if($publications->total() > 6)
            <div class="text-center mt-12">
                <a href="{{ route('decouverte.publications', $filsCheikh->slug) }}"
                   class="bg-emerald-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Voir toutes les {{ $publications->total() }} publications
                </a>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- Autres fils de Cheikh (suggestions) --}}
    @if($autres_fils->count() > 0)
    <section class="py-16 bg-emerald-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Découvrir d'autres fils de Cheikh Ahmadou Bamba
                </h2>
                <p class="text-emerald-700">Explorez la famille spirituelle</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($autres_fils as $autre)
                <article class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    @if($autre->getFirstMediaUrl('cover_image'))
                    <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $autre->getFirstMediaUrl('cover_image') }}')"></div>
                    @else
                    <div class="h-40 bg-gradient-to-br from-emerald-300 to-teal-400 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-4">
                        @if($autre->is_khalif)
                        <div class="mb-2">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Khalif {{ $autre->order_of_succession ?? '' }}
                            </span>
                        </div>
                        @endif

                        <h3 class="text-lg font-semibold text-emerald-900 mb-2 line-clamp-2">
                            {{ $autre->getLocalizedName() }}
                        </h3>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-emerald-600">
                                {{ $autre->publications->count() }} publication(s)
                            </span>
                            <a href="{{ route('decouverte.show', $autre->slug) }}"
                               class="bg-emerald-600 text-white px-3 py-1 rounded text-xs font-medium hover:bg-emerald-700 transition-colors">
                                Voir
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('decouverte.index') }}"
                   class="bg-emerald-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Voir tous les fils de Cheikh Ahmadou Bamba
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection
