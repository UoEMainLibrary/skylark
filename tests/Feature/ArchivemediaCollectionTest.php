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
    'archivemedia.browse',
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

it('renders the legacy archivemedia footer with site, social, and disclaimer blocks', function (): void {
    fakeArchivemediaSolr();

    $response = $this->get('/archivemedia');

    $response->assertSuccessful()
        // Footer site links row.
        ->assertSee('<div class="footer-links">', false)
        ->assertSee('<div class="site-links">', false)
        ->assertSee('href="'.url('/archivemedia/iiif').'"', false)
        ->assertSee('href="'.url('/archivemedia/feedback').'"', false)
        // Social icons row (Art Collection accounts, per legacy).
        ->assertSee('<ul class="social-icons">', false)
        ->assertSee('facebook.com/UniversityOfEdinburghFineArtCollection', false)
        ->assertSee('twitter.com/UoEArtColl', false)
        ->assertSee('uoeartandarchives.tumblr.com', false)
        // Disclaimer block with LUC logo, University Collections statement and IS logo.
        ->assertSee('<div class="footer-disclaimer">', false)
        ->assertSee('<div class="footer-logo">', false)
        ->assertSee('class="luclogo"', false)
        ->assertSee('This collection is part of', false)
        ->assertSee('>University Collections</a>', false)
        ->assertSee('<div class="is-logo">', false)
        ->assertSee('class="islogo"', false)
        ->assertSee('Unless explicitly stated otherwise, all material is copyright', false)
        // Legacy Takedown link points at the external CRC policy.
        ->assertSee('https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy', false);
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

it('renders archivemedia search results with legacy artist byline, dated title, IIIF luna thumbnail and thumbnail-image-search wrapper', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Date' => 'dc.date.issued.en',
            'ImageUri' => 'dc.identifier.uri.en',
            'Bitstream' => 'dc.format.original.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
        ],
    ]);

    $imageUri = 'https://images.is.ed.ac.uk/luna/servlet/iiif/uoe~1~1~123~456/full/full/0/default.jpg';

    $html = view('archivemedia.search.results', [
        'query' => '*:*',
        'docs' => [
            [
                'id' => '98289',
                'dctitleen' => ['BROWN H to BROWN L'],
                'dccontributorauthoren' => ['Frobisher, Martin'],
                'dcdateissueden' => ['2017'],
                'dcidentifierurien' => [$imageUri],
            ],
        ],
        'total' => 6012,
        'startRow' => 1,
        'endRow' => 1,
        'sort_options' => ['Title' => 'dc.title_sort'],
        'base_search' => './search/*:*',
        'base_parameters' => '',
        'paginationLinks' => '',
    ])->render();

    expect($html)
        ->toContain('class="thumbnail-image-search"')
        ->and($html)->toContain('class="artist"')
        ->and($html)->toContain('/Author:%22frobisher%2C+martin+%7C%7C%7C+Frobisher%2C+Martin%22')
        ->and($html)->toContain('BROWN H to BROWN L (2017)')
        ->and($html)->toContain('/full/!250,250/0/')
        ->and($html)->toContain('class="record-thumbnail-search"')
        ->and($html)->not->toContain('class="author"');
});

it('renders the archivemedia record page as the legacy full-title/full-metadata layout', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Subject' => 'dc.subject.en',
            'Date' => 'dc.coverage.temporal.en',
        ],
        'skylight.filters' => [
            'Author' => 'authorza_filter',
            'Subject' => 'subject_filter',
        ],
    ]);

    $html = view('archivemedia.record.show', [
        'record' => [
            'dctitleen' => ['Sample Title'],
            'dccontributorauthoren' => ['Frobisher, Martin'],
            'dcsubjecten' => ['Music Hall'],
            'dccoveragetemporalen' => ['2020'],
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

    // Legacy archivemedia record.php wraps the title in .full-title and the
    // metadata table in .full-metadata, uses class="artist" (with Artist:
    // filter) for the byline, and appends the date to the h1.
    expect($html)
        ->toContain('itemscope itemtype="http://schema.org/CreativeWork"')
        ->and($html)->toContain('<div class="full-title">')
        ->and($html)->toContain('<h1 class="itemtitle">Sample Title (2020)</h1>')
        ->and($html)->toContain('class="artist"')
        ->and($html)->toContain('/Artist:%22frobisher%2C+martin+%7C%7C%7C+Frobisher%2C+Martin%22')
        ->and($html)->toContain('<div class="full-metadata">')
        // Legacy archivemedia record.php prints metadata values as plain text
        // (no facet-value linking on the record page); do not add filter links.
        ->and($html)->toContain('<tr><th>Subject</th><td>Music Hall</td></tr>');
});
