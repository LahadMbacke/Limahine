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
              ->acceptsMimeTypes([
                  'application/pdf',
                  'application/msword',
                  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                  'application/vnd.ms-excel',
                  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                  'application/vnd.ms-powerpoint',
                  'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                  'text/plain',
                  'application/rtf',
                  'application/zip',
                  'application/x-rar-compressed'
              ]);

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

    // Méthodes pour obtenir les URLs des médias (FTP)
    public function getFeaturedImageUrl(string $conversion = ''): string
    {
        return \App\Helpers\FtpMediaHelper::getPublicUrl($this, 'featured_image', $conversion);
    }

    public function getGalleryUrls(string $conversion = ''): array
    {
        return \App\Helpers\FtpMediaHelper::getCollectionUrls($this, 'gallery', $conversion);
    }

    public function getDocumentUrls(): array
    {
        return \App\Helpers\FtpMediaHelper::getCollectionUrls($this, 'documents');
    }

    public function getAudioUrls(): array
    {
        return \App\Helpers\FtpMediaHelper::getCollectionUrls($this, 'audio');
    }

    // Méthodes sécurisées pour obtenir les URLs des médias (legacy - pour compatibilité)
    public function getSecureFeaturedImageUrl(string $conversion = ''): string
    {
        return $this->getFeaturedImageUrl($conversion);
    }

    public function getSecureGalleryUrls(string $conversion = ''): array
    {
        return $this->getGalleryUrls($conversion);
    }

    public function getSecureDocumentUrls(): array
    {
        return $this->getDocumentUrls();
    }

    public function getSecureAudioUrls(): array
    {
        return $this->getAudioUrls();
    }

    public function hasSecureFeaturedImage(): bool
    {
        return $this->hasFeaturedImage();
    }

    public function hasSecureGallery(): bool
    {
        return $this->hasGallery();
    }

    // Helper methods pour les médias
    public function hasFeaturedImage(): bool
    {
        return $this->hasMedia('featured_image');
    }

    public function hasGallery(): bool
    {
        return $this->hasMedia('gallery');
    }

    // Helper methods pour les documents
    public function hasDocuments(): bool
    {
        return $this->getMedia('documents')->count() > 0;
    }

    public function getDocuments()
    {
        return $this->getMedia('documents');
    }

    public function getDocumentsCount(): int
    {
        return $this->getMedia('documents')->count();
    }

    public function getFormattedDocuments(): array
    {
        $documents = $this->getMedia('documents');
        $formattedDocuments = [];

        foreach ($documents as $document) {
            $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));
            
            $formattedDocuments[] = [
                'id' => $document->id,
                'name' => $document->name,
                'file_name' => $document->file_name,
                'mime_type' => $document->mime_type,
                'size' => $document->size,
                'human_readable_size' => $document->human_readable_size,
                'extension' => $extension,
                'type_icon' => $this->getDocumentTypeIcon($extension),
                'type_color' => $this->getDocumentTypeColor($extension),
                'url' => route('publications.documents.serve', ['publication' => $this->id, 'document' => $document->id])
            ];
        }

        return $formattedDocuments;
    }

    public function getDocumentTypeIcon(string $extension): string
    {
        $iconMap = [
            'pdf' => 'fas fa-file-pdf',
            'doc' => 'fas fa-file-word',
            'docx' => 'fas fa-file-word',
            'xls' => 'fas fa-file-excel',
            'xlsx' => 'fas fa-file-excel',
            'ppt' => 'fas fa-file-powerpoint',
            'pptx' => 'fas fa-file-powerpoint',
            'txt' => 'fas fa-file-alt',
            'rtf' => 'fas fa-file-alt',
            'zip' => 'fas fa-file-archive',
            'rar' => 'fas fa-file-archive',
            'jpg' => 'fas fa-file-image',
            'jpeg' => 'fas fa-file-image',
            'png' => 'fas fa-file-image',
            'gif' => 'fas fa-file-image',
            'webp' => 'fas fa-file-image',
        ];

        return $iconMap[$extension] ?? 'fas fa-file';
    }

    public function getDocumentTypeColor(string $extension): string
    {
        $colorMap = [
            'pdf' => 'red',
            'doc' => 'blue',
            'docx' => 'blue',
            'xls' => 'green',
            'xlsx' => 'green',
            'ppt' => 'orange',
            'pptx' => 'orange',
            'txt' => 'gray',
            'rtf' => 'gray',
            'zip' => 'purple',
            'rar' => 'purple',
            'jpg' => 'blue',
            'jpeg' => 'blue',
            'png' => 'blue',
            'gif' => 'blue',
            'webp' => 'blue',
        ];

        return $colorMap[$extension] ?? 'gray';
    }
}
