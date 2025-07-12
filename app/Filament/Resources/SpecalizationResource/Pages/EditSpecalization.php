<?php

namespace App\Filament\Resources\SpecalizationResource\Pages;

use App\Filament\Resources\SpecalizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecalization extends EditRecord
{
    protected static string $resource = SpecalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
