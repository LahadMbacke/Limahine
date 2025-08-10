<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\FtpMediaService;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class TransferMediaToFtp
{
    protected FtpMediaService $ftpMediaService;

    public function __construct(FtpMediaService $ftpMediaService)
    {
        $this->ftpMediaService = $ftpMediaService;
    }

    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAdded $event): void
    {
        $media = $event->media;

        // Vérifier si le média n'est pas déjà sur FTP
        if ($media->disk === 'ftp') {
            // S'assurer que le chemin complet est enregistré
            $this->ftpMediaService->saveMediaWithFullFtpPath($media);
            return;
        }

        try {
            // Migrer vers FTP avec chemin complet
            $this->ftpMediaService->migrateToFtpWithFullPath($media);

        } catch (\Exception $e) {
            Log::error('Erreur lors du transfert automatique vers FTP', [
                'media_id' => $media->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
