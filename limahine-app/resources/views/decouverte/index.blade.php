@extends('layouts.app')

@section('title', 'Découverte - Fils de Cheikh Ahmadou Bamba - Limahine')
@section('description', 'Découvrez les fils de Cheikh Ahmadou Bamba, Khalifs et autres descendants, leurs biographies et enseignements.')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold text-emerald-900 mb-6">
                    Découverte
                </h1>
                <h2 class="text-2xl md:text-3xl font-semibold text-emerald-800 mb-6">
                    Les Fils de Cheikh Ahmadou Bamba
                </h2>
                <p class="text-xl text-emerald-700 leading-relaxed mb-8">
                    Explorez la vie et les enseignements des fils de Cheikh Ahmadou Bamba,
                    des Khalifs aux autres descendants qui ont perpétué son héritage spirituel.
                </p>
            </div>
        </div>
    </section>

    {{-- Khalifs Section --}}
    @if($khalifs->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Les Khalifs
                </h2>
                <p class="text-emerald-700">Les successeurs spirituels de Cheikh Ahmadou Bamba</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($khalifs as $khalif)
                <article class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-emerald-100">
                    {{-- Image de couverture --}}
                    @if($khalif->getFirstMediaUrl('cover_image'))
                    <div class="h-48 bg-cover bg-center relative" style="background-image: url('{{ $khalif->getFirstMediaUrl('cover_image') }}')">
                        <div class="absolute top-4 left-4">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Khalif {{ $khalif->order_of_succession ?? '' }}
                            </span>
                        </div>
                    </div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center relative">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div class="absolute top-4 left-4">
                            <span class="bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Khalif {{ $khalif->order_of_succession ?? '' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-emerald-900 mb-3">
                            {{ $khalif->getLocalizedName() }}
                        </h3>

                        @if($khalif->getLocalizedDescription())
                        <p class="text-emerald-700 mb-4 line-clamp-3">
                            {{ Str::limit($khalif->getLocalizedDescription(), 120) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-emerald-600 mb-4">
                            @if($khalif->birth_date)
                            <span>Né en {{ $khalif->birth_date->format('Y') }}</span>
                            @endif
                            @if($khalif->death_date)
                            <span>Décédé en {{ $khalif->death_date->format('Y') }}</span>
                            @elseif($khalif->birth_date)
                            <span class="text-green-600 font-medium">Vivant</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-emerald-600">
                                {{ $khalif->publications->count() }} publication(s)
                            </span>
                            <a href="{{ route('decouverte.show', $khalif->slug) }}"
                               class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                                Découvrir
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Autres Fils Section --}}
    @if($autres_fils->count() > 0)
    <section class="py-16 bg-emerald-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Autres Fils de Cheikh Ahmadou Bamba
                </h2>
                <p class="text-emerald-700">Les descendants qui ont contribué à l'héritage spirituel</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($autres_fils as $fils)
                <article class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                    {{-- Image de couverture --}}
                    @if($fils->getFirstMediaUrl('cover_image'))
                    <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $fils->getFirstMediaUrl('cover_image') }}')"></div>
                    @else
                    <div class="h-40 bg-gradient-to-br from-emerald-300 to-teal-400 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-emerald-900 mb-2 line-clamp-2">
                            {{ $fils->getLocalizedName() }}
                        </h3>

                        @if($fils->getLocalizedDescription())
                        <p class="text-emerald-700 text-sm mb-3 line-clamp-2">
                            {{ Str::limit($fils->getLocalizedDescription(), 80) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-emerald-600">
                                {{ $fils->publications->count() }} publication(s)
                            </span>
                            <a href="{{ route('decouverte.show', $fils->slug) }}"
                               class="bg-emerald-600 text-white px-3 py-1 rounded text-xs font-medium hover:bg-emerald-700 transition-colors">
                                Voir
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Publications Récentes --}}
    @if($recent_publications->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-emerald-900 mb-4">
                    Publications Récentes
                </h2>
                <p class="text-emerald-700">Les derniers contenus de la section Découverte</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recent_publications as $publication)
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
                            @if($publication->filsCheikh)
                            <span class="bg-teal-100 text-teal-800 text-xs font-medium px-2 py-1 rounded">
                                {{ Str::limit($publication->filsCheikh->getLocalizedName(), 20) }}
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

            <div class="text-center mt-12">
                <a href="{{ route('writing') }}?category=decouverte"
                   class="bg-emerald-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Voir toutes les publications Découverte
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection
