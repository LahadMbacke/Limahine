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

            // Vérifier que le fichier existe sur FTP
            if (!Storage::disk('ftp')->exists($media->getPath())) {
                abort(404, 'Fichier non trouvé sur le serveur FTP');
            }

            // Récupérer le contenu du fichier depuis FTP
            $fileContent = Storage::disk('ftp')->get($media->getPath());

            // Retourner le fichier avec les bons headers
            return response($fileContent, 200, [
                'Content-Type' => $media->mime_type,
                'Content-Disposition' => 'inline; filename="' . $media->file_name . '"',
                'Cache-Control' => 'public, max-age=604800', // Cache 7 jours
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET',
                'Access-Control-Allow-Headers' => 'Content-Type',
                'Content-Length' => strlen($fileContent),
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
            $conversionPath = $media->getPath($conversion);

            // Vérifier que le fichier de conversion existe sur FTP
            if (!Storage::disk('ftp')->exists($conversionPath)) {
                abort(404, 'Conversion non trouvée sur le serveur FTP');
            }

            // Récupérer le contenu de la conversion depuis FTP
            $fileContent = Storage::disk('ftp')->get($conversionPath);

            // Retourner la conversion avec les bons headers
            return response($fileContent, 200, [
                'Content-Type' => 'image/jpeg', // Les conversions sont généralement en JPEG
                'Content-Disposition' => 'inline',
                'Cache-Control' => 'public, max-age=604800', // Cache 7 jours
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET',
                'Access-Control-Allow-Headers' => 'Content-Type',
                'Content-Length' => strlen($fileContent),
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
