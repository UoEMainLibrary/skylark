<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

/**
 * Stub every outbound DSpace / Solr HTTP call with an empty result so the
 * test suite never depends on the VPN-only Solr cluster.
 */
function fakeStceciliasSolr(array $docs = [], int $numFound = 0): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => $numFound, 'docs' => $docs],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200),
    ]);
}

/**
 * Read the per-collection config file directly. Independent of the
 * `CollectionMiddleware`, which only merges the config when an HTTP request
 * is dispatched against the collection's URL prefix.
 *
 * @return array<string, mixed>
 */
function stceciliasConfig(): array
{
    return require config_path('collections/stcecilias.php');
}

/*
|--------------------------------------------------------------------------
| Route registration
|--------------------------------------------------------------------------
*/

it('registers every expected stcecilias named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [$name] is missing");
})->with([
    'stcecilias.home',
    'stcecilias.search.redirect',
    'stcecilias.search.index',
    'stcecilias.record.show',
    'stcecilias.about',
    'stcecilias.licensing',
    'stcecilias.takedown',
    'stcecilias.accessibility',
    'stcecilias.feedback',
    'stcecilias.iiif',
    'stcecilias.mirador',
    'stcecilias.advanced',
    'stcecilias.advanced.form',
    'stcecilias.advanced.post',
    'stcecilias.advanced.search',
    'stcecilias.browse',
]);

it('wires the stcecilias home route to PageController@stceciliasHome', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias', 'GET'));

    expect($route->getControllerClass())->toBe(PageController::class)
        ->and($route->getActionMethod())->toBe('stceciliasHome')
        ->and($route->getName())->toBe('stcecilias.home');
});

it('wires the stcecilias /iiif extra_route to PageController@stceciliasIiif', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias/iiif', 'GET'));

    expect($route->getControllerClass())->toBe(PageController::class)
        ->and($route->getActionMethod())->toBe('stceciliasIiif')
        ->and($route->getName())->toBe('stcecilias.iiif');
});

it('wires the stcecilias /browse/{facet} extra_route to PageController@stceciliasBrowse', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias/browse/Instrument', 'GET'));

    expect($route->getControllerClass())->toBe(PageController::class)
        ->and($route->getActionMethod())->toBe('stceciliasBrowse')
        ->and($route->getName())->toBe('stcecilias.browse');
});

it('routes /stcecilias/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /stcecilias/record/{id} via RecordController@show', function (): void {
    // The DSpace registrar constrains {id} to digits, so use a numeric id.
    $route = Route::getRoutes()->match(Request::create('/stcecilias/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('stcecilias.record.show');
});

/*
|--------------------------------------------------------------------------
| Page rendering — home, static pages, search
|--------------------------------------------------------------------------
*/

it('serves the stcecilias home page', function (): void {
    fakeStceciliasSolr();

    $this->get('/stcecilias')
        ->assertSuccessful()
        ->assertSee("St Cecilia's Hall", false);
});

it('renders the nine instrument-grouping tiles on the home page', function (string $label): void {
    fakeStceciliasSolr();

    $this->get('/stcecilias')
        ->assertSuccessful()
        ->assertSee($label);
})->with([
    'Keyboards',
    'Western Percussion',
    'Non-western Percussion',
    'Western Strings',
    'Non-western Strings',
    'Western Woodwind',
    'Non-western Woodwind',
    'Western Brasswind',
    'Non-western Brasswind',
]);

it('serves every stcecilias static page', function (string $path): void {
    fakeStceciliasSolr();

    $this->get("/stcecilias/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'accessibility',
    'feedback',
    'iiif',
]);

it('renders the legacy header (search box + visit link) on every stcecilias page', function (string $path): void {
    fakeStceciliasSolr();

    $this->get("/stcecilias/{$path}")
        ->assertSee('StCsNavLogo.png', false)
        ->assertSee('Search the museum collections', false)
        ->assertSee('Visit St Cecilia', false);
})->with([
    '',
    'about',
    'licensing',
    'iiif',
]);

it('renders the legacy "Refine Results" facet sidebar on the search page', function (): void {
    // Mirror the shape SolrService returns for facet_fields so the controller
    // populates the sidebar with at least one term per filter.
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 1, 'docs' => [['id' => 'abc', 'dctitleen' => ['Test']]]],
            'facet_counts' => [
                'facet_fields' => [
                    'type_filter' => ['keyboard ||| Keyboard', 7],
                    'author_filter' => ['john broadwood ||| John Broadwood', 3],
                    'place_filter' => ['edinburgh ||| Edinburgh', 2],
                    'gallery_filter' => ['binks gallery ||| Binks Gallery', 5],
                ],
            ],
            'highlighting' => [],
        ], 200),
    ]);

    $response = $this->get('/stcecilias/search/*:*')->assertSuccessful();

    expect($response->getContent())
        ->toContain('id="side_facet"')
        ->toContain('Refine Results')
        ->toContain('panel panel-facets')
        ->toContain('Instrument')
        ->toContain('Maker')
        ->toContain('Place Made')
        ->toContain('Gallery')
        ->toContain('inst-results')
        ->toContain('col-lg-9')
        // The legacy theme wraps the search column + facet sidebar in
        // .container-fluid.content, which provides the white #fff page
        // background. Without it the (otherwise empty) body collapses
        // and the dark-red footer bleeds up behind the columns.
        ->toContain('container-fluid content');
});

