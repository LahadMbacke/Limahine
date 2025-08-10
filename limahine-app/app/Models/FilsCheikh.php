<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FilsCheikh extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $table = 'fils_cheikh';

    protected $fillable = [
        'name',
        'biography',
        'description',
        'slug',
        'is_khalif',
        'birth_date',
        'death_date',
        'order_of_succession',
        'is_published',
        'meta_description'
    ];

    protected $translatable = [
        'name',
        'biography',
        'description',
        'meta_description'
    ];

    protected $casts = [
        'is_khalif' => 'boolean',
        'is_published' => 'boolean',
        'birth_date' => 'date',
        'death_date' => 'date',
        'order_of_succession' => 'integer'
    ];

    // Relations
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class, 'fils_cheikh_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeKhalifs($query)
    {
        return $query->where('is_khalif', true)
                    ->orderBy('order_of_succession');
    }

    public function scopeNonKhalifs($query)
    {
        return $query->where('is_khalif', false);
    }

    // Helper methods pour les traductions
    public function getLocalizedName()
    {
        return $this->getTranslation('name', app()->getLocale())
            ?: $this->getTranslation('name', 'fr')
            ?: $this->getTranslation('name', 'en');
    }

    public function getLocalizedBiography()
    {
        return $this->getTranslation('biography', app()->getLocale())
            ?: $this->getTranslation('biography', 'fr')
            ?: $this->getTranslation('biography', 'en');
    }

    public function getLocalizedDescription()
    {
        return $this->getTranslation('description', app()->getLocale())
            ?: $this->getTranslation('description', 'fr')
            ?: $this->getTranslation('description', 'en');
    }

    // Collections de médias
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_image')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('portrait')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // Méthodes pour obtenir les URLs des médias (FTP Direct)
    public function getCoverImageUrl(string $conversion = ''): string
    {
        $media = $this->getFirstMedia('cover_image');
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

    public function getPortraitUrl(string $conversion = ''): string
    {
        $media = $this->getFirstMedia('portrait');
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

    // Méthodes sécurisées pour obtenir les URLs des médias (legacy - pour compatibilité)
    public function getSecureCoverImageUrl(string $conversion = ''): string
    {
        return $this->getCoverImageUrl($conversion);
    }

    public function getSecurePortraitUrl(string $conversion = ''): string
    {
        return $this->getPortraitUrl($conversion);
    }

    public function getSecureGalleryUrls(string $conversion = ''): array
    {
        return $this->getGalleryUrls($conversion);
    }

    public function hasSecureCoverImage(): bool
    {
        return \App\Helpers\SecureMediaHelper::hasSecureMedia($this, 'cover_image');
    }

    public function hasSecurePortrait(): bool
    {
        return \App\Helpers\SecureMediaHelper::hasSecureMedia($this, 'portrait');
    }

    // Méthode pour obtenir l'âge au décès ou l'âge actuel
    public function getAge()
    {
        if (!$this->birth_date) {
            return null;
        }

        $endDate = $this->death_date ?: now();
        return $this->birth_date->diffInYears($endDate);
    }

    // Méthode pour vérifier si la personne est encore vivante
    public function isAlive()
    {
        return is_null($this->death_date);
    }
}
