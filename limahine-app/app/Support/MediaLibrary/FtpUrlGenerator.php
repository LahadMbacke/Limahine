<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class FtpUrlGenerator extends BaseUrlGenerator
{
    /**
     * Obtenir l'URL du fichier média pour FTP
     */
    public function getUrl(): string
    {
        $baseUrl = config('filesystems.disks.ftp.url');
        $path = $this->getPathRelativeToRoot();
        
        // Construire l'URL complète
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Obtenir le chemin du fichier
     */
    public function getPath(): string
    {
        return $this->media->getPath();
    }

    /**
     * Obtenir une URL temporaire (pour FTP, on retourne l'URL normale)
     */
    public function getTemporaryUrl(\DateTimeInterface $expiration, array $options = []): string
    {
        // Pour FTP, nous retournons l'URL normale car nous ne pouvons pas créer d'URLs temporaires
        return $this->getUrl();
    }

    /**
     * Obtenir l'URL pour une conversion spécifique
     */
    public function getConversionUrl(): string
    {
        $baseUrl = config('filesystems.disks.ftp.url');
        $conversionPath = $this->conversion->getConversionFile($this->media);
        
        return rtrim($baseUrl, '/') . '/' . ltrim($conversionPath, '/');
    }

    /**
     * Obtenir l'URL pour les images responsives
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        $baseUrl = config('filesystems.disks.ftp.url');
        $directory = $this->media->getResponsiveImagesDirectory();
        
        return rtrim($baseUrl, '/') . '/' . ltrim($directory, '/');
    }    /**
     * Obtenir le chemin relatif à la racine
     */
    public function getPathRelativeToRoot(): string
    {
        return $this->media->getPath();
    }
}
