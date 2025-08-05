@extends('layouts.app')

@section('title', 'Écriture - Limahine')
@section('description', 'Découvrez mes écrits, articles et essais sur des sujets qui m\'inspirent et nourrissent ma réflexion intellectuelle.')

@section('content')
    {{-- Hero Section --}}
    <x-hero
        title="L'Art de <span class='text-gradient'>l'Écriture</span>"
        subtitle="Expression & Réflexion"
        description="Explorez ma collection d'écrits, d'articles et d'essais sur des sujets variés qui nourrissent ma pensée et inspirent ma démarche intellectuelle."
        ctaText="Découvrir mes écrits"
        ctaLink="#articles"
    />

    {{-- Articles Section --}}
    <x-section
        title="Mes <span class='text-gradient'>Publications</span>"
        subtitle="Articles & Essais"
        description="Une sélection de mes écrits les plus récents, reflétant mes recherches et mes réflexions sur des thématiques contemporaines."
        background="white"
    >
        <div class="grid-auto-fit">
            <x-card
                title="Philosophie et Modernité"
                description="Une réflexion sur les défis philosophiques de notre époque et les réponses que nous pouvons y apporter."
                category="Philosophie"
                date="Janvier 2025"
                :featured="true"
                link="#"
            />

            <x-card
                title="L'Innovation Pédagogique"
                description="Comment repenser l'éducation pour former les citoyens de demain dans un monde en mutation constante."
                category="Éducation"
                date="Décembre 2024"
                link="#"
            />

            <x-card
                title="Recherche Collaborative"
                description="L'importance de la collaboration interdisciplinaire dans la recherche académique contemporaine."
                category="Recherche"
                date="Novembre 2024"
                link="#"
            />

            <x-card
                title="Éthique et Technologie"
                description="Les enjeux éthiques soulevés par les avancées technologiques et leur impact sur la société."
                category="Éthique"
                date="Octobre 2024"
                link="#"
            />

            <x-card
                title="Dialogue Interculturel"
                description="Construire des ponts entre les cultures à travers le dialogue et la compréhension mutuelle."
                category="Culture"
                date="Septembre 2024"
                link="#"
            />

            <x-card
                title="Méthodologie de Recherche"
                description="Approches innovantes en méthodologie de recherche pour l'étude des phénomènes complexes."
                category="Méthodologie"
                date="Août 2024"
                link="#"
            />
        </div>

        {{-- Load More Button --}}
        <div class="text-center mt-12">
            <button class="btn-outline" onclick="loadMoreArticles()">
                Voir plus d'articles
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
        </div>
    </x-section>

    {{-- Categories Section --}}
    <x-section
        title="Thématiques <span class='text-gradient'>Explorées</span>"
        subtitle="Domaines de Réflexion"
        description="Les différents domaines qui nourrissent ma réflexion et orientent mes recherches."
        background="gradient"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center group animate-on-scroll">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-xl flex items-center justify-center shadow-golden group-hover:shadow-glow transition-all duration-300 group-hover:scale-110">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="font-elegant font-semibold text-accent-900 mb-2">Philosophie</h3>
                <p class="text-accent-700 text-sm">Réflexions sur les questions fondamentales de l'existence</p>
                <x-badge type="primary" size="sm" class="mt-2">12 articles</x-badge>
            </div>

            <div class="text-center group animate-on-scroll">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-xl flex items-center justify-center shadow-golden group-hover:shadow-glow transition-all duration-300 group-hover:scale-110">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="font-elegant font-semibold text-accent-900 mb-2">Éducation</h3>
                <p class="text-accent-700 text-sm">Innovation pédagogique et transformation éducative</p>
                <x-badge type="secondary" size="sm" class="mt-2">8 articles</x-badge>
            </div>

            <div class="text-center group animate-on-scroll">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-xl flex items-center justify-center shadow-golden group-hover:shadow-glow transition-all duration-300 group-hover:scale-110">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="font-elegant font-semibold text-accent-900 mb-2">Recherche</h3>
                <p class="text-accent-700 text-sm">Méthodologies et approches innovantes</p>
                <x-badge type="success" size="sm" class="mt-2">15 articles</x-badge>
            </div>

            <div class="text-center group animate-on-scroll">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-xl flex items-center justify-center shadow-golden group-hover:shadow-glow transition-all duration-300 group-hover:scale-110">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                    </svg>
                </div>
                <h3 class="font-elegant font-semibold text-accent-900 mb-2">Culture</h3>
                <p class="text-accent-700 text-sm">Dialogue interculturel et diversité</p>
                <x-badge type="info" size="sm" class="mt-2">6 articles</x-badge>
            </div>
        </div>
    </x-section>

    {{-- Quote Section --}}
    <x-section
        title=""
        background="dark"
        paddingY="normal"
    >
        <div class="text-center max-w-4xl mx-auto">
            <blockquote class="text-2xl md:text-3xl font-elegant italic text-white mb-8 leading-relaxed">
                "L'écriture est l'art de découvrir ce que l'on pense en articulant ce que l'on ressent."
            </blockquote>
            <cite class="text-primary-400 font-medium">— Réflexion personnelle</cite>

            <div class="mt-12 flex justify-center space-x-8">
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-400">25+</div>
                    <div class="text-neutral-300 text-sm">Articles publiés</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-400">5</div>
                    <div class="text-neutral-300 text-sm">Thématiques</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-primary-400">3</div>
                    <div class="text-neutral-300 text-sm">Années d'écriture</div>
                </div>
            </div>
        </div>
    </x-section>

    {{-- Newsletter Section --}}
    <x-section
        title="Restez <span class='text-gradient'>Informé</span>"
        subtitle="Newsletter"
        description="Recevez mes derniers articles et réflexions directement dans votre boîte mail."
        background="white"
    >
        <div class="max-w-2xl mx-auto">
            <form class="flex flex-col sm:flex-row gap-4" id="newsletter-form">
                @csrf
                <input
                    type="email"
                    name="email"
                    placeholder="Votre adresse email"
                    required
                    class="form-input flex-1"
                >
                <button type="submit" class="btn-primary whitespace-nowrap">
                    S'abonner
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
            <p class="text-sm text-accent-600 mt-4 text-center">
                Pas de spam. Uniquement du contenu de qualité. Désabonnement facile.
            </p>
        </div>
    </x-section>
@endsection



@push('scripts')
<script>
    function loadMoreArticles() {
        // Simulation du chargement d'articles
        Toast.show('Chargement de nouveaux articles...', 'info');

        // Ici, vous pouvez ajouter une requête AJAX pour charger plus d'articles
        setTimeout(() => {
            Toast.show('Nouveaux articles chargés !', 'success');
        }, 2000);
    }

    // Gestion du formulaire de newsletter
    document.getElementById('newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const email = this.querySelector('input[name="email"]').value;

        // Simulation de l'inscription
        Toast.show('Inscription en cours...', 'info');

        setTimeout(() => {
            Toast.show('Merci pour votre inscription !', 'success');
            this.reset();
        }, 1500);
    });
</script>
@endpush

