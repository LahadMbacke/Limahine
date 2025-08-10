<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureDocumentController extends Controller
{
    /**
     * Servir un document de manière sécurisée (lecture seule, pas de téléchargement)
     */
    public function viewDocument(Publication $publication, string $documentIndex)
    {
        // Vérifier que la publication existe et est publiée
        if (!$publication->is_published) {
            abort(404);
        }

        // Récupérer les documents de la publication
        $documents = $publication->documents ?? [];
        $documentIndex = (int) $documentIndex;

        // Vérifier que l'index du document est valide
        if (!isset($documents[$documentIndex])) {
            abort(404);
        }

        $documentPath = $documents[$documentIndex];
        $fullPath = storage_path('app/public/' . $documentPath);

        // Vérifier que le fichier existe
        if (!file_exists($fullPath)) {
            abort(404);
        }

        $extension = strtolower(pathinfo($documentPath, PATHINFO_EXTENSION));
        $filename = basename($documentPath);

        // Déterminer le type MIME
        $mimeType = $this->getMimeType($extension);

        // Créer une réponse streamée avec des en-têtes de sécurité
        return response()->stream(function () use ($fullPath) {
            $stream = fopen($fullPath, 'rb');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            // Empêcher le téléchargement avec des en-têtes spécifiques
            'Content-Security-Policy' => "default-src 'self'; object-src 'none'; frame-ancestors 'self';",
        ]);
    }

    /**
     * Obtenir le type MIME en fonction de l'extension
     */
    private function getMimeType(string $extension): string
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'txt' => 'text/plain',
            'rtf' => 'application/rtf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
