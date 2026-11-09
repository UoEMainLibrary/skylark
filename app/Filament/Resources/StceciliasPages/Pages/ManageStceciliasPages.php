<?php

namespace App\Filament\Resources\StceciliasPages\Pages;

use App\Filament\Resources\StceciliasPages\StceciliasPageResource;
use Filament\Resources\Pages\ListRecords;

class ManageStceciliasPages extends ListRecords
{
    protected static string $resource = StceciliasPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
