<?php

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
