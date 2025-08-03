{{-- Composant Modal --}}
@props([
    'id' => 'modal',
    'title' => '',
    'size' => 'md', // sm, md, lg, xl, full
    'closeOnBackdrop' => true,
    'showCloseButton' => true
])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-7xl'
    ];

    $modalSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div id="{{ $id }}" class="modal fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div class="modal-backdrop absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300"></div>

    {{-- Modal Container --}}
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="modal-content relative bg-white rounded-2xl shadow-elegant {{ $modalSize }} w-full max-h-[90vh] overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
            {{-- Header --}}
            @if($title || $showCloseButton)
                <div class="flex items-center justify-between p-6 border-b border-neutral-200">
                    @if($title)
                        <h2 class="text-xl font-elegant font-semibold text-accent-900">
                            {{ $title }}
                        </h2>
                    @else
                        <div></div>
                    @endif

                    @if($showCloseButton)
                        <button class="modal-close p-2 rounded-full hover:bg-neutral-100 transition-colors group">
                            <svg class="w-5 h-5 text-accent-500 group-hover:text-accent-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            @endif

            {{-- Content --}}
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                {{ $slot }}
            </div>

            {{-- Footer (optionnel) --}}
            @if(isset($footer))
                <div class="flex items-center justify-end space-x-4 p-6 border-t border-neutral-200 bg-neutral-50">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>

@once
    @push('styles')
    <style>
        .modal.flex .modal-content {
            opacity: 1;
            transform: scale(1);
        }

        .modal-enter {
            animation: modal-enter 0.3s ease-out;
        }

        .modal-leave {
            animation: modal-leave 0.3s ease-in;
        }

        @keyframes modal-enter {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes modal-leave {
            from {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            to {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
        }
    </style>
    @endpush
@endonce

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le modal
        new Modal('{{ $id }}');

        // Fonction globale pour ouvrir le modal
        window.openModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';

                // Animation d'entrée
                setTimeout(() => {
                    const content = modal.querySelector('.modal-content');
                    if (content) {
                        content.classList.add('modal-enter');
                    }
                }, 10);
            }
        };

        // Fonction globale pour fermer le modal
        window.closeModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                const content = modal.querySelector('.modal-content');
                if (content) {
                    content.classList.add('modal-leave');
                }

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = '';

                    if (content) {
                        content.classList.remove('modal-enter', 'modal-leave');
                    }
                }, 300);
            }
        };
    });
</script>
@endpush
