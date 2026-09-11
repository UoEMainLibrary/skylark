<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Replace staging Skylark hostnames baked into cms_pages during test-environment
 * seeding with the live collections.ed.ac.uk host.
 */
return new class extends Migration
{
    private const STAGING_HOST = 'https://test.skylark.is.ed.ac.uk';

    private const PRODUCTION_HOST = 'https://collections.ed.ac.uk';

    private const PRODUCTION_ART_ON_CAMPUS = self::PRODUCTION_HOST.'/art-on-campus';

    private const STAGING_ART_ON_CAMPUS = self::STAGING_HOST.'/art-on-campus';

    public function up(): void
    {
        $this->transformCmsBodies(
            fn (string $body): string => str_replace(self::STAGING_HOST, self::PRODUCTION_HOST, $body),
            self::STAGING_HOST,
        );
    }

    public function down(): void
    {
        $this->transformCmsBodies(
            fn (string $body): string => str_replace(self::PRODUCTION_ART_ON_CAMPUS, self::STAGING_ART_ON_CAMPUS, $body),
            self::PRODUCTION_ART_ON_CAMPUS,
        );
    }

    private function transformCmsBodies(callable $transform, string $needle): void
    {
        DB::table('cms_pages')
            ->orderBy('id')
            ->each(function (object $row) use ($transform, $needle): void {
                if (! is_string($row->body) || $row->body === '') {
                    return;
                }

                if (! str_contains($row->body, $needle)) {
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
};
