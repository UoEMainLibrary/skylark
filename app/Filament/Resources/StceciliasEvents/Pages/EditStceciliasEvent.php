<?php

namespace App\Filament\Resources\StceciliasEvents\Pages;

use App\Filament\Resources\StceciliasEvents\StceciliasEventResource;
use App\Support\StceciliasEditorContent;
use Filament\Resources\Pages\EditRecord;

class EditStceciliasEvent extends EditRecord
{
    protected static string $resource = StceciliasEventResource::class;

    /** @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['body'] = StceciliasEditorContent::normalize($data['body'] ?? null);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
