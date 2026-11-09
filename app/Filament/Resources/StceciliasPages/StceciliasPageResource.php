<?php

namespace App\Filament\Resources\StceciliasPages;

use App\Filament\Resources\StceciliasPages\Pages\EditStceciliasPage;
use App\Filament\Resources\StceciliasPages\Pages\ManageStceciliasPages;
use App\Models\StceciliasPage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class StceciliasPageResource extends Resource
{
    protected static ?string $model = StceciliasPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'St Cecilia’s Hall';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'page';

    protected static ?string $pluralModelLabel = 'Pages';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('slug')->required()->maxLength(255)->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')->unique(ignoreRecord: true)->in(['home', 'planning-your-visit', 'venue-hire', 'whats-on'])->helperText('First milestone: home, planning-your-visit, venue-hire or whats-on.'),
            Toggle::make('is_visible')->label('Visible on the website')->default(false),
            Textarea::make('intro')->label('Introduction')->maxLength(2000)->columnSpanFull(),
            RichEditor::make('body')->label('Main content')->fileAttachments(false)->columnSpanFull(),
            FileUpload::make('image_path')->label('Main image')->image()->disk('public')->directory('stcecilias')->maxSize(5120),
            TextInput::make('image_alt')->label('Image description (alt text)')->maxLength(255)->requiredWith('image_path'),
            Section::make('Visitor information')
                ->description('Shared by the homepage, visitor page and footer.')
                ->visible(fn (?StceciliasPage $record): bool => $record?->slug === 'planning-your-visit')
                ->schema([
                    TextInput::make('visitor_information.opening_hours')->label('Opening hours')->required()->maxLength(255),
                    TextInput::make('visitor_information.last_entry')->label('Last entry')->maxLength(255),
                    TextInput::make('visitor_information.closed_days')->label('Closed days')->maxLength(255),
                    TextInput::make('visitor_information.admission')->label('Admission')->required()->maxLength(255),
                    TextInput::make('visitor_information.address')->label('Address')->required()->maxLength(255),
                    Textarea::make('visitor_information.notice')->label('Temporary visitor notice')->maxLength(1000),
                ])->columnSpanFull(),
            Repeater::make('sections')->collapsed()->itemLabel(fn (array $state): ?string => $state['heading'] ?? null)->schema([
                TextInput::make('heading')->required()->maxLength(255),
                TextInput::make('video_url')->label('Video URL')->url()->maxLength(2048),
                RichEditor::make('content')->fileAttachments(false)->columnSpanFull(),
            ])->collapsible()->columnSpanFull(),
            Repeater::make('gallery')->schema([
                FileUpload::make('path')->label('Image')->image()->disk('public')->directory('stcecilias')->maxSize(5120)->required(),
                TextInput::make('alt')->required()->maxLength(255),
                TextInput::make('caption')->maxLength(255),
            ])->collapsible()->columnSpanFull(),
            TextInput::make('seo_title')->label('Search engine title')->maxLength(255),
            Textarea::make('seo_description')->label('Search engine description')->maxLength(320),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable(),
            IconColumn::make('is_visible')->label('Visible')->boolean(),
        ])->defaultSort('navigation_order')
            ->reorderable('navigation_order')
            ->reorderRecordsTriggerAction(fn (Action $action, bool $isReordering): Action => $action
                ->button()
                ->label($isReordering ? 'Done reordering' : 'Reorder pages'))
            ->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStceciliasPages::route('/'),
            'edit' => EditStceciliasPage::route('/{record}/edit'),
        ];
    }
}
