<?php

use App\Http\Controllers\RecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * @return array<string, mixed>
 */
function alumniConfig(): array
{
    return require config_path('collections/alumni.php');
}

function fakeAlumniSolr(array $docs = [], int $numFound = 0, array $facetFields = []): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => $numFound, 'docs' => $docs],
            'facet_counts' => ['facet_fields' => $facetFields],
            'highlighting' => [],
        ], 200),
    ]);
}

it('registers expected alumni named routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [$name] is missing");
})->with([
    'alumni.home',
    'alumni.search.index',
    'alumni.record.show',
    'alumni.about',
    'alumni.licensing',
    'alumni.takedown',
]);

it('routes /alumni/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/alumni/record/66162', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('alumni.record.show');
});

it('serves the alumni home page under the Historical Alumni brand', function (): void {
    fakeAlumniSolr();

    $this->get('/alumni')
        ->assertSuccessful()
        ->assertSee('University of Edinburgh Historical Alumni', false)
        ->assertDontSee('University of Edinburgh Art Collection', false);
});

it('serves alumni static pages branded as Historical Alumni', function (string $path): void {
    fakeAlumniSolr();

    $response = $this->get("/alumni/{$path}")->assertSuccessful();

    expect($response->getContent())
        ->toContain('University of Edinburgh Historical Alumni')
        ->not->toContain('University of Edinburgh Art Collection');
})->with([
    'about',
    'licensing',
    'takedown',
]);

it('renders the alumni record page under the Historical Alumni layout', function (): void {
    config([
        'skylight' => array_merge(config('skylight', []), alumniConfig()),
    ]);

    $html = view('alumni.record.show', [
        'record' => [
            'dctitleen' => ['Reid, George Thomson Henderson'],
            'dcsubjecten' => ['New College'],
            'dccoveragetemporalen' => ['1932'],
            'dcrelationispartofen' => ['Students at New College, 1843-1943'],
            'dcdescriptionen' => ['b.31st March 1910'],
            'dcidentifiermatric' => ['4511'],
        ],
        'recordTitle' => 'Reid, George Thomson Henderson',
        'recordDisplay' => alumniConfig()['recorddisplay'],
        'descriptionDisplay' => [],
        'fieldMappings' => alumniConfig()['field_mappings'],
        'filters' => array_keys(alumniConfig()['filters']),
        'bitstreamField' => 'dcformatoriginalen',
        'thumbnailField' => 'dcformatthumbnailen',
        'parentCollectionField' => '',
        'subCollectionField' => '',
        'internalUriField' => '',
        'aspaceUriField' => '',
        'lunaUriField' => '',
        'lmsUriField' => '',
        'otherUriField' => '',
        'highlightQuery' => '',
        'relatedItems' => [],
        'bitstreams' => [],
    ])->render();

    // Nothing in the record page should brand as Art or link into /art/.
    expect($html)
        ->not->toContain('Art Collection')
        ->and($html)->not->toContain('/art/')
        ->and($html)->not->toContain('layouts.art')
        // Legacy record.php structure: <h1 class="itemtitle"> title only,
        // then a .tags block with Subject facet chips, then a metadata table
        // and a "Back to Search Results" button.
        ->and($html)->toContain('<h1 class="itemtitle">Reid, George Thomson Henderson</h1>')
        ->and($html)->toContain('<div class="tags">')
        // Legacy quirk: Subject facet URL uses `"SubjectXX+|||+YY"` with no
        // colon (i.e. `%22Subject...`); mirror it verbatim.
        ->and($html)->toContain('/%22Subjectnew+college+%7C%7C%7C+New+College%22')
        ->and($html)->toContain('<div class="content">')
        // Metadata rows come from `recorddisplay`.
        ->and($html)->toContain('<th>Description</th>')
        ->and($html)->toContain('b.31st March 1910')
        ->and($html)->toContain('<th>Matriculation Number</th>')
        // Legacy renders Collection facet as "<value>: See All Records | More Info".
        ->and($html)->toContain('Students at New College, 1843-1943: <a')
        ->and($html)->toContain('See All Records')
        ->and($html)->toContain('More Info')
        // The "More Info" link resolves to the collection-scoped static page.
        ->and($html)->toContain('/alumni/newcoll')
        ->and($html)->toContain('Back to Search Results')
        // Sidebar structure with related items.
        ->and($html)->toContain('<div class="col-sidebar">')
        ->and($html)->toContain('<h4>Related Items</h4>')
        // Alumni layout scaffolding (footer/header brand text).
        ->and($html)->toContain('University of Edinburgh Historical Alumni');
});

it('brands the alumni record HTML title with the record title only, no Art suffix', function (): void {
    config([
        'skylight' => array_merge(config('skylight', []), alumniConfig()),
    ]);

    $html = view('alumni.record.show', [
        'record' => ['dctitleen' => ['Reid, George Thomson Henderson']],
        'recordTitle' => 'Reid, George Thomson Henderson',
        'recordDisplay' => [],
        'descriptionDisplay' => [],
        'fieldMappings' => alumniConfig()['field_mappings'],
        'filters' => [],
        'bitstreamField' => '',
        'thumbnailField' => '',
        'parentCollectionField' => '',
        'subCollectionField' => '',
        'internalUriField' => '',
        'aspaceUriField' => '',
        'lunaUriField' => '',
        'lmsUriField' => '',
        'otherUriField' => '',
        'highlightQuery' => '',
        'relatedItems' => [],
        'bitstreams' => [],
    ])->render();

    // Legacy alumni <title> is just `"<recordTitle>"` (with the quotes) — no
    // "Art Collection" suffix, no other collection branding.
    expect($html)
        ->toContain('<title>&quot;Reid, George Thomson Henderson&quot;</title>')
        ->and($html)->not->toContain('Art Collection');
});

it('loads alumni-specific skylight config when /alumni is requested', function (): void {
    fakeAlumniSolr();

    $this->get('/alumni')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('alumni')
        ->and(config('skylight.fullname'))->toBe('University of Edinburgh Historical Alumni')
        ->and(config('skylight.theme'))->toBe('alumni')
        ->and(config('skylight.url_prefix'))->toBe('alumni')
        ->and(config('skylight.container_field'))->toBe('location.comm')
        // Static pages map is what powers the Collection facet's See All Records/
        // More Info dual link on record pages.
        ->and(config('skylight.static_pages'))->toHaveKey('Students at New College, 1843-1943', 'newcoll');
});
