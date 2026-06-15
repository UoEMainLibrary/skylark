<?php

use Illuminate\Support\Facades\Route;

it('registers expected pointsofarrival routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'pointsofarrival.home',
    'pointsofarrival.search.redirect',
    'pointsofarrival.search.index',
    'pointsofarrival.record.show',
    'pointsofarrival.feedback',
    'pointsofarrival.licensing',
    'pointsofarrival.takedown',
    'pointsofarrival.accessibility',
    'pointsofarrival.content',
    'pointsofarrival.about',
]);

it('registers pointsofarrival routes on the configured dedicated host', function (): void {
    expect(env('POINTSOFARRIVAL_HOST'))->toBe('pointsofarrival.testing')
        ->and(config('collections.domains'))->toHaveKey('pointsofarrival.testing');

    $hasDomainHome = collect(app('router')->getRoutes())->contains(
        fn ($route) => $route->uri() === '/' && $route->getDomain() === 'pointsofarrival.testing'
    );

    expect($hasDomainHome)->toBeTrue();
});

it('serves the pointsofarrival home page at / on a configured dedicated host', function (): void {
    $this->get('http://pointsofarrival.testing/')
        ->assertSuccessful()
        ->assertSee('Points of Arrival', false)
        ->assertSee('poa-sidebar', false)
        ->assertSee('Points of Arrival Films', false)
        ->assertSee('How To', false)
        ->assertSee('./films', false);
});

it('uses collection-root relative links on a dedicated host', function (): void {
    $this->get('http://pointsofarrival.testing/introduction')
        ->assertSuccessful()
        ->assertSee('href="./"', false)
        ->assertSee('href="./introduction"', false)
        ->assertSee('base href="http://pointsofarrival.testing/"', false)
        ->assertDontSee('/pointsofarrival/introduction', false);
});

it('serves pointsofarrival pages from subfolder path', function (string $path): void {
    $url = $path === '' ? '/pointsofarrival' : "/pointsofarrival/{$path}";
    $this->get($url)->assertSuccessful();
})->with([
    '',
    'introduction',
    'films',
    'themes',
    'resources',
    'contact',
    'goldwag',
    'feedback',
    'licensing',
    'takedown',
    'accessibility',
]);

it('renders the introduction page with sidebar navigation and client copy', function (): void {
    $this->get('/pointsofarrival/introduction')
        ->assertSuccessful()
        ->assertSee('Points of Arrival', false)
        ->assertSee('How To', false)
        ->assertSee('Points of Arrival Films', false)
        ->assertSee('collections/pointsofarrival/images/', false);
});

it('redirects about to introduction', function (): void {
    $this->get('/pointsofarrival/about')
        ->assertRedirect('/pointsofarrival/introduction');
});

it('includes an accessibility statement link in the left hand navigation', function (): void {
    $this->get('/pointsofarrival')
        ->assertSuccessful()
        ->assertSee('href="./accessibility"', false)
        ->assertSee('Accessibility Statement', false);
});

it('renders the pointsofarrival accessibility statement within the collection layout', function (): void {
    $html = view('pointsofarrival.pages.accessibility')->render();

    expect($html)
        ->toContain('Points of Arrival website')
        ->toContain('Preparation of this accessibility statement')
        ->toContain('Change Log')
        ->toContain('color: #2f5496')
        ->toContain('#0563c1')
        ->toContain('poa-sidebar')
        ->toContain('poa-theme')
        ->toContain('poa-accessibility')
        ->toContain('Accessibility Statement')
        ->not->toContain('name-role-valuet');
});

it('serves the pointsofarrival accessibility route with collection navigation', function (): void {
    $response = $this->get('/pointsofarrival/accessibility');

    $response->assertSuccessful();

    $html = $response->getContent();

    expect($html)
        ->toContain('Points of Arrival website')
        ->toContain('2rd March 2023')
        ->toContain('poa-sidebar')
        ->toContain('poa-img-banner')
        ->toContain('stills-banner.png');
});
