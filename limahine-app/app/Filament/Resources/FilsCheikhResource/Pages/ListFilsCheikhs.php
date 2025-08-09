<?php

namespace App\Filament\Resources\FilsCheikhResource\Pages;

use App\Filament\Resources\FilsCheikhResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilsCheikhs extends ListRecords
{
    protected static string $resource = FilsCheikhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
