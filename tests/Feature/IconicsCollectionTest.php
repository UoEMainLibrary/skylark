<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * Stub every outbound Solr call so the test suite doesn't need live DSpace.
 */
function fakeIconicsSolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

it('registers every expected iconics named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'iconics.home',
    'iconics.search.redirect',
    'iconics.search.index',
    'iconics.record.show',
    'iconics.record.image',
    'iconics.mirador',
    'iconics.advanced',
    'iconics.advanced.form',
    'iconics.advanced.post',
    'iconics.advanced.search',
    'iconics.about',
    'iconics.iiif',
    'iconics.licensing',
    'iconics.takedown',
    'iconics.accessibility',
    'iconics.feedback',
]);

it('routes /iconics/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/iconics/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /iconics/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/iconics/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('iconics.record.show');
});

it('serves the iconics home page at /iconics', function (): void {
    fakeIconicsSolr();

    $this->get('/iconics')
        ->assertSuccessful()
        ->assertSee('iconic items are the most beautiful', false)
        ->assertSee('View All', false);
});

it('serves every iconics static page', function (string $path): void {
    fakeIconicsSolr();

    $this->get("/iconics/{$path}")->assertSuccessful();
})->with([
    'about',
    'iiif',
    'licensing',
    'takedown',
    'feedback',
    'accessibility',
]);

it('loads iconics-specific skylight config when /iconics is requested', function (): void {
    fakeIconicsSolr();

    $this->get('/iconics')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('iconics')
        ->and(config('skylight.fullname'))->toBe('Library and University Collections - Iconics')
        ->and(config('skylight.theme'))->toBe('iconics')
        ->and(config('skylight.url_prefix'))->toBe('iconics')
        ->and(config('skylight.container_field'))->toBe('location.coll')
        ->and(config('skylight.container_id'))->toBe(env('ICONICS_CONTAINER_ID', '5fe7777e-d6df-47fb-be57-5fa5db719bef'))
        ->and(config('skylight.facet_limit'))->toBe(30)
        ->and(config('skylight.homepage_randomitems'))->toBeTrue();
});

it('renders random items on the iconics home page when Solr returns docs', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Bitstream' => 'dc.format.original.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
        ],
    ]);

    $html = view('iconics.home', [
        'randomItems' => [
            [
                'id' => '12345',
                'dctitleen' => ['Rashid al-Din manuscript'],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('Rashid al-Din manuscript')
        ->and($html)->toContain('./record/12345')
        ->and($html)->toContain('thumbnail-first');
});

it('renders iconics record page tag links with the legacy double-encoded filter shape', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Subject' => 'dc.subject.en',
        ],
        'skylight.filters' => [
            'Subject' => 'subject_filter',
        ],
    ]);

    $html = view('iconics.record.show', [
        'record' => [
            'dctitleen' => ['Sample Title'],
            'dcsubjecten' => ['Manuscripts'],
        ],
        'recordTitle' => 'Sample Title',
        'recordDisplay' => ['Subject'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)
        ->toContain('/Subject:%22manuscripts+%7C%7C%7C+Manuscripts%22');
});
