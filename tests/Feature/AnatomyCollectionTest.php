<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * Stub every outbound Solr call so the test suite doesn't need live DSpace.
 */
function fakeAnatomySolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

it('registers every expected anatomy named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'anatomy.home',
    'anatomy.search.redirect',
    'anatomy.search.index',
    'anatomy.record.show',
    'anatomy.record.image',
    'anatomy.mirador',
    'anatomy.advanced',
    'anatomy.advanced.form',
    'anatomy.advanced.post',
    'anatomy.advanced.search',
    'anatomy.about',
    'anatomy.licensing',
    'anatomy.takedown',
    'anatomy.accessibility',
    'anatomy.feedback',
]);

it('routes /anatomy/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/anatomy/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /anatomy/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/anatomy/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('anatomy.record.show');
});

it('serves the anatomy home page at /anatomy', function (): void {
    fakeAnatomySolr();

    $this->get('/anatomy')
        ->assertSuccessful()
        ->assertSee("It's the anatomical collection!", false)
        ->assertSee(url('/anatomy/about'), false);
});

it('serves every anatomy static page', function (string $path): void {
    fakeAnatomySolr();

    $this->get("/anatomy/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'feedback',
    'accessibility',
]);

it('loads anatomy-specific skylight config when /anatomy is requested', function (): void {
    fakeAnatomySolr();

    $this->get('/anatomy')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('anatomy')
        ->and(config('skylight.fullname'))->toBe('University of Edinburgh Anatomical Collection')
        ->and(config('skylight.theme'))->toBe('anatomy')
        ->and(config('skylight.url_prefix'))->toBe('anatomy')
        ->and(config('skylight.container_field'))->toBe('location.coll')
        ->and(config('skylight.container_id'))->toBe(env('ANATOMY_CONTAINER_ID', '50'))
        ->and(config('skylight.oaipmhcollection'))->toBe('hdl_10683_117442');
});

it('renders anatomy record page facet links with the legacy double-encoded filter shape', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Description' => 'dc.description.en',
            'Accession Number' => 'dc.identifier.en',
        ],
        'skylight.filters' => [
            'Author' => 'author_filter',
        ],
    ]);

    $html = view('anatomy.record.show', [
        'record' => [
            'dctitleen' => ['Sample anatomical specimen'],
        ],
        'recordTitle' => 'Sample anatomical specimen',
        'recordDisplay' => [],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [
            [
                'id' => '5555',
                'dctitleen' => ['Related specimen'],
                'dccontributorauthorfullen' => ['Charles Bell'],
            ],
        ],
    ])->render();

    // If the record view links any Author chips, they must use %22 quotes and
    // %7C%7C%7C (`|||`) between the lower-cased and display forms. Never a
    // literal `|||` in the href.
    expect($html)->not->toContain('href="./search/*/Author:%22charles bell')
        ->and($html)->not->toContain('|||');
});
