<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FtpMigrationService
{
    /**
     * Migrer tous les fichiers média existants vers FTP
     */
    public function migrateAllMedia(): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        $mediaItems = Media::all();

        foreach ($mediaItems as $media) {
            try {
                $this->migrateMediaToFtp($media);
                $results['success']++;
                
                Log::info("Fichier migré vers FTP: {$media->file_name}", [
                    'media_id' => $media->id,
                    'path' => $media->getPath()
                ]);
                
            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = [
                    'media_id' => $media->id,
                    'file_name' => $media->file_name,
                    'error' => $e->getMessage()
                ];
                
                Log::error("Erreur lors de la migration FTP: {$media->file_name}", [
                    'media_id' => $media->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }

    /**
     * Migrer un fichier média spécifique vers FTP
     */
    public function migrateMediaToFtp(Media $media): bool
    {
        $originalDisk = $media->disk;
        $ftpDisk = 'ftp';

        // Vérifier si le fichier existe sur le disque original
        if (!Storage::disk($originalDisk)->exists($media->getPath())) {
            throw new \Exception("Fichier source non trouvé: {$media->getPath()}");
        }

        // Copier le fichier original vers FTP
        $fileContent = Storage::disk($originalDisk)->get($media->getPath());
        $ftpPath = $media->getPath();
        
        if (!Storage::disk($ftpDisk)->put($ftpPath, $fileContent)) {
            throw new \Exception("Impossible de copier le fichier vers FTP");
        }

        // Migrer les conversions
        $this->migrateConversions($media, $originalDisk, $ftpDisk);

        // Mettre à jour le disque dans la base de données
        $media->update([
            'disk' => $ftpDisk,
            'conversions_disk' => $ftpDisk
        ]);

        return true;
    }

    /**
     * Migrer les conversions d'un média vers FTP
     */
    protected function migrateConversions(Media $media, string $originalDisk, string $ftpDisk): void
    {
        $conversions = $media->getGeneratedConversions();

        foreach ($conversions as $conversionName => $generated) {
            if (!$generated) {
                continue;
            }

            try {
                $conversionPath = $media->getPath($conversionName);
                
                if (Storage::disk($originalDisk)->exists($conversionPath)) {
                    $conversionContent = Storage::disk($originalDisk)->get($conversionPath);
                    Storage::disk($ftpDisk)->put($conversionPath, $conversionContent);
                }
            } catch (\Exception $e) {
                Log::warning("Erreur lors de la migration de la conversion {$conversionName}", [
                    'media_id' => $media->id,
                    'conversion' => $conversionName,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Tester la connexion FTP
     */
    public function testFtpConnection(): bool
    {
        try {
            $testFile = 'test_connection.txt';
            $testContent = 'Test de connexion FTP - ' . now()->toISOString();
            
            // Écrire un fichier de test
            if (!Storage::disk('ftp')->put($testFile, $testContent)) {
                return false;
            }

            // Vérifier que le fichier existe
            if (!Storage::disk('ftp')->exists($testFile)) {
                return false;
            }

            // Nettoyer le fichier de test
            Storage::disk('ftp')->delete($testFile);

            return true;
        } catch (\Exception $e) {
            Log::error('Erreur de test de connexion FTP: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtenir des informations sur l'espace FTP
     */
    public function getFtpInfo(): array
    {
        try {
            $files = Storage::disk('ftp')->allFiles();
            $directories = Storage::disk('ftp')->allDirectories();
            
            return [
                'connection_ok' => true,
                'files_count' => count($files),
                'directories_count' => count($directories),
                'files' => array_slice($files, 0, 10), // Premiers 10 fichiers
                'directories' => array_slice($directories, 0, 10) // Premiers 10 dossiers
            ];
        } catch (\Exception $e) {
            return [
                'connection_ok' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Tester la connexion FTP avec les fonctions PHP natives
     */
    public function testNativeFtpConnection(): array
    {
        $host = config('filesystems.disks.ftp.host');
        $username = config('filesystems.disks.ftp.username');
        $password = config('filesystems.disks.ftp.password');
        $port = (int) config('filesystems.disks.ftp.port', 21);
        $root = config('filesystems.disks.ftp.root', '/');

        try {
            // Connexion
            $connection = ftp_connect($host, $port, 30);
            if (!$connection) {
                throw new \Exception("Impossible de se connecter au serveur FTP {$host}:{$port}");
            }

            // Authentification
            $login = ftp_login($connection, $username, $password);
            if (!$login) {
                ftp_close($connection);
                throw new \Exception("Échec de l'authentification FTP");
            }

            // Mode passif
            ftp_pasv($connection, true);

            // Changer vers le répertoire racine si nécessaire
            if ($root !== '/') {
                $changeDir = ftp_chdir($connection, $root);
                if (!$changeDir) {
                    ftp_close($connection);
                    throw new \Exception("Impossible de changer vers le répertoire {$root}");
                }
            }

            // Lister le contenu
            $files = ftp_nlist($connection, '.') ?: [];
            
            ftp_close($connection);

            return [
                'success' => true,
                'message' => 'Connexion FTP native réussie',
                'files_count' => count($files),
                'files' => array_slice($files, 0, 5),
                'config' => [
                    'host' => $host,
                    'port' => $port,
                    'root' => $root,
                    'username' => $username
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'files_count' => 0,
                'files' => [],
                'config' => [
                    'host' => $host,
                    'port' => $port,
                    'root' => $root,
                    'username' => $username
                ]
            ];
        }
    }
}
