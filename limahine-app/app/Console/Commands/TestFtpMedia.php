<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FtpMediaService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Publication;

class TestFtpMedia extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'ftp:test-media {--publication-id= : ID d\'une publication spécifique à tester}';

    /**
     * The console command description.
     */
    protected $description = 'Tester l\'accès aux médias FTP et diagnostiquer les problèmes';

    protected FtpMediaService $ftpMediaService;

    public function __construct(FtpMediaService $ftpMediaService)
    {
        parent::__construct();
        $this->ftpMediaService = $ftpMediaService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Test des médias FTP...');

        // Test de la configuration FTP
        $this->testFtpConnection();

        // Test des médias
        if ($publicationId = $this->option('publication-id')) {
            $this->testPublicationMedia($publicationId);
        } else {
            $this->testAllMedia();
        }

        return Command::SUCCESS;
    }

    private function testFtpConnection(): void
    {
        $this->info('📡 Test de connexion FTP...');

        try {
            $config = config('filesystems.disks.ftp');

            $this->table(['Paramètre', 'Valeur'], [
                ['Host', $config['host'] ?? 'Non défini'],
                ['Port', $config['port'] ?? 'Non défini'],
                ['Username', $config['username'] ?? 'Non défini'],
                ['Root', $config['root'] ?? 'Non défini'],
                ['URL', $config['url'] ?? 'Non défini'],
            ]);

            // Test d'écriture
            $testFile = 'test_' . time() . '.txt';
            $testContent = 'Test de connexion FTP - ' . now();

            if (\Storage::disk('ftp')->put($testFile, $testContent)) {
                $this->info("✅ Écriture FTP réussie");

                // Test de lecture
                if (\Storage::disk('ftp')->exists($testFile)) {
                    $readContent = \Storage::disk('ftp')->get($testFile);
                    if ($readContent === $testContent) {
                        $this->info("✅ Lecture FTP réussie");
                    } else {
                        $this->error("❌ Contenu lu différent du contenu écrit");
                    }
                } else {
                    $this->error("❌ Fichier non trouvé après écriture");
                }

                // Nettoyage
                \Storage::disk('ftp')->delete($testFile);
                $this->info("✅ Nettoyage effectué");

            } else {
                $this->error("❌ Impossible d'écrire sur FTP");
            }

        } catch (\Exception $e) {
            $this->error("❌ Erreur de connexion FTP: " . $e->getMessage());
        }
    }

    private function testPublicationMedia(int $publicationId): void
    {
        $this->info("📄 Test des médias de la publication {$publicationId}...");

        $publication = Publication::find($publicationId);
        if (!$publication) {
            $this->error("❌ Publication {$publicationId} non trouvée");
            return;
        }

        $this->info("Publication: " . $publication->getLocalizedTitle());

        // Test de l'image mise en avant
        $featuredImage = $publication->getFirstMedia('featured_image');
        if ($featuredImage) {
            $this->testMedia($featuredImage, 'Image mise en avant');
        }

        // Test des documents
        $documents = $publication->getMedia('documents');
        $this->info("📎 {$documents->count()} document(s) trouvé(s)");

        foreach ($documents as $document) {
            $this->testMedia($document, 'Document');
        }

        // Test des images de galerie
        $galleryImages = $publication->getMedia('gallery');
        if ($galleryImages->isNotEmpty()) {
            $this->info("🖼️ {$galleryImages->count()} image(s) de galerie trouvée(s)");
            foreach ($galleryImages as $image) {
                $this->testMedia($image, 'Image de galerie');
            }
        }
    }

    private function testAllMedia(): void
    {
        $this->info('📁 Test de tous les médias FTP...');

        $ftpMedias = Media::where('disk', 'ftp')->get();
        $this->info("📊 {$ftpMedias->count()} médias FTP trouvés");

        if ($ftpMedias->isEmpty()) {
            $this->warn('⚠️ Aucun média FTP trouvé');
            return;
        }

        $accessible = 0;
        $inaccessible = 0;

        foreach ($ftpMedias as $media) {
            if ($this->ftpMediaService->isAccessible($media)) {
                $accessible++;
            } else {
                $inaccessible++;
                $this->error("❌ Média inaccessible: {$media->file_name} (ID: {$media->id})");
            }
        }

        $this->table(['Statut', 'Nombre'], [
            ['✅ Accessibles', $accessible],
            ['❌ Inaccessibles', $inaccessible],
            ['📊 Total', $ftpMedias->count()],
        ]);
    }

    private function testMedia(Media $media, string $type): void
    {
        $this->line("  🔍 Test {$type}: {$media->file_name}");

        $details = [
            ['Propriété', 'Valeur'],
            ['ID', $media->id],
            ['Disque', $media->disk],
            ['Collection', $media->collection_name],
            ['Chemin', $media->getPath()],
            ['Taille', $media->human_readable_size],
            ['Type MIME', $media->mime_type],
        ];

        // Tester l'accessibilité
        if ($this->ftpMediaService->isAccessible($media)) {
            $details[] = ['Accessibilité FTP', '✅ Accessible'];
        } else {
            $details[] = ['Accessibilité FTP', '❌ Inaccessible'];
        }

        // Tester l'URL
        try {
            $url = $media->getUrl();
            $details[] = ['URL générée', $url];
        } catch (\Exception $e) {
            $details[] = ['URL générée', "❌ Erreur: " . $e->getMessage()];
        }

        // Tester l'URL complète FTP
        $fullUrl = $this->ftpMediaService->getFullFtpUrl($media);
        if ($fullUrl) {
            $details[] = ['URL FTP complète', $fullUrl];
        } else {
            $details[] = ['URL FTP complète', '❌ Non disponible'];
        }

        $this->table(['Propriété', 'Valeur'], $details);
        $this->newLine();
    }
}
