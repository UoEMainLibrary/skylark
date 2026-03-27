<?php

namespace App\Filament\Resources\RespHomeContents\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RespHomeContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->disabled()
                    ->dehydrated(false),
                RichEditor::make('body')
                    ->label('Content')
                    ->required()
                    ->columnSpanFull()
                    ->fileAttachments(false),
            ]);
    }
}
