<?php

namespace App\Filament\Resources\CmsPages\Resp\Pages;

use App\Filament\Resources\CmsPages\Resp\RespCmsPageResource;
use Filament\Resources\Pages\EditRecord;

class EditRespCmsPage extends EditRecord
{
    protected static string $resource = RespCmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
