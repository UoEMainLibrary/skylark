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
