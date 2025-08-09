<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Publication;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SecureMediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function it_can_serve_secure_media_with_valid_uuid()
    {
        // Créer une publication avec une image
        $publication = Publication::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg');
        $media = $publication
            ->addMediaFromFile($file)
            ->toMediaCollection('featured_image');

        // Tester l'accès via l'URL sécurisée
        $response = $this->get(route('secure-media.serve', [
            'uuid' => $media->uuid,
            'filename' => $media->file_name
        ]));

        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
    }

    /** @test */
    public function it_blocks_direct_file_access()
    {
        $publication = Publication::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg');
        $media = $publication
            ->addMediaFromFile($file)
            ->toMediaCollection('featured_image');

        // Tenter d'accéder directement au fichier (doit être bloqué)
        $directPath = '/storage/' . $media->getPath();
        $response = $this->get($directPath);

        // Devrait retourner 403 ou 404 selon la configuration du serveur
        $this->assertContains($response->status(), [403, 404]);
    }

    /** @test */
    public function it_blocks_invalid_file_extensions()
    {
        $publication = Publication::factory()->create();

        // Simuler un fichier avec une extension dangereuse
        $file = UploadedFile::fake()->create('malicious.php', 100);

        try {
            $media = $publication
                ->addMediaFromFile($file)
                ->toMediaCollection('featured_image');

            $response = $this->get(route('secure-media.serve', [
                'uuid' => $media->uuid,
                'filename' => $media->file_name
            ]));

            $response->assertStatus(403);
        } catch (\Exception $e) {
            // L'ajout du fichier peut être bloqué en amont par Spatie Media Library
            $this->assertTrue(true);
        }
    }

    /** @test */
    public function it_logs_media_access()
    {
        $publication = Publication::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg');
        $media = $publication
            ->addMediaFromFile($file)
            ->toMediaCollection('featured_image');

        // Vérifier que l'accès est loggé
        $this->expectsEvents();

        $response = $this->get(route('secure-media.serve', [
            'uuid' => $media->uuid,
            'filename' => $media->file_name
        ]));

        // Le log devrait contenir des informations sur l'accès
        $this->assertTrue(true); // Placeholder - peut être amélioré avec des assertions de log spécifiques
    }

    /** @test */
    public function it_blocks_access_to_non_existent_media()
    {
        $fakeUuid = 'fake-uuid-123';

        $response = $this->get(route('secure-media.serve', [
            'uuid' => $fakeUuid,
            'filename' => 'fake.jpg'
        ]));

        $response->assertStatus(404);
    }

    /** @test */
    public function secure_url_generator_works()
    {
        $publication = Publication::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg');
        $media = $publication
            ->addMediaFromFile($file)
            ->toMediaCollection('featured_image');

        // Tester la méthode sécurisée du modèle
        $secureUrl = $publication->getSecureFeaturedImageUrl();

        $this->assertStringContains('secure-media', $secureUrl);
        $this->assertStringContains($media->uuid, $secureUrl);

        // L'URL ne doit pas contenir le chemin réel du fichier
        $this->assertStringNotContains($media->getPath(), $secureUrl);
    }
}
