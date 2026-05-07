<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use App\Services\ArchivesSpaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

/**
 * Stub every outbound Solr / ArchivesSpace HTTP call with an empty response so
 * the test suite never depends on the VPN-only ArchivesSpace cluster.
 */
function fakeArchivesSpaceSolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

/**
 * Read the per-collection config file directly. This is independent of the
 * `CollectionMiddleware`, which only merges the config when an HTTP request
 * is dispatched against the collection's URL prefix.
 *
 * @return array<string, mixed>
 */
function lhsacasenotesConfig(): array
{
    return require config_path('collections/lhsacasenotes.php');
}

/*
|--------------------------------------------------------------------------
| Route registration — lhsacasenotes
|--------------------------------------------------------------------------
*/

it('registers every expected lhsacasenotes named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [$name] is missing");
})->with([
    'lhsacasenotes.home',
    'lhsacasenotes.search.redirect',
    'lhsacasenotes.search.index',
    'lhsacasenotes.record.show',
    'lhsacasenotes.about',
    'lhsacasenotes.licensing',
    'lhsacasenotes.takedown',
    'lhsacasenotes.accessibility',
    'lhsacasenotes.feedback',
    'lhsacasenotes.history',
    'lhsacasenotes.people',
    'lhsacasenotes.tuberculosis',
    'lhsacasenotes.achievements',
    'lhsacasenotes.catalogues',
]);

/*
|--------------------------------------------------------------------------
| ArchivesSpace registrar — coverage of the new helper's contract
|--------------------------------------------------------------------------
| These tests exercise the helper indirectly via the real lhsacasenotes
| registration so we don't need to mutate the global Route table at runtime.
*/

it('does NOT register DSpace-only routes for an ArchivesSpace collection', function (string $name): void {
    expect(Route::has($name))->toBeFalse("route [$name] should not be registered for lhsacasenotes");
})->with([
    'lhsacasenotes.mirador',
    'lhsacasenotes.iiif',
    'lhsacasenotes.advanced',
    'lhsacasenotes.advanced.form',
    'lhsacasenotes.advanced.post',
    'lhsacasenotes.advanced.search',
]);

it('omits the bitstream proxy route by default (images flag defaults to false)', function (): void {
    expect(Route::has('lhsacasenotes.record.image'))->toBeFalse();
});

it('exposes /record/{id}/{type?} for ArchivesSpace records', function (): void {
    $route = Route::getRoutes()->match(Request::create('/lhsacasenotes/record/165250/archival_object', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('lhsacasenotes.record.show');
});

it('routes /search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/lhsacasenotes/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('runs extra_routes inside the prefix group so /history etc. resolve', function (string $path): void {
    $route = Route::getRoutes()->match(Request::create($path, 'GET'));

    expect($route->uri())->toBe(ltrim($path, '/'));
})->with([
    '/lhsacasenotes/history',
    '/lhsacasenotes/people',
    '/lhsacasenotes/tuberculosis',
    '/lhsacasenotes/achievements',
    '/lhsacasenotes/catalogues',
]);

/*
|--------------------------------------------------------------------------
| Page rendering — home, static pages, search
|--------------------------------------------------------------------------
*/

it('serves the lhsacasenotes home page', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/lhsacasenotes')
        ->assertSuccessful()
        ->assertSee('Medical records revived', false)
        ->assertSee('Lothian Health Services Archive');
});