it('serves a search results page even when Solr is empty', function (): void {
    fakeStceciliasSolr();

    $this->get('/stcecilias/search/*:*')
        ->assertSuccessful()
        ->assertSee('No results found');
});

it('renders search result tiles for a populated Solr response', function (): void {
    fakeStceciliasSolr([
        [
            'id' => 'abc-123',
            'dctitleen' => ['Test Harpsichord'],
            'dccontributorauthoren' => ['Joannes Ruckers'],
            'dccoveragetemporalen' => ['1638'],
            'dcidentifieren' => ['MIMEd 0001'],
        ],
    ], numFound: 1);

    $this->get('/stcecilias/search/*:*')
        ->assertSuccessful()
        ->assertSee('1 instruments found', false)
        ->assertSee('Test Harpsichord')
        ->assertSee('Joannes Ruckers')
        ->assertSee('MIMEd 0001');
});

it('renders the stcecilias Google Analytics tag from the resolved ga_code', function (): void {
    fakeStceciliasSolr();

    // CollectionMiddleware merges config/collections/stcecilias.php over the
    // base skylight config, so any in-test config() override would get
    // clobbered. Assert against the production default published in the
    // collection config (or the STCECILIAS_GA_CODE override the env defines).
    $expected = stceciliasConfig()['ga_code'];

    expect($expected)->not->toBeEmpty('stcecilias ga_code default must not be blank');

    $this->get('/stcecilias')
        ->assertSuccessful()
        ->assertSee($expected)
        ->assertSee('https://www.googletagmanager.com/gtag/js', false);
});

/*
|--------------------------------------------------------------------------
| Config sanity
|--------------------------------------------------------------------------
*/

it('uses DSpace as its repository type', function (): void {
    expect(stceciliasConfig()['repository_type'])->toBe('dspace');
});

it('enables the facet sidebar in config (matches legacy Refine Results)', function (): void {
    expect(stceciliasConfig()['show_facets'])->toBeTrue();
});

it('points the GA code at STCECILIAS_GA_CODE rather than another collection', function (): void {
    $contents = file_get_contents(config_path('collections/stcecilias.php'));

    expect($contents)
        ->toContain("env('STCECILIAS_GA_CODE'")
        ->not->toContain("env('LHSACASENOTES_GA_CODE'")
        ->not->toContain("env('ALUMNI_GA_CODE'")
        ->not->toContain("env('MIMED_GA_CODE'");
});

it('points the container id at STCECILIAS_CONTAINER_ID rather than another collection', function (): void {
    $contents = file_get_contents(config_path('collections/stcecilias.php'));

    expect($contents)
        ->toContain("env('STCECILIAS_CONTAINER_ID'")
        ->not->toContain("env('ALUMNI_CONTAINER_ID'")
        ->not->toContain("env('MIMED_CONTAINER_ID'");
});

it('exposes the documented stcecilias DSpace field mappings', function (string $key): void {
    expect(stceciliasConfig()['field_mappings'])->toHaveKey($key);
})->with([
    'Title',
    'Maker',
    'Instrument',
    'Subject',
    'Bitstream',
    'Thumbnail',
    'Place Made',
    'Date Made',
    'Accession Number',
    'Hornbostel Sachs Classification',
]);

it('uses the stcecilia (singular) theme name to match the legacy asset folder', function (): void {
    expect(stceciliasConfig()['theme'])->toBe('stcecilia');
});
