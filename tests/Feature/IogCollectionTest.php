<?php

use Illuminate\Support\Facades\Route;

it('registers expected iog routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'iog.home',
    'iog.search.redirect',
    'iog.search.index',
    'iog.record.show',
    'iog.about',
    'iog.licensing',
    'iog.takedown',
    'iog.accessibility',
    'iog.history',
    'iog.advanced',
    'iog.advanced.form',
    'iog.advanced.post',
    'iog.advanced.search',
]);

it('serves the iog advanced search form with the configured search fields', function (): void {
    $response = $this->get('/iog/advanced/form')
        ->assertSuccessful()
        ->assertSee('<h1>Advanced Search</h1>', false)
        ->assertSee('/iog/advanced/post', false)
        ->assertSee('name="operator"', false);

    foreach (array_keys(config('skylight.search_fields', [])) as $label) {
        $response->assertSee('name="'.str_replace(' ', '_', $label).'"', false);
    }
});

it('registers iog routes on the configured dedicated host', function (): void {
    expect(env('SCOTGOVYEARBOOKS_HOST'))->toBe('scottishgovernmentyearbooks.testing')
        ->and(config('collections.domains'))->toHaveKey('scottishgovernmentyearbooks.testing');

    $hasDomainHome = collect(app('router')->getRoutes())->contains(
        fn ($route) => $route->uri() === '/' && $route->getDomain() === 'scottishgovernmentyearbooks.testing'
    );

    expect($hasDomainHome)->toBeTrue();
});

it('serves the iog home page at /iog', function (): void {
    $this->get('/iog')
        ->assertSuccessful()
        ->assertSee('Scottish Government Yearbooks', false)
        ->assertSee('jgrid-wrapper', false)
        ->assertSee('Devolution', false)
        ->assertSee('collections/iog/images/carousel/', false);
});

it('serves the iog home page at / on a configured dedicated host', function (): void {
    $this->get('http://scottishgovernmentyearbooks.testing/')
        ->assertSuccessful()
        ->assertSee('Scottish Government Yearbooks', false)
        ->assertSee('jgrid-wrapper', false);
});

it('uses collection-root urls on a dedicated host', function (): void {
    $this->get('http://scottishgovernmentyearbooks.testing/about')
        ->assertSuccessful()
        ->assertSee('base href="http://scottishgovernmentyearbooks.testing/"', false)
        ->assertDontSee('/iog/about', false);
});

it('serves iog static pages from subfolder path', function (string $path): void {
    $url = $path === '' ? '/iog' : "/iog/{$path}";
    $this->get($url)->assertSuccessful();
})->with([
    '',
    'about',
    'history',
    'licensing',
    'takedown',
    'accessibility',
]);

it('renders the about page with credits and history link', function (): void {
    $this->get('/iog/about')
        ->assertSuccessful()
        ->assertSee('SCOTLAND: A PERPLEXING PLACE', false)
        ->assertSee('Homepage Image Credits', false)
        ->assertSee('Institute of Governance', false);
});

it('renders the history page with editor reflections', function (): void {
    $this->get('/iog/history')
        ->assertSuccessful()
        ->assertSee('Scottish Government Yearbook: a History', false)
        ->assertSee('Henry Drucker', false);
});

it('home page carousel links into faceted subject searches', function (): void {
    $response = $this->get('/iog');

    $response->assertSuccessful();

    foreach (['Gender', 'Media', 'Health', 'Devolution', 'Islands', 'Local+Government', 'Religion', 'Elections', 'Scottish+Office'] as $label) {
        $response->assertSee('Subject:%22', false);
        $response->assertSee($label, false);
    }
});

it('renders the legacy nav with visible "opens in a new tab" labels', function (): void {
    $this->get('/iog')
        ->assertSuccessful()
        ->assertSee('University of Edinburgh (opens in a new tab)', false)
        ->assertSee('Blog (opens in a new tab)', false)
        ->assertSee('ERA (opens in a new tab)', false)
        ->assertSee('SPS (opens in a new tab)', false)
        ->assertSee('>History<', false)
        ->assertSee('>About<', false);
});

it('registers a sidebar facets composer for the iog layout', function (): void {
    expect(app('view')->getDispatcher())->not->toBeNull();

    // The IogLayoutComposer adds $sidebar_facets et al when layouts.iog is
    // rendered. Static iog pages should expose the right-hand facets shell
    // (the <h4> facet titles come from the Solr stub when configured; here we
    // just confirm the layout's col-sidebar is wired up).
    $this->get('/iog')
        ->assertSuccessful()
        ->assertSee('col-sidebar', false);
});
