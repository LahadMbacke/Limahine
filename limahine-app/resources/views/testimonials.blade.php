@extends('layouts.app')

@section('title', 'Témoignages - Limahine')
@section('description', 'Découvrez les témoignages authentiques sur la vie et les enseignements de Cheikh Ahmadou Bamba Mbacké.')

@section('content')
    {{-- Hero Section --}}
    <x-hero
        title="<span class='text-gradient'>Témoignages</span> Authentiques"
        subtitle="Récits et Expériences Vécues"
        description="Découvrez les témoignages de ceux qui ont côtoyé Cheikh Ahmadou Bamba et de ses disciples fidèles."
        ctaText="Explorer les témoignages"
        ctaLink="#temoignages"
        background="gradient"
    />

    {{-- Témoignages vedettes --}}
    @if($featuredTemoignages && $featuredTemoignages->count() > 0)
        <x-section
            title="Témoignages <span class='text-gradient'>Vedettes</span>"
            subtitle="Récits Marquants"
            description="Les témoignages les plus significatifs et émouvants de notre collection."
            background="white"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredTemoignages as $featured)
                    <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-2xl p-6 border border-primary-200">
                        <h3 class="text-xl font-elegant font-semibold text-accent-900 mb-3">
                            {{ $1->getLocalizedTitle() ?? 'Témoignage' }}
                        </h3>
                        <p class="text-accent-700 mb-4 leading-relaxed">
                            {{ Str::limit(strip_tags(featured->getLocalizedContent() ?? ''), 120) }}
                        </p>
                        <div class="text-sm text-accent-600">
                            <p class="font-semibold">{{ $featured->author_name }}</p>
                            @if($featured->location)
                                <p>{{ $featured->location }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </x-section>
    @endif

    {{-- Section principale des témoignages --}}
    <x-section
        id="temoignages"
        title="Tous les <span class='text-gradient'>Témoignages</span>"
        subtitle="Collection Complète"
        description="Parcourez l'ensemble de notre collection de témoignages vérifiés et authentifiés."
        background="gradient"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($temoignages as $temoignage)
                <div class="bg-white rounded-2xl shadow-elegant p-6 hover:shadow-golden transition-all duration-300 hover:-translate-y-1">
                    {{-- Badge de vérification --}}
                    @if($temoignage->verified)
                        <div class="flex justify-between items-start mb-4">
                            <x-badge type="success" size="sm">Vérifié</x-badge>
                            @if($temoignage->featured)
                                <x-badge type="primary" size="sm">Vedette</x-badge>
                            @endif
                        </div>
                    @endif

                    {{-- Titre --}}
                    <h3 class="text-xl font-elegant font-semibold text-accent-900 mb-3">
                        {{ $1->getLocalizedTitle() ?? 'Témoignage' }}
                    </h3>

                    {{-- Extrait du contenu --}}
                    <p class="text-accent-700 mb-4 leading-relaxed">
                        {{ Str::limit(strip_tags(temoignage->getLocalizedContent() ?? ''), 150) }}
                    </p>

                    {{-- Informations sur l'auteur --}}
                    <div class="border-t border-neutral-200 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-accent-900">{{ $temoignage->author_name }}</p>
                                @if(isset(temoignage->getLocalizedAuthorTitle()) && temoignage->getLocalizedAuthorTitle())
                                    <p class="text-sm text-accent-600">
                                        {{ $1->getLocalizedAuthorTitle() }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right text-sm text-accent-600">
                                @if($temoignage->location)
                                    <p>{{ $temoignage->location }}</p>
                                @endif
                                @if($temoignage->date_temoignage)
                                    <p>{{ $temoignage->date_temoignage->format('Y') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="max-w-sm mx-auto">
                        <svg class="w-16 h-16 text-accent-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-accent-900 mb-2">Aucun témoignage disponible</h3>
                        <p class="text-accent-600">Les témoignages seront bientôt disponibles.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($temoignages) && $temoignages->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $temoignages->links() }}
            </div>
        @endif
    </x-section>
@endsection

