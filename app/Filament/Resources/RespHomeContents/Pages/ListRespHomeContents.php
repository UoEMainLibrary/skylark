<?php

namespace App\Filament\Resources\RespHomeContents\Pages;

use App\Filament\Resources\RespHomeContents\RespHomeContentResource;
use App\Models\RespHomeContent;
use Filament\Resources\Pages\ListRecords;

class ListRespHomeContents extends ListRecords
{
    protected static string $resource = RespHomeContentResource::class;

    public function mount(): void
    {
        static::authorizeResourceAccess();

        $record = RespHomeContent::ensureSingleton();

        $this->redirect(RespHomeContentResource::getUrl('edit', ['record' => $record]));
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
