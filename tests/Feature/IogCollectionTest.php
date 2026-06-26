<?php

use App\Contracts\RepositoryInterface;
use App\Services\DSpaceService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * @return array<string, mixed>
 */
function iogConfig(): array
{
    return require config_path('collections/iog.php');
}

it('registers expected iog routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'iog.home',
    'iog.search.redirect',
    'iog.search.index',
    'iog.record.show',
    'iog.about',
    'iog.licensing',
    'iog.takedown',
    'iog.accessibility',
    'iog.history',
    'iog.advanced',
    'iog.advanced.form',
    'iog.advanced.post',
    'iog.advanced.search',
]);

it('serves the iog advanced search form with the configured search fields', function (): void {
    $response = $this->get('/iog/advanced/form')
        ->assertSuccessful()
        ->assertSee('<h1>Advanced Search</h1>', false)
        ->assertSee('/iog/advanced/post', false)
        ->assertSee('name="operator"', false);

    foreach (array_keys(config('skylight.search_fields', [])) as $label) {
        $response->assertSee('name="'.str_replace(' ', '_', $label).'"', false);
    }
});

it('registers iog routes on the configured dedicated host', function (): void {
    expect(env('SCOTGOVYEARBOOKS_HOST'))->toBe('scottishgovernmentyearbooks.testing')
        ->and(config('collections.domains'))->toHaveKey('scottishgovernmentyearbooks.testing');

    $hasDomainHome = collect(app('router')->getRoutes())->contains(
        fn ($route) => $route->uri() === '/' && $route->getDomain() === 'scottishgovernmentyearbooks.testing'
    );

    expect($hasDomainHome)->toBeTrue();
});

it('serves the iog home page at /iog', function (): void {
    $this->get('/iog')
        ->assertSuccessful()
        ->assertSee('Scottish Government Yearbooks', false)
        ->assertSee('jgrid-wrapper', false)
        ->assertSee('Devolution', false)
        ->assertSee('collections/iog/images/carousel/', false);
});

it('serves the iog home page at / on a configured dedicated host', function (): void {
    $this->get('http://scottishgovernmentyearbooks.testing/')
        ->assertSuccessful()
        ->assertSee('Scottish Government Yearbooks', false)
        ->assertSee('jgrid-wrapper', false);
});

it('uses collection-root urls on a dedicated host', function (): void {
    $this->get('http://scottishgovernmentyearbooks.testing/about')
        ->assertSuccessful()
        ->assertSee('base href="http://scottishgovernmentyearbooks.testing/"', false)
        ->assertDontSee('/iog/about', false);
});

it('serves iog static pages from subfolder path', function (string $path): void {
    $url = $path === '' ? '/iog' : "/iog/{$path}";
    $this->get($url)->assertSuccessful();
})->with([
    '',
    'about',
    'history',
    'licensing',
    'takedown',
    'accessibility',
]);

it('renders the about page with credits and history link', function (): void {
    $this->get('/iog/about')
        ->assertSuccessful()
        ->assertSee('SCOTLAND: A PERPLEXING PLACE', false)
        ->assertSee('Homepage Image Credits', false)
        ->assertSee('Institute of Governance', false);
});

it('renders the history page with editor reflections', function (): void {
    $this->get('/iog/history')
        ->assertSuccessful()
        ->assertSee('Scottish Government Yearbook: a History', false)
        ->assertSee('Henry Drucker', false);
});

it('home page carousel links into faceted subject searches', function (): void {
    $response = $this->get('/iog');

    $response->assertSuccessful();

    foreach (['Gender', 'Media', 'Health', 'Devolution', 'Islands', 'Local+Government', 'Religion', 'Elections', 'Scottish+Office'] as $label) {
        $response->assertSee('Subject:%22', false);
        $response->assertSee($label, false);
    }
});

it('renders the legacy nav with visible "opens in a new tab" labels', function (): void {
    $this->get('/iog')
        ->assertSuccessful()
        ->assertSee('University of Edinburgh (opens in a new tab)', false)
        ->assertSee('Blog (opens in a new tab)', false)
        ->assertSee('ERA (opens in a new tab)', false)
        ->assertSee('SPS (opens in a new tab)', false)
        ->assertSee('>History<', false)
        ->assertSee('>About<', false);
});

