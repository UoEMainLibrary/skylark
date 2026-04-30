<?php

use App\Http\Controllers\PageController;

it('serves the public-art home page at /public-art', function () {
    $this->get('/public-art')->assertSuccessful();
});

it('serves public-art static pages', function (string $path) {
    $this->get("/public-art/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'accessibility',
    'takedown',
    'paolozzi',
    'artcollection',
    'feedback',
]);

it('uses the v1 layout by default', function () {
    config(['skylight.public_art_skin_version' => 1]);

    $this->get('/public-art')
        ->assertSuccessful()
        ->assertSee('cb-slideshow', false)
        ->assertSee('Search art on campus');
});

it('uses the v2 layout when PUBLIC_ART_SKIN_VERSION=2', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/public-art')
        ->assertSuccessful()
        ->assertSee('Art on Campus')
        ->assertSee('University of Edinburgh Art Collection')
        ->assertSee('Spotlight')
        ->assertDontSee('cb-slideshow')
        ->assertDontSee('Coll.ed', false);
});

it('renders the v2 paolozzi page with updated content', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/public-art/paolozzi')
        ->assertSuccessful()
        ->assertSee('Paolozzi Mosaic Project')
        ->assertSee('Tottenham Court Road')
        ->assertDontSee('Information video');
});

it('switches to v2 views when public_art_skin_version is 2', function () {
    config(['skylight.public_art_skin_version' => 2]);

    expect(PageController::publicArtViewName('public-art.home'))
        ->toBe('public-art-v2.home');
});

it('keeps v1 view name when skin version is 1', function () {
    config(['skylight.public_art_skin_version' => 1]);

    expect(PageController::publicArtViewName('public-art.home'))
        ->toBe('public-art.home');
});
