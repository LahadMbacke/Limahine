<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FtpMediaService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FixFtpMediaPaths extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'ftp:fix-media-paths {--dry-run : Afficher ce qui sera fait sans l\'exécuter}';

    /**
     * The console command description.
     */
    protected $description = 'Corriger les chemins des médias FTP et enregistrer les URLs complètes en base de données';

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
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 Mode dry-run activé - aucun changement ne sera effectué');
        }

        $this->info('🔄 Recherche des médias FTP...');

        // Récupérer tous les médias sur FTP
        $ftpMedias = Media::where('disk', 'ftp')->get();

        if ($ftpMedias->isEmpty()) {
            $this->warn('⚠️  Aucun média FTP trouvé');
            return Command::SUCCESS;
        }

        $this->info("📁 {$ftpMedias->count()} médias FTP trouvés");

        $updated = 0;
        $errors = 0;

        $this->withProgressBar($ftpMedias, function ($media) use (&$updated, &$errors, $isDryRun) {
            try {
                // Vérifier si le chemin complet est déjà enregistré
                $customProperties = $media->custom_properties ?? [];
                $hasFullUrl = isset($customProperties['ftp_full_url']);

                if ($hasFullUrl) {
                    // Vérifier si l'URL est correcte
                    $baseUrl = config('filesystems.disks.ftp.url');
                    $expectedUrl = rtrim($baseUrl, '/') . '/' . ltrim($media->getPath(), '/');

                    if ($customProperties['ftp_full_url'] !== $expectedUrl) {
                        if (!$isDryRun) {
                            $this->ftpMediaService->saveMediaWithFullFtpPath($media);
                        }
                        $updated++;
                    }
                } else {
                    // Pas de chemin complet, l'ajouter
                    if (!$isDryRun) {
                        $this->ftpMediaService->saveMediaWithFullFtpPath($media);
                    }
                    $updated++;
                }

            } catch (\Exception $e) {
                $errors++;
                $this->newLine();
                $this->error("❌ Erreur pour le média {$media->id}: {$e->getMessage()}");
            }
        });

        $this->newLine(2);

        // Afficher les résultats
        $this->info('📊 Résumé de l\'opération:');
        $this->table(['Statut', 'Nombre'], [
            ['✅ Médias mis à jour', $updated],
            ['❌ Erreurs', $errors],
            ['📊 Total traité', $ftpMedias->count()],
        ]);

        if ($isDryRun && $updated > 0) {
            $this->info("💡 Relancez sans --dry-run pour appliquer les changements");
        } elseif (!$isDryRun && $updated > 0) {
            $this->info("🎉 Opération terminée avec succès!");
        }

        return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
