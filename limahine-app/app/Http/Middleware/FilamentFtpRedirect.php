<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FilamentFtpRedirect
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Intercepter les réponses Livewire qui contiennent des uploads
        if ($request->is('livewire/update') && $response->getStatusCode() === 200) {
            $this->processLivewireUploads($request, $response);
        }

        return $response;
    }

    /**
     * Traiter les uploads Livewire pour les transférer vers FTP
     */
    private function processLivewireUploads(Request $request, Response $response): void
    {
        try {
            $content = $response->getContent();
            $data = json_decode($content, true);

            if (isset($data['effects']['returns'])) {
                foreach ($data['effects']['returns'] as &$returnData) {
                    if (isset($returnData['uploads'])) {
                        $this->transferUploadsToFtp($returnData['uploads']);
                    }
                }

                // Mettre à jour la réponse avec les nouvelles données
                $response->setContent(json_encode($data));
            }

        } catch (\Exception $e) {
            Log::error('Erreur traitement uploads Livewire vers FTP', [
                'error' => $e->getMessage(),
                'url' => $request->url()
            ]);
        }
    }

    /**
     * Transférer les uploads vers FTP
     */
    private function transferUploadsToFtp(array &$uploads): void
    {
        foreach ($uploads as &$upload) {
            if (isset($upload['tmpFilename'])) {
                $this->transferSingleUploadToFtp($upload);
            }
        }
    }

    /**
     * Transférer un seul upload vers FTP
     */
    private function transferSingleUploadToFtp(array &$upload): void
    {
        try {
            $tmpPath = 'livewire-tmp/' . $upload['tmpFilename'];

            // Vérifier que le fichier temporaire existe
            if (!Storage::disk('public')->exists($tmpPath)) {
                return;
            }

            // Générer un nom de fichier unique pour FTP
            $extension = pathinfo($upload['name'], PATHINFO_EXTENSION);
            $basename = pathinfo($upload['name'], PATHINFO_FILENAME);
            $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
            $basename = substr($basename, 0, 50);

            $ftpFilename = $basename . '_' . time() . '_' . substr(md5(uniqid()), 0, 8) . '.' . $extension;
            $ftpPath = 'uploads/' . $ftpFilename;

            // Lire le contenu du fichier temporaire
            $fileContent = Storage::disk('public')->get($tmpPath);

            // Uploader vers FTP
            if (Storage::disk('ftp')->put($ftpPath, $fileContent)) {
                Log::info('Fichier transféré vers FTP', [
                    'original' => $upload['name'],
                    'ftp_path' => $ftpPath,
                    'tmp_path' => $tmpPath
                ]);

                // Mettre à jour les informations de l'upload
                $upload['ftp_path'] = $ftpPath;
                $upload['ftp_url'] = config('filesystems.disks.ftp.url') . '/' . $ftpPath;

                // Optionnel : supprimer le fichier temporaire après transfert
                // Storage::disk('public')->delete($tmpPath);
            }

        } catch (\Exception $e) {
            Log::error('Erreur transfert individuel vers FTP', [
                'upload' => $upload,
                'error' => $e->getMessage()
            ]);
        }
    }
}
