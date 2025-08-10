<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Gérer l'image mise en avant
        if (isset($data['featured_image'])) {
            $data['featured_image'] = is_array($data['featured_image']) 
                ? $data['featured_image'][0] ?? null 
                : $data['featured_image'];
        }

        // Gérer les documents
        if (isset($data['documents']) && is_array($data['documents'])) {
            $data['documents'] = array_filter($data['documents']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
