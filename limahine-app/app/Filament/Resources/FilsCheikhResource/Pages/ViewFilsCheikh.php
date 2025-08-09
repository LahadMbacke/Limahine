<?php

namespace App\Filament\Resources\FilsCheikhResource\Pages;

use App\Filament\Resources\FilsCheikhResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFilsCheikh extends ViewRecord
{
    protected static string $resource = FilsCheikhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