it('serves every lhsacasenotes static page', function (string $path): void {
    fakeArchivesSpaceSolr();

    $this->get("/lhsacasenotes/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'accessibility',
    'feedback',
    'history',
    'people',
    'tuberculosis',
    'achievements',
    'catalogues',
]);

it('renders the legacy navigation on every lhsacasenotes page', function (string $path): void {
    fakeArchivesSpaceSolr();

    $this->get("/lhsacasenotes/{$path}")
        ->assertSee('Medical Case Notes Home Link', false)
        ->assertSee('Tuberculosis')
        ->assertSee('Achievements')
        ->assertSee('LHSA Blog');
})->with([
    '',
    'about',
    'history',
]);

it('serves a search results page even when Solr is empty', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/lhsacasenotes/search/*:*')
        ->assertSuccessful()
        ->assertSee('No results found');
});

it('extracts parent metadata from the ArchivesSpace JSON blob and renders the Hierarchy row', function (): void {
    // Solr does NOT expose `parent`, `parent_id` or `parent_type` as
    // top-level fields for archival objects — they only live inside the
    // record's JSON-LD payload. Regression guard for the missing
    // "Hierarchy → Parent Record" row + the related-items sidebar that
    // both depend on this extraction.
    config(['app.current_collection' => 'lhsacasenotes']);
    config(['skylight' => array_merge(
        config('skylight', []),
        require config_path('collections/lhsacasenotes.php')
    )]);

    $rawDoc = [
        'id' => '/repositories/13/archival_objects/151390',
        'title' => 'PR3a.1, 1957',
        'types' => ['archival_object'],
        'resource' => '/repositories/13/resources/86795',
        'json' => json_encode([
            'jsonmodel_type' => 'archival_object',
            'parent' => ['ref' => '/repositories/13/archival_objects/151389'],
            'component_id' => 'LHB41 CC/3a/PR3a.1',
            'dates' => [['expression' => '1957', 'begin' => '1957']],
            'extents' => [['number' => '1', 'extent_type' => 'item']],
            'notes' => [],
        ]),
    ];

    $service = app(ArchivesSpaceService::class);
    $transformed = $service->transformFieldNames($rawDoc, false);

    expect($transformed)
        ->toHaveKey('Title')
        ->toHaveKey('Parent', '/repositories/13/archival_objects/151389')
        ->toHaveKey('Parent_Id', '151389')
        ->toHaveKey('Parent_Type', 'archival_object');

    expect($transformed['_raw'])
        ->toHaveKey('parent_id', '151389')
        ->toHaveKey('parent_type', 'archival_object');
});

it('joins all container ids into a single Solr fq clause when searching', function (): void {
    // Regression guard for the multi-container fq bug: emitting one `&fq=` per
    // container id makes Solr AND them, returning zero results. lhsacasenotes
    // has three containers so we must combine them with `+` (Solr OR within
    // a single fq) — the same shape browseTerms uses and the legacy
    // CodeIgniter archivesspace solr client uses.
    fakeArchivesSpaceSolr();

    $this->get('/lhsacasenotes/search/*:*')->assertSuccessful();

    $config = lhsacasenotesConfig();
    $containerField = $config['container_field'];
    $containerIds = $config['container_id'];

    Http::assertSent(function ($request) use ($containerField, $containerIds) {
        $url = (string) $request->url();

        if (! str_contains($url, '/select?')) {
            return false;
        }

        // Must find one fq clause that joins all containers with `+`.
        // We test against the on-the-wire URL where Guzzle has encoded `"`
        // to `%22`, so build the expected substring the same way.
        $combined = implode('+', array_map(
            fn ($id) => $containerField.':'.str_replace('"', '%22', $id),
            $containerIds
        ));
        if (! str_contains($url, '&fq='.$combined)) {
            return false;
        }

        // And there must be no separate per-container fq clauses.
        foreach ($containerIds as $id) {
            $solo = '&fq='.$containerField.':'.str_replace('"', '%22', $id);
            $next = $solo.'&';
            if (str_contains($url, $next) || str_ends_with($url, $solo)) {
                return false;
            }
        }

        return true;
    });
});

it('renders the lhsacasenotes Google Analytics tag from the resolved ga_code', function (): void {
    fakeArchivesSpaceSolr();

    // CollectionMiddleware merges config/collections/lhsacasenotes.php over the
    // base skylight config, so any in-test config() overrides for `ga_code`
    // get clobbered. Assert against the production default published in the
    // collection config (or the LHSACASENOTES_GA_CODE override the env defines).
    $expected = lhsacasenotesConfig()['ga_code'];

    expect($expected)->not->toBeEmpty('lhsacasenotes ga_code default must not be blank');

    $this->get('/lhsacasenotes')
        ->assertSuccessful()
        ->assertSee($expected)
        ->assertSee('https://www.googletagmanager.com/gtag/js', false);
});

/*
|--------------------------------------------------------------------------
| Config sanity
|--------------------------------------------------------------------------
*/

it('uses ArchivesSpace as its repository type', function (): void {
    expect(lhsacasenotesConfig()['repository_type'])->toBe('archivesspace');
});

it('quotes container ids so Solr fq clauses are well-formed', function (): void {
    $containerIds = lhsacasenotesConfig()['container_id'];

    expect($containerIds)->toBeArray()->not->toBeEmpty();

    foreach ($containerIds as $id) {
        expect($id)
            ->toStartWith('"')
            ->toEndWith('"')
            ->toContain('/repositories/');
    }
});

it('restricts queries to published records', function (): void {
    expect(lhsacasenotesConfig()['query_restriction'])->toBe(['publish' => 'true']);
});

it('exposes the documented ArchivesSpace field mappings', function (string $key): void {
    expect(lhsacasenotesConfig()['field_mappings'])->toHaveKey($key);
})->with([
    'Title',
    'Creator',
    'Subject',
    'Agent',
    'Dates',
    'Extent',
    'Identifier',
    'Scope and Contents',
]);

it('points the GA code at LHSACASENOTES_GA_CODE rather than EERC_GA_CODE', function (): void {
    $contents = file_get_contents(config_path('collections/lhsacasenotes.php'));

    expect($contents)
        ->toContain("env('LHSACASENOTES_GA_CODE'")
        ->not->toContain("env('EERC_GA_CODE'");
});
