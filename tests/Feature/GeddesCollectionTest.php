<?php

use App\Support\CollectionViewResolver;
use Illuminate\Support\Facades\Route;

it('registers expected geddes routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'geddes.home',
    'geddes.search.redirect',
    'geddes.search.index',
    'geddes.record.show',
    'geddes.about',
    'geddes.feedback',
    'geddes.licensing',
    'geddes.takedown',
    'geddes.accessibility',
    'geddes.history',
    'geddes.people',
    'geddes.research',
    'geddes.contact',
    'geddes.browse',
]);

it('serves geddes pages', function (string $path): void {
    $this->get("/geddes/{$path}")->assertSuccessful();
})->with([
    '',
    'about',
    'history',
    'people',
    'research',
    'contact',
    'feedback',
    'licensing',
    'takedown',
    'accessibility',
]);

it('switches to v2 views when geddes_skin_version is 2', function () {
    config(['skylight.geddes_skin_version' => 2]);

    expect(CollectionViewResolver::geddes('geddes.home'))
        ->toBe('geddes-v2.home');
});

it('keeps v1 view name when geddes skin version is 1', function () {
    config(['skylight.geddes_skin_version' => 1]);

    expect(CollectionViewResolver::geddes('geddes.home'))
        ->toBe('geddes.home');
});

it('serves geddes v2 pages when skin version is 2', function (string $path) {
    config(['skylight.geddes_skin_version' => 2]);

    $this->get("/geddes/{$path}")
        ->assertSuccessful()
        ->assertSee('bg-geddes-forest', false);
})->with([
    '',
    'about',
    'history',
    'people',
    'research',
    'contact',
    'feedback',
    'licensing',
    'takedown',
]);

it('renders geddes v2 home slideshow without duplicate breakpoint columns', function () {
    config(['skylight.geddes_skin_version' => 2]);

    $response = $this->get('/geddes');

    $response->assertSuccessful()
        ->assertSee('id="geddes-cf"', false)
        ->assertDontSee('class="col-xl"', false)
        ->assertDontSee('class="col-lg"', false);
});

it('compiles shared pagination styles so ul.pagination renders inline in Tailwind layouts', function () {
    // Geddes v2, public-art v2, eerc v2 etc. all rely on @vite('resources/css/app.css').
    // Skylark's shared SearchController::buildPaginationLinks() emits
    // `<ul class="pagination"><li>...</li></ul>` which would stack vertically
    // without an explicit display rule (Tailwind's preflight clears list-style
    // but leaves <li> at display: list-item). The compiled CSS must override
    // that to keep pagination on one line.
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    $cssEntry = collect($manifest)
        ->first(fn (array $entry): bool => isset($entry['file']) && str_ends_with($entry['file'], '.css'));

    expect($cssEntry)->not->toBeNull();

    $css = file_get_contents(public_path('build/'.$cssEntry['file']));

    expect($css)
        ->toContain('ul.pagination')
        ->toContain('inline-block');
});

it('renders the geddes accessibility statement as a standalone Viki-template page', function (string $skin): void {
    config(['skylight.geddes_skin_version' => $skin === 'v1' ? 1 : 2]);

    $response = $this->get('/geddes/accessibility');

    $response->assertSuccessful();

    $html = $response->getContent();

    expect($html)
        ->toContain('The Patrick Geddes Archives website')
        ->and($html)->toContain('Change Log')
        ->and($html)->toContain('Preparation of this accessibility statement')
        // Bullet lists should render with disc markers from the standalone CSS.
        ->and($html)->toContain('list-style-type: disc')
        ->and($html)->toContain('color: #2f5496')
        // HTML typos that were in the legacy view should be fixed.
        ->and($html)->not->toContain('< h1 >')
        ->and($html)->not->toContain('Preparation of this accessibility statement</h3>')
        ->and($html)->not->toContain('#name-role-valuet')
        // Standalone page must not pull in the v1 or v2 geddes layout chrome.
        ->and($html)->not->toContain('bg-geddes-forest')
        ->and($html)->not->toContain('/collections/geddes/css/style.css');
})->with(['v1', 'v2']);
