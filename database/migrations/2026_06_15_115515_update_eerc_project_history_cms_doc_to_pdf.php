<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Replace the Project History background Word document with a PDF so the link
 * opens in the browser like interviewee transcripts instead of downloading.
 */
return new class extends Migration
{
    private const COLLECTION = 'eerc';

    private const SLUG = 'project-history';

    private const DOCX_FILENAME = 'background-to-the-resp-26-3-26.docx';

    private const PDF_FILENAME = 'background-to-the-resp-26-3-26.pdf';

    public function up(): void
    {
        $this->transformProjectHistoryBodies(fn (string $body): string => $this->replaceDocxWithPdf($body));
    }

    public function down(): void
    {
        $this->transformProjectHistoryBodies(fn (string $body): string => $this->replacePdfWithDocx($body));
    }

    private function transformProjectHistoryBodies(callable $transform): void
    {
        DB::table('cms_pages')
            ->where('collection', self::COLLECTION)
            ->where('slug', self::SLUG)
            ->orderBy('id')
            ->each(function (object $row) use ($transform): void {
                if (! is_string($row->body) || $row->body === '') {
                    return;
                }

                $updated = $transform($row->body);

                if ($updated === $row->body) {
                    return;
                }

                DB::table('cms_pages')
                    ->where('id', $row->id)
                    ->update([
                        'body' => $updated,
                        'updated_at' => now(),
                    ]);
            });
    }

    private function replaceDocxWithPdf(string $body): string
    {
        return str_replace(self::DOCX_FILENAME, self::PDF_FILENAME, $body);
    }

    private function replacePdfWithDocx(string $body): string
    {
        return str_replace(self::PDF_FILENAME, self::DOCX_FILENAME, $body);
    }
};
