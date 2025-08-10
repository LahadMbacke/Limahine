/**
 * Script de protection avancée pour Limahine
 * Protection contre le clic droit, les outils de développement et autres tentatives d'intrusion
 */

(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        devToolsThreshold: 160,
        consoleCheckInterval: 1000,
        devToolsCheckInterval: 500,
        showWarnings: true,
        blockPrint: true,
        blockCopy: true,
        blockSelection: true
    };

    // Messages de sécurité
    const MESSAGES = {
        devToolsBlocked: {
            title: '🔒 Accès Restreint - Limahine',
            message: 'Pour des raisons de sécurité et de protection du contenu, l\'utilisation des outils de développement n\'est pas autorisée sur cette plateforme.',
            instruction: 'Veuillez fermer les outils de développement pour continuer votre navigation.'
        },
        consoleBlocked: {
            title: '⚠️ Console Détectée - Limahine',
            message: 'L\'accès à la console développeur a été détecté et bloqué pour protéger l\'intégrité du site.',
            instruction: 'Fermez la console pour continuer.'
        },
        printBlocked: 'L\'impression de ce contenu n\'est pas autorisée pour des raisons de droits d\'auteur.',
        copyBlocked: 'La copie de ce contenu n\'est pas autorisée.'
    };

    // Variables de contrôle
    let devtools = { open: false };
    let consoleOpenTime = 0;
    let alertShown = false;

    // Fonction pour créer une page de blocage
    function createBlockPage(messageObj) {
        const blockHtml = `
            <div style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
                z-index: 999999;
                animation: fadeIn 0.3s ease-in-out;
            ">
                <div style="
                    text-align: center;
                    max-width: 600px;
                    padding: 3rem;
                    background: rgba(255, 255, 255, 0.05);
                    border-radius: 16px;
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    backdrop-filter: blur(10px);
                ">
                    <div style="
                        width: 80px;
                        height: 80px;
                        margin: 0 auto 2rem;
                        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 2rem;
                    ">🛡️</div>
                    <h1 style="
                        font-size: 1.8rem;
                        margin-bottom: 1rem;
                        color: #f59e0b;
                        font-weight: 700;
                    ">${messageObj.title}</h1>
                    <p style="
                        font-size: 1.1rem;
                        line-height: 1.6;
                        color: #d1d5db;
                        margin-bottom: 1.5rem;
                    ">${messageObj.message}</p>
                    <p style="
                        font-size: 0.9rem;
                        color: #9ca3af;
                        opacity: 0.8;
                    ">${messageObj.instruction}</p>
                    <div style="
                        margin-top: 2rem;
                        padding: 1rem;
                        background: rgba(239, 68, 68, 0.1);
                        border-radius: 8px;
                        border-left: 4px solid #ef4444;
                    ">
                        <p style="
                            font-size: 0.85rem;
                            color: #fca5a5;
                            margin: 0;
                        ">Cette mesure de sécurité protège le contenu et les utilisateurs de la plateforme Limahine.</p>
                    </div>
                </div>
                <style>
                    @keyframes fadeIn {
                        from { opacity: 0; transform: scale(0.95); }
                        to { opacity: 1; transform: scale(1); }
                    }
                </style>
            </div>
        `;
        document.body.innerHTML = blockHtml;
    }

    // Protection contre le clic droit
    function initContextMenuProtection() {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            if (CONFIG.showWarnings) {
                showTemporaryMessage('Clic droit désactivé pour protéger le contenu.');
            }
            return false;
        }, false);
    }

    // Protection contre la sélection
    function initSelectionProtection() {
        if (CONFIG.blockSelection) {
            document.addEventListener('selectstart', function(e) {
                if (!['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                    e.preventDefault();
                    return false;
                }
            }, false);

            document.addEventListener('dragstart', function(e) {
                if (e.target.tagName === 'IMG') {
                    e.preventDefault();
                    return false;
                }
            }, false);
        }
    }

    // Protection contre les raccourcis clavier
    function initKeyboardProtection() {
        document.addEventListener('keydown', function(e) {
            // Liste des raccourcis à bloquer
            const blockedKeys = [
                { key: 'F12' },
                { ctrl: true, shift: true, key: 'I' },
                { ctrl: true, shift: true, key: 'C' },
                { ctrl: true, shift: true, key: 'J' },
                { ctrl: true, shift: true, key: 'K' },
                { ctrl: true, shift: true, key: 'E' },
                { ctrl: true, key: 'u' },
                { ctrl: true, key: 's' },
                { ctrl: true, key: 'p' },
                { alt: true, key: 'F4' }
            ];

            // Ctrl+A seulement si pas dans un input
            if (e.ctrlKey && e.key === 'a' && !['INPUT', 'TEXTAREA'].includes(e.target.tagName)) {
                e.preventDefault();
                return false;
            }

            // Vérifier les autres raccourcis
            for (const blocked of blockedKeys) {
                let match = true;
                if (blocked.ctrl && !e.ctrlKey) match = false;
                if (blocked.shift && !e.shiftKey) match = false;
                if (blocked.alt && !e.altKey) match = false;
                if (blocked.key && e.key !== blocked.key) match = false;

                if (match) {
                    e.preventDefault();
                    if (CONFIG.showWarnings) {
                        showTemporaryMessage('Raccourci clavier désactivé pour des raisons de sécurité.');
                    }
                    return false;
                }
            }
        }, false);
    }

    // Détection des outils de développement
    function initDevToolsDetection() {
        setInterval(function() {
            const widthThreshold = window.outerWidth - window.innerWidth > CONFIG.devToolsThreshold;
            const heightThreshold = window.outerHeight - window.innerHeight > CONFIG.devToolsThreshold;
            
            if (widthThreshold || heightThreshold) {
                if (!devtools.open) {
                    devtools.open = true;
                    createBlockPage(MESSAGES.devToolsBlocked);
                }
            } else {
                devtools.open = false;
            }
        }, CONFIG.devToolsCheckInterval);
    }

    // Détection de la console
    function initConsoleDetection() {
        setInterval(function() {
            const startTime = performance.now();
            console.clear();
            console.log('%c', 'font-size: 1px;');
            const endTime = performance.now();
            
            if (endTime - startTime > 100) {
                if (consoleOpenTime === 0) {
                    consoleOpenTime = Date.now();
                    createBlockPage(MESSAGES.consoleBlocked);
                }
            } else {
                consoleOpenTime = 0;
            }
        }, CONFIG.consoleCheckInterval);
    }

    // Protection contre l'impression
    function initPrintProtection() {
        if (CONFIG.blockPrint) {
            window.addEventListener('beforeprint', function(e) {
                e.preventDefault();
                alert(MESSAGES.printBlocked);
                return false;
            }, false);

            // Protection CSS pour l'impression
            const style = document.createElement('style');
            style.textContent = `
                @media print {
                    * { display: none !important; }
                    body::before {
                        content: "Impression non autorisée - ${window.location.hostname}" !important;
                        display: block !important;
                        font-size: 24px !important;
                        text-align: center !important;
                        margin-top: 50vh !important;
                        transform: translateY(-50%) !important;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Protection contre la copie
    function initCopyProtection() {
        if (CONFIG.blockCopy) {
            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', '');
                e.preventDefault();
                if (CONFIG.showWarnings) {
                    showTemporaryMessage(MESSAGES.copyBlocked);
                }
                return false;
            }, false);
        }
    }

    // Afficher un message temporaire
    function showTemporaryMessage(message) {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 14px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease-out;
        `;
        toast.textContent = message;

        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideIn 0.3s ease-in reverse';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Protections de la console
    function initConsoleProtection() {
        // Messages d'avertissement stylés
        console.clear();
        console.log('%c⚠️ ARRÊT !', 'color: #dc2626; font-size: 48px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);');
        console.log('%c🛡️ Zone Sécurisée - Limahine', 'color: #f59e0b; font-size: 24px; font-weight: bold;');
        console.log('%cCeci est une fonctionnalité du navigateur destinée aux développeurs.', 'color: #dc2626; font-size: 16px; font-weight: bold;');
        console.log('%c⚠️ ATTENTION : Si quelqu\'un vous a demandé de copier-coller du code ici, il s\'agit très probablement d\'une tentative d\'arnaque !', 'color: #dc2626; font-size: 14px;');
        console.log('%c🛡️ Cette action pourrait compromettre votre sécurité et donner accès à vos données personnelles.', 'color: #dc2626; font-size: 14px;');
        console.log('%c📞 En cas de doute, contactez notre support technique.', 'color: #059669; font-size: 14px; font-weight: bold;');

        // Protection contre eval
        const originalEval = window.eval;
        window.eval = function() {
            if (!alertShown) {
                alertShown = true;
                alert('🚨 Tentative d\'exécution de code détectée ! Pour votre sécurité, cette action a été bloquée.');
            }
            throw new Error('Exécution de code externe bloquée pour des raisons de sécurité');
        };
    }

    // Protection contre la manipulation de la visibilité
    function initVisibilityProtection() {
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                document.body.style.filter = 'blur(5px)';
                document.body.style.transform = 'scale(0.95)';
                document.body.style.transition = 'all 0.3s ease';
            } else {
                document.body.style.filter = 'none';
                document.body.style.transform = 'scale(1)';
            }
        });
    }

    // Initialisation de toutes les protections
    function initAllProtections() {
        try {
            initContextMenuProtection();
            initSelectionProtection();
            initKeyboardProtection();
            initDevToolsDetection();
            initConsoleDetection();
            initPrintProtection();
            initCopyProtection();
            initConsoleProtection();
            initVisibilityProtection();
            
            console.log('%c✅ Système de protection Limahine activé', 'color: #059669; font-size: 14px; font-weight: bold;');
        } catch (error) {
            console.error('Erreur lors de l\'initialisation des protections:', error);
        }
    }

    // Démarrer les protections dès que le DOM est prêt
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllProtections);
    } else {
        initAllProtections();
    }

    // Protection contre la désactivation de ce script
    Object.freeze(CONFIG);
    Object.freeze(MESSAGES);

})();
