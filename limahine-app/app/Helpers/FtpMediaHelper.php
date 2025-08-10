<?php

namespace App\Helpers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FtpMediaHelper
{
    /**
     * Obtenir l'URL publique d'un média stocké sur FTP
     */
    public static function getPublicUrl($model, string $collection = 'default', string $conversion = ''): string
    {
        if (!$model) {
            return '';
        }

        $media = $model->getFirstMedia($collection);

        if (!$media) {
            return '';
        }

        return self::getMediaUrl($media, $conversion);
    }

    /**
     * Obtenir l'URL publique d'un média spécifique
     */
    public static function getMediaUrl(Media $media, string $conversion = ''): string
    {
        $baseUrl = config('filesystems.disks.ftp.url');

        if ($conversion && $media->hasGeneratedConversion($conversion)) {
            $path = $media->getPath($conversion);
        } else {
            $path = $media->getPath();
        }

        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Obtenir toutes les URLs d'une collection
     */
    public static function getCollectionUrls($model, string $collection = 'default', string $conversion = ''): array
    {
        if (!$model) {
            return [];
        }

        $mediaItems = $model->getMedia($collection);
        $urls = [];

        foreach ($mediaItems as $media) {
            $urls[] = self::getMediaUrl($media, $conversion);
        }

        return $urls;
    }

    /**
     * Obtenir l'URL avec fallback vers une image par défaut
     */
    public static function getUrlWithFallback($model, string $collection = 'default', string $conversion = '', string $fallback = ''): string
    {
        $url = self::getPublicUrl($model, $collection, $conversion);

        if (empty($url) && !empty($fallback)) {
            return $fallback;
        }

        return $url;
    }

    /**
     * Vérifier si un média est accessible sur FTP
     */
    public static function isMediaAccessible(Media $media): bool
    {
        try {
            $url = self::getMediaUrl($media);

            // Faire une requête HEAD pour vérifier l'existence
            $headers = @get_headers($url, 1);

            return $headers && strpos($headers[0], '200') !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtenir les informations d'un média avec URLs
     */
    public static function getMediaInfo(Media $media): array
    {
        return [
            'id' => $media->id,
            'uuid' => $media->uuid,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
            'human_readable_size' => $media->humanReadableSize,
            'url' => self::getMediaUrl($media),
            'conversions' => self::getConversionsUrls($media),
            'collection' => $media->collection_name,
            'disk' => $media->disk,
        ];
    }

    /**
     * Obtenir les URLs de toutes les conversions d'un média
     */
    public static function getConversionsUrls(Media $media): array
    {
        $conversions = [];
        $generatedConversions = $media->getGeneratedConversions();

        foreach ($generatedConversions as $conversionName => $generated) {
            if ($generated) {
                $conversions[$conversionName] = self::getMediaUrl($media, $conversionName);
            }
        }

        return $conversions;
    }
}
