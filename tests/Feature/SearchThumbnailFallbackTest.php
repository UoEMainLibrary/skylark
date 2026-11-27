<?php

it('removes failed image links from Art search results', function (): void {
    $template = file_get_contents(resource_path('views/art/search/results.blade.php'));

    expect($template)
        ->toContain("onerror=\"this.closest('a').remove()\"");
});

it('removes failed image links from Cockburn IIIF search thumbnails', function (): void {
    $template = file_get_contents(resource_path('views/cockburn/search/results.blade.php'));

    expect($template)
        ->toContain("onerror=\"this.closest('a').remove()\"")
        ->and(substr_count($template, 'onerror="this.closest(\\\'a\\\').remove()"'))->toBe(0);
});

it('derives the St Cecilia EDC link by stripping only a manifest suffix', function (): void {
    $template = file_get_contents(resource_path('views/stcecilias/record/show.blade.php'));

    expect($template)
        ->toContain("preg_replace('~/manifest$~', '', \$manifest)");
});
