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
}
