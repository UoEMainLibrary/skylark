<?php

namespace App\Filament\Resources\CmsPages\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Shared table for both per-collection CMS resources.
 *
 * Pages can only ever be edited (not created or deleted) from the admin —
 * the catalogue of managed pages lives in config/cms.php and the rows
 * themselves are seeded from CmsPagesSeeder.
 */
class CmsPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Page')
                    ->searchable(false),
                TextColumn::make('updated_at')
                    ->label('Last updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('title')
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
