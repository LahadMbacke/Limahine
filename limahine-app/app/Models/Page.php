<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'is_published',
        'page_type', // home, mouridisme, about, etc.
        'meta_title',
        'meta_description',
        'order'
    ];

    protected $translatable = [
        'title',
        'content',
        'excerpt',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'is_published' => 'boolean'
    ];

    // Types de pages
    public static function getPageTypes(): array
    {
        return [
            'home' => 'Accueil',
            'mouridisme' => 'Mouridisme',
            'about' => 'À propos',
            'contact' => 'Contact',
            'custom' => 'Personnalisée'
        ];
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('page_type', $type);
    }
}
