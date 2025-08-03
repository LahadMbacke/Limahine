// Composants JavaScript pour Limahine App
// Gestion des interactions utilisateur et animations

// Initialisation de l'application
export function initApp() {
    console.log('🕌 Initialisation de Limahine App...');

    // Initialiser tous les composants
    initLanguageSelector();
    initMobileMenu();
    initScrollEffects();
    initSearchFilters();
    initAnimations();
    initFormValidation();
    initTooltips();
    initModalSystem();

    console.log('✅ Limahine App initialisée avec succès');
}

// Gestion du sélecteur de langue
function initLanguageSelector() {
    const languageButton = document.getElementById('language-button');
    const languageDropdown = document.getElementById('language-dropdown');

    if (languageButton && languageDropdown) {
        languageButton.addEventListener('click', (e) => {
            e.stopPropagation();
            languageDropdown.classList.toggle('hidden');
        });

        // Fermer le dropdown quand on clique ailleurs
        document.addEventListener('click', () => {
            languageDropdown.classList.add('hidden');
        });
    }
}

// Gestion du menu mobile
function initMobileMenu() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');

            // Animation de l'icône hamburger
            const icon = mobileMenuButton.querySelector('svg');
            if (icon) {
                icon.style.transform = mobileMenu.classList.contains('hidden')
                    ? 'rotate(0deg)'
                    : 'rotate(90deg)';
            }
        });

        // Fermer le menu mobile lors du redimensionnement
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
}

// Effets de scroll
function initScrollEffects() {
    let ticking = false;

    function updateScrollEffects() {
        const scrollY = window.scrollY;
        const header = document.querySelector('header');

        if (header) {
            if (scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }

        // Parallax pour les éléments hero
        const heroElements = document.querySelectorAll('.hero-parallax');
        heroElements.forEach(el => {
            const speed = el.dataset.speed || 0.5;
            const yPos = -(scrollY * speed);
            el.style.transform = `translateY(${yPos}px)`;
        });

        // Animation d'apparition des éléments
        const animateElements = document.querySelectorAll('.animate-on-scroll');
        animateElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

            if (isVisible && !el.classList.contains('animated')) {
                el.classList.add('animated', 'fade-in');
            }
        });

        ticking = false;
    }

    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(updateScrollEffects);
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
}

// Gestion des filtres de recherche
function initSearchFilters() {
    // Filtres de catégorie
    const categoryFilters = document.querySelectorAll('.category-filter');
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', () => {
            // Retirer la classe active de tous les filtres
            categoryFilters.forEach(f => f.classList.remove('active'));
            // Ajouter la classe active au filtre cliqué
            filter.classList.add('active');

            // Déclencher la recherche
            const category = filter.dataset.category;
            filterContent(category, 'category');
        });
    });

    // Recherche en temps réel
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const query = e.target.value;
                filterContent(query, 'search');
            }, 300);
        });
    });
}

// Fonction de filtrage du contenu
function filterContent(value, type) {
    const url = new URL(window.location);

    if (value && value !== 'all') {
        url.searchParams.set(type, value);
    } else {
        url.searchParams.delete(type);
    }

    // Recharger la page avec les nouveaux paramètres
    window.location.href = url.toString();
}

// Animations et transitions
function initAnimations() {
    // Observer pour les animations d'entrée
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const animationType = element.dataset.animation || 'fade-in';
                const delay = element.dataset.delay || 0;

                setTimeout(() => {
                    element.classList.add('animate', animationType);
                }, delay);

                observer.unobserve(element);
            }
        });
    }, observerOptions);

    // Observer tous les éléments avec l'attribut data-animation
    document.querySelectorAll('[data-animation]').forEach(el => {
        observer.observe(el);
    });
}

// Validation de formulaires
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            if (validateForm(form)) {
                // Soumettre le formulaire si valide
                form.submit();
            }
        });

        // Validation en temps réel
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => clearFieldError(input));
        });
    });
}

function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });

    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = '';

    // Validation requis
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Ce champ est requis';
    }

    // Validation email
    else if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
            errorMessage = 'Veuillez entrer un email valide';
        }
    }

    // Validation longueur minimale
    else if (field.hasAttribute('minlength')) {
        const minLength = parseInt(field.getAttribute('minlength'));
        if (value.length < minLength) {
            isValid = false;
            errorMessage = `Minimum ${minLength} caractères requis`;
        }
    }

    // Afficher ou masquer l'erreur
    showFieldError(field, isValid ? '' : errorMessage);

    return isValid;
}

function showFieldError(field, message) {
    const errorElement = field.parentNode.querySelector('.field-error');

    if (message) {
        field.classList.add('border-red-500');
        field.classList.remove('border-neutral-300');

        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        } else {
            const error = document.createElement('div');
            error.className = 'field-error text-red-500 text-sm mt-1';
            error.textContent = message;
            field.parentNode.appendChild(error);
        }
    } else {
        clearFieldError(field);
    }
}

function clearFieldError(field) {
    field.classList.remove('border-red-500');
    field.classList.add('border-neutral-300');

    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.classList.add('hidden');
    }
}

// Système de tooltips
function initTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');

    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(e) {
    const element = e.target;
    const text = element.dataset.tooltip;

    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip bg-accent-900 text-white px-2 py-1 rounded text-sm absolute z-50 pointer-events-none';
    tooltip.textContent = text;
    tooltip.id = 'tooltip';

    document.body.appendChild(tooltip);

    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

function hideTooltip() {
    const tooltip = document.getElementById('tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

// Système de modales
function initModalSystem() {
    // Ouvrir les modales
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-modal-target]');
        if (trigger) {
            e.preventDefault();
            const modalId = trigger.dataset.modalTarget;
            openModal(modalId);
        }

        // Fermer les modales
        const closeButton = e.target.closest('[data-modal-close]');
        if (closeButton) {
            const modal = closeButton.closest('.modal');
            if (modal) {
                closeModal(modal.id);
            }
        }
    });

    // Fermer avec Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal:not(.hidden)');
            if (openModal) {
                closeModal(openModal.id);
            }
        }
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Animation d'entrée
        requestAnimationFrame(() => {
            modal.classList.add('opacity-100');
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.classList.add('scale-100');
            }
        });
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('opacity-100');
        const content = modal.querySelector('.modal-content');
        if (content) {
            content.classList.remove('scale-100');
        }

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    }
}

// Changement de langue
window.switchLanguage = function(locale) {
    fetch('/language/switch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ locale })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Erreur lors du changement de langue:', error);
    });
}

// Classes exportées pour utilisation externe
export class Modal {
    static open(modalId) {
        openModal(modalId);
    }

    static close(modalId) {
        closeModal(modalId);
    }
}

export class Toast {
    static show(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full`;

        // Couleurs selon le type
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-black',
            info: 'bg-blue-500 text-white'
        };

        toast.className += ` ${colors[type] || colors.info}`;
        toast.textContent = message;

        document.body.appendChild(toast);

        // Animation d'entrée
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
        });

        // Auto-suppression
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }
}

export class FormHandler {
    static async submit(form, options = {}) {
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (result.success) {
                Toast.show(result.message || 'Succès !', 'success');
                if (options.onSuccess) options.onSuccess(result);
            } else {
                Toast.show(result.message || 'Une erreur est survenue', 'error');
                if (options.onError) options.onError(result);
            }

            return result;
        } catch (error) {
            Toast.show('Erreur de connexion', 'error');
            if (options.onError) options.onError(error);
            throw error;
        }
    }
}
