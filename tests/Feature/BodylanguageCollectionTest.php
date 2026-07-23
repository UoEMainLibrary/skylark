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

it('renders the legacy bodylanguage header quick-links inside <header>', function (): void {
    fakeArchivesSpaceSolr();

    $html = $this->get('/bodylanguage')->assertSuccessful()->getContent();

    // Legacy header.php places <div class="quick-links"><ul>...</ul></div>
    // right after <h3 class="site-tag">, still inside <header>.
    expect($html)
        ->toContain('<div class="quick-links">')
        ->toContain('About the Project</a>')
        ->toContain('View the Catalogue</a>')
        ->toContain('Meet the People</a>')
        ->toContain('#project-anchor');

    // Order: site-tag then quick-links then </header>.
    $tagPos = strpos($html, 'class="site-tag"');
    $qlPos = strpos($html, 'class="quick-links"');
    $endHeaderPos = strpos($html, '</header>');
    expect($tagPos)->toBeLessThan($qlPos)
        ->and($qlPos)->toBeLessThan($endHeaderPos);
});

it('renders the legacy bodylanguage footer with site-links, uoe-logo and CRC Takedown URL', function (): void {
    fakeArchivesSpaceSolr();

    $html = $this->get('/bodylanguage')->assertSuccessful()->getContent();

    expect($html)
        ->toContain('<div class="footer-links">')
        ->toContain('<div class="site-links">')
        ->toContain('>About</a>')
        ->toContain('>Catalogue</a>')
        ->toContain('>People</a>')
        ->toContain('>Contact Us</a>')
        ->toContain('<div class="footer-disclaimer">')
        ->toContain('<div class="uoe-logo"></div>')
        ->toContain('class="footer-copyright"')
        // Takedown is the external CRC policy URL, not internal.
        ->toContain('https://www.ed.ac.uk/information-services/library-museum-gallery/crc/services/copying-and-digitisation/image-licensing/takedown-policy');
});

it('hides the Skip to content link and inline "(Opens in a new tab)" annotations', function (): void {
    fakeArchivesSpaceSolr();

    $html = $this->get('/bodylanguage')->assertSuccessful()->getContent();
    $css = file_get_contents(public_path('collections/bodylanguage/css/style.css'));

    expect($html)
        ->toContain('>Skip to content</a>')
        ->toContain('class="sr-only"');
    expect($css)
        ->toContain('.sr-only')
        ->toContain('clip-path')
        ->toContain('position: absolute');
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

it('renders the bodylanguage record page with the legacy full-title, results-link, big-divider and .sidebar-overlay sidebar', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'title',
            'Identifier' => 'component_id',
            'Id' => 'id',
        ],
        'skylight.link_url' => 'https://archivesspace.collections.ed.ac.uk',
        'skylight.filters' => [
            'Subject' => 'subjects',
        ],
    ]);

    $html = view('bodylanguage.record.show', [
        'record' => [
            'Title' => ['Artefacts, c.1957'],
            'Identifier' => ['EUA GD55/1/4/7'],
            'Id' => ['/repositories/2/archival_objects/141164'],
        ],
        'recordTitle' => 'Artefacts, c.1957',
        'recordDisplay' => ['Identifier'],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [
            [
                'Title' => ['Related archival object'],
                'Id' => ['/repositories/2/archival_objects/141165'],
                '_raw' => ['types' => ['archival_object']],
            ],
        ],
        'collectionUrl' => fn (string $path = '') => '/bodylanguage/'.ltrim($path, '/'),
    ])->render();

    // Legacy bodylanguage record.php has:
    //   .content > .full-title > h1.itemtitle, .smol-divider, a.results-link
    //   pointing at the ArchivesSpace public URL, .divider, .full-metadata
    //   table (with "Consult at" row) and .big-divider at the end.
    // related_items.php renders <a href="./record/{id}/{type}"> (no
    // related-record class) and a .sidebar-overlay div per row.
    expect($html)
        ->toContain('<div class="full-title">')
        ->and($html)->toContain('<h1 class="itemtitle">Artefacts, c.1957</h1>')
        ->and($html)->toContain('<div class="smol-divider"></div>')
        ->and($html)->toContain('class="results-link"')
        ->and($html)->toContain('archivesspace.collections.ed.ac.uk/repositories/2/archival_objects/141164')
        ->and($html)->toContain('View full record in University of Edinburgh archives catalogue')
        ->and($html)->toContain('<div class="divider"></div>')
        ->and($html)->toContain('<div class="full-metadata">')
        ->and($html)->toContain('<th>Consult at</th>')
        ->and($html)->toContain('<div class="big-divider"></div>')
        ->and($html)->toContain('./record/141165/archival_object')
        ->and($html)->toContain('<div class="sidebar-overlay"></div>')
        ->and($html)->not->toContain('related-record');
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
