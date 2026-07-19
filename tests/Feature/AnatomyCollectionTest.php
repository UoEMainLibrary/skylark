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

it('renders anatomy search results with the legacy class="artist" byline and dated title', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Date' => 'dc.coverage.temporal.en',
            'Bitstream' => 'dc.format.original.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
            'ImageUri' => 'dc.identifier.uri.en',
        ],
    ]);

    $html = view('anatomy.search.results', [
        'query' => '*:*',
        'docs' => [
            [
                'id' => '1',
                'dctitleen' => ['Skull of Charles Bell'],
                'dccontributorauthoren' => ['Charles Bell'],
                'dccoveragetemporalen' => ['1820'],
            ],
        ],
        'total' => 1,
        'startRow' => 1,
        'endRow' => 1,
        'sort_options' => ['Title' => 'dc.title_sort'],
        'base_search' => './search/*:*',
        'base_parameters' => '',
        'paginationLinks' => '',
    ])->render();

    expect($html)
        ->toContain('class="artist"')
        ->and($html)->toContain('>Charles Bell</a>')
        ->and($html)->toContain('/Author:%22charles+bell+%7C%7C%7C+Charles+Bell%22')
        ->and($html)->toContain('Skull of Charles Bell (1820)')
        ->and($html)->not->toContain('class="author"');
});

it('renders the anatomy record page with the legacy full-title byline, table and related-items sidebar', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
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
            'dccontributorauthoren' => ['Charles Bell'],
        ],
        'recordTitle' => 'Sample anatomical specimen',
        'recordDisplay' => ['Title'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [
            [
                'id' => '5555',
                'dctitleen' => ['Related specimen'],
                'dccontributorauthoren' => ['Charles Bell'],
            ],
        ],
    ])->render();

    // Legacy anatomy record.php uses class="artist" for the byline and
    // Artist:%22...+%7C%7C%7C+...%22 links; related_items.php produces
    // <a class="related-record"> entries with per-doc .tags → Artist filter
    // links. Never a literal `|||` in the href.
    expect($html)
        ->toContain('<h1 class="itemtitle">Sample anatomical specimen</h1>')
        ->and($html)->toContain('class="artist"')
        ->and($html)->toContain('/Artist:%22charles+bell+%7C%7C%7C+Charles+Bell%22')
        ->and($html)->toContain('<a class="related-record"')
        ->and($html)->toContain('>Related specimen')
        ->and($html)->not->toContain('|||');
});
