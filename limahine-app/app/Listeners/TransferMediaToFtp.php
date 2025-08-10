<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class TransferMediaToFtp
{
    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAdded $event): void
    {
        $media = $event->media;

        // Vérifier si le média n'est pas déjà sur FTP
        if ($media->disk === 'ftp') {
            return;
        }

        try {
            // Lire le contenu du fichier depuis le disque actuel
            $fileContent = Storage::disk($media->disk)->get($media->getPath());

            // Générer le chemin FTP
            $ftpPath = $this->generateFtpPath($media);

            // Uploader vers FTP
            if (Storage::disk('ftp')->put($ftpPath, $fileContent)) {
                // Mettre à jour le média pour pointer vers FTP
                $media->update([
                    'disk' => 'ftp',
                    'conversions_disk' => 'ftp',
                    'file_name' => basename($ftpPath)
                ]);

                Log::info('Média automatiquement transféré vers FTP', [
                    'media_id' => $media->id,
                    'original_path' => $media->getPath(),
                    'ftp_path' => $ftpPath
                ]);

                // Optionnel : supprimer l'ancien fichier
                try {
                    Storage::disk($media->disk === 'ftp' ? 'public' : $media->disk)->delete($media->getPath());
                } catch (\Exception $e) {
                    Log::warning('Impossible de supprimer l\'ancien fichier', [
                        'media_id' => $media->id,
                        'path' => $media->getPath(),
                        'error' => $e->getMessage()
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors du transfert automatique vers FTP', [
                'media_id' => $media->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Générer un chemin FTP pour le média
     */
    private function generateFtpPath($media): string
    {
        $collection = $media->collection_name;
        $filename = $media->file_name;

        // Nettoyer le nom de fichier pour FTP
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
        $basename = substr($basename, 0, 50);

        $ftpFilename = $basename . '_' . time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;

        return $collection . '/' . $ftpFilename;
    }
}
