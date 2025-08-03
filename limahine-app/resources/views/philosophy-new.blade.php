@extends('layouts.app')

@section('title', 'Philosophie - Limahine')
@section('description', 'Explorez les fondements spirituels, éducatifs et éthiques portés par Cheikh Ahmadou Bamba et les grandes orientations de la voie mouride.')

@section('content')
    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background spirituel -->
        <div class="absolute inset-0 bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50"></div>

        <!-- Motifs géométriques -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/4 left-1/4 w-32 h-32 border-2 border-teal-400 rounded-full"></div>
            <div class="absolute top-1/3 right-1/4 w-24 h-24 border-2 border-cyan-400 rotate-45"></div>
            <div class="absolute bottom-1/4 left-1/3 w-20 h-20 border-2 border-blue-400 rounded-full"></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 text-center">
            <div class="max-w-5xl mx-auto">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-teal-900 mb-8">
                    Philosophie
                </h1>

                <h2 class="text-2xl md:text-3xl lg:text-4xl font-light text-teal-800 mb-8 leading-relaxed">
                    Les Fondements Spirituels de la Voie Mouride
                </h2>

                <p class="text-xl md:text-2xl text-teal-700 max-w-4xl mx-auto mb-12 leading-relaxed">
                    Exploration des fondements spirituels, éducatifs et éthiques portés par
                    <span class="font-semibold">Cheikh Ahmadou Bamba Mbacké</span>,
                    ainsi que les grandes orientations de la tarîqa mouride.
                </p>

                <!-- Navigation des sections -->
                <div class="flex flex-wrap justify-center gap-4 mb-16">
                    <a href="#fondements" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-full font-medium transition-colors">
                        Fondements
                    </a>
                    <a href="#enseignements" class="bg-white hover:bg-teal-50 text-teal-800 border-2 border-teal-600 px-6 py-3 rounded-full font-medium transition-colors">
                        Enseignements
                    </a>
                    <a href="#pratiques" class="bg-white hover:bg-teal-50 text-teal-800 border-2 border-teal-600 px-6 py-3 rounded-full font-medium transition-colors">
                        Pratiques
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- Fondements Spirituels --}}
    <section id="fondements" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-teal-900 mb-6">
                    Fondements Spirituels
                </h2>
                <p class="text-xl text-teal-700 max-w-3xl mx-auto leading-relaxed">
                    Les piliers fondamentaux qui structurent la voie mouride et guident les disciples
                    dans leur cheminement spirituel vers l'excellence (Ihsân).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <!-- Tawhîd -->
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 12v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-teal-900 mb-4">Tawhîd</h3>
                    <p class="text-teal-700 leading-relaxed">
                        L'unicité divine comme fondement absolu. La reconnaissance de l'Unique
                        guide vers la purification de l'âme et l'élévation spirituelle.
                    </p>
                </div>

                <!-- Tarbiyya -->
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-teal-900 mb-4">Tarbiyya</h3>
                    <p class="text-teal-700 leading-relaxed">
                        L'éducation spirituelle progressive qui façonne le caractère du disciple
                        selon les nobles enseignements prophétiques.
                    </p>
                </div>

                <!-- Khidma -->
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-teal-900 mb-4">Khidma</h3>
                    <p class="text-teal-700 leading-relaxed">
                        Le service désintéressé comme moyen de purification et d'élévation,
                        incarnant l'amour et la dévotion envers le Cheikh et la communauté.
                    </p>
                </div>

                <!-- Wird -->
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-teal-900 mb-4">Wird</h3>
                    <p class="text-teal-700 leading-relaxed">
                        La pratique régulière du dhikr et des oraisons révélées,
                        créant une connexion permanente avec le Divin.
                    </p>
                </div>

                <!-- Adab -->
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-teal-900 mb-4">Adab</h3>
                    <p class="text-teal-700 leading-relaxed">
                        L'excellence du comportement et de l'étiquette spirituelle,
                        reflétant la beauté intérieure du disciple bien éduqué.
                    </p>
                </div>

                <!-- Irshâd -->
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-teal-900 mb-4">Irshâd</h3>
                    <p class="text-teal-700 leading-relaxed">
                        La guidance spirituelle par la chaîne initiatique ininterrompue,
                        transmettant la lumière prophétique de génération en génération.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Citation inspirante --}}
    <section class="py-16 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <blockquote class="text-2xl md:text-3xl font-light leading-relaxed mb-8 italic">
                    "Le travail est un acte d'adoration quand il est accompli avec l'intention sincère
                    de plaire à Allah et de servir l'humanité."
                </blockquote>
                <footer class="text-xl">
                    <cite class="font-semibold">— Cheikh Ahmadou Bamba Mbacké</cite>
                </footer>
            </div>
        </div>
    </section>

    {{-- Enseignements Principaux --}}
    <section id="enseignements" class="py-20 bg-teal-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-teal-900 mb-6">
                    Enseignements Principaux
                </h2>
                <p class="text-xl text-teal-700 max-w-3xl mx-auto leading-relaxed">
                    Les grandes thématiques développées par Cheikh Ahmadou Bamba dans ses écrits
                    et enseignements oraux, formant un corpus spirituel complet.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- L'Éducation Spirituelle -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-teal-900">L'Éducation Spirituelle</h3>
                    </div>
                    <p class="text-teal-700 leading-relaxed mb-4">
                        Le Cheikh insiste sur l'importance de l'éducation de l'âme (tarbiyya) comme préalable
                        à toute élévation spirituelle. Cette éducation passe par la purification du cœur,
                        l'abandon des vices et l'acquisition des vertus prophétiques.
                    </p>
                    <ul class="text-teal-600 space-y-2">
                        <li>• Purification de l'âme (tazkiyya)</li>
                        <li>• Développement des vertus morales</li>
                        <li>• Maîtrise des passions (nafs)</li>
                        <li>• Cultivation de la patience et de la persévérance</li>
                    </ul>
                </div>

                <!-- Le Travail comme Adoration -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-teal-900">Le Travail comme Adoration</h3>
                    </div>
                    <p class="text-teal-700 leading-relaxed mb-4">
                        Révolution spirituelle majeure : le travail honnête est élevé au rang d'acte d'adoration.
                        Cette vision transforme l'activité économique en moyen de rapprochement divin,
                        réconciliant spiritualité et engagement worldly.
                    </p>
                    <ul class="text-teal-600 space-y-2">
                        <li>• Sanctification du travail honnête</li>
                        <li>• Indépendance économique et spirituelle</li>
                        <li>• Éthique des affaires islamique</li>
                        <li>• Contribution au bien-être communautaire</li>
                    </ul>
                </div>

                <!-- L'Amour du Prophète -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-teal-900">L'Amour du Prophète ﷺ</h3>
                    </div>
                    <p class="text-teal-700 leading-relaxed mb-4">
                        L'amour sincère et profond pour le Prophète Muhammad ﷺ constitue le cœur de la voie mouride.
                        Cet amour se manifeste par l'imitation de ses nobles qualités et l'invocation constante
                        sur sa personne bénie.
                    </p>
                    <ul class="text-teal-600 space-y-2">
                        <li>• Méditation sur la beauté prophétique</li>
                        <li>• Récitation intensive de salawât</li>
                        <li>• Imitation des qualités muhammadiyya</li>
                        <li>• Célébration du Mawlid</li>
                    </ul>
                </div>

                <!-- La Science et la Sagesse -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-teal-900">La Science et la Sagesse</h3>
                    </div>
                    <p class="text-teal-700 leading-relaxed mb-4">
                        Cheikh Ahmadou Bamba prône la recherche constante de la connaissance,
                        alliant sciences religieuses et sagesse spirituelle. L'ignorance est considérée
                        comme le plus grand obstacle à l'épanouissement humain.
                    </p>
                    <ul class="text-teal-600 space-y-2">
                        <li>• Quête permanente de la connaissance</li>
                        <li>• Équilibre entre sciences et spiritualité</li>
                        <li>• Transmission du savoir aux générations</li>
                        <li>• Sagesse pratique dans la vie quotidienne</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Publications Philosophiques --}}
    @if($philosophyPublications->count() > 0)
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-teal-900 mb-6">
                    Publications sur la Philosophie Mouride
                </h2>
                <p class="text-xl text-teal-700 max-w-3xl mx-auto leading-relaxed">
                    Approfondissez votre compréhension à travers nos articles spécialisés
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($philosophyPublications as $publication)
                <article class="bg-white border border-teal-100 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    @if($publication->getFirstMediaUrl('featured_image'))
                    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $publication->getFirstMediaUrl('featured_image') }}')"></div>
                    @else
                    <div class="h-48 bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    @endif
                      <div class="p-6">
                        <h3 class="text-xl font-semibold text-teal-900 mb-3 line-clamp-2">
                            {{ $publication->getLocalizedTitle() }}
                        </h3>

                        @if($publication->getLocalizedExcerpt())
                        <p class="text-teal-700 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($publication->getLocalizedExcerpt()), 120) }}
                        </p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-teal-600 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $publication->author->name }}
                            </div>
                            @if($publication->reading_time)
                            <span>{{ $publication->reading_time }} min</span>
                            @endif
                        </div>

                        <a href="{{ route('publications.show', $publication->slug) }}"
                           class="inline-flex items-center text-teal-600 hover:text-teal-800 font-medium">
                            Lire l'article
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('writing') }}?category=philosophy"
                   class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                    Voir tous les articles philosophiques
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Pratiques Spirituelles --}}
    <section id="pratiques" class="py-20 bg-teal-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-teal-900 mb-6">
                    Pratiques Spirituelles
                </h2>
                <p class="text-xl text-teal-700 max-w-3xl mx-auto leading-relaxed">
                    Les pratiques concrètes enseignées par Cheikh Ahmadou Bamba pour
                    l'élévation spirituelle et le rapprochement divin.
                </p>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Wird quotidien -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-teal-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Wird Quotidien
                        </h3>
                        <p class="text-teal-700 mb-4">
                            Récitation régulière des litanies révélées par le Cheikh, créant un lien constant
                            avec le Divin et purifiant le cœur du disciple.
                        </p>
                        <ul class="text-teal-600 space-y-2">
                            <li>• Wird du matin (après Fajr)</li>
                            <li>• Wird du soir (après Maghrib)</li>
                            <li>• Dhikr pendant les activités</li>
                            <li>• Méditation sur les Noms divins</li>
                        </ul>
                    </div>

                    <!-- Jeûne spirituel -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-teal-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            Jeûne Spirituel
                        </h3>
                        <p class="text-teal-700 mb-4">
                            Au-delà du jeûne obligatoire, pratique du jeûne surérogatoire comme moyen
                            de purification et d'élévation spirituelle.
                        </p>
                        <ul class="text-teal-600 space-y-2">
                            <li>• Jeûne des lundis et jeudis</li>
                            <li>• Jeûne des jours blancs</li>
                            <li>• Jeûne de purification (tawba)</li>
                            <li>• Jeûne de gratitude (shukr)</li>
                        </ul>
                    </div>

                    <!-- Étude et enseignement -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-teal-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Étude et Enseignement
                        </h3>
                        <p class="text-teal-700 mb-4">
                            L'acquisition et la transmission de la connaissance comme actes d'adoration,
                            contribuant à l'élévation personnelle et communautaire.
                        </p>
                        <ul class="text-teal-600 space-y-2">
                            <li>• Étude des sciences islamiques</li>
                            <li>• Mémorisation du Coran</li>
                            <li>• Cercles d'enseignement (halaqât)</li>
                            <li>• Formation des cadres religieux</li>
                        </ul>
                    </div>

                    <!-- Service communautaire -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold text-teal-900 mb-6 flex items-center">
                            <svg class="w-8 h-8 text-teal-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Service Communautaire
                        </h3>
                        <p class="text-teal-700 mb-4">
                            Engagement actif au service de la communauté comme expression concrète
                            de l'amour divin et prophétique.
                        </p>
                        <ul class="text-teal-600 space-y-2">
                            <li>• Aide aux nécessiteux</li>
                            <li>• Participation aux projets collectifs</li>
                            <li>• Entraide et solidarité</li>
                            <li>• Développement socio-économique</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-20 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">
                Approfondissez Votre Compréhension
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-3xl mx-auto">
                Explorez nos ressources pour approfondir votre connaissance de la philosophie mouride
                et de ses applications pratiques dans la vie moderne.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('writing') }}"
                   class="bg-white text-teal-600 hover:bg-teal-50 px-8 py-4 rounded-full font-semibold transition-colors">
                    Lire les Publications
                </a>
                <a href="{{ route('biography') }}"
                   class="border-2 border-white text-white hover:bg-white hover:text-teal-600 px-8 py-4 rounded-full font-semibold transition-colors">
                    Explorer la Bibliographie
                </a>
                <a href="{{ route('testimonials') }}"
                   class="border-2 border-white text-white hover:bg-white hover:text-teal-600 px-8 py-4 rounded-full font-semibold transition-colors">
                    Lire les Témoignages
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
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

    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

