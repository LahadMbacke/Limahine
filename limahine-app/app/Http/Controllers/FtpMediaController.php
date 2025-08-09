<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FtpMigrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FtpMediaController extends Controller
{
    protected FtpMigrationService $ftpService;

    public function __construct(FtpMigrationService $ftpService)
    {
        $this->ftpService = $ftpService;
    }

    /**
     * Tester la connexion FTP
     */
    public function testConnection(): JsonResponse
    {
        try {
            $isConnected = $this->ftpService->testFtpConnection();
            
            return response()->json([
                'success' => $isConnected,
                'message' => $isConnected ? 'Connexion FTP réussie' : 'Échec de la connexion FTP',
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors du test de connexion FTP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test de connexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtenir les informations du serveur FTP
     */
    public function getInfo(): JsonResponse
    {
        try {
            $info = $this->ftpService->getFtpInfo();
            
            return response()->json([
                'success' => true,
                'data' => $info
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des infos FTP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des informations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Démarrer la migration des médias vers FTP
     */
    public function startMigration(Request $request): JsonResponse
    {
        try {
            // Vérifier la connexion avant de commencer
            if (!$this->ftpService->testFtpConnection()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de se connecter au serveur FTP'
                ], 400);
            }

            // Lancer la migration
            $results = $this->ftpService->migrateAllMedia();
            
            Log::info('Migration FTP terminée', $results);

            return response()->json([
                'success' => true,
                'message' => 'Migration terminée',
                'data' => $results
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la migration FTP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la migration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vérifier le statut de la migration
     */
    public function getMigrationStatus(): JsonResponse
    {
        try {
            // Obtenir le nombre de médias par disque
            $localMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('disk', 'local')->count();
            $publicMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('disk', 'public')->count();
            $ftpMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('disk', 'ftp')->count();
            $totalMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_media' => $totalMedia,
                    'local_media' => $localMedia,
                    'public_media' => $publicMedia,
                    'ftp_media' => $ftpMedia,
                    'migration_progress' => $totalMedia > 0 ? round(($ftpMedia / $totalMedia) * 100, 2) : 0
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du statut',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
