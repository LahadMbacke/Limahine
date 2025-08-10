<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPublication extends EditRecord
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Convertir l'image mise en avant en tableau pour Filament
        if (isset($data['featured_image']) && !is_array($data['featured_image'])) {
            $data['featured_image'] = $data['featured_image'] ? [$data['featured_image']] : [];
        }

        // S'assurer que documents est un tableau
        if (isset($data['documents']) && !is_array($data['documents'])) {
            $data['documents'] = $data['documents'] ? json_decode($data['documents'], true) : [];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
}
