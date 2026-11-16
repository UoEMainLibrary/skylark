<?php

namespace App\Console\Commands;

use App\Models\StceciliasEvent;
use App\Models\StceciliasPage;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

#[Signature('app:import-stcecilias-content {directory : Directory containing the migration bundle} {--staging : Allow the import on the Collections staging site}')]
#[Description('Import the verified St Cecilia’s WordPress snapshot into the museum site')]
class ImportStceciliasContent extends Command
{
    public function handle(): int
    {
        $isLocalPreview = app()->isLocal() && config('database.default') === 'sqlite';
        $isStaging = $this->option('staging')
            && parse_url(config('app.url'), PHP_URL_HOST) === 'test.collections.ed.ac.uk'
            && config('stcecilias.museum_enabled');

        if (! $isLocalPreview && ! $isStaging) {
            $this->error('Run this from the local SQLite preview or the enabled Collections staging site.');

            return self::FAILURE;
        }

        $directory = $this->argument('directory');
        $manifest = $directory.'/content.json';
        if (! is_readable($manifest)) {
            $this->error('Cannot read the migration bundle.');

            return self::FAILURE;
        }

        $bundle = json_decode(file_get_contents($manifest), true, flags: JSON_THROW_ON_ERROR);
        $disk = Storage::disk('public');

        foreach ($bundle['media'] as $name => $url) {
            if ($name !== basename($name) || ! is_file($directory.'/media/'.$name)) {
                $this->error('Missing bundle file: '.$name);

                return self::FAILURE;
            }
        }

        foreach ($bundle['media'] as $name => $url) {
            $path = 'stcecilias/migration/'.$name;
            if (! $disk->exists($path) && ! $disk->put($path, fopen($directory.'/media/'.$name, 'rb'))) {
                $this->error('Unable to copy '.$name);

                return self::FAILURE;
            }
        }

        DB::transaction(function () use ($bundle): void {
            foreach ($bundle['pages'] as $page) {
                StceciliasPage::query()->firstOrCreate(['slug' => $page['slug']], $page);
            }

            foreach ($bundle['events'] as $event) {
                StceciliasEvent::query()->firstOrCreate(['slug' => $event['slug']], $event);
                StceciliasEvent::query()->where('slug', $event['slug'])->whereNull('body')
                    ->update(['body' => filled($event['body']) ? $event['body'] : '']);
            }

            foreach (['planning-your-visit', 'venue-hire'] as $slug) {
                $page = StceciliasPage::query()->where('slug', $slug)->firstOrFail();
                $sections = $page->sections ?? [];
                foreach ($sections as &$section) {
                    foreach (['content', 'video_url'] as $field) {
                        if (isset($section[$field])) {
                            $section[$field] = str_replace(array_keys($bundle['existing_media']), array_values($bundle['existing_media']), $section[$field]);
                        }
                    }
                }
                unset($section);

                if ($slug === 'planning-your-visit' && ! collect($sections)->contains('anchor', 'digital-guide')) {
                    $sections[] = ['heading' => 'Using the digital guide', 'anchor' => 'digital-guide', 'content' => $bundle['visitor_guide']];
                    $sections[] = ['heading' => 'More ways to visit', 'anchor' => 'tours', 'content' => '<p><a href="/stcecilias/tours">Tours</a> · <a href="/stcecilias/learning">Learning</a></p>'];
                }
                if ($sections !== $page->sections) {
                    $page->update(['sections' => $sections]);
                }
            }
        });

        $this->info('Imported '.count($bundle['pages']).' page records and reconciled '.count($bundle['events']).' public events.');

        return self::SUCCESS;
    }
}
