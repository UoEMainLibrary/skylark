<?php

use Illuminate\Support\Facades\Route;

it('registers expected jlss routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'jlss.home',
    'jlss.search.redirect',
    'jlss.search.index',
    'jlss.record.show',
    'jlss.about',
    'jlss.feedback',
    'jlss.licensing',
    'jlss.takedown',
    'jlss.accessibility',
    'jlss.browse',
]);

it('registers jlss routes on the configured SJAC dedicated host', function (): void {
    expect(env('SJAC_HOST'))->toBe('sjac.testing')
        ->and(config('collections.domains'))->toHaveKey('sjac.testing');

    $hasDomainHome = collect(app('router')->getRoutes())->contains(
        fn ($route) => $route->uri() === '/' && $route->getDomain() === 'sjac.testing'
    );

    expect($hasDomainHome)->toBeTrue();
});

it('serves the jlss home page at / on a configured dedicated host', function (): void {
    $this->get('http://sjac.testing/')
        ->assertSuccessful()
        ->assertSee('Scottish Jewish Archives Centre', false)
        ->assertSee('Collections', false);
});

it('uses root-relative collection links on a dedicated host', function (): void {
    $this->get('http://sjac.testing/about')
        ->assertSuccessful()
        ->assertSee('href="http://sjac.testing"', false)
        ->assertSee('href="http://sjac.testing/about"', false)
        ->assertDontSee('/jlss/about', false);
});

it('serves jlss pages from subfolder path', function (string $path): void {
    $url = $path === '' ? '/jlss' : "/jlss/{$path}";
    $this->get($url)->assertSuccessful();
})->with([
    '',
    'about',
    'feedback',
    'licensing',
    'takedown',
    'accessibility',
]);

it('uses existing local images for jlss about and feedback pages', function (string $path): void {
    $url = "/jlss/{$path}";

    $this->get($url)
        ->assertSuccessful()
        ->assertSee('/collections/jlss/images/sjac-temp.jpg', false)
        ->assertDontSee('../../theme/jlss/images/sjac-temp.jpg', false);
})->with([
    'about',
    'feedback',
]);

it('shows jlss about sidebar search and collection links', function (): void {
    $this->get('/jlss/about')
        ->assertSuccessful()
        ->assertSee('/jlss/search', false)
        ->assertSee('Collection', false)
        ->assertSee('Theatre', false)
        ->assertSee('Migration', false);
});

it('renders the jlss accessibility statement within the collection layout', function (): void {
    $response = $this->get('/jlss/accessibility');

    $response->assertSuccessful();

    $html = $response->getContent();

    expect($html)
        ->toContain('Scottish Jewish Archives Centre')
        ->toContain('Disproportionate burden')
        ->toContain('navbar')
        ->toContain('color: #2f5496')
        ->not->toContain('content-divider-inline');
});
