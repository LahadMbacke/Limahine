<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Biographie extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'author_name',
        'description',
        'type', // livre, article, manuscrit
        'langue',
        'date_publication',
        'editeur',
        'isbn',
        'pages',
        'disponible_en_ligne',
        'url_telechargement',
        'is_published',
        'featured',
        'category'
    ];

    protected $translatable = [
        'title',
        'description',
        'author_name'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'featured' => 'boolean',
        'disponible_en_ligne' => 'boolean',
        'date_publication' => 'date'
    ];

    // Types d'ouvrages
    public static function getTypes(): array
    {
        return [
            'livre' => 'Livre',
            'article' => 'Article',
            'manuscrit' => 'Manuscrit',
            'these' => 'Thèse',
            'memoire' => 'Mémoire',
            'conference' => 'Conférence'
        ];
    }

    // Categories
    public static function getCategories(): array
    {
        return [
            'cheikh_ahmadou_bamba' => 'Cheikh Ahmadou Bamba',
            'khalifes' => 'Les Khalifes',
            'fils' => 'Les Fils',
            'disciples' => 'Les Disciples',
            'histoire_mouride' => 'Histoire Mouride',
            'etudes_academiques' => 'Études académiques'
        ];
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Helper methods pour les traductions
    public function getLocalizedTitle()
    {
        return $this->getTranslation('title', app()->getLocale())
            ?: $this->getTranslation('title', 'fr')
            ?: $this->getTranslation('title', 'en');
    }

    public function getLocalizedDescription()
    {
        return $this->getTranslation('description', app()->getLocale())
            ?: $this->getTranslation('description', 'fr')
            ?: $this->getTranslation('description', 'en');
    }

    public function getLocalizedAuthorName()
    {
        return $this->getTranslation('author_name', app()->getLocale())
            ?: $this->getTranslation('author_name', 'fr')
            ?: $this->getTranslation('author_name', 'en');
    }

    // Collections de médias
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('document')
              ->singleFile()
              ->acceptsMimeTypes(['application/pdf', 'application/msword']);

        $this->addMediaCollection('previews')
              ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

}
