<?php

namespace App\Filament\Resources\BibliographieResource\Pages;

use App\Filament\Resources\BibliographieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBibliographies extends ListRecords
{
    protected static string $resource = BibliographieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
