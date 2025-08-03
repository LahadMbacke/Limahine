{{-- Composant Loader --}}
@props([
    'size' => 'md', // sm, md, lg
    'color' => 'primary',
    'text' => null,
    'overlay' => false
])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12'
    ];

    $colorClasses = [
        'primary' => 'text-primary-500',
        'secondary' => 'text-secondary-500',
        'white' => 'text-white',
        'accent' => 'text-accent-500'
    ];

    $loaderSize = $sizeClasses[$size] ?? $sizeClasses['md'];
    $loaderColor = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

@if($overlay)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 shadow-elegant">
@endif

<div class="flex flex-col items-center justify-center space-y-4">
    {{-- Spinner animé --}}
    <div class="relative {{ $loaderSize }}">
        <div class="absolute inset-0 border-4 border-neutral-200 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-transparent border-t-current rounded-full animate-spin {{ $loaderColor }}"></div>
    </div>

    {{-- Logo central (optionnel) --}}
    @if($size === 'lg')
        <div class="absolute inset-0 flex items-center justify-center">
            <img src="{{ asset('assets/unnamed.jpg') }}" alt="Limahine" class="w-6 h-6 rounded-full opacity-50">
        </div>
    @endif

    {{-- Texte de chargement --}}
    @if($text)
        <p class="text-sm font-medium {{ $overlay ? 'text-accent-700' : $loaderColor }}">
            {{ $text }}
        </p>
    @endif
</div>

@if($overlay)
        </div>
    </div>
@endif

{{-- Styles pour l'animation personnalisée --}}
@once
    @push('styles')
    <style>
        .loader-pulse {
            animation: loader-pulse 1.5s ease-in-out infinite;
        }

        @keyframes loader-pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(1.05);
            }
        }

        .loader-dots::after {
            content: '';
            animation: loader-dots 1.5s infinite;
        }

        @keyframes loader-dots {
            0%, 20% {
                content: '';
            }
            40% {
                content: '.';
            }
            60% {
                content: '..';
            }
            80%, 100% {
                content: '...';
            }
        }
    </style>
    @endpush
@endonce
