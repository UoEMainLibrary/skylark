<?php

use App\Http\Controllers\PageController;
use App\Support\PublicArtOverrides;

it('serves the public-art home page at /public-art', function () {
    $this->get('/public-art')->assertSuccessful();
});

it('serves public-art static pages', function (string $path) {
    $this->get("/public-art/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'accessibility',
    'takedown',
    'paolozzi',
    'artcollection',
    'feedback',
]);

it('uses the v1 layout by default', function () {
    config(['skylight.public_art_skin_version' => 1]);

    $this->get('/public-art')
        ->assertSuccessful()
        ->assertSee('cb-slideshow', false)
        ->assertSee('Search art on campus');
});

it('uses the v2 layout when PUBLIC_ART_SKIN_VERSION=2', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/public-art')
        ->assertSuccessful()
        ->assertSee('Art on Campus')
        ->assertSee('University of Edinburgh Art Collection')
        ->assertSee('Spotlight')
        ->assertDontSee('cb-slideshow')
        ->assertDontSee('Coll.ed', false);
});

it('renders the v2 paolozzi page with updated content', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/public-art/paolozzi')
        ->assertSuccessful()
        ->assertSee('Paolozzi Mosaic Project')
        ->assertSee('Tottenham Court Road')
        ->assertDontSee('Information video')
        ->assertSee('player.vimeo.com/video/170003917', false)
        ->assertSee('vimeo.com/170003917', false);
});

it('switches to v2 views when public_art_skin_version is 2', function () {
    config(['skylight.public_art_skin_version' => 2]);

    expect(PageController::publicArtViewName('public-art.home'))
        ->toBe('public-art-v2.home');
});

it('keeps v1 view name when skin version is 1', function () {
    config(['skylight.public_art_skin_version' => 1]);

    expect(PageController::publicArtViewName('public-art.home'))
        ->toBe('public-art.home');
});

it('renders the Public Art Google Analytics tag on both skin versions', function (int $version) {
    config([
        'skylight.public_art_skin_version' => $version,
        'skylight.ga_code' => 'G-GYJPCFG6QY',
    ]);

    $this->get('/public-art')
        ->assertSuccessful()
        ->assertSee('G-GYJPCFG6QY')
        ->assertSee('https://www.googletagmanager.com/gtag/js', false);
})->with([1, 2]);

/**
 * Luna's IIIF endpoint accepts width-first ('200,/') and best-fit ('!w,h/')
 * sizes, but rejects height-first (',1200/') with HTTP 400. These tests guard
 * against re-introducing the bad syntax.
 */
it('never uses Luna-broken height-first IIIF size syntax in public-art blades', function (string $blade) {
    expect(file_get_contents(resource_path("views/{$blade}")))
        ->not->toMatch('#/full/,\d+/#');
})->with([
    'public-art/search/results.blade.php',
    'public-art-v2/search/results.blade.php',
    'public-art-v2/record/show.blade.php',
]);

it('uses Luna-safe IIIF size syntax for V2 record hero and thumbnails', function () {
    expect(file_get_contents(resource_path('views/public-art-v2/record/show.blade.php')))
        ->toContain('/full/!600,600/')
        ->toContain('/full/200,/');
});

it('uses best-fit IIIF size syntax in V2 search results grid', function () {
    expect(file_get_contents(resource_path('views/public-art-v2/search/results.blade.php')))
        ->toContain('/full/!400,400/');
});

it('renders the V2 record gallery, thumbnail buttons and zoom dialog markup', function () {
    $contents = file_get_contents(resource_path('views/public-art-v2/record/show.blade.php'));

    expect($contents)
        ->toContain('data-image-gallery')
        ->toContain('data-thumb')
        ->toContain('data-zoom-trigger')
        ->toContain('data-zoom-dialog')
        ->toContain('aria-pressed')
        ->toContain('<dialog');
});

it('discloses every public-art-v2 external link as opening in a new tab', function (string $blade) {
    $contents = file_get_contents(resource_path("views/{$blade}"));

    preg_match_all('/<a\b[^>]*\btarget=["\']_blank["\'][^>]*>(.*?)<\/a>/si', $contents, $matches);

    expect(true)->toBeTrue();

    foreach ($matches[0] as $i => $anchor) {
        $body = $matches[1][$i];
        $hasSrOnly = str_contains($body, 'opens in a new tab') || str_contains($body, 'opens in a dialog');
        $usesPartial = str_contains($contents, "external-link', [\n");
        expect($hasSrOnly || $usesPartial)->toBeTrue("External link in {$blade} lacks a new-tab disclosure: {$anchor}");
    }
})->with([
    'layouts/public-art-v2.blade.php',
    'public-art-v2/home.blade.php',
    'public-art-v2/record/show.blade.php',
    'public-art-v2/pages/about.blade.php',
    'public-art-v2/pages/accessibility.blade.php',
    'public-art-v2/pages/artcollection.blade.php',
    'public-art-v2/pages/feedback.blade.php',
    'public-art-v2/pages/licensing.blade.php',
    'public-art-v2/pages/paolozzi.blade.php',
    'public-art-v2/pages/takedown.blade.php',
]);

