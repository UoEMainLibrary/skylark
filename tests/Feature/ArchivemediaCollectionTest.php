<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * Stub every outbound Solr call so the test suite doesn't need live DSpace.
 */
function fakeArchivemediaSolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

it('registers every expected archivemedia named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'archivemedia.home',
    'archivemedia.search.redirect',
    'archivemedia.search.index',
    'archivemedia.record.show',
    'archivemedia.record.image',
    'archivemedia.mirador',
    'archivemedia.advanced',
    'archivemedia.advanced.form',
    'archivemedia.advanced.post',
    'archivemedia.advanced.search',
    'archivemedia.about',
    'archivemedia.iiif',
    'archivemedia.licensing',
    'archivemedia.takedown',
    'archivemedia.accessibility',
    'archivemedia.feedback',
]);

it('routes /archivemedia/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/archivemedia/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /archivemedia/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/archivemedia/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('archivemedia.record.show');
});

it('serves the archivemedia home page at /archivemedia', function (): void {
    fakeArchivemediaSolr();

    $this->get('/archivemedia')
        ->assertSuccessful()
        ->assertSee('Media for the Archives Collections', false)
        ->assertSee(url('/archivemedia').'/', false);
});

it('serves every archivemedia static page', function (string $path): void {
    fakeArchivemediaSolr();

    $this->get("/archivemedia/{$path}")->assertSuccessful();
})->with([
    'iiif',
    'licensing',
    'takedown',
    'feedback',
    'accessibility',
]);

it('loads archivemedia-specific skylight config when /archivemedia is requested', function (): void {
    fakeArchivemediaSolr();

    $this->get('/archivemedia')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('archivemedia')
        ->and(config('skylight.fullname'))->toBe('Archives Media')
        ->and(config('skylight.theme'))->toBe('archivemedia')
        ->and(config('skylight.url_prefix'))->toBe('archivemedia')
        ->and(config('skylight.container_field'))->toBe('location.comm')
        ->and(config('skylight.container_id'))->toBe(env('ARCHIVEMEDIA_CONTAINER_ID', '656322c0-3cfd-453f-8d2b-1aa94bc0b082'));
});

it('renders archivemedia record page tag links with the legacy double-encoded filter shape', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Subject' => 'dc.subject.en',
        ],
        'skylight.filters' => [
            'Author' => 'authorza_filter',
            'Subject' => 'subject_filter',
        ],
    ]);

    $html = view('archivemedia.record.show', [
        'record' => [
            'dctitleen' => ['Sample Title'],
            'dcsubjecten' => ['Music Hall'],
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

    // Facet chip links must use %7C%7C%7C (|||) between the lower-cased and
    // display forms, and %22 quotes around the whole value.
    expect($html)
        ->toContain('/Subject:%22music+hall+%7C%7C%7C+Music+Hall%22');
});
