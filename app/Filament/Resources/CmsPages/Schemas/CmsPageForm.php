<?php

namespace App\Filament\Resources\CmsPages\Schemas;

use App\Support\Cms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/**
 * Shared form for both per-collection CMS resources (RESP and Public Art).
 *
 * The image upload fields show themselves dynamically based on the page's
 * declared `images` count in config/cms.php — pages flagged `images => 0`
 * just see the title + body fields, pages with 1 or 2 also see the
 * matching FileUpload + alt-text inputs.
 */
class CmsPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Page')
                    ->disabled()
                    ->dehydrated(false),

                RichEditor::make('body')
                    ->label('Content')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachments(false),

                FileUpload::make('image_1_path')
                    ->label('Image 1')
                    ->image()
                    ->disk('public')
                    ->directory(fn ($record) => "cms/{$record->collection}/{$record->slug}")
                    ->visible(fn ($record) => $record !== null
                        && Cms::pageImageCount($record->collection, $record->slug) >= 1),

                TextInput::make('image_1_alt')
                    ->label('Image 1 alt text')
                    ->visible(fn ($record) => $record !== null
                        && Cms::pageImageCount($record->collection, $record->slug) >= 1),

                FileUpload::make('image_2_path')
                    ->label('Image 2')
                    ->image()
                    ->disk('public')
                    ->directory(fn ($record) => "cms/{$record->collection}/{$record->slug}")
                    ->visible(fn ($record) => $record !== null
                        && Cms::pageImageCount($record->collection, $record->slug) >= 2),

                TextInput::make('image_2_alt')
                    ->label('Image 2 alt text')
                    ->visible(fn ($record) => $record !== null
                        && Cms::pageImageCount($record->collection, $record->slug) >= 2),
            ]);
    }
}
