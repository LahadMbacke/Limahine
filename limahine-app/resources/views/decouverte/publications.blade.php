@extends('layouts.app')

@section('title', 'Publications de ' . $filsCheikh->getLocalizedName() . ' - Limahine')
@section('description', 'Découvrez toutes les publications et enseignements liés à ' . $filsCheikh->getLocalizedName() . ', fils de Cheikh Ahmadou Bamba.')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-amber-50 via-yellow-50 to-cyan-50 py-20 pt-32">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto">
                <div class="flex items-center justify-center mb-6">
                    <a href="{{ route('decouverte.show', $filsCheikh->slug) }}"
                       class="text-amber-600 hover:text-amber-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-4xl md:text-5xl font-bold text-amber-900 ml-4">
                        Publications de {{ $filsCheikh->getLocalizedName() }}
                    </h1>
                </div>

                @if($filsCheikh->is_khalif)
                <div class="mb-6">
                    <span class="bg-yellow-500 text-white px-6 py-2 rounded-full text-lg font-bold flex items-center justify-center w-fit mx-auto">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Khalif {{ $filsCheikh->order_of_succession ?? '' }}
                    </span>
                </div>
                @endif

                <p class="text-xl text-amber-700 leading-relaxed mb-8">
                    Explorez {{ $publications->total() }} publication(s) liée(s) aux enseignements et à la vie de
                    {{ $filsCheikh->getLocalizedName() }}.
                </p>

                <!-- Recherche -->
                <div class="max-w-md mx-auto">
                    <form method="GET" action="{{ route('decouverte.publications', $filsCheikh->slug) }}" class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Rechercher dans les publications..."
                               class="w-full px-4 py-3 pl-12 rounded-full border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none bg-white">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        @if(request('search'))
                        <button type="button" onclick="window.location.href='{{ route('decouverte.publications', $filsCheikh->slug) }}'" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-amber-400 hover:text-amber-600">
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

    {{-- Breadcrumb et informations --}}
    <section class="py-6 bg-white border-b border-amber-100">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <nav class="text-sm breadcrumbs">
                    <ul class="flex items-center space-x-2 text-amber-600">
                        <li><a href="{{ route('decouverte.index') }}" class="hover:text-amber-800">Découverte</a></li>
                        <li class="text-amber-400">/</li>
                        <li><a href="{{ route('decouverte.show', $filsCheikh->slug) }}" class="hover:text-amber-800">{{ Str::limit($filsCheikh->getLocalizedName(), 30) }}</a></li>
                        <li class="text-amber-400">/</li>
                        <li class="text-amber-800 font-medium">Publications</li>
                    </ul>
                </nav>

                <div class="text-amber-700">
                    {{ $publications->total() }} publication(s) trouvée(s)
                    @if(request('search'))
                        pour "{{ request('search') }}"
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Publications Grid --}}
    @if($publications->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($publications as $publication)
                <article class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-amber-100">
                    @if($publication->getFirstMediaUrl('featured_image'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $publication->getFirstMediaUrl('featured_image') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="bg-amber-100 text-amber-800 text-xs font-medium px-3 py-1 rounded-full">
                                Découverte
                            </span>
                            <div class="flex items-center space-x-2">
                                @if($publication->featured)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">
                                    ⭐ Vedette
                                </span>
                                @endif
                                @if($publication->reading_time)
                                <span class="text-amber-600 text-xs">
                                    {{ $publication->reading_time }} min
                                </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="text-xl font-semibold text-amber-900 mb-3 line-clamp-2">
                            {{ $publication->getLocalizedTitle() }}
                        </h3>

                        <p class="text-amber-700 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($publication->getLocalizedExcerpt() ?? ''), 120) }}
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-amber-600">
                                {{ $publication->published_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('publications.show', $publication->slug) }}"
                               class="bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-amber-700 transition-colors">
                                Lire
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $publications->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
    @else
    {{-- Aucune publication trouvée --}}
    <section class="py-16 bg-amber-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <svg class="w-24 h-24 text-amber-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-amber-900 mb-4">
                    @if(request('search'))
                        Aucune publication trouvée pour "{{ request('search') }}"
                    @else
                        Aucune publication disponible
                    @endif
                </h3>
                <p class="text-amber-700 mb-8">
                    @if(request('search'))
                        Essayez avec d'autres mots-clés ou supprimez les filtres de recherche.
                    @else
                        Les publications liées à {{ $filsCheikh->getLocalizedName() }} seront bientôt disponibles.
                    @endif
                </p>

                <div class="flex justify-center space-x-4">
                    @if(request('search'))
                    <a href="{{ route('decouverte.publications', $filsCheikh->slug) }}"
                       class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition-colors">
                        Voir toutes les publications
                    </a>
                    @endif
                    <a href="{{ route('decouverte.show', $filsCheikh->slug) }}"
                       class="bg-gray-100 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                        Retour au profil
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

