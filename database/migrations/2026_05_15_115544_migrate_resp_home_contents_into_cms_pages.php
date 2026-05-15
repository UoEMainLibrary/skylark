<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Move the single RESP V2 homepage row from resp_home_contents into the
 * generalised cms_pages table, then drop resp_home_contents.
 *
 * Idempotent: if there is no source row (fresh install where CmsPagesSeeder
 * will populate the home page directly) this is a no-op. If a destination
 * row already exists for (eerc, home) the source row's body wins so any
 * client edits made in production are preserved.
 *
 * Down: re-creates the original resp_home_contents schema and copies the
 * eerc/home row back. Dropping the cms_pages row is left to the original
 * create_cms_pages_table migration's down() — the data migration's
 * concern is just the resp_home_contents table.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('resp_home_contents')) {
            return;
        }

        DB::table('resp_home_contents')
            ->orderBy('id')
            ->each(function (object $row): void {
                DB::table('cms_pages')->updateOrInsert(
                    ['collection' => 'eerc', 'slug' => 'home'],
                    [
                        'title' => $row->title,
                        'body' => $row->body,
                        'created_at' => $row->created_at,
                        'updated_at' => $row->updated_at,
                    ]
                );
            });

        Schema::dropIfExists('resp_home_contents');
    }

    public function down(): void
    {
        if (Schema::hasTable('resp_home_contents')) {
            return;
        }

        Schema::create('resp_home_contents', function ($table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body');
            $table->timestamps();
        });

        $homeRow = DB::table('cms_pages')
            ->where('collection', 'eerc')
            ->where('slug', 'home')
            ->first();

        if ($homeRow !== null) {
            DB::table('resp_home_contents')->insert([
                'title' => $homeRow->title,
                'slug' => 'eerc-v2-home',
                'body' => $homeRow->body ?? '',
                'created_at' => $homeRow->created_at,
                'updated_at' => $homeRow->updated_at,
            ]);
        }
    }
};
