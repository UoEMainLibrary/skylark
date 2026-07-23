<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * Stub every outbound Solr call so the test suite doesn't need live DSpace.
 */
function fakeCalendarsSolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

it('registers every expected calendars named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'calendars.home',
    'calendars.search.redirect',
    'calendars.search.index',
    'calendars.record.show',
    'calendars.record.image',
    'calendars.mirador',
    'calendars.advanced',
    'calendars.advanced.form',
    'calendars.advanced.post',
    'calendars.advanced.search',
    'calendars.about',
    'calendars.licensing',
    'calendars.takedown',
    'calendars.accessibility',
    'calendars.feedback',
    'calendars.laing',
]);

it('routes /calendars/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/calendars/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /calendars/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/calendars/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('calendars.record.show');
});

it('serves the calendars home page at /calendars with the legacy 2016 carousel', function (): void {
    fakeCalendarsSolr();

    $this->get('/calendars')
        ->assertSuccessful()
        ->assertSee('University Calendar 2016', false)
        ->assertSee('Georg Braun', false)
        ->assertSee('data-jcarousel', false)
        ->assertSee('./record/52833', false);
});

it('serves every calendars static page', function (string $path): void {
    fakeCalendarsSolr();

    $this->get("/calendars/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'feedback',
    'accessibility',
    'laing',
]);

it('links the Laing 2015 calendar with the double-encoded subject filter shape', function (): void {
    $html = view('calendars.pages.laing')->render();

    expect($html)
        // Never a literal `|||` in href — double-encoded as %7C%7C%7C.
        ->not->toContain('|||')
        ->and($html)->toContain('/Subject:%22images+from+the+david+laing+collection+2015%7C%7C%7CImages+from+the+David+Laing+Collection+2015%22');
});

it('renders calendars search results with the legacy Subject byline and no Author link', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Subject' => 'dc.subject.en',
            'Bitstream' => 'dc.format.original.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
            'ImageUri' => 'dc.identifier.uri.en',
        ],
    ]);

    $html = view('calendars.search.results', [
        'query' => '*:*',
        'docs' => [
            [
                'id' => '52840',
                'dctitleen' => ['Civitates Orbis Terrarum'],
                'dccontributorauthoren' => ['Georg Braun'],
                'dcsubjecten' => ['Cities of the World 2016'],
            ],
        ],
        'total' => 130,
        'startRow' => 1,
        'endRow' => 1,
        'sort_options' => ['Title' => 'dc.title_sort'],
        'base_search' => './search/*:*',
        'base_parameters' => '',
        'paginationLinks' => '',
    ])->render();

    expect($html)
        ->toContain('Civitates Orbis Terrarum')
        ->and($html)->toContain('/Subject:%22cities+of+the+world+2016+%7C%7C%7C+Cities+of+the+World+2016%22')
        ->and($html)->toContain('>Cities of the World 2016</a>')
        ->and($html)->not->toContain('class="author"')
        ->and($html)->not->toContain('/Author:%22georg+braun');
});

it('renders the calendars record page as the legacy main-image + full-metadata layout', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Subject' => 'dc.subject.en',
            'Description' => 'dc.description.en',
            'Shelf Mark' => 'dc.identifier.en',
            'Link' => 'dc.identifier.uri.en',
            'Bitstream' => 'dc.format.original.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
        ],
        'skylight.filters' => [
            'Subject' => 'subject_filter',
        ],
        'skylight.schema_links' => [
            'Title' => 'name',
            'Author' => 'creator',
            'Description' => 'description',
        ],
    ]);

    $html = view('calendars.record.show', [
        'record' => [
            'dctitleen' => ["A 'wind-chariot' on the beach in Holland"],
            'dccontributorauthoren' => ['Michael van Meer'],
            'dcsubjecten' => ['Travel 2008'],
            'dcdescriptionen' => ['Album Amicorum details.'],
            'dcidentifierurien' => ['http://images.is.ed.ac.uk/luna/servlet/s/89hg46'],
            'dcformatoriginalen' => [
                'thumb##January.jpg##desc##10683/19397##1##',
            ],
        ],
        'recordTitle' => "A 'wind-chariot' on the beach in Holland",
        'recordDisplay' => ['Title', 'Author', 'Subject', 'Description'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => 'dcformatoriginalen',
        'thumbnailField' => 'dcformatthumbnailen',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    // Legacy calendars record.php:
    //  - `<h1 class="itemtitle">` (no date suffix)
    //  - schema.org CreativeWork wrapper
    //  - .tags with buggy legacy subject link shape (%22SubjectXX+|||+YY%22)
    //  - .record_bitstreams > .main-image (fancybox) for the first .jpg
    //  - .full-metadata > table with .schema.org spans, facet links for
    //    filter fields, and a "Zoomable Image" row for images.is.ed.ac.uk
    //    links.
    expect($html)
        ->toContain('<h1 class="itemtitle">')
        ->and($html)->toContain('itemscope itemtype="http://schema.org/CreativeWork"')
        ->and($html)->toContain('/%22Subjecttravel+2008+%7C%7C%7C+Travel+2008%22')
        ->and($html)->toContain('<div class="main-image">')
        ->and($html)->toContain('class="record-main-image"')
        ->and($html)->toContain('<div class="full-metadata">')
        ->and($html)->toContain('<span itemprop="creator">')
        ->and($html)->toContain('<span itemprop="description">')
        ->and($html)->toContain('/Subject:%22travel+2008+%7C%7C%7C+Travel+2008%22')
        ->and($html)->toContain('<tr><th>Zoomable Image</th>')
        ->and($html)->toContain('fa-file-image-o');
});

it('loads calendars-specific skylight config when /calendars is requested', function (): void {
    fakeCalendarsSolr();

    $this->get('/calendars')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('calendars')
        ->and(config('skylight.fullname'))->toBe('University of Edinburgh Calendars')
        ->and(config('skylight.theme'))->toBe('calendars')
        ->and(config('skylight.url_prefix'))->toBe('calendars')
        ->and(config('skylight.container_field'))->toBe('location.coll')
        ->and(config('skylight.container_id'))->toBe(env('CALENDARS_CONTAINER_ID', '4e5e82a5-c06c-4844-bc65-c6aef272f646'))
        ->and(config('skylight.oaipmhcollection'))->toBe('hdl_10683_19396')
        ->and(config('skylight.results_per_page'))->toBe(15);
});
