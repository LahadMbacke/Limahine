<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class SecurePathGenerator implements PathGenerator
{
    /**
     * Générer un chemin sécurisé basé sur l'UUID et des dossiers aléatoires
     */
    public function getPath(Media $media): string
    {
        // Utiliser l'UUID du média pour créer un chemin sécurisé
        $uuid = $media->uuid;

        // Diviser l'UUID en segments pour créer une structure de dossiers
        $segments = [
            substr($uuid, 0, 2),
            substr($uuid, 2, 2),
            substr($uuid, 4, 2),
        ];

        // Ajouter un préfixe basé sur le type de collection
        $collectionPrefix = $this->getCollectionPrefix($media->collection_name);

        return $collectionPrefix . '/' . implode('/', $segments) . '/';
    }

    /**
     * Obtenir le chemin pour les conversions
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    /**
     * Obtenir le chemin pour les images responsives
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }

    /**
     * Obtenir le préfixe basé sur le type de collection
     */
    private function getCollectionPrefix(string $collectionName): string
    {
        $prefixes = [
            'featured_image' => 'sec/fi',
            'gallery' => 'sec/ga',
            'documents' => 'sec/docs',
            'audio' => 'sec/aud',
            'cover_image' => 'sec/cv',
            'portrait' => 'sec/pt',
            'author_photo' => 'sec/ap',
        ];

        return $prefixes[$collectionName] ?? 'sec/misc';
    }
}
