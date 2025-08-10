<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Enregistrer le service de migration FTP
        $this->app->singleton(\App\Services\FtpMigrationService::class);

        // Enregistrer le service de gestion des médias FTP
        $this->app->singleton(\App\Services\FtpMediaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Définir la locale par défaut depuis la session ou le config
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            App::setLocale(config('app.locale', 'fr'));
        }

        // Enregistrer les commandes FTP si nous sommes en mode console
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\TestFtpMedia::class,
                \App\Console\Commands\FixFtpMediaPaths::class,
                \App\Console\Commands\MigrateMediaToFtp::class,
            ]);
        }

        // Événement de transfert FTP désactivé pour éviter les conflits
        // Event::listen(
        //     \Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded::class,
        //     \App\Listeners\TransferMediaToFtp::class
        // );
    }
}