it('renders the shared external-link partial with new-tab disclosure', function () {
    $html = view('public-art-v2.partials.external-link', [
        'href' => 'https://example.com/page',
        'label' => 'Example link',
    ])->render();

    expect($html)
        ->toContain('href="https://example.com/page"')
        ->toContain('target="_blank"')
        ->toContain('rel="noopener"')
        ->toContain('underline')
        ->toContain('opens in a new tab')
        ->toContain('aria-hidden="true"');
});

it('configures every public-art-v2 video iframe with a host-platform name and lazy load', function (string $blade) {
    $contents = file_get_contents(resource_path("views/{$blade}"));

    if (! str_contains($contents, '<iframe')) {
        expect(true)->toBeTrue();

        return;
    }

    preg_match_all('/<iframe\b[^>]*>/si', $contents, $iframes);

    expect($iframes[0])->not->toBeEmpty();

    foreach ($iframes[0] as $iframe) {
        expect(str_contains($iframe, 'title='))->toBeTrue("iframe in {$blade} is missing a title attribute");
        expect(str_contains($iframe, 'loading="lazy"'))->toBeTrue("iframe in {$blade} should be lazy-loaded");
        $usesKnownHost = str_contains($iframe, 'media.ed.ac.uk') || str_contains($iframe, 'player.vimeo.com');
        if ($usesKnownHost) {
            $titleNamesHost = preg_match('/title="[^"]*\b(Media Hopper|Vimeo)\b/i', $iframe) === 1;
            expect($titleNamesHost)->toBeTrue("iframe in {$blade} should name its host platform in title");
        }
    }
})->with([
    'public-art-v2/home.blade.php',
    'public-art-v2/record/show.blade.php',
    'public-art-v2/pages/paolozzi.blade.php',
]);

it('renders a transcript / full-page link beside each video embed', function (string $blade) {
    $contents = file_get_contents(resource_path("views/{$blade}"));

    if (! str_contains($contents, '<iframe')) {
        expect(true)->toBeTrue();

        return;
    }

    expect($contents)->toMatch('/full-page version (of this video|on Vimeo)/');
})->with([
    'public-art-v2/home.blade.php',
    'public-art-v2/pages/paolozzi.blade.php',
]);

it('keeps the V2 ink/accent palette WCAG-compliant against white and ink-50', function () {
    $relativeLuminance = function (string $hex): float {
        $hex = ltrim($hex, '#');
        $channels = [
            hexdec(substr($hex, 0, 2)) / 255,
            hexdec(substr($hex, 2, 2)) / 255,
            hexdec(substr($hex, 4, 2)) / 255,
        ];
        $linear = array_map(
            fn (float $c): float => $c <= 0.03928 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4,
            $channels,
        );

        return 0.2126 * $linear[0] + 0.7152 * $linear[1] + 0.0722 * $linear[2];
    };
    $contrast = function (string $a, string $b) use ($relativeLuminance): float {
        $la = $relativeLuminance($a);
        $lb = $relativeLuminance($b);
        $light = max($la, $lb);
        $dark = min($la, $lb);

        return ($light + 0.05) / ($dark + 0.05);
    };

    $css = file_get_contents(resource_path('css/app.css'));
    $extract = function (string $token) use ($css): string {
        preg_match('/--color-'.preg_quote($token, '/').':\s*(#[0-9a-fA-F]{6})/', $css, $m);

        return $m[1] ?? '';
    };

    $tokens = [
        'pa-ink-500' => $extract('pa-ink-500'),
        'pa-ink-600' => $extract('pa-ink-600'),
        'pa-ink-700' => $extract('pa-ink-700'),
        'pa-ink-800' => $extract('pa-ink-800'),
        'pa-ink-900' => $extract('pa-ink-900'),
        'pa-accent' => $extract('pa-accent'),
        'pa-accent-dark' => $extract('pa-accent-dark'),
    ];

    foreach ($tokens as $name => $hex) {
        expect($hex)->not->toBe('', "Missing CSS token --color-{$name}");
        $vsWhite = $contrast($hex, '#ffffff');
        $vsInk50 = $contrast($hex, '#f6f6f5');
        expect($vsWhite)->toBeGreaterThanOrEqual(4.5, "{$name} contrast vs white was {$vsWhite}:1");
        expect($vsInk50)->toBeGreaterThanOrEqual(4.5, "{$name} contrast vs ink-50 was {$vsInk50}:1");
    }
});

