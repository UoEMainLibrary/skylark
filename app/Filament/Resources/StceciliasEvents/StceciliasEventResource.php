<?php

namespace App\Filament\Resources\StceciliasEvents;

use App\Filament\Resources\StceciliasEvents\Pages\CreateStceciliasEvent;
use App\Filament\Resources\StceciliasEvents\Pages\EditStceciliasEvent;
use App\Filament\Resources\StceciliasEvents\Pages\ManageStceciliasEvents;
use App\Models\StceciliasEvent;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class StceciliasEventResource extends Resource
{
    protected static ?string $model = StceciliasEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'St Cecilia’s Hall';

    protected static ?string $navigationLabel = 'Events';

    protected static ?string $modelLabel = 'event';

    protected static ?string $pluralModelLabel = 'Events';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('slug')->required()->maxLength(255)->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')->unique(ignoreRecord: true),
            Toggle::make('is_visible')->label('Visible on the website')->default(false),
            Textarea::make('intro')->label('Introduction')->maxLength(2000)->columnSpanFull(),
            RichEditor::make('body')->label('Main content')->fileAttachments(false)->columnSpanFull(),
            FileUpload::make('image_path')->label('Main image')->image()->disk('public')->directory('stcecilias')->maxSize(5120),
            TextInput::make('image_alt')->label('Image description (alt text)')->maxLength(255)->requiredWith('image_path'),
            DateTimePicker::make('starts_at')->required()->timezone('Europe/London'),
            DateTimePicker::make('ends_at')->afterOrEqual('starts_at')->timezone('Europe/London'),
            TextInput::make('category')->maxLength(255),
            TextInput::make('venue')->maxLength(255),
            TextInput::make('price')->maxLength(255),
            TextInput::make('booking_url')->url()->maxLength(2048),
            TextInput::make('seo_title')->label('Search engine title')->maxLength(255),
            Textarea::make('seo_description')->label('Search engine description')->maxLength(320),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable(),
            IconColumn::make('is_visible')->label('Visible')->boolean(),
            TextColumn::make('starts_at')->dateTime('d M Y H:i', timezone: 'Europe/London')->sortable(),
        ])->defaultSort('starts_at')->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStceciliasEvents::route('/'),
            'create' => CreateStceciliasEvent::route('/create'),
            'edit' => EditStceciliasEvent::route('/{record}/edit'),
        ];
    }
}
