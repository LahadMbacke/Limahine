<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SecureMediaController extends Controller
{
    /**
     * Servir un fichier média de manière sécurisée
     *
     * @param string $uuid UUID du média
     * @param string $filename Nom du fichier (optionnel pour validation)
     * @return Response|StreamedResponse
     */
    public function serve(Request $request, string $uuid, string $filename = null)
    {
        try {
            // Trouver le média par UUID
            $media = Media::where('uuid', $uuid)->firstOrFail();

            // Vérifier que le fichier existe
            if (!Storage::disk($media->disk)->exists($media->getPath())) {
                abort(404, 'Fichier non trouvé');
            }

            // Obtenir le chemin du fichier
            $filePath = Storage::disk($media->disk)->path($media->getPath());

            // Vérifier l'extension du fichier pour empêcher l'exécution
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'mp3', 'wav', 'ogg'];
            $extension = strtolower(pathinfo($media->file_name, PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                abort(403, 'Type de fichier non autorisé');
            }

            // Logger l'accès pour audit
            Log::info('Fichier média accédé', [
                'media_id' => $media->id,
                'uuid' => $uuid,
                'filename' => $media->file_name,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Headers de sécurité pour empêcher le téléchargement
            $headers = [
                'Content-Type' => $media->mime_type,
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'DENY',
                'X-XSS-Protection' => '1; mode=block',
                'Content-Security-Policy' => "default-src 'none'; img-src 'self'; object-src 'none';",
                // Empêcher le téléchargement direct
                'Content-Disposition' => 'inline; filename="' . $media->name . '"',
                // Headers pour empêcher la mise en cache côté navigateur
                'X-Robots-Tag' => 'noindex, nofollow, noarchive, nosnippet',
            ];

            // Pour les images, on peut les afficher inline
            if (str_starts_with($media->mime_type, 'image/')) {
                return response()->file($filePath, $headers);
            }

            // Pour les autres types (PDF, audio), streaming sécurisé
            return response()->stream(function () use ($filePath) {
                $stream = fopen($filePath, 'rb');
                fpassthru($stream);
                fclose($stream);
            }, 200, $headers);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la lecture du fichier média', [
                'uuid' => $uuid,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);

            abort(404, 'Fichier non trouvé');
        }
    }

    /**
     * Servir une conversion d'image (thumbnail, etc.)
     */
    public function serveConversion(Request $request, string $uuid, string $conversion, string $filename = null)
    {
        try {
            $media = Media::where('uuid', $uuid)->firstOrFail();

            // Vérifier que la conversion existe
            if (!$media->hasGeneratedConversion($conversion)) {
                abort(404, 'Conversion non trouvée');
            }

            $conversionPath = $media->getPath($conversion);

            if (!Storage::disk($media->conversions_disk ?? $media->disk)->exists($conversionPath)) {
                abort(404, 'Fichier de conversion non trouvé');
            }

            $filePath = Storage::disk($media->conversions_disk ?? $media->disk)->path($conversionPath);

            $headers = [
                'Content-Type' => 'image/jpeg', // Les conversions sont généralement en JPEG
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'DENY',
                'Content-Disposition' => 'inline',
                'X-Robots-Tag' => 'noindex, nofollow, noarchive, nosnippet',
            ];

            return response()->file($filePath, $headers);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la lecture de la conversion', [
                'uuid' => $uuid,
                'conversion' => $conversion,
                'error' => $e->getMessage(),
            ]);

            abort(404, 'Conversion non trouvée');
        }
    }
}
