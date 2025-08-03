<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Carbon\Carbon;

class VideoTrailer extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'youtube_video_id',
        'youtube_original_url',
        'trailer_duration',
        'start_time',
        'end_time',
        'is_published',
        'published_at',
        'featured',
        'thumbnail_url',
        'category',
        'tags',
        'meta_description',
        'slug'
    ];

    protected $translatable = [
        'title',
        'description',
        'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'featured' => 'boolean',
        'tags' => 'array',
        'start_time' => 'integer',
        'end_time' => 'integer',
        'trailer_duration' => 'integer'
    ];

    /**
     * Génère l'URL YouTube avec les paramètres de temps
     */
    public function getYoutubeUrlAttribute(): string
    {
        $url = "https://www.youtube.com/watch?v={$this->youtube_video_id}";

        if ($this->start_time) {
            $url .= "&t={$this->start_time}s";
        }

        return $url;
    }

    /**
     * Génère l'URL d'embed YouTube avec les paramètres de temps
     */
    public function getYoutubeEmbedUrlAttribute(): string
    {
        $url = "https://www.youtube.com/embed/{$this->youtube_video_id}";

        $params = [];
        if ($this->start_time) {
            $params[] = "start={$this->start_time}";
        }
        if ($this->end_time) {
            $params[] = "end={$this->end_time}";
        }

        if (!empty($params)) {
            $url .= '?' . implode('&', $params);
        }

        return $url;
    }

    /**
     * Génère l'URL de la miniature YouTube avec fallback
     */
    public function getYoutubeThumbnailAttribute(): string
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        // Essayer d'abord maxresdefault, puis hqdefault en fallback
        return "https://img.youtube.com/vi/{$this->youtube_video_id}/hqdefault.jpg";
    }

    /**
     * Génère l'URL de la miniature YouTube en haute qualité
     */
    public function getYoutubeThumbnailHdAttribute(): string
    {
        return "https://img.youtube.com/vi/{$this->youtube_video_id}/maxresdefault.jpg";
    }

    /**
     * Scope pour les trailers publiés
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    /**
     * Scope pour les trailers en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Formate la durée en format lisible
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->trailer_duration) {
            return 'N/A';
        }

        $minutes = floor($this->trailer_duration / 60);
        $seconds = $this->trailer_duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
