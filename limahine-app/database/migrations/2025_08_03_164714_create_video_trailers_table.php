<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('video_trailers', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Multilingue
            $table->json('description')->nullable(); // Multilingue
            $table->string('youtube_video_id'); // ID de la vidéo YouTube
            $table->string('youtube_original_url'); // URL complète de la vidéo originale
            $table->integer('trailer_duration')->nullable(); // Durée du trailer en secondes
            $table->integer('start_time')->nullable(); // Temps de début en secondes
            $table->integer('end_time')->nullable(); // Temps de fin en secondes
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('thumbnail_url')->nullable(); // URL personnalisée de la miniature
            $table->string('category')->nullable();
            $table->json('tags')->nullable(); // Tags sous forme de tableau
            $table->json('meta_description')->nullable(); // Multilingue
            $table->string('slug')->unique();
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['is_published', 'published_at']);
            $table->index(['featured', 'is_published']);
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_trailers');
    }
};
