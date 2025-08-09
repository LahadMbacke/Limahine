<?php

namespace App\Helpers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SecureMediaHelper
{
    /**
     * Obtenir l'URL sécurisée d'un média
     */
    public static function getSecureUrl($model, string $collection = 'default', string $conversion = ''): string
    {
        if (!$model) {
            return '';
        }

        $media = $model->getFirstMedia($collection);

        if (!$media) {
            return '';
        }

        if ($conversion) {
            return route('secure-media.conversion', [
                'uuid' => $media->uuid,
                'conversion' => $conversion,
                'filename' => $media->file_name
            ]);
        }

        return route('secure-media.serve', [
            'uuid' => $media->uuid,
            'filename' => $media->file_name
        ]);
    }

    /**
     * Obtenir l'URL sécurisée d'une collection complète
     */
    public static function getSecureMediaCollection($model, string $collection = 'default', string $conversion = ''): array
    {
        if (!$model) {
            return [];
        }

        $mediaItems = $model->getMedia($collection);
        $urls = [];

        foreach ($mediaItems as $media) {
            if ($conversion) {
                $urls[] = route('secure-media.conversion', [
                    'uuid' => $media->uuid,
                    'conversion' => $conversion,
                    'filename' => $media->file_name
                ]);
            } else {
                $urls[] = route('secure-media.serve', [
                    'uuid' => $media->uuid,
                    'filename' => $media->file_name
                ]);
            }
        }

        return $urls;
    }

    /**
     * Vérifier si un média existe dans une collection
     */
    public static function hasSecureMedia($model, string $collection = 'default'): bool
    {
        if (!$model) {
            return false;
        }

        return $model->getFirstMedia($collection) !== null;
    }

    /**
     * Obtenir les métadonnées d'un média de manière sécurisée
     */
    public static function getSecureMediaMeta($model, string $collection = 'default'): array
    {
        if (!$model) {
            return [];
        }

        $media = $model->getFirstMedia($collection);

        if (!$media) {
            return [];
        }

        // Retourner seulement les métadonnées non sensibles
        return [
            'name' => $media->name,
            'size' => $media->human_readable_size,
            'mime_type' => $media->mime_type,
            'collection' => $media->collection_name,
            // Ne pas exposer l'UUID ou le chemin réel
        ];
    }
}
