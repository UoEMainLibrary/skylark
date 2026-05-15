<?php

use App\Http\Controllers\Collections\Stcecilias\PageController;
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

it('wires the stcecilias home route to Collections\Stcecilias\PageController@home', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias', 'GET'));

    expect($route->getControllerClass())->toBe(PageController::class)
        ->and($route->getActionMethod())->toBe('home')
        ->and($route->getName())->toBe('stcecilias.home');
});

it('wires the stcecilias /iiif extra_route to Collections\Stcecilias\PageController@iiif', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias/iiif', 'GET'));

    expect($route->getControllerClass())->toBe(PageController::class)
        ->and($route->getActionMethod())->toBe('iiif')
        ->and($route->getName())->toBe('stcecilias.iiif');
});

it('wires the stcecilias /browse/{facet} extra_route to Collections\Stcecilias\PageController@browse', function (): void {
    $route = Route::getRoutes()->match(Request::create('/stcecilias/browse/Instrument', 'GET'));

    expect($route->getControllerClass())->toBe(PageController::class)
        ->and($route->getActionMethod())->toBe('browse')
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

it('renders the legacy record page structure verbatim', function (): void {
    // Mirror a realistic St Cecilia's DSpace record. The legacy theme's
    // record.php emits a fixed scaffold of stc-section1..6 divs with
    // .center-nav, .main-image, .stc-tags, .full-metadata, .info-box,
    // .child-meta-container etc. Skylark's record/show.blade.php must
    // emit the same scaffold so the legacy CSS / JS just works.
    Http::fake([
        '*' => Http::response([
            'response' => [
                'numFound' => 1,
                'docs' => [[
                    'id' => '96077',
                    'dctitleen' => ['Single-manual harpsichord'],
                    'dccontributorauthoren' => ['John Broadwood'],
                    'dccontributorauthorfullen' => ['John Broadwood'],
                    'dccoveragetemporalen' => ['1793'],
                    'dccoveragetemporalperioden' => ['18th century', '1790s'],
                    'dcidentifieren' => ['4319'],
                    'dcrelationispartofen' => ['MIMEd', 'Raymond Russell Collection'],
                    'dccoveragespatialen' => ['London', 'Europe', 'England', 'United Kingdom'],
                    'dccoveragespatialcityen' => ['London'],
                    'dccoveragespatialcountryen' => ['England'],
                    'dctypeen' => ['Harpsichord/Harpsichords/Keyboard/Musical Instrument', 'Harpsichord'],
                    'dctypefamilyen' => ['Keyboard'],
                    'dcsubjectclassificationen' => ['314.122-6-8', 'musical instrument'],
                    'dcdescriptionen' => ['Technical description: Single-manual English harpsichord.'],
                    'dcprovenanceen' => ['Bought by Raymond Russell from the Dolmetsch workshop in 1955.'],
                    'dcformatoriginalen' => [
                        'application/json##manifest.json##5438##10683/96077##1##abc##',
                        'audio/mp3##0035517s.mp3##485284##10683/96077##2##def##',
                    ],
                    'dcidentifierimageUri' => [
                        'http://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~2~2~61382~104991/full/full/0/default.jpg',
                    ],
                ]],
            ],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200),
    ]);

    $response = $this->get('/stcecilias/record/96077')->assertSuccessful();

    expect($response->getContent())
        // Section anchors mirroring the legacy record.php scaffold
        ->toContain('id="stc-section1"')
        ->toContain('id="stc-section2"')
        ->toContain('id="stc-section3"')
        ->toContain('id="stc-section4"')
        ->toContain('id="stc-section5"')
        ->toContain('class="center-nav"')
        ->toContain('class="cnav-link"')
        ->toContain('class="col-lg-12 main-image"')
        ->toContain('class="thumb-strip"')
        ->toContain('class="json-link"')
        // The record-page layout sits inside .container-fluid.content so the
        // legacy CSS gives the body a white background (not the dark-red
        // footer bleeding through).
        ->toContain('container-fluid content')
        // Section 5 — Instrument Data panel
        ->toContain('class="full-metadata"')
        ->toContain('class="panel panel-default container-fluid"')
        ->toContain('class="panel-heading straight-borders"')
        ->toContain('id="collapse1"')
        ->toContain('class="info-box"')
        ->toContain('class="meta-container"')
        ->toContain('class="child-meta-container"')
        ->toContain('class="child-meta-container-wide"')
        ->toContain('class="meta-spacing"')
        // Sub-headings
        ->toContain('Instrument Information')
        ->toContain('Date Information')
        ->toContain('Gallery Information')
        ->toContain('Maker Information')
        ->toContain('Made In')
        ->toContain('Description')
        ->toContain('Classification')
        // Header text combining Title | Maker | Date Made
        ->toContain('Single-manual harpsichord | John Broadwood | 1793')
        // IIIF / UV / Mirador / LUNA / CC-BY badge row
        ->toContain('class="uvlogo"')
        ->toContain('class="miradorlogo"')
        ->toContain('class="lunalogo"')
        ->toContain('class="iiiflogo"')
        ->toContain('class="ccbylogo"');
});

it("nests #stc-section3..5 inside #stc-section2's .itemscope (matches Skylight DOM)", function (): void {
    // The legacy stcecilia/views/record.php never closes #stc-section2 or
    // .itemscope — every section that follows (json-link, #stc-section3,
    // #stc-section4, .full-metadata + #stc-section5) ends up nested inside
    // .itemscope, and #stc-section6 is a sibling of .itemscope inside
    // #stc-section2. Skylark must reproduce that exact nesting; otherwise
    // the legacy CSS targets things at the wrong depth and the layout
    // visibly diverges from Skylight.
    Http::fake([
        '*' => Http::response([
            'response' => [
                'numFound' => 1,
                'docs' => [[
                    'id' => '96077',
                    'dctitleen' => ['Single-manual harpsichord'],
                    'dccontributorauthoren' => ['John Broadwood'],
                    'dctypeen' => ['Harpsichord'],
                    'dcformatoriginalen' => [
                        'application/json##manifest.json##5438##10683/96077##1##abc##',
                    ],
                    'dcidentifierimageUri' => [
                        'http://images.is.ed.ac.uk/luna/servlet/iiif/x/full/full/0/default.jpg',
                    ],
                ]],
            ],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200),
    ]);

    $body = $this->get('/stcecilias/record/96077')->assertSuccessful()->getContent();

    // Strip HTML comments and <script>...</script> blocks so they don't
    // confuse the depth tracker.
    $stripped = preg_replace('/<!--.*?-->/s', '', $body);
    $stripped = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $stripped);

    // Walk every <div> / </div>, recording the source order in which
    // each "interesting" id/class opens.
    preg_match_all('/<\/?div\b([^>]*)>/i', $stripped, $matches, PREG_SET_ORDER);
    $stack = [];
    $opened = []; // [label => depthAtOpen]
    foreach ($matches as $m) {
        $tag = $m[0];
        $attrs = $m[1] ?? '';
        if (str_starts_with($tag, '</')) {
            array_pop($stack);

            continue;
        }
        $stack[] = $attrs;

        // Record the first open at this depth for each interesting label.
        // We check id and EVERY class token (legacy uses e.g.
        // class="col-lg-12 main-image", so .main-image is the second class).
        $labels = [];
        if (preg_match('/\bid\s*=\s*"([^"]+)"/', $attrs, $idMatch)) {
            $labels[] = '#'.$idMatch[1];
        }
        if (preg_match('/\bclass\s*=\s*"([^"]+)"/', $attrs, $clsMatch)) {
            foreach (preg_split('/\s+/', trim($clsMatch[1])) as $cls) {
                if ($cls !== '') {
                    $labels[] = '.'.$cls;
                }
            }
        }
        foreach ($labels as $label) {
            if (! isset($opened[$label])
                && in_array($label, [
                    '#stc-section1', '#stc-section2', '#stc-section3',
                    '#stc-section4', '#stc-section5', '#stc-section6',
                    '.main-image', '.itemscope', '.thumb-strip', '.json-link',
                    '.full-metadata',
                ], true)
            ) {
                $opened[$label] = count($stack);
            }
        }
    }

    expect($opened)
        // #stc-section1 (title, anchor nav) is at depth 2 — child of
        // .container-fluid.content
        ->toHaveKey('#stc-section1')
        ->and($opened['#stc-section1'])->toBe(2)
        // #stc-section2 also at depth 2
        ->and($opened['#stc-section2'])->toBe(2)
        // .main-image and .itemscope are siblings inside #stc-section2
        ->and($opened['.main-image'])->toBe(3)
        ->and($opened['.itemscope'])->toBe(3)
        // .thumb-strip, .json-link, #stc-section3, #stc-section4 and
        // .full-metadata all live inside .itemscope
        ->and($opened['.thumb-strip'])->toBe(4)
        ->and($opened['.json-link'])->toBe(4)
        ->and($opened['#stc-section3'])->toBe(4)
        ->and($opened['.full-metadata'])->toBe(4)
        // #stc-section5 is inside .full-metadata
        ->and($opened['#stc-section5'])->toBe(5)
        // #stc-section6 is a sibling of .itemscope (NOT inside it),
        // back at the #stc-section2 child depth.
        ->and($opened['#stc-section6'])->toBe(3);
});

it('renders the search.error view (not a 500) when Solr fails', function (): void {
    // Real-world trigger: dev machine drops off VPN and Solr returns 403.
    // Previously this was caught but the controller then tried to render a
    // non-existent search.error view, cascading to "View [search.error] not
    // found." and a fatal 500.
    Http::fake([
        '*' => Http::response('forbidden', 403),
    ]);

    $this->get('/stcecilias/search/*:*')
        ->assertSuccessful()
        ->assertSee('Search Error')
        ->assertSee('There was a problem performing your search', false);
});

it('forwards facet filter URL segments to Solr as fq parameters', function (): void {
    // Skylark used to silently drop the entire filter portion of the URL when
    // the {query} segment contained legacy-style "+" spaces (e.g. links built
    // by the facet sidebar), because extractFilterSegments() tried to match
    // rawurlencode($query) — which uses "%20" — against the raw URI. The
    // result was that clicking "Harpsichord (17)" still showed the unfiltered
    // 36-instrument count. This test pins that regression.
    fakeStceciliasSolr();

    $this->get('/stcecilias/search/%22Keyboard+grouping%22/Instrument:%22harpsichord+%7C%7C%7C+Harpsichord%22')
        ->assertSuccessful();

    Http::assertSent(function (Illuminate\Http\Client\Request $request): bool {
        $url = (string) $request->url();

        // Filter on type_filter must reach Solr (URL-encoded form). The exact
        // separator between "harpsichord" and "Harpsichord" is `\n|||\n`
        // (encoded as "%0A%7C%7C%7C%0A") because Solr indexes the value with
        // newlines around the ||| delimiter.
        return str_contains($url, 'fq=type_filter%3A%22harpsichord%0A%7C%7C%7C%0AHarpsichord%22');
    });
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
