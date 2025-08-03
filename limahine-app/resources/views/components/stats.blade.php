{{-- Composant Stats --}}
@props([
    'title' => 'Nos Réalisations',
    'subtitle' => 'En chiffres',
    'description' => '',
    'stats' => []
])

<x-section
    :title="$title"
    :subtitle="$subtitle"
    :description="$description"
    background="gradient"
>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($stats as $stat)
            <div class="text-center animate-on-scroll group">
                <div class="relative inline-block mb-4">
                    {{-- Cercle de fond avec gradient --}}
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-primary-400 to-secondary-400 rounded-full flex items-center justify-center shadow-golden group-hover:shadow-glow transition-all duration-500 group-hover:scale-110">
                        {{-- Icône si fournie --}}
                        @if(isset($stat['icon']))
                            <div class="text-white">
                                {!! $stat['icon'] !!}
                            </div>
                        @else
                            {{-- Nombre animé --}}
                            <span class="counter text-2xl font-bold text-white" data-target="{{ $stat['value'] ?? 0 }}">
                                0
                            </span>
                            @if(isset($stat['suffix']))
                                <span class="text-white text-xl">{{ $stat['suffix'] }}</span>
                            @endif
                        @endif
                    </div>

                    {{-- Effet de particules --}}
                    <div class="absolute -top-2 -right-2 w-4 h-4 bg-primary-300 rounded-full opacity-70 animate-float"></div>
                    <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-secondary-300 rounded-full opacity-60 animate-float" style="animation-delay: 0.5s;"></div>
                </div>

                {{-- Valeur numérique (si pas d'icône) --}}
                @if(!isset($stat['icon']))
                    <div class="mb-2">
                        <span class="counter text-4xl font-bold text-accent-900" data-target="{{ $stat['value'] ?? 0 }}">
                            0
                        </span>
                        @if(isset($stat['suffix']))
                            <span class="text-2xl text-primary-600 font-semibold">{{ $stat['suffix'] }}</span>
                        @endif
                    </div>
                @endif

                {{-- Titre et description --}}
                <h3 class="text-lg font-elegant font-semibold text-accent-900 mb-2">
                    {{ $stat['title'] ?? 'Statistique' }}
                </h3>

                @if(isset($stat['description']))
                    <p class="text-accent-700 text-sm leading-relaxed">
                        {{ $stat['description'] }}
                    </p>
                @endif

                {{-- Barre de progression (optionnelle) --}}
                @if(isset($stat['progress']))
                    <div class="mt-4">
                        <div class="w-full bg-neutral-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-2 rounded-full transition-all duration-1000 ease-out progress-bar"
                                 data-progress="{{ $stat['progress'] }}"
                                 style="width: 0%">
                            </div>
                        </div>
                        <span class="text-xs text-accent-600 mt-1 block">{{ $stat['progress'] }}%</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Ligne décorative --}}
    <div class="mt-16 text-center">
        <div class="divider-golden mb-8"></div>
        <p class="text-accent-600 font-medium">
            {{ $slot ?? 'Ces chiffres reflètent notre engagement constant vers l\'excellence.' }}
        </p>
    </div>
</x-section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des compteurs
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16); // 60 FPS

            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }

            updateCounter();
        }

        // Animation des barres de progression
        function animateProgressBar(element, targetProgress) {
            setTimeout(() => {
                element.style.width = targetProgress + '%';
            }, 500);
        }

        // Observer pour déclencher les animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animer les compteurs
                    const counters = entry.target.querySelectorAll('.counter');
                    counters.forEach(counter => {
                        const target = parseInt(counter.dataset.target);
                        animateCounter(counter, target);
                    });

                    // Animer les barres de progression
                    const progressBars = entry.target.querySelectorAll('.progress-bar');
                    progressBars.forEach(bar => {
                        const progress = parseInt(bar.dataset.progress);
                        animateProgressBar(bar, progress);
                    });

                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        // Observer la section des statistiques
        const statsSection = document.querySelector('.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4');
        if (statsSection) {
            observer.observe(statsSection);
        }
    });
</script>
@endpush

