<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\UrlGenerator\BaseUrlGenerator;

class FtpUrlGenerator extends BaseUrlGenerator
{    /**
     * Obtenir l'URL du fichier média pour FTP - DIRECT
     */
    public function getUrl(): string
    {
        // Utiliser directement l'URL FTP sans proxy
        $baseUrl = config('filesystems.disks.ftp.url');
        $path = $this->media->getPath();

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
        // Pour FTP, retourner directement l'URL publique
        return $this->getUrl();
    }

    /**
     * Obtenir l'URL pour une conversion spécifique
     */
    public function getConversionUrl(): string
    {
        // Pour les conversions, utiliser directement l'URL FTP
        $baseUrl = config('filesystems.disks.ftp.url');
        $path = $this->media->getPath($this->conversion);

        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
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
