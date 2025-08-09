// Anti-FOUC (Flash of Unstyled Content) Script
// Ce script évite le flash de contenu non stylisé pendant le chargement

(function() {
    'use strict';

    // Ajouter une classe au body pour masquer le contenu initialement
    document.documentElement.style.visibility = 'hidden';
    document.documentElement.style.opacity = '0';

    // Fonction pour révéler le contenu une fois que tout est chargé
    function revealContent() {
        document.documentElement.style.visibility = 'visible';
        document.documentElement.style.opacity = '1';
        document.documentElement.style.transition = 'opacity 0.3s ease-in-out';

        // Ajouter une classe pour indiquer que le contenu est chargé
        document.documentElement.classList.add('content-loaded');
    }

    // Attendre que les styles CSS soient complètement chargés
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            // Petit délai pour s'assurer que les styles sont appliqués
            setTimeout(revealContent, 50);
        });
    } else {
        // Le DOM est déjà chargé
        setTimeout(revealContent, 50);
    }

    // Fallback au cas où quelque chose se passerait mal
    window.addEventListener('load', function() {
        setTimeout(revealContent, 100);
    });

    // Révéler le contenu après un délai maximum (safety net)
    setTimeout(revealContent, 1000);
})();
