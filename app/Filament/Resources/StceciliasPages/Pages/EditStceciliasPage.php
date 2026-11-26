<?php

namespace App\Filament\Resources\StceciliasPages\Pages;

use App\Filament\Resources\StceciliasPages\StceciliasPageResource;
use App\Support\StceciliasEditorContent;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStceciliasPage extends EditRecord
{
    protected static string $resource = StceciliasPageResource::class;

    /** @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['body'] = StceciliasEditorContent::normalize($data['body'] ?? null);
        foreach ($data['sections'] ?? [] as $index => $section) {
            $data['sections'][$index]['content'] = StceciliasEditorContent::normalize($section['content'] ?? null);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
