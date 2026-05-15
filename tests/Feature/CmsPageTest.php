<?php

use App\Filament\Resources\CmsPages\PublicArt\PublicArtCmsPageResource;
use App\Filament\Resources\CmsPages\Resp\RespCmsPageResource;
use App\Models\CmsPage;
use App\Support\Cms;
use Database\Seeders\CmsPagesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    config([
        'skylight.resp_skin_version' => 2,
        'skylight.public_art_skin_version' => 2,
    ]);
});

// ---- Registry + helper ------------------------------------------------------

it('lists every CMS-managed RESP page in the registry', function (): void {
    $pages = config('cms.pages.eerc');

    expect(array_keys($pages))->toEqualCanonicalizing([
        'home', 'about', 'resp', 'project-history', 'overview',
        'contact', 'accessibility', 'bsl',
    ]);
});

it('lists every CMS-managed Public Art page in the registry', function (): void {
    $pages = config('cms.pages.public-art');

    expect(array_keys($pages))->toEqualCanonicalizing([
        'home', 'licensing', 'takedown', 'accessibility', 'feedback',
    ]);
});

it('treats only the eerc home page as always-cms', function (): void {
    expect(Cms::pageAlwaysCms('eerc', 'home'))->toBeTrue();
    expect(Cms::pageAlwaysCms('eerc', 'about'))->toBeFalse();
    expect(Cms::pageAlwaysCms('public-art', 'artcollection'))->toBeFalse();
});

it('exposes the configured image count per page', function (): void {
    expect(Cms::pageImageCount('eerc', 'resp'))->toBe(1);
    expect(Cms::pageImageCount('eerc', 'project-history'))->toBe(1);
    expect(Cms::pageImageCount('eerc', 'about'))->toBe(0);
    expect(Cms::pageImageCount('public-art', 'licensing'))->toBe(0);
});

it('shouldRenderCms is true when the global toggle is on', function (): void {
    config(['cms.enabled' => true]);

    expect(Cms::shouldRenderCms('public-art', 'licensing'))->toBeTrue();
});

it('shouldRenderCms is false when the global toggle is off and the page is not always_cms', function (): void {
    config(['cms.enabled' => false]);

    expect(Cms::shouldRenderCms('public-art', 'licensing'))->toBeFalse();
});

it('shouldRenderCms is true for always_cms pages even when the toggle is off', function (): void {
    config(['cms.enabled' => false]);

    expect(Cms::shouldRenderCms('eerc', 'home'))->toBeTrue();
});

// ---- Seeder ----------------------------------------------------------------

it('seeds one row per registry entry', function (): void {
    $this->seed(CmsPagesSeeder::class);

    $expected = collect(config('cms.pages'))
        ->flatMap(fn ($pages, $collection) => collect(array_keys($pages))
            ->map(fn ($slug) => "{$collection}/{$slug}"))
        ->all();

    $actual = CmsPage::query()->get()
        ->map(fn (CmsPage $row) => "{$row->collection}/{$row->slug}")
        ->all();

    expect($actual)->toEqualCanonicalizing($expected);
});

it('preserves existing rows on reseed (firstOrCreate keyed on collection+slug)', function (): void {
    CmsPage::query()->create([
        'collection' => 'eerc',
        'slug' => 'about',
        'title' => 'About',
        'body' => '<p>existing custom body should not be overwritten</p>',
    ]);

    $this->seed(CmsPagesSeeder::class);

    expect(CmsPage::lookup('eerc', 'about')?->body)
        ->toBe('<p>existing custom body should not be overwritten</p>');
});

// ---- Public-facing toggle behaviour ----------------------------------------

it('renders the static fallback when CMS_ENABLED is false', function (): void {
    config(['cms.enabled' => false]);

    $html = view('public-art-v2.pages.licensing')->render();

    // String from the static @else branch in licensing.blade.php.
    expect($html)->toContain('Unless explicitly stated otherwise, all material on this website is copyright');
});

it('renders the CMS body when CMS_ENABLED is true and a row exists', function (): void {
    config(['cms.enabled' => true]);

    CmsPage::query()->create([
        'collection' => 'public-art',
        'slug' => 'licensing',
        'title' => 'Licensing & Copyright',
        'body' => '<p>cms-marker beta-77</p>',
    ]);

    $html = view('public-art-v2.pages.licensing')->render();

    expect($html)->toContain('cms-marker beta-77')
        ->and($html)->not->toContain('Unless explicitly stated otherwise, all material on this website is copyright');
});

