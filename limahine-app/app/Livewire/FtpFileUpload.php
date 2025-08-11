<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\FtpUploadService;
use Illuminate\Support\Facades\Log;

class FtpFileUpload extends Component
{
    use WithFileUploads;

    public $files = [];
    public $uploadedFiles = [];
    public $isUploading = false;
    public $uploadProgress = 0;

    protected FtpUploadService $ftpService;

    public function boot(FtpUploadService $ftpService)
    {
        $this->ftpService = $ftpService;
    }

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'file|max:61440', // 60MB max
        ]);

        $this->uploadFiles();
    }

    public function uploadFiles()
    {
        if (empty($this->files)) {
            return;
        }

        $this->isUploading = true;
        $this->uploadProgress = 0;

        $totalFiles = count($this->files);
        $uploadedCount = 0;

        foreach ($this->files as $file) {
            try {
                // Upload vers FTP
                $ftpPath = $this->ftpService->uploadFile($file, 'uploads');

                if ($ftpPath) {
                    $this->uploadedFiles[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'ftp_path' => $ftpPath,
                        'url' => $this->ftpService->getPublicUrl($ftpPath),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ];

                    $uploadedCount++;
                }

                // Mettre à jour la progression
                $this->uploadProgress = round(($uploadedCount / $totalFiles) * 100);

            } catch (\Exception $e) {
                Log::error('Erreur upload Livewire FTP', [
                    'file' => $file->getClientOriginalName(),
                    'error' => $e->getMessage()
                ]);

                session()->flash('error', 'Erreur lors de l\'upload de ' . $file->getClientOriginalName());
            }
        }

        $this->isUploading = false;
        $this->files = [];

        if ($uploadedCount > 0) {
            session()->flash('success', "$uploadedCount fichier(s) uploadé(s) avec succès !");
        }

        $this->dispatch('filesUploaded', $this->uploadedFiles);
    }

    public function removeFile($index)
    {
        if (isset($this->uploadedFiles[$index])) {
            $file = $this->uploadedFiles[$index];

            // Supprimer du FTP
            $this->ftpService->deleteFile($file['ftp_path']);

            // Supprimer de la liste
            unset($this->uploadedFiles[$index]);
            $this->uploadedFiles = array_values($this->uploadedFiles);

            session()->flash('success', 'Fichier supprimé avec succès !');
        }
    }

    public function render()
    {
        return view('livewire.ftp-file-upload');
    }
}