function bindIogRepositoryStub(array &$captured): void
{
    $stub = new class($captured) implements RepositoryInterface
    {
        public function __construct(public array &$captured) {}

        public function search(string $query, array $filters = [], int $page = 1, ?string $sortBy = null): array
        {
            return ['docs' => [], 'total' => 0, 'start' => 0, 'rows' => 0, 'facets' => []];
        }

        public function searchWithHighlighting(string $query, array $filters, int $offset, string $sortBy, int $rows, array $activeFilters = []): array
        {
            // Only capture the first call so the sidebar facets composer's
            // `*:*` lookup doesn't overwrite the controller's query.
            if ($this->captured['query'] === null) {
                $this->captured['query'] = $query;
                $this->captured['filters'] = $filters;
            }

            return [
                'docs' => [],
                'total' => 0,
                'start' => $offset,
                'rows' => $rows,
                'facets' => [],
                'highlights' => [],
                'suggestions' => [],
            ];
        }

        public function getRecord(string $id): ?array
        {
            return null;
        }

        public function getRelatedItems(array $record, int $limit = 10): array
        {
            return [];
        }

        public function buildFacetsWithActiveState(array $facetData, array $activeFilters, array $configFilters): array
        {
            return [];
        }

        public function transformFieldNames(array $record): array
        {
            return $record;
        }
    };

    app()->instance(DSpaceService::class, $stub);
}

it('iog advanced search sends user terms in q (not fq) so DSpace text field matches', function (): void {
    $captured = ['query' => null, 'filters' => null];
    bindIogRepositoryStub($captured);

    $this->get('/iog/advanced/search/Keywords:test?operator=OR')->assertSuccessful();

    expect($captured['query'])->toBe('test')
        ->and($captured['filters'])->toBe([]);
});

it('iog advanced search combines multiple fields with the chosen operator', function (): void {
    $captured = ['query' => null, 'filters' => null];
    bindIogRepositoryStub($captured);

    $this->get('/iog/advanced/search/Keywords:foo/Subject:bar?operator=AND')->assertSuccessful();

    expect($captured['query'])->toBe('foo AND dc.subject:bar');
});

it('loads the iog Skylark override stylesheet so pagination renders inline', function (): void {
    $response = $this->get('/iog')->assertSuccessful();

    expect($response->getContent())->toContain('collections/iog/css/skylark.css');

    $cssPath = public_path('collections/iog/css/skylark.css');
    expect(file_exists($cssPath))->toBeTrue();
    expect(file_get_contents($cssPath))
        ->toContain('ul.pagination li')
        ->toContain('inline-block');
});

it('registers a sidebar facets composer for the iog layout', function (): void {
    expect(app('view')->getDispatcher())->not->toBeNull();

    // The IogLayoutComposer adds $sidebar_facets et al when layouts.iog is
    // rendered. Static iog pages should expose the right-hand facets shell
    // (the <h4> facet titles come from the Solr stub when configured; here we
    // just confirm the layout's col-sidebar is wired up).
    $this->get('/iog')
        ->assertSuccessful()
        ->assertSee('col-sidebar', false);
});

it('configures a Year facet on dateIssued.year with enough facet_limit for all years', function (): void {
    expect(iogConfig()['filters'])
        ->toHaveKey('Year', 'dateIssued.year')
        ->and(iogConfig()['facet_limit'])->toBeGreaterThanOrEqual(16);
});

it('renders clickable Year facet links in the iog sidebar', function (): void {
    $html = view('iog.partials.sidebar-facets', [
        'facets' => [[
            'name' => 'Year',
            'active_terms' => [],
            'inactive_terms' => [[
                'name' => '1980',
                'display_name' => '1980',
                'count' => 30,
            ]],
            'queries' => [],
        ]],
        'base_search' => '/iog/search/*:*',
        'delimiter' => ':',
        'base_parameters' => '',
        'collectionUrl' => static fn (string $path = ''): string => '/iog/'.ltrim($path, '/'),
    ])->render();

    expect($html)
        ->toContain('>Year<')
        ->toContain('1980 (30)')
        ->toContain('/iog/search/*:*/Year:%221980%22');
});

it('forwards Year facet filter URL segments to Solr as fq parameters', function (): void {
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 30, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200),
    ]);

    $this->get('/iog/search/*:*/Year:%221980%22')
        ->assertSuccessful();

    Http::assertSent(function (Request $request): bool {
        $url = (string) $request->url();

        return str_contains($url, 'fq=dateIssued.year%3A%221980%22');
    });
});
