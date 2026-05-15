<?php

namespace App\Filament\Resources\CmsPages\Resp;

use App\Filament\Resources\CmsPages\Resp\Pages\EditRespCmsPage;
use App\Filament\Resources\CmsPages\Resp\Pages\ListRespCmsPages;
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
 * Filament resource for the RESP (eerc) slice of cms_pages.
 *
 * Sibling of PublicArtCmsPageResource — both wrap App\Models\CmsPage but
 * scope their list/edit pages to a single `collection` value so each one
 * sits in its own admin nav group ("RESP" / "Public Art"). The shared
 * form and table schemas live under
 * App\Filament\Resources\CmsPages\Schemas/Tables.
 */
class RespCmsPageResource extends Resource
{
    protected static ?string $model = CmsPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'RESP';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = 'resp/pages';

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * Restrict every query through this resource (list, edit, count) to
     * RESP rows. The Public Art resource does the same for its slice.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('collection', CmsPage::COLLECTION_EERC);
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
            'index' => ListRespCmsPages::route('/'),
            'edit' => EditRespCmsPage::route('/{record}/edit'),
        ];
    }
}