it('falls back to static HTML when the CMS row is missing even with the toggle on', function (): void {
    config(['cms.enabled' => true]);

    $html = view('public-art-v2.pages.licensing')->render();

    expect($html)->toContain('Unless explicitly stated otherwise, all material on this website is copyright');
});

it('renders the CMS welcome paragraph on the Public Art home when the toggle is on', function (): void {
    config(['cms.enabled' => true]);

    CmsPage::query()->create([
        'collection' => 'public-art',
        'slug' => 'home',
        'title' => 'Home',
        'body' => '<p>cms-marker public-art-home-77</p>',
    ]);

    $html = view('public-art-v2.home')->render();

    expect($html)->toContain('cms-marker public-art-home-77')
        ->and($html)->not->toContain('Ranging from historic memorials');
});

it('keeps the lead sentence and Spotlight block on the Public Art home regardless of the toggle', function (): void {
    config(['cms.enabled' => true]);

    CmsPage::query()->create([
        'collection' => 'public-art',
        'slug' => 'home',
        'title' => 'Home',
        'body' => '<p>cms-marker public-art-home-77</p>',
    ]);

    $html = view('public-art-v2.home')->render();

    // Lead sentence above the editable block stays static. Blade doesn't
    // decode &rsquo; so the literal HTML entity is what reaches the page.
    expect($html)->toContain('Artworks from the University of Edinburgh&rsquo;s Art Collection')
        // Spotlight section below the editable block stays static.
        ->and($html)->toContain('Spotlight')
        ->and($html)->toContain('Ideas at the King');
});

it('always renders the CMS body for the eerc home (always_cms) regardless of the toggle', function (): void {
    config(['cms.enabled' => false]);

    CmsPage::query()->create([
        'collection' => 'eerc',
        'slug' => 'home',
        'title' => 'Home',
        'body' => '<p>cms-marker home-always-on-99</p>',
    ]);

    $html = view('eerc-v2.home', [
        'subjectFacet' => [],
        'personFacet' => [],
    ])->render();

    expect($html)->toContain('cms-marker home-always-on-99');
});

// ---- Image rendering -------------------------------------------------------

it('renders the editable image src when CMS is on and an upload exists', function (): void {
    config(['cms.enabled' => true]);

    CmsPage::query()->create([
        'collection' => 'eerc',
        'slug' => 'resp',
        'title' => 'About the Project',
        'body' => '<p>placeholder</p>',
        'image_1_path' => 'cms/eerc/resp/uploaded.jpg',
        'image_1_alt' => 'Custom uploaded portrait',
    ]);

    $html = view('eerc-v2.pages.resp', [
        'subjectFacet' => [],
        'personFacet' => [],
    ])->render();

    expect($html)->toContain('storage/cms/eerc/resp/uploaded.jpg')
        ->and($html)->toContain('Custom uploaded portrait')
        ->and($html)->not->toContain('DG38-5-4-1.jpg');
});

it('falls back to the stock image asset when no upload exists', function (): void {
    config(['cms.enabled' => true]);

    CmsPage::query()->create([
        'collection' => 'eerc',
        'slug' => 'resp',
        'title' => 'About the Project',
        'body' => '<p>placeholder</p>',
    ]);

    $html = view('eerc-v2.pages.resp', [
        'subjectFacet' => [],
        'personFacet' => [],
    ])->render();

    expect($html)->toContain('DG38-5-4-1.jpg');
});

// ---- Filament resources ----------------------------------------------------

it('places the RESP and Public Art CMS resources in distinct nav groups', function (): void {
    expect(RespCmsPageResource::getNavigationGroup())->toBe('RESP');
    expect(PublicArtCmsPageResource::getNavigationGroup())->toBe('Public Art');
});

it('scopes each Filament resource to its collection', function (): void {
    CmsPage::query()->create([
        'collection' => 'eerc',
        'slug' => 'about',
        'title' => 'About',
        'body' => '<p>resp body</p>',
    ]);
    CmsPage::query()->create([
        'collection' => 'public-art',
        'slug' => 'licensing',
        'title' => 'Licensing & Copyright',
        'body' => '<p>public art body</p>',
    ]);

    expect(RespCmsPageResource::getEloquentQuery()->pluck('slug')->all())
        ->toBe(['about']);
    expect(PublicArtCmsPageResource::getEloquentQuery()->pluck('slug')->all())
        ->toBe(['licensing']);
});
