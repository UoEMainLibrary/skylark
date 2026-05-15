<?php

namespace App\Filament\Resources\CmsPages\PublicArt;

use App\Filament\Resources\CmsPages\PublicArt\Pages\EditPublicArtCmsPage;
use App\Filament\Resources\CmsPages\PublicArt\Pages\ListPublicArtCmsPages;
use App\Filament\Resources\CmsPages\Schemas\CmsPageForm;
use App\Filament\Resources\CmsPages\Tables\CmsPagesTable;
use App\Models\CmsPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

/**
 * Filament resource for the Public Art slice of cms_pages. Sibling of
 * RespCmsPageResource — see that file for the full design rationale.
 */
class PublicArtCmsPageResource extends Resource
{
    protected static ?string $model = CmsPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static string|UnitEnum|null $navigationGroup = 'Public Art';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = 'public-art/pages';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('collection', CmsPage::COLLECTION_PUBLIC_ART);
    }

    public static function form(Schema $schema): Schema
    {
        return CmsPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsPagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPublicArtCmsPages::route('/'),
            'edit' => EditPublicArtCmsPage::route('/{record}/edit'),
        ];
    }
}
