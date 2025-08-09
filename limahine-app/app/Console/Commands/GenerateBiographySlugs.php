<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Biographie;

class GenerateBiographySlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'biographies:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Générer les slugs pour toutes les biographies existantes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Génération des slugs pour les biographies...');

        $biographies = Biographie::whereNull('slug')->orWhere('slug', '')->get();

        $count = 0;
        foreach ($biographies as $biographie) {
            $biographie->slug = $biographie->generateSlug();
            $biographie->save();
            $count++;

            $this->line("Slug généré pour: {$biographie->getLocalizedTitle()} -> {$biographie->slug}");
        }

        $this->info("✅ {$count} slugs générés avec succès!");

        return 0;
    }
}
