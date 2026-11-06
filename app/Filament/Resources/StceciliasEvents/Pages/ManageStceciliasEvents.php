<?php

namespace App\Filament\Resources\StceciliasEvents\Pages;

use App\Filament\Resources\StceciliasEvents\StceciliasEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStceciliasEvents extends ManageRecords
{
    protected static string $resource = StceciliasEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
