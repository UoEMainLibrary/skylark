<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

function fakeSpeccollSolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

it('registers every expected speccoll named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'speccoll.home',
    'speccoll.search.redirect',
    'speccoll.search.index',
    'speccoll.record.show',
    'speccoll.record.image',
    'speccoll.mirador',
    'speccoll.advanced',
    'speccoll.advanced.form',
    'speccoll.advanced.post',
    'speccoll.advanced.search',
    'speccoll.about',
    'speccoll.licensing',
    'speccoll.takedown',
    'speccoll.accessibility',
    'speccoll.feedback',
]);

it('routes /speccoll/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/speccoll/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /speccoll/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/speccoll/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('speccoll.record.show');
});

it('serves the speccoll home page at /speccoll', function (): void {
    fakeSpeccollSolr();

    $this->get('/speccoll')
        ->assertSuccessful()
        ->assertSee('Special Collections hero image', false);
});

it('serves every speccoll static page', function (string $path): void {
    fakeSpeccollSolr();

    $this->get("/speccoll/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'feedback',
    'accessibility',
]);

it('loads speccoll-specific skylight config when /speccoll is requested', function (): void {
    fakeSpeccollSolr();

    $this->get('/speccoll')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('speccoll')
        ->and(config('skylight.fullname'))->toBe('Special Collections')
        ->and(config('skylight.theme'))->toBe('speccoll')
        ->and(config('skylight.url_prefix'))->toBe('speccoll')
        ->and(config('skylight.container_field'))->toBe('location.coll')
        ->and(config('skylight.container_id'))->toBe(env('SPECCOLL_CONTAINER_ID', '05a4fd68-f752-4d4e-a4fc-030d2642091c'))
        ->and(config('skylight.manifest_endpoint'))->toContain('librarylabs.ed.ac.uk/iiif/speccollprototype')
        ->and(config('skylight.show_facets'))->toBeFalse();
});

it('renders speccoll record tag links with the legacy double-encoded filter shape', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Type' => 'dc.type.en',
        ],
        'skylight.filters' => [
            'Author' => 'author_filter',
            'Type' => 'type_filter',
        ],
    ]);

    $html = view('speccoll.record.show', [
        'record' => [
            'dctitleen' => ['Sample Title'],
            'dctypeen' => ['Manuscript'],
        ],
        'recordTitle' => 'Sample Title',
        'recordDisplay' => ['Type'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)
        ->toContain('/Type:%22manuscript+%7C%7C%7C+Manuscript%22');
});
