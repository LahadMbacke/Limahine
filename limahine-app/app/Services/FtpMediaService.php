<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FtpMediaService
{
    /**
     * Enregistrer le chemin complet FTP en base de données
     */
    public function saveMediaWithFullFtpPath(Media $media): void
    {
        if ($media->disk === 'ftp') {
            // Construire le chemin complet FTP
            $baseUrl = config('filesystems.disks.ftp.url');
            if (!empty($baseUrl)) {
                $fullPath = rtrim($baseUrl, '/') . '/' . ltrim($media->getPath(), '/');

                // Stocker le chemin complet dans custom_properties
                $customProperties = $media->custom_properties;
                $customProperties['ftp_full_url'] = $fullPath;

                $media->update([
                    'custom_properties' => $customProperties
                ]);

                Log::info('Chemin FTP complet enregistré', [
                    'media_id' => $media->id,
                    'ftp_full_url' => $fullPath
                ]);
            }
        }
    }

    /**
     * Obtenir l'URL complète FTP d'un média
     */
    public function getFullFtpUrl(Media $media): ?string
    {
        if ($media->disk === 'ftp') {
            // Essayer d'abord le chemin stocké dans custom_properties
            $customProperties = $media->custom_properties ?? [];
            if (isset($customProperties['ftp_full_url'])) {
                return $customProperties['ftp_full_url'];
            }

            // Sinon, construire l'URL
            $baseUrl = config('filesystems.disks.ftp.url');
            if (!empty($baseUrl)) {
                return rtrim($baseUrl, '/') . '/' . ltrim($media->getPath(), '/');
            }
        }

        return null;
    }

    /**
     * Migrer un média vers FTP et enregistrer le chemin complet
     */
    public function migrateToFtpWithFullPath(Media $media): bool
    {
        try {
            if ($media->disk === 'ftp') {
                // Déjà sur FTP, juste mettre à jour le chemin
                $this->saveMediaWithFullFtpPath($media);
                return true;
            }

            // Lire le contenu depuis le disque actuel
            $originalDisk = $media->disk;
            $originalPath = $media->getPath();

            if (!Storage::disk($originalDisk)->exists($originalPath)) {
                throw new \Exception("Fichier source non trouvé: {$originalPath}");
            }

            $fileContent = Storage::disk($originalDisk)->get($originalPath);

            // Générer un nouveau nom de fichier avec timestamp pour éviter les conflits
            $extension = pathinfo($media->file_name, PATHINFO_EXTENSION);
            $baseName = pathinfo($media->file_name, PATHINFO_FILENAME);
            $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $baseName);
            $newFileName = $safeName . '_' . time() . '.' . $extension;

            // Créer le chemin FTP
            $ftpPath = $media->collection_name . '/' . $newFileName;

            // Uploader vers FTP
            if (Storage::disk('ftp')->put($ftpPath, $fileContent)) {
                // Mettre à jour le média
                $media->update([
                    'disk' => 'ftp',
                    'conversions_disk' => 'ftp',
                    'file_name' => $newFileName,
                ]);

                // Mettre à jour le chemin dans la base
                $media->setAttribute('conversions_disk', 'ftp');
                $media->forceFill([
                    'disk' => 'ftp',
                    'conversions_disk' => 'ftp'
                ])->save();

                // Enregistrer le chemin complet
                $this->saveMediaWithFullFtpPath($media);

                Log::info('Média migré vers FTP avec succès', [
                    'media_id' => $media->id,
                    'original_path' => $originalPath,
                    'ftp_path' => $ftpPath
                ]);

                return true;
            }

        } catch (\Exception $e) {
            Log::error('Erreur migration FTP', [
                'media_id' => $media->id,
                'error' => $e->getMessage()
            ]);
        }

        return false;
    }

    /**
     * Vérifier si un média est accessible sur FTP
     */
    public function isAccessible(Media $media): bool
    {
        if ($media->disk !== 'ftp') {
            return false;
        }

        try {
            return Storage::disk('ftp')->exists($media->getPath());
        } catch (\Exception $e) {
            Log::error('Erreur vérification accessibilité FTP', [
                'media_id' => $media->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
