<?php

namespace App\Services;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LivewireFtpService
{
    /**
     * Transférer un fichier temporaire Livewire vers FTP
     */
    public function transferToFtp(TemporaryUploadedFile $temporaryFile, string $collection = 'default'): ?array
    {
        try {
            // Générer un nom de fichier unique
            $filename = $this->generateUniqueFilename($temporaryFile);

            // Créer le chemin de destination sur FTP
            $ftpPath = $collection . '/' . $filename;

            // Lire le contenu du fichier temporaire
            $fileContent = file_get_contents($temporaryFile->getRealPath());

            // Uploader vers FTP
            $uploaded = Storage::disk('ftp')->put($ftpPath, $fileContent);

            if ($uploaded) {
                Log::info('Fichier Livewire transféré vers FTP', [
                    'original_name' => $temporaryFile->getClientOriginalName(),
                    'ftp_path' => $ftpPath,
                    'size' => $temporaryFile->getSize()
                ]);

                return [
                    'ftp_path' => $ftpPath,
                    'original_name' => $temporaryFile->getClientOriginalName(),
                    'size' => $temporaryFile->getSize(),
                    'mime_type' => $temporaryFile->getMimeType(),
                    'url' => $this->getFtpUrl($ftpPath)
                ];
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Erreur transfert Livewire vers FTP', [
                'file' => $temporaryFile->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Créer un média à partir d'un fichier temporaire Livewire
     */
    public function createMediaFromTemporaryFile($model, TemporaryUploadedFile $temporaryFile, string $collection = 'default'): ?Media
    {
        try {
            // Transférer vers FTP
            $ftpData = $this->transferToFtp($temporaryFile, $collection);

            if (!$ftpData) {
                return null;
            }

            // Créer le média directement sur le disque FTP
            $media = $model->addMedia($temporaryFile->getRealPath())
                ->usingName($temporaryFile->getClientOriginalName())
                ->usingFileName(basename($ftpData['ftp_path']))
                ->toMediaCollection($collection, 'ftp');

            // Mettre à jour le chemin pour correspondre à notre structure FTP
            $media->update([
                'file_name' => basename($ftpData['ftp_path']),
                'disk' => 'ftp',
                'conversions_disk' => 'ftp'
            ]);

            return $media;

        } catch (\Exception $e) {
            Log::error('Erreur création média FTP depuis Livewire', [
                'file' => $temporaryFile->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Obtenir l'URL FTP d'un fichier
     */
    public function getFtpUrl(string $path): string
    {
        $baseUrl = config('filesystems.disks.ftp.url');
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Générer un nom de fichier unique pour FTP
     */
    private function generateUniqueFilename(TemporaryUploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Nettoyer le nom de base pour FTP
        $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
        $basename = substr($basename, 0, 50);

        // Générer un identifiant unique
        $timestamp = time();
        $random = substr(md5(uniqid()), 0, 8);

        return $basename . '_' . $timestamp . '_' . $random . '.' . $extension;
    }

    /**
     * Nettoyer les fichiers temporaires après transfert
     */
    public function cleanupTemporaryFiles(array $temporaryFiles): void
    {
        foreach ($temporaryFiles as $temporaryFile) {
            if ($temporaryFile instanceof TemporaryUploadedFile) {
                try {
                    // Supprimer le fichier temporaire
                    if (file_exists($temporaryFile->getRealPath())) {
                        unlink($temporaryFile->getRealPath());
                    }

                    // Supprimer l'entrée de la base de données Livewire si elle existe
                    $temporaryFile->delete();

                } catch (\Exception $e) {
                    Log::warning('Impossible de nettoyer le fichier temporaire', [
                        'file' => $temporaryFile->getClientOriginalName(),
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
    }

    /**
     * Vérifier si le serveur FTP est accessible
     */
    public function isFtpAccessible(): bool
    {
        try {
            $testFile = 'test_livewire_' . time() . '.txt';
            $testContent = 'Test Livewire FTP - ' . now()->toISOString();

            $written = Storage::disk('ftp')->put($testFile, $testContent);

            if ($written) {
                Storage::disk('ftp')->delete($testFile);
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Test accessibilité FTP échoué', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
