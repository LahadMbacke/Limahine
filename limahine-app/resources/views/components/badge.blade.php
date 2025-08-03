{{-- Composant Badge --}}
@props([
    'type' => 'primary',
    'size' => 'md',
    'variant' => 'solid',
    'icon' => null,
    'removable' => false,
    'class' => ''
])

@php
    $type = $type ?? 'primary';
    $size = $size ?? 'md';
    $variant = $variant ?? 'solid';
    $removable = $removable ?? false;
    $class = $class ?? '';

    $baseClasses = 'inline-flex items-center font-medium rounded-full transition-all duration-200';

    $sizeClasses = [
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-base'
    ];

    $typeClasses = [
        'primary' => [
            'solid' => 'bg-primary-500 text-white',
            'outline' => 'border-2 border-primary-500 text-primary-600 bg-transparent',
            'soft' => 'bg-primary-100 text-primary-700'
        ],
        'secondary' => [
            'solid' => 'bg-secondary-500 text-white',
            'outline' => 'border-2 border-secondary-500 text-secondary-600 bg-transparent',
            'soft' => 'bg-secondary-100 text-secondary-700'
        ],
        'success' => [
            'solid' => 'bg-green-500 text-white',
            'outline' => 'border-2 border-green-500 text-green-600 bg-transparent',
            'soft' => 'bg-green-100 text-green-700'
        ],
        'warning' => [
            'solid' => 'bg-yellow-500 text-white',
            'outline' => 'border-2 border-yellow-500 text-yellow-600 bg-transparent',
            'soft' => 'bg-yellow-100 text-yellow-700'
        ],
        'error' => [
            'solid' => 'bg-red-500 text-white',
            'outline' => 'border-2 border-red-500 text-red-600 bg-transparent',
            'soft' => 'bg-red-100 text-red-700'
        ],
        'info' => [
            'solid' => 'bg-blue-500 text-white',
            'outline' => 'border-2 border-blue-500 text-blue-600 bg-transparent',
            'soft' => 'bg-blue-100 text-blue-700'
        ]
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $typeClass = isset($typeClasses[$type][$variant]) ? $typeClasses[$type][$variant] : $typeClasses['primary']['solid'];
    $additionalClass = $class ?? '';
    $classes = trim($baseClasses . ' ' . $sizeClass . ' ' . $typeClass . ' ' . $additionalClass);
@endphp

<span class="{{ $classes }} group">
    @if($icon)
        <span class="mr-1.5 {{ $size === 'sm' ? 'w-3 h-3' : ($size === 'lg' ? 'w-5 h-5' : 'w-4 h-4') }}">
            {!! $icon !!}
        </span>
    @endif

    {{ $slot }}

    @if($removable)
        <button class="ml-1.5 hover:opacity-70 transition-opacity" onclick="this.parentElement.remove()">
            <svg class="{{ $size === 'sm' ? 'w-3 h-3' : ($size === 'lg' ? 'w-5 h-5' : 'w-4 h-4') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    @endif
</span>
