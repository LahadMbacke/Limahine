<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FtpMediaProxyController extends Controller
{
    /**
     * Servir un fichier média via proxy depuis le serveur FTP
     */
    public function serve(Request $request, string $mediaId)
    {
        try {
            // Trouver le média
            $media = Media::findOrFail($mediaId);

            // Construire l'URL FTP directe
            $baseUrl = config('filesystems.disks.ftp.url');
            $filePath = $media->getPath();
            $ftpUrl = rtrim($baseUrl, '/') . '/' . ltrim($filePath, '/');

            // Télécharger le fichier depuis le FTP
            $response = Http::timeout(30)->get($ftpUrl);

            if (!$response->successful()) {
                abort(404, 'Fichier non trouvé sur le serveur FTP');
            }

            // Retourner le fichier avec les bons headers
            return response($response->body(), 200, [
                'Content-Type' => $media->mime_type,
                'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
                'Cache-Control' => 'public, max-age=604800', // Cache 7 jours
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET',
                'Access-Control-Allow-Headers' => 'Content-Type',
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur proxy FTP', [
                'media_id' => $mediaId,
                'error' => $e->getMessage()
            ]);

            abort(404, 'Fichier non accessible');
        }
    }

    /**
     * Servir une conversion via proxy
     */
    public function serveConversion(Request $request, string $mediaId, string $conversion)
    {
        try {
            // Trouver le média
            $media = Media::findOrFail($mediaId);

            // Vérifier que la conversion existe
            if (!$media->hasGeneratedConversion($conversion)) {
                abort(404, 'Conversion non trouvée');
            }

            // Construire l'URL FTP pour la conversion
            $baseUrl = config('filesystems.disks.ftp.url');
            $conversionPath = $media->getPath($conversion);
            $ftpUrl = rtrim($baseUrl, '/') . '/' . ltrim($conversionPath, '/');

            // Télécharger le fichier depuis le FTP
            $response = Http::timeout(30)->get($ftpUrl);

            if (!$response->successful()) {
                abort(404, 'Conversion non trouvée sur le serveur FTP');
            }

            // Retourner la conversion avec les bons headers
            return response($response->body(), 200, [
                'Content-Type' => 'image/jpeg', // Les conversions sont généralement en JPEG
                'Content-Disposition' => 'inline',
                'Cache-Control' => 'public, max-age=604800', // Cache 7 jours
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET',
                'Access-Control-Allow-Headers' => 'Content-Type',
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur proxy conversion FTP', [
                'media_id' => $mediaId,
                'conversion' => $conversion,
                'error' => $e->getMessage()
            ]);

            abort(404, 'Conversion non accessible');
        }
    }
}
