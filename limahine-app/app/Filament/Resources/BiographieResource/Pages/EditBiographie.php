<?php

namespace App\Filament\Resources\BiographieResource\Pages;

use App\Filament\Resources\BiographieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBiographie extends EditRecord
{
    protected static string $resource = BiographieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}