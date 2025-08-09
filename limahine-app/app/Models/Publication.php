<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'slug',
        'category',
        'is_published',
        'published_at',
        'featured_image',
        'meta_description',
        'author_id',
        'reading_time',
        'tags',
        'featured',
        'fils_cheikh_id'
    ];

    protected $translatable = [
        'title',
        'content',
        'excerpt',
        'meta_description'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array',
        'featured' => 'boolean'
    ];

    // Relations
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function filsCheikh(): BelongsTo
    {
        return $this->belongsTo(FilsCheikh::class, 'fils_cheikh_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Categories disponibles
    public static function getCategories(): array
    {
        return [
            'fiqh' => 'Fiqh (Jurisprudence islamique)',
            'tasawwuf' => 'Tasawwuf (Éducation spirituelle)',
            'sira' => 'Sîra (Biographie du Prophète ﷺ)',
            'khassaids' => 'Khassaïds',
            'philosophy' => 'Philosophie',
            'histoire' => 'Histoire',
            'temoignages' => 'Témoignages',
            'decouverte' => 'Découverte - Fils de Cheikh Ahmadou Bamba'
        ];
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

    public function getLocalizedExcerpt()
    {
        return $this->getTranslation('excerpt', app()->getLocale())
            ?: $this->getTranslation('excerpt', 'fr')
            ?: $this->getTranslation('excerpt', 'en');
    }

    // Collections de médias
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('documents')
              ->acceptsMimeTypes(['application/pdf', 'application/msword']);

        $this->addMediaCollection('audio')
              ->acceptsMimeTypes(['audio/mpeg', 'audio/wav', 'audio/ogg']);
    }

    // Conversions des médias avec protection
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(300)
              ->height(300)
              ->quality(70)
              ->nonQueued()
              ->performOnCollections('featured_image', 'gallery');

        $this->addMediaConversion('preview')
              ->width(800)
              ->height(600)
              ->quality(60)
              ->nonQueued()
              ->performOnCollections('featured_image', 'gallery');

        // Conversion avec filigrane pour les images sensibles
        $this->addMediaConversion('watermarked')
              ->width(1200)
              ->height(900)
              ->quality(50)
              ->nonQueued()
              ->performOnCollections('featured_image', 'gallery');
    }

    // Méthodes sécurisées pour obtenir les URLs des médias
    public function getSecureFeaturedImageUrl(string $conversion = ''): string
    {
        return \App\Helpers\SecureMediaHelper::getSecureUrl($this, 'featured_image', $conversion);
    }

    public function getSecureGalleryUrls(string $conversion = ''): array
    {
        return \App\Helpers\SecureMediaHelper::getSecureMediaCollection($this, 'gallery', $conversion);
    }

    public function getSecureDocumentUrls(): array
    {
        return \App\Helpers\SecureMediaHelper::getSecureMediaCollection($this, 'documents');
    }

    public function getSecureAudioUrls(): array
    {
        return \App\Helpers\SecureMediaHelper::getSecureMediaCollection($this, 'audio');
    }

    public function hasSecureFeaturedImage(): bool
    {
        return \App\Helpers\SecureMediaHelper::hasSecureMedia($this, 'featured_image');
    }

    public function hasSecureGallery(): bool
    {
        return \App\Helpers\SecureMediaHelper::hasSecureMedia($this, 'gallery');
    }
}
