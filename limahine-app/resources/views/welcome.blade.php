@extends('layouts.app')

@section('title', 'Accueil - Limahine')
@section('description', 'Découvrez Limahine, une plateforme dédiée à l\'excellence académique et à l\'innovation.')

@section('content')
    {{-- Hero Section --}}
    <x-hero
        title="Bienvenue sur <span class='text-gradient'>Limahine</span>"
        subtitle="Plateforme d'Excellence Académique"
        description="Une plateforme dédiée à l'excellence et à l'innovation dans le domaine académique et de la recherche."
        ctaText="Découvrir"
        ctaLink="#mission"
        :secondaryCta="['text' => 'Nos Publications', 'link' => route('writing')]"
    />

    {{-- Mission Section --}}
    <x-section
        id="mission"
        title="Notre <span class='text-gradient'>Mission</span>"
        subtitle="Excellence et Innovation"
        description="Nous nous engageons à promouvoir l'excellence académique et l'innovation à travers la recherche et le partage des connaissances."
        background="white"
    >
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <x-card
                title="Excellence Académique"
                description="Nous nous efforçons d'atteindre les plus hauts standards dans tous nos domaines d'expertise."
                :icon="'<svg class=\"w-6 h-6 text-white\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z\"></path></svg>'"
            />

            <x-card
                title="Innovation Continue"
                description="Nous encourageons l'innovation et la créativité pour faire avancer la recherche."
                :icon="'<svg class=\"w-6 h-6 text-white\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\"></path></svg>'"
            />

            <x-card
                title="Partage des Connaissances"
                description="Nous facilitons le partage et la diffusion des connaissances pour bénéficier à tous."
                :icon="'<svg class=\"w-6 h-6 text-white\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\"></path></svg>'"
            />
        </div>
    </x-section>

    {{-- Featured Content Section --}}
    <x-section
        title="Contenus <span class='text-gradient'>Phares</span>"
        subtitle="Nos dernières contributions"
        description="Découvrez nos dernières publications, recherches et réflexions."
        background="gradient"
    >
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <x-card
                title="La Philosophie de l'Excellence"
                description="Une exploration profonde des fondements philosophiques qui guident notre approche de l'excellence académique."
                :link="route('philosophy')"
                :featured="true"
                category="Philosophie"
                date="Juillet 2025"
            />

            <x-card
                title="Méthodologies de Recherche"
                description="Découvrez les nouvelles méthodologies que nous développons pour repousser les limites de la recherche."
                :link="route('writing')"
                category="Recherche"
                date="Juin 2025"
            />
        </div>

        <div class="text-center mt-12">
            <x-button href="{{ route('writing') }}" type="outline" size="lg">
                Voir toutes nos publications
                <x-slot name="icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </x-slot>
            </x-button>
        </div>
    </x-section>

    {{-- Call to Action Section --}}
    <x-section
        title="Rejoignez <span class='text-gradient'>notre communauté</span>"
        subtitle="Ensemble vers l'excellence"
        description="Découvrez comment vous pouvez contribuer à notre mission d'excellence et d'innovation."
        background="dark"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {{-- CTA Card 1 --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-elegant font-semibold text-white mb-4">Rejoindre notre équipe</h3>
                <p class="text-white/80 mb-6">Découvrez notre équipe de chercheurs et d'innovateurs passionnés.</p>
                <x-button href="{{ route('chercheurs') }}" type="secondary">
                    Découvrir l'équipe
                </x-button>
            </div>

            {{-- CTA Card 2 --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-elegant font-semibold text-white mb-4">Témoignages</h3>
                <p class="text-white/80 mb-6">Découvrez les retours de notre communauté et partenaires.</p>
                <x-button href="{{ route('testimonials') }}" type="secondary">
                    Lire les témoignages
                </x-button>
            </div>
        </div>
    </x-section>

    {{-- Contact Section --}}
    <x-section
        id="contact"
        title="Nous <span class='text-gradient'>contacter</span>"
        subtitle="Démarrons une conversation"
        description="Vous avez un projet, une question ou souhaitez collaborer ? Nous serions ravis d'échanger avec vous."
        background="white"
    >
        <div class="max-w-2xl mx-auto">
            <x-contact-form />
        </div>
    </x-section>
@endsection