it('aligns the V2 accessibility statement with the official policy contacts and structure', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/public-art/accessibility')->assertSuccessful();

    $response
        ->assertSee('Accessibility statement for Art on Campus')
        ->assertSee('Library and University Collections Directorate')
        ->assertSee('Information.systems@ed.ac.uk', false)
        ->assertSee('+44 (0)131 651 5151')
        ->assertSee('Contact Scotland BSL')
        ->assertSee('Equality Advisory and Support Service')
        ->assertSee('Compliance status')
        ->assertSee('partially compliant')
        ->assertSee('Disproportionate burden')
        ->assertSee('Preparation of this accessibility statement')
        ->assertSee('20 March 2026')
        ->assertSee('Change log');
});

it('renders a skip-map link, labelled map region, and textual location list on the V2 search map view', function () {
    $blade = file_get_contents(resource_path('views/public-art-v2/search/results.blade.php'));

    expect($blade)
        ->toContain('Skip interactive map')
        ->toContain('href="#map-textual-list"')
        ->toContain('id="map-textual-list"')
        ->toContain('id="map-textual-list-heading"')
        ->toContain('aria-label="Interactive map of artworks across the University of Edinburgh campuses')
        ->toContain('Artworks on the map');
});

it('emits a skip-map link and labelled map region on V2 record pages', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.author.full.en',
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Mapped Artwork'],
            'dcidentifierimageUri' => ['https://example.test/iiif/abc/full/full/0/default.jpg'],
            'dccoveragespatialcoorden' => ['55.9445, -3.1892'],
            'dccoveragespatialen' => ['George Square'],
        ],
        'recordTitle' => 'Mapped Artwork',
        'recordDisplay' => ['Title'],
    ])->render();

    expect($html)
        ->toContain('Skip interactive map')
        ->toContain('href="#location-after-map"')
        ->toContain('id="location-after-map"')
        ->toContain('aria-label="Interactive map showing the location of Mapped Artwork"')
        ->toContain('Approximate coordinates');
});

/**
 * Site-wide V2 presentation overrides (label rename + browse-by-date order).
 * Per-artwork content is managed upstream in DSpace, not in skylark.
 */
it('normalises browse-order lookup keys (case, whitespace, tags)', function () {
    expect(PublicArtOverrides::lookupKey('  Rhino   head '))->toBe('rhino head')
        ->and(PublicArtOverrides::lookupKey('<em>Ideas</em>'))->toBe('ideas')
        ->and(PublicArtOverrides::lookupKey('The Protégé'))->toBe('the protégé');
});

it('returns curated browse-order positions, with unknown titles last', function () {
    expect(PublicArtOverrides::browseSortKey('Ideas'))->toBe(0)
        ->and(PublicArtOverrides::browseSortKey('Startled Horse Rising'))->toBe(25)
        ->and(PublicArtOverrides::browseSortKey('Some Unmapped Work'))->toBe(PHP_INT_MAX)
        ->and(PublicArtOverrides::browseSortKey(null))->toBe(PHP_INT_MAX);
});

it('relabels Format and Format Extent for the V2 metadata table', function () {
    expect(PublicArtOverrides::labels())
        ->toMatchArray([
            'Format' => 'Media',
            'Format Extent' => 'Dimensions',
        ]);
});

it('sorts browse docs newest-first, preserving upstream order for unmapped titles', function () {
    $docs = [
        ['dctitleen' => ['Startled Horse Rising']],   // sort 25
        ['dctitleen' => ['Ideas']],                    // sort 0
        ['dctitleen' => ['Mystery Work']],             // sort PHP_INT_MAX (1st unknown)
        ['dctitleen' => ['Canter']],                   // sort 2
        ['dctitleen' => ['Another Mystery']],          // sort PHP_INT_MAX (2nd unknown)
    ];

    $sorted = PublicArtOverrides::sortBrowse($docs, 'dctitleen');
    $titles = array_map(fn (array $d) => $d['dctitleen'][0], $sorted);

    expect($titles)->toBe([
        'Ideas',
        'Canter',
        'Startled Horse Rising',
        'Mystery Work',
        'Another Mystery',
    ]);
});

it('does not rewrite per-artwork Solr field values when rendering V2', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.authorfull.en',
            'Description' => 'dc.description.en',
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Rhino head'],
            'dccontributorauthorfullen' => ['Upstream DSpace Author'],
            'dcdescriptionen' => ['Upstream DSpace description, rendered untouched.'],
        ],
        'recordTitle' => 'Rhino head',
        'recordDisplay' => ['Title', 'Artist', 'Description'],
    ])->render();

    expect($html)
        ->toContain('Upstream DSpace Author')
        ->toContain('Upstream DSpace description, rendered untouched.');
});

