<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Publication;
use App\Models\Temoignage;
use App\Models\VideoTrailer;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        // Publications vedettes
        $featuredPublications = Publication::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Témoignages vedettes
        $featuredTestimonials = Temoignage::published()
            ->verified()
            ->featured()
            ->take(3)
            ->get();

        // Vidéo en vedette
        $featuredTrailers = VideoTrailer::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Statistiques pour la page d'accueil
        $stats = [
            'publications' => Publication::published()->count(),
            'temoignages' => Temoignage::published()->verified()->count(),
            'trailers' => VideoTrailer::published()->count(),
        ];

        return view('home-new', compact('featuredPublications', 'featuredTestimonials', 'featuredTrailers', 'stats'));
    }

    public function writing()
    {
        $query = Publication::published()->latest('published_at');

        // Filtrage par catégorie
        if (request('category')) {
            $query->byCategory(request('category'));
        }

        // Recherche textuelle
        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function($q) use ($searchTerm) {
                $q->whereJsonContains('title->fr', $searchTerm)
                  ->orWhereJsonContains('title->en', $searchTerm)
                  ->orWhereJsonContains('title->ar', $searchTerm)
                  ->orWhereJsonContains('content->fr', $searchTerm)
                  ->orWhereJsonContains('content->en', $searchTerm)
                  ->orWhereJsonContains('content->ar', $searchTerm)
                  ->orWhereJsonContains('excerpt->fr', $searchTerm)
                  ->orWhereJsonContains('excerpt->en', $searchTerm)
                  ->orWhereJsonContains('excerpt->ar', $searchTerm)
                  ->orWhere('tags', 'like', '%' . $searchTerm . '%');
            });
        }

        $publications = $query->paginate(12);
        $categories = Publication::getCategories();

        // Publications vedettes (uniquement si pas de filtre)
        $featuredPublications = collect();
        if (!request('category') && !request('search')) {
            $featuredPublications = Publication::published()
                ->featured()
                ->take(3)
                ->get();
        }

        return view('publications-new', compact('publications', 'categories', 'featuredPublications'));
    }

    public function mouridisme()
    {
        $mouridismePublications = Publication::published()
            ->byCategory('mouridisme')
            ->latest('published_at')
            ->take(6)
            ->get();

        $page = Page::where('page_type', 'mouridisme')->published()->first();

        return view('mouridisme-new', compact('mouridismePublications', 'page'));
    }

    public function testimonials()
    {
        $temoignages = Temoignage::published()
            ->verified()
            ->latest('published_at')
            ->paginate(9);

        $featuredTemoignages = Temoignage::published()
            ->verified()
            ->featured()
            ->take(3)
            ->get();

        return view('testimonials-new', compact('temoignages', 'featuredTemoignages'));
    }

    public function chercheurs()
    {
        $academicResources = Publication::published()
            ->where(function($query) {
                $query->byCategory('academic')
                      ->orWhere('category', 'research');
            })
            ->take(6)
            ->get();

        return view('chercheurs-new', compact('academicResources'));
    }

    public function publications()
    {
        $publications = Publication::published()
            ->latest('published_at')
            ->paginate(12);

        return view('publications.index', compact('publications'));
    }

    public function showPublication(Publication $publication)
    {
        if (!$publication->is_published) {
            abort(404);
        }

        $relatedPublications = Publication::published()
            ->where('category', $publication->category)
            ->where('id', '!=', $publication->id)
            ->take(3)
            ->get();

        return view('publications.show', compact('publication', 'relatedPublications'));
    }

    public function viewDocument($publicationId, $documentId)
    {
        // Récupérer la publication par ID
        $publication = Publication::findOrFail($publicationId);

        // Vérifier que la publication est publiée
        if (!$publication->is_published) {
            abort(404);
        }

        // Récupérer le document spécifique
        $document = $publication->getMedia('documents')->find($documentId);

        if (!$document) {
            abort(404, 'Document non trouvé');
        }

        // Obtenir le chemin du fichier selon le disque
        if ($document->disk === 'ftp') {
            // Vérifier l'existence sur FTP
            if (!Storage::disk('ftp')->exists($document->getPath())) {
                abort(404, 'Fichier non trouvé sur le serveur FTP');
            }
            $filePath = $document->getPath(); // Chemin FTP
        } else {
            // Fichier local
            $filePath = $document->getPath();
            if (!file_exists($filePath)) {
                abort(404, 'Fichier non trouvé');
            }
        }

        // Détecter le type MIME
        $mimeType = $document->mime_type;
        $filename = $document->file_name;

        // Pour les PDF, forcer l'affichage inline dans le navigateur
        if ($mimeType === 'application/pdf') {
            if ($document->disk === 'ftp') {
                $fileContent = Storage::disk('ftp')->get($filePath);
                return response($fileContent, 200, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    'X-Frame-Options' => 'SAMEORIGIN',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            } else {
                return response()->file($filePath, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    'X-Frame-Options' => 'SAMEORIGIN',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            }
        }

        // Pour les documents Office (Word, Excel, PowerPoint), utiliser Office Online Viewer
        if (in_array($mimeType, [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ])) {
            // Créer une URL temporaire sécurisée pour le document
            $documentUrl = route('publications.documents.serve', [
                'publication' => $publication->id,
                'document' => $documentId
            ]);

            // Rediriger vers Office Online Viewer
            $viewerUrl = 'https://view.officeapps.live.com/op/embed.aspx?src=' . urlencode(url($documentUrl));

            return view('publications.document-viewer', [
                'publication' => $publication,
                'document' => $document,
                'viewerUrl' => $viewerUrl,
                'documentType' => 'office'
            ]);
        }

        // Pour les fichiers texte, afficher directement le contenu
        if (in_array($mimeType, ['text/plain', 'application/rtf'])) {
            if ($document->disk === 'ftp') {
                $content = Storage::disk('ftp')->get($filePath);
            } else {
                $content = file_get_contents($filePath);
            }

            return view('publications.document-viewer', [
                'publication' => $publication,
                'document' => $document,
                'content' => $content,
                'documentType' => 'text'
            ]);
        }

        // Pour les archives, afficher les informations du fichier
        if (in_array($mimeType, ['application/zip', 'application/x-rar-compressed'])) {
            return view('publications.document-viewer', [
                'publication' => $publication,
                'document' => $document,
                'documentType' => 'archive'
            ]);
        }

        // Par défaut, essayer d'afficher le fichier dans le navigateur
        if ($document->disk === 'ftp') {
            $fileContent = Storage::disk('ftp')->get($filePath);
            return response($fileContent, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'X-Frame-Options' => 'SAMEORIGIN',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } else {
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'X-Frame-Options' => 'SAMEORIGIN',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        }
    }

    public function serveDocument($publicationId, $documentId, Request $request)
    {
        // Récupérer la publication par ID
        $publication = Publication::findOrFail($publicationId);

        // Vérifier que la publication est publiée
        if (!$publication->is_published) {
            abort(404);
        }

        // Récupérer le document spécifique
        $document = $publication->getMedia('documents')->find($documentId);

        if (!$document) {
            abort(404, 'Document non trouvé');
        }

        // Vérifier si le fichier est sur FTP
        if ($document->disk === 'ftp') {
            return $this->serveFtpDocument($document, $request);
        }

        // Pour les fichiers locaux
        $filePath = $document->getPath();

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        // Si c'est une demande de contenu texte
        if ($request->has('text') && in_array($document->mime_type, ['text/plain', 'application/rtf'])) {
            $content = file_get_contents($filePath);

            // Nettoyer le contenu RTF basique (enlever les balises RTF principales)
            if ($document->mime_type === 'application/rtf') {
                $content = strip_tags($content);
                $content = preg_replace('/\\\\[a-z]+[0-9]*\s?/', '', $content);
                $content = str_replace(['{', '}'], '', $content);
                $content = trim($content);
            }

            return response($content, 200, [
                'Content-Type' => 'text/plain; charset=utf-8',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        }

        // Servir le fichier directement pour les visualiseurs externes
        return response()->file($filePath, [
            'Content-Type' => $document->mime_type,
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Cache-Control' => 'public, max-age=3600',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    /**
     * Servir un document depuis FTP
     */
    private function serveFtpDocument($document, Request $request)
    {
        try {
            // Vérifier que le fichier existe sur FTP
            if (!Storage::disk('ftp')->exists($document->getPath())) {
                abort(404, 'Fichier non trouvé sur le serveur FTP');
            }

            // Si c'est une demande de contenu texte
            if ($request->has('text') && in_array($document->mime_type, ['text/plain', 'application/rtf'])) {
                $content = Storage::disk('ftp')->get($document->getPath());

                // Nettoyer le contenu RTF basique
                if ($document->mime_type === 'application/rtf') {
                    $content = strip_tags($content);
                    $content = preg_replace('/\\\\[a-z]+[0-9]*\s?/', '', $content);
                    $content = str_replace(['{', '}'], '', $content);
                    $content = trim($content);
                }

                return response($content, 200, [
                    'Content-Type' => 'text/plain; charset=utf-8',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]);
            }

            // Pour les autres fichiers, récupérer le contenu depuis FTP
            $fileContent = Storage::disk('ftp')->get($document->getPath());

            return response($fileContent, 200, [
                'Content-Type' => $document->mime_type,
                'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
                'X-Frame-Options' => 'SAMEORIGIN',
                'Cache-Control' => 'public, max-age=3600',
                'Access-Control-Allow-Origin' => '*',
                'Content-Length' => strlen($fileContent)
            ]);

        } catch (\Exception $e) {
            \Log::error('Erreur lors du service du document FTP', [
                'document_id' => $document->id,
                'path' => $document->getPath(),
                'error' => $e->getMessage()
            ]);

            abort(404, 'Impossible de récupérer le fichier');
        }
    }
}
