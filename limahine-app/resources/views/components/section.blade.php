{{-- Composant Section --}}
@props([
    'title' => '',
    'subtitle' => '',
    'description' => '',
    'background' => 'white', // white, dark, gradient
    'centered' => true,
    'paddingY' => 'normal' // small, normal, large
])

@php
    $backgroundClasses = [
        'white' => 'bg-white',
        'dark' => 'section-dark',
        'gradient' => 'bg-gradient-to-br from-primary-50 via-white to-secondary-50',
        'light' => 'bg-neutral-50'
    ];

    $paddingClasses = [
        'small' => 'py-12 md:py-16',
        'normal' => 'section',
        'large' => 'py-24 md:py-32 lg:py-40'
    ];

    $bgClass = $backgroundClasses[$background] ?? $backgroundClasses['white'];
    $paddingClass = $paddingClasses[$paddingY] ?? $paddingClasses['normal'];
    $textColorClass = $background === 'dark' ? 'text-white' : 'text-accent-900';
@endphp

<section class="{{ $bgClass }} {{ $paddingClass }} relative overflow-hidden">
    {{-- Background Decoration --}}
    @if($background === 'gradient')
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-32 h-32 bg-primary-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-48 h-48 bg-secondary-400 rounded-full blur-3xl"></div>
        </div>
    @endif

    <div class="container-custom relative z-10">
        {{-- Header --}}
        @if($title || $subtitle || $description)
            <div class="{{ $centered ? 'text-center' : '' }} mb-12 md:mb-16">
                @if($subtitle)
                    <p class="text-primary-600 font-medium mb-4 uppercase tracking-wide text-sm animate-on-scroll">
                        {{ $subtitle }}
                    </p>
                @endif

                @if($title)
                    <h2 class="font-elegant font-bold {{ $textColorClass }} mb-6 decoration-line animate-on-scroll">
                        {!! $title !!}
                    </h2>
                @endif

                @if($description)
                    <p class="text-xl {{ $background === 'dark' ? 'text-neutral-300' : 'text-accent-700' }} leading-relaxed {{ $centered ? 'max-w-3xl mx-auto' : 'max-w-2xl' }} animate-on-scroll">
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Content --}}
        <div class="animate-on-scroll">
            {{ $slot }}
        </div>
    </div>
</section>

