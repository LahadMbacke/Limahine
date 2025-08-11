<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temoignage extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'author_name',
        'author_title',
        'author_description',
        'author_photo',
        'is_published',
        'published_at',
        'featured',
        'location',
        'date_temoignage',
        'verified',
        'meta_description'
    ];

    protected $translatable = [
        'title',
        'content',
        'author_title',
        'author_description',
        'meta_description'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'date_temoignage' => 'date',
        'featured' => 'boolean',
        'verified' => 'boolean'
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Collections de médias
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('author_photo')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('audio')
              ->acceptsMimeTypes(['audio/mpeg', 'audio/wav', 'audio/ogg']);
    }

    // Méthodes pour obtenir les URLs des médias (FTP Direct)
    public function getAuthorPhotoUrl(string $conversion = ''): string
    {
        $media = $this->getFirstMedia('author_photo');
        return $media ? $media->getUrl($conversion) : '';
    }

    /**
     * Utiliser directement Media Library pour tous les médias
     */
    public function getFirstMediaUrl(string $collectionName = 'default', string $conversion = ''): string
    {
        $media = $this->getFirstMedia($collectionName);
        return $media ? $media->getUrl($conversion) : '';
    }

    public function getGalleryUrls(string $conversion = ''): array
    {
        $mediaItems = $this->getMedia('gallery');
        $urls = [];

        foreach ($mediaItems as $media) {
            $urls[] = $media->getUrl($conversion);
        }

        return $urls;
    }

    public function getAudioUrls(): array
    {
        $mediaItems = $this->getMedia('audio');
        $urls = [];

        foreach ($mediaItems as $media) {
            $urls[] = $media->getUrl();
        }

        return $urls;
    }

    // Méthodes sécurisées pour obtenir les URLs des médias (legacy - pour compatibilité)
    public function getSecureAuthorPhotoUrl(string $conversion = ''): string
    {
        return $this->getAuthorPhotoUrl($conversion);
    }

    public function getSecureGalleryUrls(string $conversion = ''): array
    {
        return $this->getGalleryUrls($conversion);
    }

    public function getSecureAudioUrls(): array
    {
        return $this->getAudioUrls();
    }

    public function hasSecureAuthorPhoto(): bool
    {
        return \App\Helpers\SecureMediaHelper::hasSecureMedia($this, 'author_photo');
    }

    // Helper methods pour les traductions
    public function getLocalizedTitle()
    {
        return $this->getTranslation('title', app()->getLocale())
            ?: $this->getTranslation('title', 'fr')
            ?: $this->getTranslation('title', 'en');
    }

    public function getLocalizedContent()
    {
        return $this->getTranslation('content', app()->getLocale())
            ?: $this->getTranslation('content', 'fr')
            ?: $this->getTranslation('content', 'en');
    }

    public function getLocalizedAuthorTitle()
    {
        return $this->getTranslation('author_title', app()->getLocale())
            ?: $this->getTranslation('author_title', 'fr')
            ?: $this->getTranslation('author_title', 'en');
    }
}
