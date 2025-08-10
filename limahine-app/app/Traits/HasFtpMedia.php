<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

trait HasFtpMedia
{
    /**
     * Obtenir l'URL d'un média avec gestion FTP
     */
    public function getFtpMediaUrl(string $collection = 'default', string $conversion = ''): string
    {
        $media = $this->getFirstMedia($collection);

        if (!$media) {
            return '';
        }

        // Si le média est sur FTP, construire l'URL directement
        if ($media->disk === 'ftp') {
            $baseUrl = config('filesystems.disks.ftp.url');

            if ($conversion && $media->hasGeneratedConversion($conversion)) {
                $path = $media->getPath($conversion);
            } else {
                $path = $media->getPath();
            }

            return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }

        // Sinon, utiliser la méthode normale
        return $media->getUrl($conversion);
    }

    /**
     * Obtenir toutes les URLs d'une collection avec gestion FTP
     */
    public function getFtpMediaUrls(string $collection = 'default', string $conversion = ''): array
    {
        $mediaItems = $this->getMedia($collection);
        $urls = [];

        foreach ($mediaItems as $media) {
            if ($media->disk === 'ftp') {
                $baseUrl = config('filesystems.disks.ftp.url');

                if ($conversion && $media->hasGeneratedConversion($conversion)) {
                    $path = $media->getPath($conversion);
                } else {
                    $path = $media->getPath();
                }

                $urls[] = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            } else {
                $urls[] = $media->getUrl($conversion);
            }
        }

        return $urls;
    }

    /**
     * Migrer un média vers FTP
     */
    public function migrateMediaToFtp(string $collection = 'default'): bool
    {
        $media = $this->getFirstMedia($collection);

        if (!$media || $media->disk === 'ftp') {
            return false;
        }

        try {
            // Copier le fichier vers FTP
            $originalPath = $media->getPath();
            $fileContent = Storage::disk($media->disk)->get($originalPath);

            $ftpPath = $originalPath;
            $uploaded = Storage::disk('ftp')->put($ftpPath, $fileContent);

            if ($uploaded) {
                // Mettre à jour l'enregistrement
                $media->update([
                    'disk' => 'ftp',
                    'conversions_disk' => 'ftp'
                ]);

                // Optionnel : supprimer l'ancien fichier
                // Storage::disk($originalDisk)->delete($originalPath);

                return true;
            }

        } catch (\Exception $e) {
            \Log::error('Erreur migration FTP pour média', [
                'media_id' => $media->id,
                'collection' => $collection,
                'error' => $e->getMessage()
            ]);
        }

        return false;
    }

    /**
     * Vérifier si un média est accessible sur FTP
     */
    public function isFtpMediaAccessible(string $collection = 'default'): bool
    {
        $media = $this->getFirstMedia($collection);

        if (!$media || $media->disk !== 'ftp') {
            return false;
        }

        try {
            return Storage::disk('ftp')->exists($media->getPath());
        } catch (\Exception $e) {
            return false;
        }
    }
}
