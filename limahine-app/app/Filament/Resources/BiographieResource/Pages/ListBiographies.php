<?php

namespace App\Filament\Resources\BiographieResource\Pages;

use App\Filament\Resources\BiographieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBiographies extends ListRecords
{
    protected static string $resource = BiographieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
