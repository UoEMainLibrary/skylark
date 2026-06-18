<?php

use App\Http\Controllers\SearchController;
use App\Services\DSpaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * @return array<string, mixed>
 */
function guardbookConfig(): array
{
    return require config_path('collections/guardbook.php');
}

function fakeGuardbookSolr(array $docs = [], int $numFound = 0, array $facetFields = []): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => $numFound, 'docs' => $docs],
            'facet_counts' => ['facet_fields' => $facetFields],
            'highlighting' => [],
        ], 200),
    ]);
}

/**
 * @return array<string, string>
 */
function parseSolrRequestQuery(string $url): array
{
    $query = parse_url($url, PHP_URL_QUERY);
    if (! is_string($query)) {
        return [];
    }

    parse_str($query, $params);

    return is_array($params) ? $params : [];
}

it('registers expected guardbook named routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [$name] is missing");
})->with([
    'guardbook.home',
    'guardbook.search.index',
    'guardbook.record.show',
]);

it('configures guardbook for title default sort and unpaginated A-Z browse', function (): void {
    $config = guardbookConfig();

    expect($config['default_sort'])->toBe('dc.title_sort+asc')
        ->and($config['unpaginated_filters'])->toBe(['A-Z'])
        ->and($config['facet_browse_max_rows'])->toBe(500);
});

it('applies default_sort to Solr when sort_by is omitted', function (): void {
    config([
        'skylight' => array_merge(config('skylight', []), guardbookConfig(), [
            'solr_base' => 'http://solr.test/search/',
        ]),
    ]);

    $capturedUrl = null;

    Http::fake(function (Illuminate\Http\Client\Request $request) use (&$capturedUrl) {
        $capturedUrl = $request->url();

        return Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200);
    });

    $service = new DSpaceService;
    $service->searchWithHighlighting('*:*', [], 0, '', 10);

    $params = parseSolrRequestQuery((string) $capturedUrl);

    expect($params['sort'] ?? null)->toBe('dc.title_sort asc');
});

it('preserves sort_by in pagination links on guardbook search', function (): void {
    fakeGuardbookSolr(
        docs: [['id' => '1001', 'dctitleen' => ['Guardbook Volume 1']]],
        numFound: 25,
    );

    $response = $this->get('/guardbook/search/*:*?sort_by=dc.title_sort+asc');

    $response->assertSuccessful();

    expect($response->getContent())
        ->toContain('sort_by=dc.title_sort')
        ->toContain('offset=10');
});

it('requests all rows for an active A-Z letter filter', function (): void {
    $capturedUrl = null;

    Http::fake(function (Illuminate\Http\Client\Request $request) use (&$capturedUrl) {
        $capturedUrl = $request->url();

        return Http::response([
            'response' => [
                'numFound' => 3,
                'docs' => [
                    ['id' => '1001', 'dctitleen' => ['Guardbook Volume 1']],
                    ['id' => '1002', 'dctitleen' => ['Guardbook Volume 2']],
                    ['id' => '1003', 'dctitleen' => ['Guardbook Volume 3']],
                ],
            ],
            'facet_counts' => [
                'facet_fields' => [
                    'subject_filter' => ['A', 3],
                ],
            ],
            'highlighting' => [],
        ], 200);
    });

    $response = $this->get('/guardbook/search/*:*/A-Z:%22A%22');

    $response->assertSuccessful();

    $params = parseSolrRequestQuery((string) $capturedUrl);

    expect($params['rows'] ?? null)->toBe('500')
        ->and($params['sort'] ?? null)->toBe('dc.title_sort asc')
        ->and($response->getContent())->toContain('Showing 1&ndash;3 of 3 results')
        ->and($response->getContent())->not->toContain('offset=10');
});

it('keeps paginated browse for unfiltered guardbook search', function (): void {
    $capturedUrl = null;

    Http::fake(function (Illuminate\Http\Client\Request $request) use (&$capturedUrl) {
        $capturedUrl = $request->url();

        return Http::response([
            'response' => [
                'numFound' => 25,
                'docs' => [['id' => '1001', 'dctitleen' => ['Guardbook Volume 1']]],
            ],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200);
    });

    $response = $this->get('/guardbook/search/*:*');

    $response->assertSuccessful();

    $params = parseSolrRequestQuery((string) $capturedUrl);

    expect($params['rows'] ?? null)->toBe('10')
        ->and($response->getContent())->toContain('offset=10');
});

it('renders the guardbook results count range in the view', function (): void {
    $html = view('guardbook.search.results', [
        'docs' => [
            ['id' => '1001', 'dctitleen' => ['Guardbook Volume 1']],
        ],
        'total' => 42,
        'query' => '*:*',
        'searchbox_query' => '',
        'base_search' => './search/*:*',
        'base_parameters' => '',
        'facets' => [],
        'highlights' => [],
        'suggestions' => [],
        'startRow' => 1,
        'endRow' => 10,
        'offset' => 0,
        'rows' => 10,
        'sort_by' => '',
        'sort_options' => ['Title' => 'dc.title_sort'],
        'paginationLinks' => '',
        'active_filters' => [],
        'delimiter' => ':',
    ])->render();

    expect($html)->toContain('Showing 1&ndash;10 of 42 results');
});

it('routes guardbook search through SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/guardbook/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});