it('applies the Format → Media and Format Extent → Dimensions rename', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Format' => 'dc.format',
            'Format Extent' => 'dc.format.extent',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.authorfull.en',
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Some Work'],
            'dcformat' => ['bronze (metal)'],
            'dcformatextent' => ['100cm x 100cm'],
        ],
        'recordTitle' => 'Some Work',
        'recordDisplay' => ['Title', 'Format', 'Format Extent'],
    ])->render();

    expect($html)
        ->toContain('>Media<')
        ->toContain('>Dimensions<')
        ->not->toContain('>Format<')
        ->not->toContain('>Format Extent<');
});

it('appends the work year next to the title and reorders browse results', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Alt Image' => 'dc.image.primary.en',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Artist' => 'dc.contributor.authorfull.en',
            'Dates' => 'dc.coverage.temporal.en',
        ],
    ]);

    $docs = [
        ['id' => '1', 'dctitleen' => ['Startled Horse Rising'], 'dcidentifierimageUri' => [''], 'dccoveragetemporalen' => ['1833']],
        ['id' => '2', 'dctitleen' => ['Ideas'], 'dcidentifierimageUri' => [''], 'dccoveragetemporalen' => ['2021']],
    ];

    $html = view('public-art-v2.search.results', [
        'docs' => $docs,
        'total' => 2,
        'query' => '*:*',
        'searchbox_query' => '',
        'base_search' => '/public-art/search/*:*',
        'base_parameters' => '',
        'facets' => [],
        'highlights' => [],
        'suggestions' => [],
        'startRow' => 1,
        'endRow' => 2,
        'offset' => 0,
        'rows' => 30,
        'sort_by' => '',
        'sort_options' => [],
        'paginationLinks' => '',
        'active_filters' => [],
        'delimiter' => '|',
    ])->render();

    expect($html)
        ->toContain('Ideas')
        ->toContain('>2021<')
        ->toContain('Startled Horse Rising')
        ->toContain('>1833<');

    // Curated order: Ideas (2021) appears before Startled Horse Rising (1833)
    expect(strpos($html, 'Ideas'))->toBeLessThan(strpos($html, 'Startled Horse Rising'));
});

it('renders the client-revised home-page welcome copy', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/public-art')
        ->assertSuccessful()
        ->assertSee('Artworks from the University of Edinburgh', false)
        ->assertSee('visible across campus', false)
        ->assertSee('Ranging from historic memorials to contemporary creative interventions')
        ->assertSee('overseeing the movement and presentation of works from the')
        ->assertSee('manages both permanent and temporary commissions')
        ->assertSee('Commission and Loans pages');
});

it('uses the client-revised wording on the V2 paolozzi page', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/public-art/paolozzi')->assertSuccessful();

    $response
        ->assertSee('Scottish artist Eduardo Paolozzi', false)
        ->assertSee('Nonetheless, the arches were removed')
        ->assertSee('two critical points emerged')
        ->assertSee('the mosaics remain a regular feature in teaching')
        ->assertDontSee('Unfortunately, the arches were removed')
        ->assertDontSee('two points of consensus were reached')
        ->assertDontSee('John Bryden')
        ->assertDontSee('The future', false);
});

it('configures the public-art-overrides config file with labels and 26 browse entries', function () {
    $config = require config_path('public-art-overrides.php');

    expect($config['labels'])->toBe(['Format' => 'Media', 'Format Extent' => 'Dimensions'])
        ->and($config['browse_order'])->toHaveCount(26)
        ->and($config['browse_order'][0])->toBe('Ideas')
        ->and(end($config['browse_order']))->toBe('Startled Horse Rising')
        ->and($config)->not->toHaveKey('records');
});

it('renders the V2 record blade end-to-end with a multi-image record', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.author.full.en',
        ],
    ]);

    $base = 'https://images.is.ed.ac.uk/luna/servlet/iiif/UoEart~1~1~76077~216419';

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Test Artwork'],
            'dcidentifierimageUri' => [
                "{$base}/full/full/0/default.jpg",
                "{$base}-2/full/full/0/default.jpg",
            ],
            'dccoveragespatialen' => ['Bristo Square'],
            'dccontributorauthorfullen' => ['Susan Collis (b.1956)'],
        ],
        'recordTitle' => 'Test Artwork',
        'recordDisplay' => ['Title', 'Artist'],
    ])->render();

    expect($html)
        ->toContain("{$base}/full/!600,600/0/default.jpg")
        ->toContain("{$base}/full/full/0/default.jpg") // zoom = source resolution
        ->toContain("{$base}/full/200,/0/default.jpg") // thumb
        ->toContain('data-image-gallery')
        ->toContain('aria-pressed="true"')
        ->toContain('aria-pressed="false"')
        ->toContain('Image 1 of 2');
});
