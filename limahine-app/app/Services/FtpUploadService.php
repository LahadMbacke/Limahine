<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FtpUploadService
{
    /**
     * Uploader un fichier vers le serveur FTP
     */
    public function uploadFile(UploadedFile $file, string $path = ''): ?string
    {
        try {
            // Générer un nom de fichier unique
            $filename = $this->generateUniqueFilename($file);

            // Définir le chemin complet
            $fullPath = trim($path, '/') . '/' . $filename;
            $fullPath = ltrim($fullPath, '/');

            // Uploader vers FTP
            $uploaded = Storage::disk('ftp')->putFileAs(
                dirname($fullPath),
                $file,
                basename($fullPath)
            );

            if ($uploaded) {
                Log::info('Fichier uploadé vers FTP', [
                    'original_name' => $file->getClientOriginalName(),
                    'ftp_path' => $uploaded,
                    'size' => $file->getSize()
                ]);

                return $uploaded;
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Erreur upload FTP', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Supprimer un fichier du serveur FTP
     */
    public function deleteFile(string $path): bool
    {
        try {
            return Storage::disk('ftp')->delete($path);
        } catch (\Exception $e) {
            Log::error('Erreur suppression FTP', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Obtenir l'URL publique d'un fichier FTP
     */
    public function getPublicUrl(string $path): string
    {
        $baseUrl = config('filesystems.disks.ftp.url');
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Tester la connexion FTP
     */
    public function testConnection(): bool
    {
        try {
            $testFile = 'test_connection_' . time() . '.txt';
            $testContent = 'Test connexion FTP - ' . now()->toISOString();

            // Essayer d'écrire un fichier de test
            $written = Storage::disk('ftp')->put($testFile, $testContent);

            if ($written) {
                // Vérifier que le fichier existe
                $exists = Storage::disk('ftp')->exists($testFile);

                // Nettoyer le fichier de test
                Storage::disk('ftp')->delete($testFile);

                return $exists;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Test connexion FTP échoué', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Générer un nom de fichier unique
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Nettoyer le nom de base
        $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
        $basename = substr($basename, 0, 50); // Limiter la longueur

        // Générer un timestamp unique
        $timestamp = time();
        $random = substr(md5(uniqid()), 0, 8);

        return $basename . '_' . $timestamp . '_' . $random . '.' . $extension;
    }

    /**
     * Lister les fichiers dans un répertoire FTP
     */
    public function listFiles(string $directory = ''): array
    {
        try {
            return Storage::disk('ftp')->files($directory);
        } catch (\Exception $e) {
            Log::error('Erreur listage FTP', [
                'directory' => $directory,
                'error' => $e->getMessage()
            ]);

            return [];
        }
    }
}
