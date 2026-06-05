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
    'accessibility',
]);

it('renders geddes v2 home slideshow without duplicate breakpoint columns', function () {
    config(['skylight.geddes_skin_version' => 2]);

    $response = $this->get('/geddes');

    $response->assertSuccessful()
        ->assertSee('id="geddes-cf"', false)
        ->assertDontSee('class="col-xl"', false)
        ->assertDontSee('class="col-lg"', false);
});
