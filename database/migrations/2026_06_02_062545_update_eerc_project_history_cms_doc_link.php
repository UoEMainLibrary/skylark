<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Open the Project History background document in a new tab instead of forcing
 * a download. Seeded CMS rows still carry the old `download` attribute until
 * this migration runs.
 */
return new class extends Migration
{
    private const COLLECTION = 'eerc';

    private const SLUG = 'project-history';

    public function up(): void
    {
        $this->transformProjectHistoryBodies(fn (string $body): string => $this->applyNewTabLink($body));
    }

    public function down(): void
    {
        $this->transformProjectHistoryBodies(fn (string $body): string => $this->revertToDownloadLink($body));
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

    private function applyNewTabLink(string $body): string
    {
        $updated = preg_replace(
            '/<a href="([^"]+)" download>read more about the EERC, RESP and the Archive Project<\/a>/',
            '<a href="$1" target="_blank" rel="noopener">read more about the EERC, RESP and the Archive Project<span class="sr-only"> (opens in a new tab)</span></a>',
            $body,
        );

        return is_string($updated) ? $updated : $body;
    }

    private function revertToDownloadLink(string $body): string
    {
        $updated = preg_replace(
            '/<a href="([^"]+)" target="_blank" rel="noopener">read more about the EERC, RESP and the Archive Project<span class="sr-only"> \(opens in a new tab\)<\/span><\/a>/',
            '<a href="$1" download>read more about the EERC, RESP and the Archive Project</a>',
            $body,
        );

        return is_string($updated) ? $updated : $body;
    }
};
