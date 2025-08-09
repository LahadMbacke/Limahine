{{-- Composant Hero Section --}}
@props([
    'title' => 'Titre par défaut',
    'subtitle' => '',
    'description' => '',
    'image' => null,
    'ctaText' => 'En savoir plus',
    'ctaLink' => '#',
    'background' => 'gradient'
])

<section class="section-hero">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 bg-gradient-to-br from-primary-50/50 via-white to-secondary-50/50"></div>
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-primary-400 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-secondary-400 rounded-full blur-3xl animate-float" style="animation-delay: 1s;"></div>
    </div>

    <div class="container-custom relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Content --}}
            <div class="text-center lg:text-left animate-slide-up">
                @if($subtitle)
                    <p class="text-primary-600 font-medium mb-4 uppercase tracking-wide text-sm">{{ $subtitle }}</p>
                @endif

                <h1 class="font-elegant font-bold text-accent-900 mb-6 leading-tight">
                    {!! $title !!}
                </h1>

                @if($description)
                    <p class="text-xl text-accent-700 mb-8 leading-relaxed max-w-2xl">
                        {{ $description }}
                    </p>
                @endif

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ $ctaLink }}" class="btn-primary group">
                        {{ $ctaText }}
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>

                    @if(isset($secondaryCta))
                        <a href="{{ $secondaryCta['link'] ?? '#' }}" class="btn-outline">
                            {{ $secondaryCta['text'] ?? 'Découvrir' }}
                        </a>
                    @endif
                </div>
            </div>

            {{-- Image/Visual --}}
            @if($image)
                <div class="relative">
                    <div class="relative z-10 animate-fade-in" style="animation-delay: 0.3s;">
                        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto rounded-2xl shadow-elegant hover-lift">
                    </div>

                    {{-- Decorative elements --}}
                    <div class="absolute -top-6 -right-6 w-24 h-24 bg-primary-200 rounded-full opacity-50 blur-xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-secondary-200 rounded-full opacity-50 blur-xl"></div>
                </div>
            @else
                <div class="relative flex items-center justify-center h-96">
                    {{-- Logo or Default Visual --}}
                    <div class="text-center animate-scale-in" style="animation-delay: 0.3s;">
                        <div class="w-48 h-48 mx-auto mb-6 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-full flex items-center justify-center shadow-golden hover:shadow-glow transition-all duration-500 hover:scale-105">
                            <img src="{{ asset('assets/unnamed.jpg') }}" alt="Limahine" class="w-32 h-32 rounded-full">
                        </div>
                        <div class="flex justify-center space-x-4">
                            <div class="w-16 h-1 bg-primary-400 rounded-full"></div>
                            <div class="w-8 h-1 bg-secondary-400 rounded-full"></div>
                            <div class="w-12 h-1 bg-primary-300 rounded-full"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

