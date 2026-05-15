<?php

namespace App\Filament\Resources\CmsPages\PublicArt\Pages;

use App\Filament\Resources\CmsPages\PublicArt\PublicArtCmsPageResource;
use Filament\Resources\Pages\ListRecords;

class ListPublicArtCmsPages extends ListRecords
{
    protected static string $resource = PublicArtCmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
