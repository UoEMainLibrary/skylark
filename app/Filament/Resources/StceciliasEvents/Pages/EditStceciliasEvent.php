<?php

namespace App\Filament\Resources\StceciliasEvents\Pages;

use App\Filament\Resources\StceciliasEvents\StceciliasEventResource;
use Filament\Resources\Pages\EditRecord;

class EditStceciliasEvent extends EditRecord
{
    protected static string $resource = StceciliasEventResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
