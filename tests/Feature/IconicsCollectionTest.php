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

it('renders the legacy iconics header nav on the home page', function (): void {
    fakeIconicsSolr();

    $response = $this->get('/iconics')->assertSuccessful();

    $response->assertSee('<nav id="menu">', false)
        ->assertSee('facebook-icon', false)
        ->assertSee('twitter-icon', false)
        ->assertSee('flickr-icon', false)
        ->assertSee('https://www.facebook.com/crc.edinburgh', false)
        ->assertSee('https://twitter.com/CRC_EdUni', false)
        ->assertSee('https://www.flickr.com/photos/crcedinburgh', false);

    foreach (['Home', 'About', 'CRC', 'Blog', 'Projects', 'Feedback'] as $label) {
        $response->assertSee('>'.$label.'<', false);
    }
});

it('renders the iconics search box with legacy placeholder and no advanced link', function (): void {
    fakeIconicsSolr();

    $html = $this->get('/iconics')->assertSuccessful()->getContent();

    expect($html)
        ->toContain('placeholder="search the iconics"')
        ->and($html)->not->toContain('/iconics/advanced')
        ->and($html)->not->toContain('class="advanced"');
});

it('renders the iconics home page full-width with no sidebar facets', function (): void {
    fakeIconicsSolr();

    $html = $this->get('/iconics')->assertSuccessful()->getContent();

    expect($html)
        ->toContain('class="col-main-full"')
        ->and($html)->not->toContain('class="col-sidebar"');
});

it('renders the legacy iconics footer with site, disclaimer and University Collections blocks', function (): void {
    fakeIconicsSolr();

    $response = $this->get('/iconics')->assertSuccessful();

    $response->assertSee('class="footer-links"', false)
        ->assertSee('class="site-links"', false)
        ->assertSee('Iconics Collection Home', false)
        ->assertSee('About the Iconics Collection', false)
        ->assertSee('Library &amp; University Collections Home', false)
        ->assertSee('class="footer-disclaimer"', false)
        ->assertSee('luclogo', false)
        ->assertSee('islogo', false)
        ->assertSee('This collection is part of', false)
        ->assertSee('University Collections', false)
        ->assertSee('https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy', false);
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

it('renders iconics search results as a legacy 4-column bootstrap thumbnail grid', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Bitstream' => 'dc.format.original.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
        ],
    ]);

    $html = view('iconics.search.results', [
        'query' => '*:*',
        'docs' => [
            [
                'id' => '51417',
                'dctitleen' => ['McBeath Gaelic medical manuscript'],
                'dcformatoriginalen' => ['##0024691c.jpg##dspace##10683/51417##4##'],
                'dcformatthumbnailen' => ['##0024691c.jpg.jpg##dspace##10683/51417##5##'],
            ],
        ],
        'total' => 47,
        'startRow' => 1,
        'endRow' => 1,
        'sort_options' => ['Title' => 'dc.title_sort'],
        'base_search' => './search/*:*',
        'base_parameters' => '',
        'paginationLinks' => '',
    ])->render();

    expect($html)
        ->toContain('class="container-fluid"')
        ->and($html)->toContain('col-xs-6 col-md-3')
        ->and($html)->toContain('class="thumbnail results-thumbnail"')
        ->and($html)->toContain('class="search-thumbnail"')
        ->and($html)->toContain('./record/51417')
        ->and($html)->toContain('McBeath Gaelic medical manuscript')
        ->and($html)->not->toContain('<ul class="listing">');
});

it('renders the iconics record page as the legacy openseadragon + full-title + metadatarow layout', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Subject' => 'dc.subject.en',
            'Type' => 'dc.type.en',
            'Link' => 'dc.identifier.uri',
            'Tags' => 'dc.subject.crowdsourced.en',
            'Abstract' => 'dc.description.abstract.en',
            'Description' => 'dc.description.en',
            'Date' => 'dc.coverage.temporal.en',
        ],
        'skylight.filters' => [
            'Subject' => 'subject_filter',
            'Type' => 'type_filter',
            'Tags' => 'tags_filter',
        ],
        'skylight.schema_links' => [
            'Subject' => 'about',
            'Date' => 'dateCreated',
        ],
    ]);

    $html = view('iconics.record.show', [
        'record' => [
            'dctitleen' => ['Newton, Sir Isaac, and Gregory, David'],
            'dcsubjecten' => ['Manuscripts'],
            'dctypeen' => ['Archives'],
            'dccoveragetemporalen' => ['c1692'],
            'dcdescriptionabstracten' => ['Newton diagrams in Gregory manuscripts.'],
            'dcdescriptionen' => ['David Gregory was a mathematician.'],
            'dcidentifieruri' => ['https://images.is.ed.ac.uk/luna/servlet/detail/UoEgal~5~5~69888~104607'],
            'dcsubjectcrowdsourceden' => ['geometry', 'euclid'],
        ],
        'recordTitle' => 'Newton, Sir Isaac, and Gregory, David',
        'recordDisplay' => ['Subject', 'Type', 'Date'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    // Legacy iconics record.php places an OpenSeadragon viewer above the
    // .content block when there's a luna image, wraps title/date in
    // .full-title > .title-header with prev/next arrows, shows the abstract in
    // .item-abstract, then a .panel.panel-default > .panel-body wrapper with
    // .maintext (description) and .metadatarow entries. Facet fields become
    // clickable links with %7C%7C%7C between the lower-cased and display form.
    expect($html)
        ->toContain('id="openseadragon"')
        ->and($html)->toContain('info.json')
        ->and($html)->toContain('<div class="full-title">')
        ->and($html)->toContain('<div class="title-header">')
        ->and($html)->toContain('<h1 class="item-title">')
        ->and($html)->toContain('(c1692)')
        ->and($html)->toContain('<div class="item-abstract">')
        ->and($html)->toContain('Newton diagrams in Gregory manuscripts.')
        ->and($html)->toContain('panel panel-default')
        ->and($html)->toContain('<div class="maintext">')
        ->and($html)->toContain('David Gregory was a mathematician.')
        ->and($html)->toContain('<div class="metadatarow">')
        ->and($html)->toContain('<div class="metadatakey">Subject</div>')
        ->and($html)->toContain('/Subject:%22manuscripts+%7C%7C%7C+Manuscripts%22')
        ->and($html)->toContain('<span itemprop="about">')
        ->and($html)->toContain('<div class="crowd-tags">')
        ->and($html)->toContain('/Tags:%22geometry+%7C%7C%7C+geometry%22')
        ->and($html)->toContain('IIIF-compliant');
});
