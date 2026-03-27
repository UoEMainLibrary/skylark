<?php

namespace App\Filament\Resources\RespHomeContents;

use App\Filament\Resources\RespHomeContents\Pages\EditRespHomeContent;
use App\Filament\Resources\RespHomeContents\Pages\ListRespHomeContents;
use App\Filament\Resources\RespHomeContents\Schemas\RespHomeContentForm;
use App\Filament\Resources\RespHomeContents\Tables\RespHomeContentsTable;
use App\Models\RespHomeContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RespHomeContentResource extends Resource
{
    protected static ?string $model = RespHomeContent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|UnitEnum|null $navigationGroup = 'RESP';

    protected static ?string $navigationLabel = 'Home';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = 'resp/home';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return RespHomeContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RespHomeContentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRespHomeContents::route('/'),
            'edit' => EditRespHomeContent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = RespHomeContent::query()->where('slug', RespHomeContent::SLUG)->first();

        if ($record !== null) {
            return static::getUrl('edit', ['record' => $record]);
        }

        return static::getUrl('index');
    }
}
