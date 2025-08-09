<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class SecureUrlGenerator extends BaseUrlGenerator
{
    /**
     * Générer une URL sécurisée pour le média
     */
    public function getUrl(): string
    {
        // Utiliser l'UUID du média au lieu du chemin réel
        return route('secure-media.serve', [
            'uuid' => $this->media->uuid,
            'filename' => $this->media->file_name
        ]);
    }

    /**
     * Générer une URL sécurisée pour une conversion
     */
    public function getUrlForConversion(string $conversionName): string
    {
        return route('secure-media.conversion', [
            'uuid' => $this->media->uuid,
            'conversion' => $conversionName,
            'filename' => $this->media->file_name
        ]);
    }

    /**
     * Obtenir le chemin du média (non utilisé dans notre implémentation sécurisée)
     */
    public function getPath(): string
    {
        // Ne pas exposer le vrai chemin
        return '';
    }

    /**
     * Générer une URL temporaire (non supportée pour la sécurité)
     */
    public function getTemporaryUrl(\DateTimeInterface $expiration, array $options = []): string
    {
        // Pour des raisons de sécurité, nous ne supportons pas les URLs temporaires
        // qui pourraient exposer les chemins réels
        throw new \Exception('Les URLs temporaires ne sont pas supportées pour des raisons de sécurité.');
    }

    /**
     * Obtenir l'URL du répertoire des images responsives
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        // Pour la sécurité, nous ne exposons pas les répertoires directs
        // Les images responsives doivent passer par le contrôleur sécurisé
        return '';
    }
}
