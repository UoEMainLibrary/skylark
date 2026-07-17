<?php

use App\Http\Controllers\RecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

it('registers every expected bodylanguage named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'bodylanguage.home',
    'bodylanguage.search.redirect',
    'bodylanguage.search.index',
    'bodylanguage.record.show',
    'bodylanguage.about',
    'bodylanguage.licensing',
    'bodylanguage.takedown',
    'bodylanguage.accessibility',
    'bodylanguage.feedback',
    'bodylanguage.catalogue',
    'bodylanguage.contact',
    'bodylanguage.people',
    'bodylanguage.browse',
]);

it('does NOT register DSpace-only routes for bodylanguage', function (string $name): void {
    expect(Route::has($name))->toBeFalse("route [{$name}] should not be registered for bodylanguage");
})->with([
    'bodylanguage.mirador',
    'bodylanguage.iiif',
    'bodylanguage.advanced',
]);

it('exposes /record/{id}/{type?} for ArchivesSpace records', function (): void {
    $route = Route::getRoutes()->match(Request::create('/bodylanguage/record/20528/archival_object', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('bodylanguage.record.show');
});

it('serves the bodylanguage home page', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/bodylanguage')
        ->assertSuccessful()
        ->assertSee('movement, dance and physical education in Scotland', false)
        ->assertSee('An online portal', false);
});

it('serves every bodylanguage static page', function (string $path): void {
    fakeArchivesSpaceSolr();

    $this->get("/bodylanguage/{$path}")->assertSuccessful();
})->with([
    'about',
    'catalogue',
    'contact',
    'people',
    'licensing',
    'takedown',
    'accessibility',
    'feedback',
]);

it('loads bodylanguage-specific skylight config when /bodylanguage is requested', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/bodylanguage')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('bodylanguage')
        ->and(config('skylight.fullname'))->toBe('Body Language')
        ->and(config('skylight.theme'))->toBe('bodylanguage')
        ->and(config('skylight.url_prefix'))->toBe('bodylanguage')
        ->and(config('skylight.repository_type'))->toBe('archivesspace')
        ->and(config('skylight.container_field'))->toBe('resource')
        // The four legacy resource IDs must be quoted so ArchivesSpace's
        // resource facet does not tokenise on the forward slashes.
        ->and(config('skylight.container_id'))->toBe([
            '"/repositories/2/resources/85725"',
            '"/repositories/2/resources/86677"',
            '"/repositories/2/resources/86712"',
            '"/repositories/2/resources/86737"',
        ])
        ->and(config('skylight.query_restriction'))->toBe(['publish' => 'true']);
});

it('uses the shared ARCHIVESSPACE_SOLR_URL / ARCHIVESSPACE_LINK_URL envs rather than hard-coded live4 URLs', function (): void {
    $config = require config_path('collections/bodylanguage.php');

    expect($config['solr_base'])->not->toContain('live4')
        ->and($config['link_url'])->not->toContain('live4')
        // Both defaults should point at the same ArchivesSpace cluster as
        // Fairbairn / LHSA / Towards Dolly.
        ->and($config['solr_base'])->toContain('archivesspace')
        ->and($config['link_url'])->toContain('archivesspace');
});

it('serves a bodylanguage search results page with Subject and Person facet headings', function (): void {
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => [
                'facet_fields' => [
                    'subjects' => ['Movement', 5],
                    'agents' => ['Margaret Morris', 2],
                ],
            ],
        ], 200),
    ]);

    $this->get('/bodylanguage/search/*:*')
        ->assertSuccessful()
        ->assertSee('Subject', false)
        ->assertSee('Person', false);
});

it('renders bodylanguage search sidebar facet links with the legacy double-encoded quoted-term shape', function (): void {
    $html = view('bodylanguage.search.partials.facets', [
        'facets' => [
            [
                'name' => 'Subject',
                'terms' => [
                    ['name' => 'Physical Education', 'display_name' => 'Physical Education', 'count' => 3, 'active' => false],
                ],
                'queries' => [],
            ],
            [
                'name' => 'Person',
                'terms' => [
                    ['name' => 'Margaret Morris', 'display_name' => 'Margaret Morris', 'count' => 2, 'active' => false],
                ],
                'queries' => [],
            ],
        ],
        'base_search' => '/bodylanguage/search/*:*',
        'base_parameters' => '',
        'collectionUrl' => fn (string $path) => '/bodylanguage/'.$path,
    ])->render();

    // Facet chip links must use %22 quotes around the URL-encoded term.
    expect($html)
        ->toContain('/bodylanguage/search/*:*/Subject:%22Physical+Education%22')
        ->and($html)->toContain('/bodylanguage/search/*:*/Person:%22Margaret+Morris%22');
});
