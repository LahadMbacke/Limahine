<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'content',
        'excerpt',
        'slug',
        'category',
        'is_published',
        'published_at',
        'featured_image',
        'documents',
        'document_names',
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
        'featured' => 'boolean',
        'documents' => 'array'
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

    // Helper methods pour les médias simplifiés
    public function hasFeaturedImage(): bool
    {
        return !empty($this->featured_image);
    }

    public function getFeaturedImageUrl(): string
    {
        if (empty($this->featured_image)) {
            return '';
        }

        return asset('storage/' . $this->featured_image);
    }

    // Helper methods pour les documents simplifiés
    public function hasDocuments(): bool
    {
        return !empty($this->documents) && count($this->documents) > 0;
    }

    public function getDocumentsCount(): int
    {
        return $this->documents ? count($this->documents) : 0;
    }

    public function getFormattedDocuments(bool $includeDownloadUrl = true): array
    {
        if (empty($this->documents)) {
            return [];
        }

        $formattedDocuments = [];
        $customNames = $this->getCustomDocumentNames();

        foreach ($this->documents as $index => $document) {
            if (empty($document)) continue;

            $extension = strtolower(pathinfo($document, PATHINFO_EXTENSION));
            $originalFilename = basename($document);
            
            // Utiliser le nom personnalisé s'il existe, sinon nettoyer le nom original
            $displayName = isset($customNames[$index]) && !empty($customNames[$index])
                ? trim($customNames[$index])
                : $this->getCleanFileName($originalFilename);

            $documentData = [
                'name' => $displayName,
                'file_name' => $displayName,
                'original_name' => $originalFilename,
                'has_custom_name' => isset($customNames[$index]) && !empty($customNames[$index]),
                'extension' => $extension,
                'type_icon' => $this->getDocumentTypeIcon($extension),
                'type_color' => $this->getDocumentTypeColor($extension),
                'size' => $this->getFileSize($document),
                'human_readable_size' => $this->getHumanReadableSize($document)
            ];

            // N'inclure l'URL que si explicitement demandé (pour compatibilité avec les vues existantes)
            if ($includeDownloadUrl) {
                $documentData['url'] = asset('storage/' . $document);
            }

            $formattedDocuments[] = $documentData;
        }

        return $formattedDocuments;
    }

    private function getFileSize(string $filePath): int
    {
        $fullPath = storage_path('app/public/' . $filePath);
        return file_exists($fullPath) ? filesize($fullPath) : 0;
    }

    private function getHumanReadableSize(string $filePath): string
    {
        $size = $this->getFileSize($filePath);
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, 2) . ' ' . $units[$i];
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

    /**
     * Obtenir l'URL sécurisée pour visualiser un document (sans téléchargement)
     */
    public function getSecureDocumentViewUrl(string $documentPath): string
    {
        // Pour l'instant, on utilise la même URL mais cela pourrait être 
        // modifié pour passer par un contrôleur qui ajoute des en-têtes
        // de sécurité ou utilise un middleware de protection
        return asset('storage/' . $documentPath);
    }

    /**
     * Nettoyer et formater le nom de fichier pour l'affichage
     */
    private function getCleanFileName(string $filename): string
    {
        // Retirer l'extension du nom
        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Si le nom contient trop de caractères bizarres ou est trop long, utiliser un nom générique
        if (strlen($nameWithoutExt) > 50 || preg_match('/[^\w\s\-_\.]/', $nameWithoutExt)) {
            return $this->getGenericDocumentName($extension);
        }
        
        // Nettoyer le nom : remplacer les underscores par des espaces, capitaliser
        $cleanName = str_replace(['_', '-'], ' ', $nameWithoutExt);
        $cleanName = ucwords(strtolower($cleanName));
        
        // Limiter la longueur
        if (strlen($cleanName) > 30) {
            $cleanName = substr($cleanName, 0, 27) . '...';
        }
        
        return $cleanName;
    }

    /**
     * Obtenir un nom générique basé sur le type de document
     */
    private function getGenericDocumentName(string $extension): string
    {
        $genericNames = [
            'pdf' => 'Document PDF',
            'doc' => 'Document Word',
            'docx' => 'Document Word',
            'xls' => 'Feuille Excel',
            'xlsx' => 'Feuille Excel',
            'ppt' => 'Présentation PowerPoint',
            'pptx' => 'Présentation PowerPoint',
            'txt' => 'Fichier Texte',
            'rtf' => 'Document RTF',
            'zip' => 'Archive ZIP',
            'rar' => 'Archive RAR',
            'jpg' => 'Image JPEG',
            'jpeg' => 'Image JPEG',
            'png' => 'Image PNG',
            'gif' => 'Image GIF',
            'webp' => 'Image WebP',
        ];

        return $genericNames[$extension] ?? 'Document';
    }

    /**
     * Obtenir les noms personnalisés des documents
     */
    private function getCustomDocumentNames(): array
    {
        if (empty($this->document_names)) {
            return [];
        }

        $names = explode("\n", $this->document_names);
        $cleanNames = [];
        
        foreach ($names as $index => $name) {
            $cleanName = trim($name);
            if (!empty($cleanName)) {
                $cleanNames[$index] = $cleanName;
            }
        }
        
        return $cleanNames;
    }
}
