<?php

namespace App\Filament\Resources\StceciliasPages;

use App\Filament\Resources\StceciliasPages\Pages\CreateStceciliasPage;
use App\Filament\Resources\StceciliasPages\Pages\EditStceciliasPage;
use App\Filament\Resources\StceciliasPages\Pages\ManageStceciliasPages;
use App\Models\StceciliasPage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
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
            TextInput::make('slug')->required()->maxLength(255)->disabled(fn (?StceciliasPage $record): bool => $record !== null)->regex('~^(?!(?:search|record|browse|advanced|redirect|event|events|iiif|mirador|feedback|licensing|takedown|accessibility|about|home)(?:/|$)|whats-on/)[a-z0-9]+(?:[-/][a-z0-9]+)*$~')->helperText('Use lower-case words separated by hyphens. Existing addresses are fixed to preserve links.')->unique(ignoreRecord: true),
            Toggle::make('is_visible')->label('Visible on the website')->default(false),
            Section::make('Main menu')->schema([
                Toggle::make('show_in_navigation')->label('Include in the main menu')
                    ->afterStateHydrated(fn (Toggle $component, ?StceciliasPage $record) => $component->state($record?->appearsInNavigation() ?? false)),
                TextInput::make('navigation_label')->label('Menu label')->maxLength(255)->helperText('Leave blank to use the page title.'),
                Select::make('navigation_parent_id')->label('Dropdown under')->placeholder('Top-level menu item')
                    ->options(fn (?StceciliasPage $record): array => StceciliasPage::query()->whereNull('navigation_parent_id')
                        ->where('slug', '!=', 'home')
                        ->when($record, fn ($query) => $query->whereKeyNot($record->id))
                        ->orderBy('navigation_order')->pluck('title', 'id')->all())
                    ->helperText('Choose a top-level page to show this page in its dropdown. Both pages must be visible and included in the menu. Use Reorder pages to set the menu order.'),
            ])->columnSpanFull(),
            Textarea::make('intro')->label('Introduction')->maxLength(2000)->columnSpanFull(),
            RichEditor::make('body')->label('Main content')->resizableImages()->fileAttachments(false)->columnSpanFull(),
            FileUpload::make('image_path')->label('Main image')->image()->disk('public')->directory('stcecilias')->maxSize(5120),
            Select::make('image_size')->label('Main image size')->options(['small' => 'Small', 'medium' => 'Medium', 'full' => 'Full content width'])->default('full')->required(),
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
            Repeater::make('sections')->defaultItems(0)->collapsed()->itemLabel(fn (array $state): ?string => $state['heading'] ?? null)->schema([
                TextInput::make('heading')->required()->maxLength(255),
                TextInput::make('anchor')->maxLength(255)->regex('/^[a-z0-9-]+$/'),
                TextInput::make('video_url')->label('Video URL')->maxLength(2048),
                TextInput::make('audio_url')->label('Audio URL')->maxLength(2048),
                RichEditor::make('content')->resizableImages()->fileAttachments(false)->columnSpanFull(),
            ])->collapsible()->columnSpanFull(),
            Repeater::make('gallery')->defaultItems(0)->schema([
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
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStceciliasPages::route('/'),
            'create' => CreateStceciliasPage::route('/create'),
            'edit' => EditStceciliasPage::route('/{record}/edit'),
        ];
    }
}
