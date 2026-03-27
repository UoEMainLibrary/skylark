<?php

namespace App\Filament\Resources\RespHomeContents\Pages;

use App\Filament\Resources\RespHomeContents\RespHomeContentResource;
use Filament\Resources\Pages\EditRecord;

class EditRespHomeContent extends EditRecord
{
    protected static string $resource = RespHomeContentResource::class;

    protected static ?string $breadcrumb = 'Home';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
