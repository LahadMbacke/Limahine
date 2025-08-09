<?php

namespace App\Filament\Resources\FilsCheikhResource\Pages;

use App\Filament\Resources\FilsCheikhResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFilsCheikh extends EditRecord
{
    protected static string $resource = FilsCheikhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
