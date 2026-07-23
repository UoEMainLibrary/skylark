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
    'speccoll.browse',
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

it('renders the legacy black bootstrap footer with icons, UoE logo and policy rows', function (): void {
    fakeSpeccollSolr();

    $response = $this->get('/speccoll')->assertSuccessful();

    $response->assertSee('<footer class="footer bg-primary">', false)
        ->assertSee('fa fa-home', false)
        ->assertSee('fa fa-info', false)
        ->assertSee('fa fa-facebook', false)
        ->assertSee('fa fa-twitter', false)
        ->assertSee('fa fa-envelope', false)
        ->assertSee('https://www.facebook.com/crc.edinburgh', false)
        ->assertSee('https://twitter.com/CRC_EdUni', false)
        ->assertSee('UoETransparentWhite.png', false)
        ->assertSee('Library and University Collections', false)
        ->assertSee('is a division of', false)
        ->assertSee('Information Services', false)
        ->assertSee('https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy', false)
        ->assertSee(url('/speccoll/licensing'), false);
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

it('renders speccoll search results as a legacy bootstrap masonry grid with luna thumbnail', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Shelfmark' => 'dc.identifier.en',
            'ImageURI' => 'dc.identifier.imageUri.en',
            'Images' => 'dc.format.extent.en',
        ],
        'skylight.sort_fields' => [
            'Title' => 'dc.title_sort',
        ],
    ]);

    $html = view('speccoll.search.results', [
        'docs' => [
            [
                'id' => '116792',
                'dctitleen' => ['The Indian primer, or, The way of training up of our Indian youth'],
                'dccontributorauthoren' => ['Eliot, John'],
                'dcidentifieren' => ['Df.7.98'],
                'dcidentifierimageUrien' => ['https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~152171~199639/full/full/0/default.jpg'],
                'dcformatextenten' => [138],
            ],
        ],
        'total' => 1,
        'query' => 'test',
        'base_search' => 'https://skylark.test/speccoll/search/test',
        'base_parameters' => '',
        'facets' => [
            [
                'name' => 'Author',
                'terms' => [
                    ['name' => 'eliot, john ||| Eliot, John', 'display_name' => 'Eliot, John', 'count' => 1, 'active' => false],
                ],
            ],
        ],
        'startRow' => 1,
        'endRow' => 1,
        'sort_options' => config('skylight.sort_fields'),
        'paginationLinks' => '<ul class="pagination pagination-sm pagination-xs"><li class="active"><span>1</span></li></ul>',
    ])->render();

    expect($html)
        ->toContain('1 volumes found')
        ->and($html)->toContain('<div id="results-grid" class="grid">')
        ->and($html)->toContain('class="grid-item col-xs-6 col-sm-6 col-md-3 col-lg-3"')
        ->and($html)->toContain('class="img-responsive record-thumbnail-search"')
        ->and($html)->toContain('images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~152171~199639/1000,1000,300,300/300,300/0/default.jpg')
        ->and($html)->toContain('138 digitised images')
        ->and($html)->toContain('Df.7.98')
        ->and($html)->toContain('id="side_facet"')
        ->and($html)->toContain('Refine Results')
        ->and($html)->toContain('panel panel-facets')
        ->and($html)->toContain('fa fa-chevron-down');
});

it('renders speccoll record page as the legacy stc-section layout with UV manifest', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Shelfmark' => 'dc.identifier.en',
            'Date' => 'dc.date.created.en',
            'Manifest' => 'dc.identifier.manifest.en',
            'ImageURI' => 'dc.identifier.imageUri.en',
        ],
        'skylight.manifest_endpoint' => 'https://librarylabs.ed.ac.uk/iiif/speccollprototype/manifest/',
    ]);

    $html = view('speccoll.record.show', [
        'record' => [
            'dctitleen' => ['The Indian primer'],
            'dccontributorauthoren' => ['Eliot, John', 'Kirton, James'],
            'dcidentifieren' => ['Df.7.98'],
            'dcdatecreateden' => ['1669'],
            'dcidentifiermanifesten' => ['36rul50t'],
        ],
        'recordTitle' => 'The Indian primer',
        'recordDisplay' => ['Title', 'Author', 'Shelfmark', 'Date'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => [],
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [
            [
                'id' => '119068',
                'dctitleen' => ['The Indian Grammar'],
                // Solr keys keep the original case after stripping dots, so
                // `dc.identifier.imageUri.en` → `dcidentifierimageUrien`.
                'dcidentifierimageUrien' => [
                    'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEgal~5~5~150570~164362/full/full/0/default.jpg',
                ],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('class="navbar navbar-fixed-top second-navbar"')
        ->and($html)->toContain('#stc-section1')
        ->and($html)->toContain('#stc-section2')
        ->and($html)->toContain('#stc-section3')
        ->and($html)->toContain('#stc-section5')
        ->and($html)->toContain('#stc-section6')
        ->and($html)->toContain('id="stc-section1"')
        ->and($html)->toContain('id="stc-section2"')
        ->and($html)->toContain('id="stc-section5"')
        ->and($html)->toContain('id="stc-section6"')
        // Legacy title format is `Title | Author | Date`, and Author is taken
        // from the LAST value in the multivalued list to mirror legacy record.php.
        ->and($html)->toContain('The Indian primer | Kirton, James | 1669')
        ->and($html)->toContain('class="itemtitle hidden-sm hidden-xs"')
        ->and($html)->toContain('class="itemtitle hidden-lg hidden-md"')
        // UV iframe + Mirador + IIIF logo links.
        ->and($html)->toContain('https://librarylabs.ed.ac.uk/iiif/uv/?manifest=https://librarylabs.ed.ac.uk/iiif/speccollprototype/manifest/36rul50t/manifest')
        ->and($html)->toContain('class="uvlogo"')
        ->and($html)->toContain('class="miradorlogo"')
        ->and($html)->toContain('class="iiiflogo"')
        // Catalogue Data accordion panel.
        ->and($html)->toContain('class="panel panel-default container-fluid"')
        ->and($html)->toContain('class="accordion-toggle"')
        ->and($html)->toContain('href="#collapse1"')
        ->and($html)->toContain('Catalogue Data')
        // Related items masonry grid with luna thumbnail.
        ->and($html)->toContain('class="col-xs-12 related inactive container-fluid"')
        ->and($html)->toContain('data-masonry=\'{ "itemSelector": ".grid-item", "columnWidth": 150 }\'')
        ->and($html)->toContain('class="grid-item thumbnail"')
        ->and($html)->toContain('class="record-thumbnail-landscape"')
        ->and($html)->toContain('./record/119068')
        ->and($html)->toContain('The Indian Grammar');
});
