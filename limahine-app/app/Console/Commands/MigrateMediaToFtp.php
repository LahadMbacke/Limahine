<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FtpMigrationService;
use Illuminate\Support\Facades\Log;

class MigrateMediaToFtp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:migrate-to-ftp 
                            {--test : Tester la connexion FTP uniquement}
                            {--info : Afficher les informations FTP}
                            {--force : Forcer la migration sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrer tous les fichiers média vers le serveur FTP';

    protected FtpMigrationService $ftpService;

    public function __construct(FtpMigrationService $ftpService)
    {
        parent::__construct();
        $this->ftpService = $ftpService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Migration des médias vers FTP');
        $this->newLine();

        // Test de connexion
        if ($this->option('test')) {
            return $this->testConnection();
        }

        // Informations FTP
        if ($this->option('info')) {
            return $this->showFtpInfo();
        }

        // Test de connexion avant migration
        $this->info('📡 Test de la connexion FTP...');
        if (!$this->ftpService->testFtpConnection()) {
            $this->error('❌ Impossible de se connecter au serveur FTP !');
            $this->error('Vérifiez la configuration dans le fichier .env');
            return Command::FAILURE;
        }
        $this->info('✅ Connexion FTP réussie !');
        $this->newLine();

        // Confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('Voulez-vous vraiment migrer tous les fichiers vers FTP ?')) {
                $this->info('Migration annulée.');
                return Command::SUCCESS;
            }
        }

        // Migration
        $this->info('🔄 Migration en cours...');
        $bar = $this->output->createProgressBar();
        $bar->start();

        $results = $this->ftpService->migrateAllMedia();

        $bar->finish();
        $this->newLine(2);

        // Résultats
        $this->displayResults($results);

        return $results['failed'] > 0 ? Command::FAILURE : Command::SUCCESS;
    }    protected function testConnection(): int
    {
        $this->info('🔍 Test de la connexion FTP...');
        
        // Test avec la méthode native
        $nativeResult = $this->ftpService->testNativeFtpConnection();
        
        if ($nativeResult['success']) {
            $this->info('✅ Connexion FTP native réussie !');
            $this->table(['Information', 'Valeur'], [
                ['Serveur', $nativeResult['config']['host']],
                ['Port', $nativeResult['config']['port']],
                ['Utilisateur', $nativeResult['config']['username']],
                ['Répertoire racine', $nativeResult['config']['root']],
                ['Nombre de fichiers', $nativeResult['files_count']],
            ]);
            
            if (!empty($nativeResult['files'])) {
                $this->newLine();
                $this->info('📁 Quelques fichiers présents :');
                foreach ($nativeResult['files'] as $file) {
                    $this->line('  • ' . $file);
                }
            }
            
            // Test avec Flysystem
            $this->newLine();
            $this->info('🔍 Test avec Flysystem...');
            if ($this->ftpService->testFtpConnection()) {
                $this->info('✅ Connexion Flysystem réussie !');
            } else {
                $this->warn('⚠️  Connexion Flysystem échouée (mais native fonctionne)');
                $this->line('  Cela peut indiquer un problème de configuration dans filesystems.php');
            }
            
            return Command::SUCCESS;
        } else {
            $this->error('❌ Échec de la connexion FTP native !');
            $this->error('Erreur: ' . $nativeResult['message']);
            $this->error('Vérifiez les paramètres suivants dans votre fichier .env :');
            $this->table(['Paramètre', 'Valeur'], [
                ['FTP_HOST', $nativeResult['config']['host']],
                ['FTP_USERNAME', $nativeResult['config']['username']],
                ['FTP_PORT', $nativeResult['config']['port']],
                ['FTP_ROOT', $nativeResult['config']['root']],
            ]);
            return Command::FAILURE;
        }
    }

    protected function showFtpInfo(): int
    {
        $this->info('📊 Informations du serveur FTP :');
        $this->newLine();

        $info = $this->ftpService->getFtpInfo();

        if (!$info['connection_ok']) {
            $this->error('❌ Impossible de récupérer les informations FTP');
            $this->error('Erreur: ' . $info['error']);
            return Command::FAILURE;
        }

        $this->table(['Information', 'Valeur'], [
            ['Statut de connexion', '✅ Connecté'],
            ['Nombre de fichiers', $info['files_count']],
            ['Nombre de dossiers', $info['directories_count']],
        ]);

        if (!empty($info['files'])) {
            $this->newLine();
            $this->info('📁 Quelques fichiers présents :');
            foreach (array_slice($info['files'], 0, 5) as $file) {
                $this->line('  • ' . $file);
            }
        }

        if (!empty($info['directories'])) {
            $this->newLine();
            $this->info('📂 Quelques dossiers présents :');
            foreach (array_slice($info['directories'], 0, 5) as $dir) {
                $this->line('  • ' . $dir);
            }
        }

        return Command::SUCCESS;
    }

    protected function displayResults(array $results): void
    {
        $this->info('📈 Résultats de la migration :');
        $this->newLine();

        $this->table(['Statut', 'Nombre'], [
            ['✅ Réussis', $results['success']],
            ['❌ Échecs', $results['failed']],
            ['📊 Total', $results['success'] + $results['failed']],
        ]);

        if (!empty($results['errors'])) {
            $this->newLine();
            $this->error('❌ Erreurs rencontrées :');
            foreach ($results['errors'] as $error) {
                $this->line("  • {$error['file_name']} (ID: {$error['media_id']})");
                $this->line("    Erreur: {$error['error']}");
            }
        }

        if ($results['success'] > 0) {
            $this->newLine();
            $this->info('🎉 Migration terminée avec succès !');
            $this->info('Les fichiers sont maintenant stockés sur votre serveur FTP.');
        }
    }
}
