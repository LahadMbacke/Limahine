<?php

namespace App\Traits;

use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Services\LivewireFtpService;
use Illuminate\Support\Facades\Storage;

trait FilamentFtpUpload
{
    /**
     * Créer un composant FileUpload configuré pour FTP
     */
    public static function makeFileUploadForFtp(string $name, string $label = null): FileUpload
    {
        return FileUpload::make($name)
            ->label($label ?? ucfirst($name))
            ->disk('local') // Utiliser le disque local pour les uploads temporaires
            ->directory('livewire-tmp')
            ->visibility('private')
            ->preserveFilenames()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
            ->maxSize(10240) // 10MB
            ->enableDownload()
            ->enableOpen()
            ->imageEditor()
            ->imageCropAspectRatio('16:9')
            ->imageResizeTargetWidth('1920')
            ->imageResizeTargetHeight('1080')
            ->getUploadedFileNameForStorageUsing(
                fn (TemporaryUploadedFile $file): string =>
                    (string) str($file->getClientOriginalName())
                        ->prepend(time() . '_')
            );
    }

    /**
     * Créer un composant FileUpload multiple configuré pour FTP
     */
    public static function makeMultipleFileUploadForFtp(string $name, string $label = null): FileUpload
    {
        return static::makeFileUploadForFtp($name, $label)
            ->multiple()
            ->reorderable()
            ->maxFiles(10);
    }

    /**
     * Traiter les fichiers uploadés et les transférer vers FTP
     */
    protected function processFilesForFtp(array $fileData, string $collection = 'default'): array
    {
        $livewireFtpService = app(LivewireFtpService::class);
        $processedFiles = [];

        foreach ($fileData as $fileItem) {
            if (is_string($fileItem)) {
                // Le fichier est déjà un chemin de fichier (probable fichier existant)
                $processedFiles[] = $fileItem;
            } elseif ($fileItem instanceof TemporaryUploadedFile) {
                // Nouveau fichier uploadé - transférer vers FTP
                $ftpData = $livewireFtpService->transferToFtp($fileItem, $collection);

                if ($ftpData) {
                    $processedFiles[] = $ftpData['ftp_path'];
                }
            }
        }

        return $processedFiles;
    }

    /**
     * Obtenir les URLs des fichiers pour l'affichage
     */
    protected function getFileUrlsFromFtp(array $filePaths): array
    {
        $baseUrl = config('filesystems.disks.ftp.url');
        $urls = [];

        foreach ($filePaths as $path) {
            if (!empty($path)) {
                $urls[] = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
            }
        }

        return $urls;
    }

    /**
     * Supprimer des fichiers du FTP
     */
    protected function deleteFilesFromFtp(array $filePaths): void
    {
        foreach ($filePaths as $path) {
            try {
                if (!empty($path)) {
                    Storage::disk('ftp')->delete($path);
                }
            } catch (\Exception $e) {
                \Log::warning('Impossible de supprimer le fichier FTP', [
                    'path' => $path,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Valider que les fichiers existent sur FTP
     */
    protected function validateFtpFiles(array $filePaths): array
    {
        $validFiles = [];

        foreach ($filePaths as $path) {
            try {
                if (!empty($path) && Storage::disk('ftp')->exists($path)) {
                    $validFiles[] = $path;
                }
            } catch (\Exception $e) {
                \Log::warning('Erreur validation fichier FTP', [
                    'path' => $path,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $validFiles;
    }
}
