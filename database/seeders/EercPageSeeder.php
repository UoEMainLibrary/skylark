<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class EercPageSeeder extends Seeder
{
    /**
     * Seed EERC static pages by extracting content from existing Blade files.
     */
    public function run(): void
    {
        $pages = [
            ['slug' => 'eerc-about', 'title' => 'About', 'file' => 'about'],
            ['slug' => 'eerc-resp', 'title' => 'About the Project', 'file' => 'resp'],
            ['slug' => 'eerc-project-history', 'title' => 'Project History', 'file' => 'project_history'],
            ['slug' => 'eerc-creative-engagement', 'title' => 'Creative Engagement and Research', 'file' => 'creative_engagement'],
            ['slug' => 'eerc-exhibition-gallery', 'title' => 'Exhibition Gallery', 'file' => 'exhibition_gallery'],
            ['slug' => 'eerc-using', 'title' => 'Searching and Using the Collection', 'file' => 'using'],
            ['slug' => 'eerc-contact', 'title' => 'Contact', 'file' => 'contact'],
            ['slug' => 'eerc-accessibility', 'title' => 'Accessibility', 'file' => 'accessibility'],
            ['slug' => 'eerc-bsl', 'title' => 'British Sign Language (BSL)', 'file' => 'bsl'],
        ];

        foreach ($pages as $page) {
            $bladePath = resource_path("views/eerc-v2/pages/{$page['file']}.blade.php");

            if (! file_exists($bladePath)) {
                $this->command->warn("Blade file not found: {$bladePath}");

                continue;
            }

            $blade = file_get_contents($bladePath);
            $body = $this->extractBody($blade);

            Page::updateOrCreate(
                ['slug' => $page['slug']],
                [
                    'collection' => 'eerc',
                    'title' => $page['title'],
                    'body' => $body,
                ]
            );

            $this->command->info("Seeded: {$page['slug']}");
        }
    }

    /**
     * Extract the body content from a Blade file, resolving Blade helpers to plain HTML.
     */
    protected function extractBody(string $blade): string
    {
        // Extract content between first <div class="lg:col-span-3..."> and the sidebar div
        // Remove @extends, @section directives
        $content = preg_replace('/@extends\(.*?\)\s*/', '', $blade);
        $content = preg_replace('/@section\(\'title\'.*?\)\s*/', '', $content);
        $content = preg_replace('/@section\(\'content\'\)\s*/', '', $content);
        $content = preg_replace('/@endsection\s*/', '', $content);
        $content = preg_replace('/@push\(.*?\)\s*/', '', $content);
        $content = preg_replace('/@endpush\s*/', '', $content);

        // Remove outer grid wrapper
        $content = preg_replace('/<div class="lg:grid lg:grid-cols-4 lg:gap-8">\s*/', '', $content);

        // Remove the col-span-3 wrapper opening
        $content = preg_replace('/<div class="lg:col-span-3[^"]*">\s*/', '', $content, 1);

        // Remove the sidebar section and everything after
        $sidebarPos = strpos($content, '@include(\'eerc-v2.partials.sidebar\')');
        if ($sidebarPos !== false) {
            // Walk back to find the sidebar wrapper div
            $beforeSidebar = substr($content, 0, $sidebarPos);
            // Remove trailing closing divs for the sidebar wrapper and outer grid
            $beforeSidebar = preg_replace('/\s*<div class="mt-8 lg:mt-0">\s*$/', '', $beforeSidebar);
            $content = $beforeSidebar;
        }

        // Remove the h1 tag (we render that from the title field)
        $content = preg_replace('/<h1 class="[^"]*">.*?<\/h1>\s*/s', '', $content, 1);

        // Remove trailing closing </div>s that belong to the wrapper
        $content = rtrim($content);
        // Remove 2 closing divs (col-span-3 + outer grid)
        $content = preg_replace('/\s*<\/div>\s*<\/div>\s*$/', '', $content);
        // Also handle single trailing </div>
        $content = preg_replace('/\s*<\/div>\s*$/', '', $content);

        // Resolve Blade helpers to plain HTML
        $content = preg_replace("/\\{\\{\\s*url\\('([^']*)'\\)\\s*\\}\\}/", '$1', $content);
        $content = preg_replace("/\\{\\{\\s*asset\\('([^']*)'\\)\\s*\\}\\}/", '/$1', $content);

        // Clean up any remaining simple Blade echo tags that just output a variable
        // Leave {!! !!} as-is since we won't have those in static content

        return trim($content);
    }
}
