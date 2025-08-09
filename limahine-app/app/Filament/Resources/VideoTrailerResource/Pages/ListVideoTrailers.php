<?php

namespace App\Filament\Resources\VideoTrailerResource\Pages;

use App\Filament\Resources\VideoTrailerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideoTrailers extends ListRecords
{
    protected static string $resource = VideoTrailerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
