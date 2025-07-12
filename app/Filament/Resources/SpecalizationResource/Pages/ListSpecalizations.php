<?php

namespace App\Filament\Resources\SpecalizationResource\Pages;

use App\Filament\Resources\SpecalizationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpecalizations extends ListRecords
{
    protected static string $resource = SpecalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
