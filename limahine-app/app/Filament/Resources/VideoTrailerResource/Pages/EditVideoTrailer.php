<?php

namespace App\Filament\Resources\VideoTrailerResource\Pages;

use App\Filament\Resources\VideoTrailerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoTrailer extends EditRecord
{
    protected static string $resource = VideoTrailerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
