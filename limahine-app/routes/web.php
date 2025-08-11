<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\VideoTrailerController;
use App\Http\Controllers\FilsCheikhController;
use App\Http\Controllers\SecureMediaController;
use App\Http\Controllers\FtpMediaController;
use App\Http\Controllers\FtpMediaProxyController;
use App\Http\Controllers\SecureDocumentController;

// Routes pour la gestion des langues
Route::post('/language/switch', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/language/current', [LanguageController::class, 'current'])->name('language.current');

// Routes pour le FTP Media
Route::prefix('admin/ftp')->middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('admin.ftp-admin');
    })->name('ftp.admin');
    Route::get('/test-connection', [FtpMediaController::class, 'testConnection'])->name('ftp.test');
    Route::get('/info', [FtpMediaController::class, 'getInfo'])->name('ftp.info');
    Route::post('/migrate', [FtpMediaController::class, 'startMigration'])->name('ftp.migrate');
    Route::get('/status', [FtpMediaController::class, 'getMigrationStatus'])->name('ftp.status');
});

// Route pour la page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour les pages principales
Route::get('/publications', [HomeController::class, 'writing'])->name('writing');
Route::get('/mouridisme', [HomeController::class, 'mouridisme'])->name('mouridisme');
Route::get('/temoignages', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/chercheurs', [HomeController::class, 'chercheurs'])->name('chercheurs');

// Routes pour les publications individuelles
Route::get('/publications/{publication:slug}', [HomeController::class, 'showPublication'])->name('publications.show');

// Route sécurisée pour visualiser les documents (lecture seule)
Route::get('/publications/{publication}/documents/{documentIndex}/secure-view', [SecureDocumentController::class, 'viewDocument'])->name('publications.documents.secure-view');

// Routes pour les documents des publications (anciennes, à supprimer éventuellement)
Route::get('/publications/{publication:id}/documents/{document}/view', [HomeController::class, 'viewDocument'])->name('publications.documents.view');
Route::get('/publications/{publication:id}/documents/{document}/serve', [HomeController::class, 'serveDocument'])->name('publications.documents.serve');

// Route de test pour diagnostiquer le problème d'affichage des médias FTP
Route::get('/test-media-ftp', function() {
    $results = [];

    try {
        // 1. Test de la connexion FTP
        $results['ftp_config'] = [
            'host' => config('filesystems.disks.ftp.host'),
            'url' => config('filesystems.disks.ftp.url'),
            'disk_name' => config('media-library.disk_name'),
        ];

        // 2. Compter les médias FTP
        $ftpMediaCount = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('disk', 'ftp')->count();
        $results['ftp_media_count'] = $ftpMediaCount;

        // 3. Tester quelques médias FTP
        $testMedias = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('disk', 'ftp')
            ->take(3)
            ->get()
            ->map(function($media) {
                try {
                    return [
                        'id' => $media->id,
                        'file_name' => $media->file_name,
                        'collection' => $media->collection_name,
                        'path' => $media->getPath(),
                        'url' => $media->getUrl(),
                        'exists_on_ftp' => \Storage::disk('ftp')->exists($media->getPath()),
                        'custom_properties' => $media->custom_properties,
                    ];
                } catch (\Exception $e) {
                    return [
                        'id' => $media->id,
                        'error' => $e->getMessage()
                    ];
                }
            });

        $results['test_medias'] = $testMedias;

        // 4. Tester une publication avec médias
        $publicationWithMedia = \App\Models\Publication::has('media')->first();
        if ($publicationWithMedia) {
            $results['publication_test'] = [
                'id' => $publicationWithMedia->id,
                'title' => $publicationWithMedia->getLocalizedTitle(),
                'featured_image_url' => $publicationWithMedia->getFeaturedImageUrl(),
                'documents_count' => $publicationWithMedia->getDocumentsCount(),
                'documents' => $publicationWithMedia->getFormattedDocuments(),
            ];
        }

        return response()->json($results, 200, [], JSON_PRETTY_PRINT);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Route de test pour la configuration FTP
Route::get('/test-ftp', function() {
    try {
        $config = config('filesystems.disks.ftp');

        $results = [
            'config_loaded' => true,
            'config' => [
                'host' => $config['host'],
                'port' => $config['port'],
                'username' => $config['username'],
                'root' => $config['root'],
            ]
        ];

        // Test de connexion avec Storage
        $ftpDisk = Storage::disk('ftp');
        $testContent = "Test Laravel FTP - " . now();
        $testFile = 'test_laravel.txt';

        $writeResult = $ftpDisk->put($testFile, $testContent);
        $results['write_test'] = $writeResult;

        if ($writeResult) {
            $results['file_exists'] = $ftpDisk->exists($testFile);
            if ($ftpDisk->exists($testFile)) {
                $results['content'] = $ftpDisk->get($testFile);
                $ftpDisk->delete($testFile);
                $results['cleanup'] = true;
            }
        }

        return response()->json($results);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Route de test pour vérifier les méthodes de Publication
Route::get('/test-publication-methods', function() {
    $publication = \App\Models\Publication::first();
    if (!$publication) {
        return response()->json(['error' => 'Aucune publication trouvée']);
    }

    $methods = [];
    $methods['hasDocuments_exists'] = method_exists($publication, 'hasDocuments');
    $methods['getDocuments_exists'] = method_exists($publication, 'getDocuments');
    $methods['getDocumentsCount_exists'] = method_exists($publication, 'getDocumentsCount');
    $methods['getFormattedDocuments_exists'] = method_exists($publication, 'getFormattedDocuments');

    if ($methods['hasDocuments_exists']) {
        $methods['hasDocuments_result'] = $publication->hasDocuments();
        $methods['getDocumentsCount_result'] = $publication->getDocumentsCount();
    }

    return response()->json([
        'publication_id' => $publication->id,
        'publication_title' => $publication->getLocalizedTitle(),
        'methods' => $methods,
        'class' => get_class($publication)
    ]);
});

// Route de test pour les documents
Route::get('/test-documents/{publicationId}', function($publicationId) {
    $publication = \App\Models\Publication::findOrFail($publicationId);
    $documents = $publication->getMedia('documents');
    return response()->json([
        'publication_id' => $publication->id,
        'publication_title' => $publication->getLocalizedTitle(),
        'documents_count' => $documents->count(),
        'documents' => $documents->map(function($doc) use ($publication) {
            return [
                'id' => $doc->id,
                'name' => $doc->name,
                'file_name' => $doc->file_name,
                'mime_type' => $doc->mime_type,
                'size' => $doc->size,
                'view_url' => route('publications.documents.view', ['publication' => $publication->id, 'document' => $doc->id]),
                'serve_url' => route('publications.documents.serve', ['publication' => $publication->id, 'document' => $doc->id])
            ];
        })
    ]);
});

// Routes pour la section Découverte - Fils de Cheikh Ahmadou Bamba (DÉSACTIVÉES)
// Route::get('/decouverte', [FilsCheikhController::class, 'index'])->name('decouverte.index');
// Route::get('/decouverte/{filsCheikh:slug}', [FilsCheikhController::class, 'show'])->name('decouverte.show');
// Route::get('/decouverte/{filsCheikh:slug}/publications', [FilsCheikhController::class, 'publications'])->name('decouverte.publications');

// Routes pour les Vidéo
Route::get('/trailers', [VideoTrailerController::class, 'index'])->name('trailers.index');
Route::get('/trailers/{slug}', [VideoTrailerController::class, 'show'])->name('trailers.show');
Route::get('/api/trailers', [VideoTrailerController::class, 'api'])->name('trailers.api');

// Routes sécurisées pour les médias
Route::get('/secure-media/{uuid}/{filename?}', [SecureMediaController::class, 'serve'])
    ->name('secure-media.serve')
    ->where('uuid', '[0-9a-f-]+');
Route::get('/secure-media/{uuid}/conversions/{conversion}/{filename?}', [SecureMediaController::class, 'serveConversion'])
    ->name('secure-media.conversion')
    ->where('uuid', '[0-9a-f-]+');

// Routes pour le proxy FTP
Route::get('/ftp-media/{mediaId}', [FtpMediaProxyController::class, 'serve'])
    ->name('ftp-media.serve')
    ->where('mediaId', '[0-9]+');
Route::get('/ftp-media/{mediaId}/conversions/{conversion}', [FtpMediaProxyController::class, 'serveConversion'])
    ->name('ftp-media.serve-conversion')
    ->where('mediaId', '[0-9]+');

// Route de test pour diagnostiquer le problème de la page découverte
Route::get('/test-decouverte-debug', function () {
    $output = [];

    try {
        $output[] = "=== TEST DE DIAGNOSTIC DECOUVERTE ===";

        // 1. Test du modèle FilsCheikh
        $output[] = "1. Test du modèle FilsCheikh...";
        $filsCheikhCount = \App\Models\FilsCheikh::count();
        $output[] = "✓ Nombre de FilsCheikh: " . $filsCheikhCount;

        // 2. Test des scopes
        $output[] = "2. Test des scopes...";
        $publishedCount = \App\Models\FilsCheikh::published()->count();
        $output[] = "✓ FilsCheikh publiés: " . $publishedCount;

        $khalifCount = \App\Models\FilsCheikh::khalifs()->count();
        $output[] = "✓ Khalifs: " . $khalifCount;

        $otherCount = \App\Models\FilsCheikh::nonKhalifs()->count();
        $output[] = "✓ Non-Khalifs: " . $otherCount;

        // 3. Test du modèle Publication
        $output[] = "3. Test du modèle Publication...";
        $publicationCount = \App\Models\Publication::count();
        $output[] = "✓ Nombre de Publications: " . $publicationCount;

        // 4. Test de la vue
        $output[] = "4. Test de rendu de la vue...";
        $khalifs = \App\Models\FilsCheikh::published()->khalifs()->get();
        $autres_fils = \App\Models\FilsCheikh::published()->nonKhalifs()->orderBy('name->fr')->get();
        $recent_publications = \App\Models\Publication::published()
            ->byCategory('decouverte')
            ->with('filsCheikh')
            ->latest('published_at')
            ->take(6)
            ->get();

        $output[] = "✓ Données chargées:";
        $output[] = "  - Khalifs: " . $khalifs->count();
        $output[] = "  - Autres fils: " . $autres_fils->count();
        $output[] = "  - Publications récentes: " . $recent_publications->count();

        // 5. Test de rendu de la vue
        $output[] = "5. Test de rendu de la vue decouverte.index...";
        $view = view('decouverte.index', compact('khalifs', 'autres_fils', 'recent_publications'));
        $content = $view->render();
        $output[] = "✓ Vue rendue avec succès (" . strlen($content) . " caractères)";

    } catch (\Exception $e) {
        $output[] = "✗ ERREUR: " . $e->getMessage();
        $output[] = "Trace: " . $e->getTraceAsString();
    }

    return response('<pre>' . implode("\n", $output) . '</pre>');
});
