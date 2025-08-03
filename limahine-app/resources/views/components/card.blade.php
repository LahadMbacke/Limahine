{{-- Composant Card --}}
@props([
    'title' => '',
    'description' => '',
    'image' => null,
    'link' => null,
    'featured' => false,
    'icon' => null,
    'date' => null,
    'category' => null
])

<div class="{{ $featured ? 'card-featured' : 'card' }} hover-lift animate-on-scroll">
    {{-- Image --}}
    @if($image)
        <div class="relative mb-6 -m-6 mb-6">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover rounded-t-2xl">

            @if($category)
                <div class="absolute top-4 left-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-500 text-white">
                        {{ $category }}
                    </span>
                </div>
            @endif

            @if($date)
                <div class="absolute bottom-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 text-accent-700">
                        {{ $date }}
                    </span>
                </div>
            @endif
        </div>
    @endif

    {{-- Icon --}}
    @if($icon && !$image)
        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-primary-400 to-secondary-400 rounded-xl mb-6 shadow-golden">
            {!! $icon !!}
        </div>
    @endif

    {{-- Content --}}
    <div class="{{ $image ? 'p-6 -mt-6' : '' }}">
        @if($title)
            <h3 class="font-elegant font-semibold text-accent-900 mb-3 {{ $image ? 'text-xl' : 'text-lg' }}">
                @if($link)
                    <a href="{{ $link }}" class="hover:text-primary-600 transition-colors">
                        {{ $title }}
                    </a>
                @else
                    {{ $title }}
                @endif
            </h3>
        @endif

        @if($description)
            <p class="text-accent-700 leading-relaxed mb-4">
                {{ $description }}
            </p>
        @endif

        {{-- Slot pour contenu personnalisé --}}
        {{ $slot }}

        {{-- Lien de lecture --}}
        @if($link)
            <div class="flex items-center justify-between mt-6 pt-4 border-t border-neutral-200">
                <a href="{{ $link }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium transition-colors group">
                    Lire la suite
                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>

                @if($date)
                    <span class="text-sm text-neutral-500">{{ $date }}</span>
                @endif
            </div>
        @endif
    </div>
</div>
