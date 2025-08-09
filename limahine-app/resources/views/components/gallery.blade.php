{{-- Composant Gallery/Carousel --}}
@props([
    'images' => [],
    'title' => '',
    'autoplay' => false,
    'interval' => 5000,
    'showThumbnails' => true,
    'showIndicators' => true
])

<div class="gallery-carousel relative" data-autoplay="{{ $autoplay ? 'true' : 'false' }}" data-interval="{{ $interval }}">
    @if($title)
        <h3 class="text-xl font-elegant font-semibold text-accent-900 mb-6 text-center">{{ $title }}</h3>
    @endif

    {{-- Main Image Container --}}
    <div class="relative overflow-hidden rounded-2xl shadow-elegant group">
        <div class="carousel-container flex transition-transform duration-500 ease-in-out">
            @foreach($images as $index => $image)
                <div class="carousel-slide flex-shrink-0 w-full relative">
                    <img src="{{ $image['url'] ?? $image }}"
                         alt="{{ $image['alt'] ?? 'Image ' . ($index + 1) }}"
                         class="w-full h-96 object-cover">

                    {{-- Overlay avec informations --}}
                    @if(isset($image['title']) || isset($image['description']))
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end">
                            <div class="p-6 text-white">
                                @if(isset($image['title']))
                                    <h4 class="text-lg font-semibold mb-2">{{ $image['title'] }}</h4>
                                @endif
                                @if(isset($image['description']))
                                    <p class="text-sm opacity-90">{{ $image['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Navigation Arrows --}}
        @if(count($images) > 1)
            <button class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center text-accent-700 hover:bg-white hover:text-primary-600 transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center text-accent-700 hover:bg-white hover:text-primary-600 transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        @endif

        {{-- Indicateurs --}}
        @if($showIndicators && count($images) > 1)
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                @foreach($images as $index => $image)
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300 {{ $index === 0 ? 'bg-white' : '' }}"
                            data-slide="{{ $index }}">
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Pause/Play Button (pour autoplay) --}}
        @if($autoplay)
            <button class="carousel-play-pause absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center text-accent-700 hover:bg-white transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="play-icon w-4 h-4 hidden" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
                <svg class="pause-icon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6"></path>
                </svg>
            </button>
        @endif
    </div>

    {{-- Thumbnails --}}
    @if($showThumbnails && count($images) > 1)
        <div class="flex space-x-3 mt-4 overflow-x-auto scrollbar-hide">
            @foreach($images as $index => $image)
                <button class="carousel-thumb flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 transition-all duration-300 {{ $index === 0 ? 'border-primary-500' : 'border-transparent hover:border-primary-300' }}"
                        data-slide="{{ $index }}">
                    <img src="{{ $image['url'] ?? $image }}"
                         alt="{{ $image['alt'] ?? 'Thumbnail ' . ($index + 1) }}"
                         class="w-full h-full object-cover">
                </button>
            @endforeach
        </div>
    @endif

    {{-- Modal pour vue agrandie --}}
    <x-modal id="gallery-modal-{{ $id ?? 'default' }}" size="xl" title="Galerie">
        <div class="text-center">
            <img id="modal-image" src="" alt="" class="max-w-full h-auto rounded-lg shadow-lg">
            <div id="modal-info" class="mt-4 text-left"></div>
        </div>

        <x-slot name="footer">
            <button onclick="closeModal('gallery-modal-{{ $id ?? 'default' }}')" class="btn-secondary">
                Fermer
            </button>
        </x-slot>
    </x-modal>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const galleries = document.querySelectorAll('.gallery-carousel');

        galleries.forEach(gallery => {
            const container = gallery.querySelector('.carousel-container');
            const slides = gallery.querySelectorAll('.carousel-slide');
            const prevBtn = gallery.querySelector('.carousel-prev');
            const nextBtn = gallery.querySelector('.carousel-next');
            const indicators = gallery.querySelectorAll('.carousel-indicator');
            const thumbnails = gallery.querySelectorAll('.carousel-thumb');
            const playPauseBtn = gallery.querySelector('.carousel-play-pause');

            let currentSlide = 0;
            let isPlaying = gallery.dataset.autoplay === 'true';
            let autoplayTimer;

            // Fonction pour aller à un slide spécifique
            function goToSlide(index) {
                currentSlide = index;
                const offset = -index * 100;
                container.style.transform = `translateX(${offset}%)`;

                // Mettre à jour les indicateurs
                indicators.forEach((indicator, i) => {
                    indicator.classList.toggle('bg-white', i === index);
                    indicator.classList.toggle('bg-white/50', i !== index);
                });

                // Mettre à jour les thumbnails
                thumbnails.forEach((thumb, i) => {
                    thumb.classList.toggle('border-primary-500', i === index);
                    thumb.classList.toggle('border-transparent', i !== index);
                });
            }

            // Navigation précédent/suivant
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    currentSlide = currentSlide > 0 ? currentSlide - 1 : slides.length - 1;
                    goToSlide(currentSlide);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    currentSlide = currentSlide < slides.length - 1 ? currentSlide + 1 : 0;
                    goToSlide(currentSlide);
                });
            }

            // Indicateurs
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToSlide(index);
                });
            });

            // Thumbnails
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    goToSlide(index);
                });
            });

            // Autoplay
            function startAutoplay() {
                if (isPlaying && slides.length > 1) {
                    autoplayTimer = setInterval(() => {
                        currentSlide = currentSlide < slides.length - 1 ? currentSlide + 1 : 0;
                        goToSlide(currentSlide);
                    }, parseInt(gallery.dataset.interval));
                }
            }

            function stopAutoplay() {
                clearInterval(autoplayTimer);
            }

            function toggleAutoplay() {
                isPlaying = !isPlaying;
                if (isPlaying) {
                    startAutoplay();
                    playPauseBtn.querySelector('.play-icon').classList.add('hidden');
                    playPauseBtn.querySelector('.pause-icon').classList.remove('hidden');
                } else {
                    stopAutoplay();
                    playPauseBtn.querySelector('.play-icon').classList.remove('hidden');
                    playPauseBtn.querySelector('.pause-icon').classList.add('hidden');
                }
            }

            if (playPauseBtn) {
                playPauseBtn.addEventListener('click', toggleAutoplay);
            }

            // Pause on hover
            gallery.addEventListener('mouseenter', stopAutoplay);
            gallery.addEventListener('mouseleave', () => {
                if (isPlaying) startAutoplay();
            });

            // Navigation au clavier
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft' && prevBtn) {
                    prevBtn.click();
                } else if (e.key === 'ArrowRight' && nextBtn) {
                    nextBtn.click();
                }
            });

            // Clic sur image pour vue agrandie
            slides.forEach((slide, index) => {
                slide.addEventListener('click', () => {
                    const img = slide.querySelector('img');
                    const modalImg = document.getElementById('modal-image');
                    const modalInfo = document.getElementById('modal-info');

                    if (modalImg && img) {
                        modalImg.src = img.src;
                        modalImg.alt = img.alt;

                        // Ajouter les informations si disponibles
                        const title = slide.querySelector('h4');
                        const description = slide.querySelector('p');

                        if (modalInfo) {
                            modalInfo.innerHTML = '';
                            if (title) {
                                modalInfo.innerHTML += `<h4 class="font-semibold text-lg mb-2">${title.textContent}</h4>`;
                            }
                            if (description) {
                                modalInfo.innerHTML += `<p class="text-accent-700">${description.textContent}</p>`;
                            }
                        }

                        openModal('gallery-modal-{{ $id ?? "default" }}');
                    }
                });
            });

            // Démarrer l'autoplay si activé
            if (isPlaying) {
                startAutoplay();
            }
        });
    });
</script>
@endpush

