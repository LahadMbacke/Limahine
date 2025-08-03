/**
 * Système de composants JavaScript pour Limahine App
 * Interactions et animations personnalisées
 */

// Gestion des animations d'apparition
export function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer les éléments avec la classe .animate-on-scroll
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

// Système de navigation fluide
export function initSmoothNavigation() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Gestion du header sticky avec effet de transparence
export function initStickyHeader() {
    const header = document.querySelector('header, .navbar');
    if (!header) return;

    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > 100) {
            header.classList.add('glass-effect', 'shadow-lg');
            header.classList.remove('bg-transparent');
        } else {
            header.classList.remove('glass-effect', 'shadow-lg');
            header.classList.add('bg-transparent');
        }

        // Masquer/afficher le header selon la direction du scroll
        if (currentScrollY > lastScrollY && currentScrollY > 200) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }

        lastScrollY = currentScrollY;
    });
}

// Système de modal réutilisable
export class Modal {
    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.backdrop = this.modal?.querySelector('.modal-backdrop');
        this.closeBtn = this.modal?.querySelector('.modal-close');
        this.init();
    }

    init() {
        if (!this.modal) return;

        // Fermer avec le backdrop
        this.backdrop?.addEventListener('click', () => this.close());

        // Fermer avec le bouton
        this.closeBtn?.addEventListener('click', () => this.close());

        // Fermer avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen()) {
                this.close();
            }
        });
    }

    open() {
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        // Animation d'ouverture
        setTimeout(() => {
            this.modal.querySelector('.modal-content')?.classList.add('animate-scale-in');
        }, 10);
    }

    close() {
        this.modal.classList.add('hidden');
        this.modal.classList.remove('flex');
        document.body.style.overflow = '';

        this.modal.querySelector('.modal-content')?.classList.remove('animate-scale-in');
    }

    isOpen() {
        return !this.modal.classList.contains('hidden');
    }
}

// Système de notification toast
export class Toast {
    static show(message, type = 'info', duration = 5000) {
        const toast = document.createElement('div');
        toast.className = `
            fixed top-4 right-4 z-50 p-4 rounded-lg shadow-elegant
            transform translate-x-full transition-transform duration-300
            ${this.getTypeClasses(type)}
        `;

        toast.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    ${this.getIcon(type)}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button class="toast-close flex-shrink-0 p-1 rounded-full hover:bg-black/10 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(toast);

        // Animation d'entrée
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 10);

        // Fermeture automatique
        const autoClose = setTimeout(() => {
            this.remove(toast);
        }, duration);

        // Fermeture manuelle
        toast.querySelector('.toast-close').addEventListener('click', () => {
            clearTimeout(autoClose);
            this.remove(toast);
        });
    }

    static getTypeClasses(type) {
        const classes = {
            success: 'bg-green-50 text-green-800 border border-green-200',
            error: 'bg-red-50 text-red-800 border border-red-200',
            warning: 'bg-yellow-50 text-yellow-800 border border-yellow-200',
            info: 'bg-blue-50 text-blue-800 border border-blue-200'
        };
        return classes[type] || classes.info;
    }

    static getIcon(type) {
        const icons = {
            success: '<svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
            error: '<svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
            warning: '<svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
            info: '<svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
        };
        return icons[type] || icons.info;
    }

    static remove(toast) {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }
}

// Système de lazy loading pour les images
export function initLazyLoading() {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('animate-fade-in');
                imageObserver.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Système de parallax léger
export function initParallax() {
    const parallaxElements = document.querySelectorAll('.parallax');

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;

        parallaxElements.forEach(element => {
            const rate = scrolled * -0.5;
            element.style.transform = `translateY(${rate}px)`;
        });
    });
}

// Gestion des formulaires avec validation
export class FormHandler {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.init();
    }

    init() {
        if (!this.form) return;

        this.form.addEventListener('submit', (e) => this.handleSubmit(e));

        // Validation en temps réel
        this.form.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('input', () => this.clearErrors(field));
        });
    }

    async handleSubmit(e) {
        e.preventDefault();

        if (!this.validateForm()) {
            return;
        }

        const submitBtn = this.form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        // État de chargement
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Envoi en cours...
        `;

        try {
            const formData = new FormData(this.form);
            // Ici vous pouvez ajouter votre logique d'envoi

            // Simulation d'une requête
            await new Promise(resolve => setTimeout(resolve, 2000));

            Toast.show('Formulaire envoyé avec succès !', 'success');
            this.form.reset();

        } catch (error) {
            Toast.show('Erreur lors de l\'envoi du formulaire', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }

    validateForm() {
        let isValid = true;
        const fields = this.form.querySelectorAll('input[required], textarea[required]');

        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Validation requise
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Ce champ est requis';
        }

        // Validation email
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Email invalide';
            }
        }

        // Validation téléphone
        if (field.type === 'tel' && value) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]+$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Numéro de téléphone invalide';
            }
        }

        this.showFieldError(field, isValid ? '' : errorMessage);
        return isValid;
    }

    showFieldError(field, message) {
        const errorElement = field.parentNode.querySelector('.field-error');

        if (message) {
            field.classList.add('border-red-500', 'focus:border-red-500');
            field.classList.remove('border-neutral-300', 'focus:border-primary-500');

            if (errorElement) {
                errorElement.textContent = message;
            } else {
                const error = document.createElement('p');
                error.className = 'field-error text-red-500 text-sm mt-1';
                error.textContent = message;
                field.parentNode.appendChild(error);
            }
        } else {
            field.classList.remove('border-red-500', 'focus:border-red-500');
            field.classList.add('border-neutral-300', 'focus:border-primary-500');

            if (errorElement) {
                errorElement.remove();
            }
        }
    }

    clearErrors(field) {
        const errorElement = field.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
        field.classList.remove('border-red-500', 'focus:border-red-500');
        field.classList.add('border-neutral-300', 'focus:border-primary-500');
    }
}

// Initialisation globale
export function initApp() {
    // Attendre que le DOM soit chargé
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initScrollAnimations();
            initSmoothNavigation();
            initStickyHeader();
            initLazyLoading();
            initParallax();
        });
    } else {
        initScrollAnimations();
        initSmoothNavigation();
        initStickyHeader();
        initLazyLoading();
        initParallax();
    }
}

// Auto-initialisation
initApp();
