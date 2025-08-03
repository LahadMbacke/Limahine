<?php

namespace App\Filament\Resources\BibliographieResource\Pages;

use App\Filament\Resources\BibliographieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBibliographie extends EditRecord
{
    protected static string $resource = BibliographieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
