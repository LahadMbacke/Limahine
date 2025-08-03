{{-- Composant Button --}}
@props([
    'type' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'iconPosition' => 'right',
    'loading' => false,
    'disabled' => false
])

@php
    $type = $type ?? 'primary';
    $size = $size ?? 'md';
    $iconPosition = $iconPosition ?? 'right';
    $loading = $loading ?? false;
    $disabled = $disabled ?? false;

    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-300 focus:outline-none focus:ring-4 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none';

    $typeClasses = [
        'primary' => 'text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 shadow-golden hover:shadow-glow focus:ring-primary-200',
        'secondary' => 'text-accent-800 bg-gradient-to-r from-secondary-100 to-secondary-200 hover:from-secondary-200 hover:to-secondary-300 shadow-brown border border-secondary-300 focus:ring-secondary-200',
        'outline' => 'text-primary-600 border-2 border-primary-500 bg-transparent hover:bg-primary-500 hover:text-white focus:ring-primary-200',
        'ghost' => 'text-accent-700 bg-transparent hover:bg-secondary-100 focus:ring-secondary-200'
    ];

    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg'
    ];

    $classes = $baseClasses . ' ' . ($typeClasses[$type] ?? $typeClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);

    $tag = $href ? 'a' : 'button';
    $tagAttributes = $href ? ['href' => $href] : ['type' => 'button'];

    if ($disabled) {
        $tagAttributes['disabled'] = true;
    }
@endphp

<{{ $tag }} class="{{ $classes }}" @foreach($tagAttributes as $key => $value) {{ $key }}="{{ $value }}" @endforeach {{ $attributes }}>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Chargement...
    @else
        @if($icon && $iconPosition === 'left')
            <span class="mr-2">
                {!! $icon !!}
            </span>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <span class="ml-2 group-hover:translate-x-1 transition-transform">
                {!! $icon !!}
            </span>
        @endif
    @endif
</{{ $tag }}>

