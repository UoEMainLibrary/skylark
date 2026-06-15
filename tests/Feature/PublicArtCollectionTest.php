<?php

use App\Support\CollectionViewResolver;
use App\Support\PublicArtOverrides;

it('serves the Art on Campus home page at /art-on-campus', function () {
    $this->get('/art-on-campus')->assertSuccessful();
});

it('serves Art on Campus static pages', function (string $path) {
    $this->get("/art-on-campus/{$path}")->assertSuccessful();
})->with([
    'licensing',
    'accessibility',
    'takedown',
    'paolozzi',
    'feedback',
]);

it('301-redirects the retired /art-on-campus/artcollection page to /art', function () {
    $response = $this->get('/art-on-campus/artcollection');

    $response->assertStatus(301);
    $response->assertRedirect('/art');
});

it('301-redirects the legacy /public-art prefix to /art-on-campus', function (string $from, string $to) {
    $response = $this->get($from);

    $response->assertStatus(301);
    $response->assertRedirect($to);
})->with([
    'home' => ['/public-art', '/art-on-campus'],
    'paolozzi' => ['/public-art/paolozzi', '/art-on-campus/paolozzi'],
    'browse' => ['/public-art/search/*:*', '/art-on-campus/search/*:*'],
    'map' => ['/public-art/search/*:*/?map=true', '/art-on-campus/search/*:*/?map=true'],
    'record' => ['/public-art/record/12345', '/art-on-campus/record/12345'],
    'about (chains to home)' => ['/public-art/about', '/art-on-campus/about'],
]);

it('preserves the query string when redirecting from /public-art to /art-on-campus', function () {
    $response = $this->get('/public-art/search/*:*?q=Ideas&sort=date');

    $response->assertStatus(301);
    $response->assertRedirect('/art-on-campus/search/*:*?q=Ideas&sort=date');
});

it('redirects /art-on-campus/about to the home page', function () {
    $response = $this->get('/art-on-campus/about');

    $response->assertStatus(301);
    $response->assertRedirect('/art-on-campus');
});

it('uses the v1 layout by default', function () {
    config(['skylight.public_art_skin_version' => 1]);

    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertSee('cb-slideshow', false)
        ->assertSee('Search art on campus');
});

it('uses the v2 layout when PUBLIC_ART_SKIN_VERSION=2', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertSee('Art on Campus')
        ->assertSee('University of Edinburgh Art Collection')
        ->assertSee('Spotlight')
        ->assertDontSee('cb-slideshow')
        ->assertDontSee('Coll.ed', false);
});

it('renders the v2 paolozzi page with updated content', function () {
    config(['skylight.public_art_skin_version' => 2]);

    // Note: the V2 navigation still links to "Paolozzi Mosaic Project" because
    // that label is sourced from DSpace and is being updated separately. The
    // assertion below intentionally only covers the page H1, browser title and
    // meta description, all of which are owned by this Blade view.
    $this->get('/art-on-campus/paolozzi')
        ->assertSuccessful()
        ->assertSee('<h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Paolozzi Mosaics</h1>', false)
        ->assertSee('<title>Paolozzi Mosaics | Art on Campus</title>', false)
        ->assertSee('Tottenham Court Road')
        ->assertDontSee('Information video')
        ->assertSee('player.vimeo.com/video/170003917', false)
        ->assertSee('vimeo.com/170003917', false)
        // Mosaic fragment images displayed at the top of the page.
        ->assertSee('paolozzi/tcr-fragment-4.jpg', false)
        ->assertSee('paolozzi/0069748c.jpg', false);
});

it('serves paolozzi mosaic images from local assets in the v1 viewer', function () {
    config(['skylight.public_art_skin_version' => 1]);

    $this->get('/art-on-campus/paolozzi')
        ->assertSuccessful()
        ->assertSee('collections/public-art/assets/paolozzi_images/0069069d.png', false)
        ->assertSee('collections/public-art/assets/paolozzi_images/0069760d.png', false)
        ->assertDontSee('test.collections.ed.ac.uk', false);
});

it('switches to v2 views when public_art_skin_version is 2', function () {
    config(['skylight.public_art_skin_version' => 2]);

    expect(CollectionViewResolver::publicArt('public-art.home'))
        ->toBe('public-art-v2.home');
});

it('keeps v1 view name when skin version is 1', function () {
    config(['skylight.public_art_skin_version' => 1]);

    expect(CollectionViewResolver::publicArt('public-art.home'))
        ->toBe('public-art.home');
});

it('renders the Public Art Google Analytics tag on both skin versions', function (int $version) {
    config([
        'skylight.public_art_skin_version' => $version,
        'skylight.ga_code' => 'G-GYJPCFG6QY',
    ]);

    $this->get('/art-on-campus')
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
    'public-art-v2/pages/accessibility.blade.php',
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
        $usesKnownHost = str_contains($iframe, 'media.ed.ac.uk')
            || str_contains($iframe, 'cdnapisec.kaltura.com')
            || str_contains($iframe, 'player.vimeo.com');
        if ($usesKnownHost) {
            // cdnapisec.kaltura.com is the underlying CDN that powers Media
            // Hopper, so a "Media Hopper" title is the right user-facing label
            // for both hosts.
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

    $response = $this->get('/art-on-campus/accessibility')->assertSuccessful();

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
        ->toContain('Artworks on the map')
        ->toContain('window.publicArtPinIcon')
        ->toContain('collections/public-art/locations/pinpoint.png');
});

it('compiles the V2 search map view with location pins as valid PHP', function (string $skinVersion, string $view, string $recordPathPrefix) {
    // Regression for /art-on-campus/search/*:*?map=true erroring with
    // "Unclosed '[' on line 220 does not match ')'". Blade's directive
    // argument parser doesn't handle multi-line arrow functions with array
    // literals inside `@json(...)`, so the map view needs to build the
    // locations payload in a `@php` block before passing it to @json().
    config([
        'skylight.public_art_skin_version' => (int) $skinVersion,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
        ],
    ]);

    // The blades flip between grid and map view based on `?map=true`.
    request()->merge(['map' => 'true']);

    $docs = [
        [
            'id' => 'abc',
            'dctitleen' => ['Mapped Artwork'],
            'dcidentifierimageUri' => ['https://example.test/iiif/abc/full/full/0/default.jpg'],
            'dccoveragespatialcoorden' => ['55.9445, -3.1892'],
        ],
    ];

    $html = view($view, [
        'docs' => $docs,
        'total' => 1,
        'query' => '*:*',
        'searchbox_query' => '',
        'base_search' => $recordPathPrefix.'/search/*:*',
        'base_parameters' => '',
        'facets' => [],
        'highlights' => [],
        'suggestions' => [],
        'startRow' => 1,
        'endRow' => 1,
        'offset' => 0,
        'rows' => 30,
        'sort_by' => '',
        'sort_options' => [],
        'paginationLinks' => '',
        'active_filters' => [],
        'delimiter' => '|',
    ])->render();

    expect($html)
        ->toContain('var locationsArray =')
        ->toContain('Mapped Artwork')
        ->toContain('55.9445')
        ->toContain('-3.1892')
        // The record URL is JSON-encoded (slashes escaped) inside the
        // locationsArray payload, so accept either escaped or plain form.
        ->toMatch('#'.preg_quote($recordPathPrefix, '#').'\\\\?/record\\\\?/abc#');
})->with([
    'V1 layout' => ['1', 'public-art.search.results', '/public-art'],
    'V2 layout' => ['2', 'public-art-v2.search.results', '/art-on-campus'],
]);

it('serves local map pin icons for public art OpenLayers bundles', function (): void {
    expect(file_get_contents(public_path('collections/public-art/locations/main.js')))
        ->toContain("window.publicArtPinIcon || '/collections/public-art/locations/pinpoint.png'")
        ->and(file_get_contents(public_path('collections/public-art/map/main.js')))
        ->toContain("window.publicArtRecordPinIcon || '/collections/public-art/map/pinpoint.png'");
});

it('uses only the first map coordinate when a record has multiple', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Multi-site Artwork'],
            'dcidentifierimageUri' => ['https://example.test/iiif/abc/full/full/0/default.jpg'],
            'dccoveragespatialcoorden' => ['55.9445, -3.1892', '51.5000, -0.1200'],
            'dccoveragespatialen' => ['George Square', 'London'],
        ],
        'recordTitle' => 'Multi-site Artwork',
        'recordDisplay' => ['Title'],
    ])->render();

    expect(substr_count($html, 'id="record-map"'))->toBe(1)
        ->and(substr_count($html, 'collections/public-art/map/bundle.js'))->toBe(1);

    expect($html)
        ->toContain('55.9445, -3.1892')
        ->not->toContain('51.5000')
        ->not->toContain('-0.1200')
        ->toContain('George Square')
        ->not->toContain('London')
        ->toContain('window.lat = 55.9445')
        ->toContain('window.lon = -3.1892');
});

it('parses the first map coordinate when Solr returns a single string value', function () {
    expect(PublicArtOverrides::firstMapCoordinates(
        ['dccoveragespatialcoorden' => '55.9445, -3.1892'],
        'dccoveragespatialcoorden'
    ))->toBe(['lat' => '55.9445', 'lon' => '-3.1892']);
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
        ->toContain('Approximate coordinates')
        ->toContain('window.publicArtRecordPinIcon')
        ->toContain('pinpoint.png');
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
        ->and(PublicArtOverrides::browseSortKey('Startled Horse Rising'))->toBe(26)
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

it('constrains the V2 record thumbnail grid to a JS-enhanced scroll panel with a no-JS grid fallback', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.authorfull.en',
        ],
    ]);

    // Build a record with enough images to trigger the scroll fallback in
    // the browser. The number itself isn't load-bearing — the test just pins
    // the enhancement contract.
    $imageUris = array_fill(0, 20, 'https://example.test/iiif/abc/full/full/0/default.jpg');

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Ideas'],
            'dcidentifierimageUri' => $imageUris,
        ],
        'recordTitle' => 'Ideas',
        'recordDisplay' => ['Title'],
    ])->render();

    expect($html)
        // No-JS fallback: thumbnails are still emitted inline as a single
        // <ul> grid (no hidden offscreen list, no pagination).
        ->toContain('grid grid-cols-4 gap-3 sm:grid-cols-6')
        ->toContain('aria-label="All 20 images of this artwork"')
        // JS hook + CSS rule are both present so the enhancer can flip the
        // grid into a scroll panel without shipping more script.
        ->toContain('data-thumb-grid')
        ->toContain("classList.add('is-scrollable')")
        ->toContain('[data-thumb-grid].is-scrollable')
        ->toContain('max-height: 22rem');
});

it('hides Subject, Artist Biography, City and Country on the V2 record page (client allow-list)', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.authorfull.en',
            'Dates' => 'dc.coverage.temporal.en',
            'Format' => 'dc.format',
            'Format Extent' => 'dc.format.extent',
            'Description' => 'dc.description.en',
            'Subject' => 'dc.subject',
            'Artist Biography' => 'dc.contributor.authorbio.en',
            'City' => 'dc.coverage.spatialcity.en',
            'Country' => 'dc.coverage.spatialcountry.en',
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['Untitled (Rhino head)'],
            'dccontributorauthorfullen' => ['Helen Denerley'],
            'dccoveragetemporalen' => ['2009'],
            'dcformat' => ['scrap metal'],
            'dcformatextent' => ['life-size'],
            'dcdescriptionen' => ['A rhino sculpture welded from reclaimed steel.'],
            'dcsubject' => ['Animals; Sculpture'],
            'dccontributorauthorbioen' => ['Helen Denerley is a Scottish sculptor working with reclaimed metal.'],
            'dccoveragespatialcityen' => ['Edinburgh'],
            'dccoveragespatialcountryen' => ['Scotland'],
        ],
        'recordTitle' => 'Untitled (Rhino head)',
        'recordDisplay' => [
            'Title', 'Artist', 'Creator', 'Dates', 'City', 'Country',
            'Format', 'Format Extent', 'Description', 'Subject', 'Artist Biography',
        ],
    ])->render();

    expect($html)
        // Allow-list: Artist, Dates, Media, Dimensions, Description.
        ->toContain('>Artist<')
        ->toContain('>Dates<')
        ->toContain('>Media<')
        ->toContain('>Dimensions<')
        ->toContain('>Description<')
        ->toContain('Helen Denerley')
        ->toContain('A rhino sculpture welded from reclaimed steel.')
        // Hidden fields should not appear as <dt> labels OR as content.
        ->not->toContain('>Subject<')
        ->not->toContain('>Artist Biography<')
        ->not->toContain('>City<')
        ->not->toContain('>Country<')
        ->not->toContain('Animals; Sculpture')
        ->not->toContain('Helen Denerley is a Scottish sculptor')
        ->not->toContain('>Edinburgh<')
        ->not->toContain('>Scotland<');
});

it('uses the public Kaltura CDN url (not media.ed.ac.uk/embed/secure) for per-record videos', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.authorfull.en',
        ],
        // Mirror the config/collections/public-art.php map for this assertion.
        'skylight.public_art_videos' => [
            'ideas' => [
                'entry' => '1_lh3jbplo',
                'widget' => '1_65sjprmo',
                'widget_param' => 'wid',
                'uiconf' => '32599141',
                'use_flashvars' => true,
            ],
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => ['dctitleen' => ['Ideas']],
        'recordTitle' => 'Ideas',
        'recordDisplay' => ['Title'],
    ])->render();

    expect($html)
        ->toContain('cdnapisec.kaltura.com')
        ->toContain('uiconf_id/32599141')
        ->toContain('entry_id=1_lh3jbplo')
        ->toContain('wid=1_65sjprmo')
        ->not->toContain('widget_id=0_j4c8cidb')
        // The legacy gated proxy must not slip back in.
        ->not->toContain('media.ed.ac.uk/embed/secure/iframe');
});

it('uses the entry-specific Kaltura widget id for artist Public Art Shorts videos', function () {
    config([
        'skylight.public_art_skin_version' => 2,
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Image URI' => 'dc.identifier.imageUri',
            'Map Reference' => 'dc.coverage.spatial.coord.en',
            'Location' => 'dc.coverage.spatial.en',
            'Artist' => 'dc.contributor.authorfull.en',
        ],
        'skylight.public_art_videos' => [
            'the next big thing...is a series of little things' => [
                'entry' => '1_rs2vb5l9',
                'widget' => '1_4h6g4272',
            ],
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => ['dctitleen' => ['The Next Big Thing...is a Series of Little Things']],
        'recordTitle' => 'The Next Big Thing...is a Series of Little Things',
        'recordDisplay' => ['Title'],
    ])->render();

    expect($html)
        ->toContain('entry_id=1_rs2vb5l9')
        ->toContain('widget_id=1_4h6g4272')
        ->toContain('uiconf_id/40887822')
        ->not->toContain('wid=1_65sjprmo');
});

it('renders the per-record video beneath the description and above the Back to all artworks button', function () {
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
        'skylight.public_art_videos' => [
            'the basic material is not the word but the letter' => [
                'entry' => '0_tmmkjuz4',
                'widget' => '0_j4c8cidb',
            ],
        ],
    ]);

    $html = view('public-art-v2.record.show', [
        'record' => [
            'dctitleen' => ['The Basic Material is Not the Word but the Letter'],
            'dcdescriptionen' => ['About the work.'],
        ],
        'recordTitle' => 'The Basic Material is Not the Word but the Letter',
        'recordDisplay' => ['Title', 'Description'],
    ])->render();

    $descriptionPos = strpos($html, 'About the work.');
    $videoPos = strpos($html, 'entry_id=0_tmmkjuz4');
    $widgetPos = strpos($html, 'widget_id=0_j4c8cidb');
    $backBtnPos = strpos($html, 'Back to all artworks');

    expect($descriptionPos)->toBeInt()
        ->and($videoPos)->toBeInt()->toBeGreaterThan($descriptionPos)
        ->and($widgetPos)->toBeInt()->toBeGreaterThan($videoPos)
        ->and($backBtnPos)->toBeInt()->toBeGreaterThan($widgetPos);
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
        'base_search' => '/art-on-campus/search/*:*',
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

    $this->get('/art-on-campus')
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

    $response = $this->get('/art-on-campus/paolozzi')->assertSuccessful();

    $response
        // Renamed section headings.
        ->assertSee('Renovation plans')
        ->assertSee('Coming to Edinburgh')
        ->assertSee('A Rich Case Study and Future Steps')
        ->assertDontSee('Restoration plans')
        ->assertDontSee('Mosaic fragments')
        ->assertDontSee('Next stages')
        // Background paragraph: trimmed to the new short version.
        ->assertSee('Across two structures, there were six archways in total')
        ->assertDontSee('watch straps')
        ->assertDontSee('Egyptian panel')
        // Renovation plans: consolidated wording.
        ->assertSee('deemed unretainable by contractors and structural', false)
        ->assertSee('public and media opposed the removal of the arches')
        ->assertDontSee('Agreeing with contractors and structural engineers')
        ->assertDontSee('the public and media protested')
        // Coming to Edinburgh: rewritten opener, no February 2015 date.
        ->assertSee('TfL made contact with the University of Edinburgh')
        ->assertSee('Following discussions, in June 2015')
        ->assertSee('hundreds of fragments arrived in Edinburgh')
        ->assertDontSee('In February 2015 TfL')
        ->assertDontSee('over 600 fragments')
        ->assertDontSee('in the north at Edinburgh College of Art')
        // Conundrum: typo fix on "compiled" and unchanged %.
        ->assertSee('compiled data and images')
        ->assertDontSee('complied data and images')
        // Rev-2 amend: the entire body under "A Rich Case Study and Future
        // Steps" has been replaced with a single new paragraph from Olivia
        // Laumenech. The old "A Ghost Arch?" and "The Future" sub-sections
        // and the "two points of consensus" wording are gone.
        ->assertSee('rich case study for research and education')
        ->assertSee('Paolozzi at 100')
        ->assertSee('National Galleries of Scotland')
        ->assertSee('open to discussions about the future of the material')
        ->assertDontSee('two points of consensus were reached')
        ->assertDontSee('two options were identified for their future form')
        ->assertDontSee('A Ghost Arch?')
        ->assertDontSee('ghost arch would be inappropriate')
        ->assertDontSee('<h2>The Future</h2>', false)
        ->assertDontSee('met with the Paolozzi Foundation in October 2017')
        ->assertDontSee('a competition for artists')
        // Sanity carry-overs from the previous edit.
        ->assertSee('Scottish artist Eduardo Paolozzi', false)
        ->assertSee('Nonetheless, the arches were removed')
        ->assertDontSee('Unfortunately, the arches were removed')
        ->assertDontSee('John Bryden');
});

it('configures the public-art-overrides config file with labels and 26 browse entries', function () {
    $config = require config_path('public-art-overrides.php');

    expect($config['labels'])->toBe(['Format' => 'Media', 'Format Extent' => 'Dimensions'])
        ->and($config['browse_order'])->toHaveCount(27)
        ->and($config['browse_order'][0])->toBe('Ideas')
        ->and(end($config['browse_order']))->toBe('Startled Horse Rising')
        ->and($config)->not->toHaveKey('records');
});

it('maps Public Art record videos by lower-cased artwork title in collection config', function () {
    $config = require config_path('collections/public-art.php');

    expect($config)->toHaveKey('public_art_videos');

    expect($config['public_art_videos'])->toBe([
        'ideas' => [
            'entry' => '1_lh3jbplo',
            'widget' => '1_65sjprmo',
            'widget_param' => 'wid',
            'uiconf' => '32599141',
            'use_flashvars' => true,
        ],
        'the next big thing...is a series of little things' => [
            'entry' => '1_rs2vb5l9',
            'widget' => '1_4h6g4272',
        ],
        'the basic material is not the word but the letter' => [
            'entry' => '0_tmmkjuz4',
            'widget' => '0_j4c8cidb',
        ],
        'untitled (rhino head)' => [
            'entry' => '1_gzno6iwu',
            'widget' => '1_si1vukuv',
        ],
        'bite / haynes nano stage' => [
            'entry' => '1_1elsd561',
            'widget' => '1_v8wtxhzh',
        ],
    ]);

    // Keys are normalised the same way the record blade normalises lookup
    // keys: strtolower(trim(strip_tags($recordTitle))). Guard against a
    // contributor accidentally re-introducing mixed case or stray whitespace
    // here, which would silently break the lookup.
    foreach (array_keys($config['public_art_videos']) as $key) {
        expect($key)->toBe(strtolower(trim(strip_tags($key))));
    }
});

it('shows the Ideas spotlight image and credit line on the V2 home page', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertSee('collections/public-art/images/spotlight/ideas-2021-john-mckenzie.jpg', false)
        ->assertSee('Photography by John McKenzie')
        ->assertSee('Micro water-jet cut stainless steel');
});

it('shows the Edinburgh Runestone block in the More Information section on the V2 home page', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertSee('Edinburgh Runestone')
        ->assertSee('on loan courtesy of National Museums Scotland')
        ->assertDontSee('on loan from National Museum of Scotland')
        ->assertSee('https://www.ssns.org.uk/news/update-on-the-edinburgh-runestone/', false)
        ->assertSee('https://www.socantscot.org/wp-content/uploads/2018/04/Runestone-0703-FINAL-web.pdf', false);
});

it('shows the Public Art Shorts and Podcast links above the Runestone block on the V2 home page', function () {
    config(['skylight.public_art_skin_version' => 2]);

    // Client request (May 2026): keep the two links present in the V2 reskin
    // and point them at the latest destinations supplied by the collection.
    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertSee('Public Art Shorts')
        ->assertSee('The Collection: Public Art Podcast')
        ->assertSee('media.ed.ac.uk/search?fields=tags&keyword=%22public%20art%20shorts%22', false)
        ->assertSee('media.ed.ac.uk/channel/The+Collection%3A+Public+Art+Podcast+-+Apple+Podcasts/95117231', false);
});

it('shows the Heritage Collections / CRC block and contact address on the V2 home page', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertSee('Heritage Collections and Centre for Research Collections')
        ->assertSee('https://library.ed.ac.uk/heritage-collections', false)
        ->assertSee('Centre for Research Collections')
        ->assertSee('EH8 9LJ')
        ->assertSee('+44 (0)131 650 8379')
        ->assertSee('HeritageCollections@ed.ac.uk', false);
});

it('no longer renders the student-intern footnote on the V2 home page', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/art-on-campus')
        ->assertSuccessful()
        ->assertDontSee('created by a student intern')
        ->assertDontSee('ISG Innovation Grant');
});

it('serves the new Cast Collections page with the supplied client copy and external links', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $this->get('/art-on-campus/cast-collections')
        ->assertSuccessful()
        ->assertSee('University Cast Collections')
        // Lead-paragraph phrases (split because the Blade wraps prose across
        // lines, so a single long substring won't match contiguously).
        ->assertSee('most significant')
        ->assertSee('historic plaster casts')
        ->assertSee('Parthenon frieze')
        // Brochure (Cast Collection PDF on era.ed.ac.uk).
        ->assertSee('Cast Collection brochure (PDF)')
        ->assertSee('era.ed.ac.uk/server/api/core/bitstreams/c0c13972-6155-499b-a9fb-8d55768092eb/content', false)
        // Past Projects block and the live cast-collection blog link.
        ->assertSee('More information: Past Projects', false)
        ->assertSee('the Edinburgh Cast Collection project site')
        ->assertSee('https://blogs.ed.ac.uk/casts/the-collection/', false)
        // Client-supplied image, served from the public/collections asset path.
        ->assertSee('collections/public-art/images/cast-collections/east-pediment-cast.jpg', false);
});

it('serves the Old College Artworks page with the supplied client copy and images', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/art-on-campus/old-college')
        ->assertSuccessful()
        ->assertSee('<h1 class="mt-2 text-4xl font-semibold tracking-tight text-pa-ink-900 sm:text-5xl">Old College Artworks</h1>', false)
        ->assertSee('<title>Old College Artworks | Art on Campus</title>', false)
        ->assertSee('Old College Heritage and Values Project (2023&ndash;ongoing)', false)
        ->assertSeeInOrder(['between the seventeenth and', 'twentieth centuries'])
        ->assertDontSee('seventeenth to the twentieth centuries')
        ->assertSee('July 2025')
        ->assertSee('colonialism, enslavement and empire')
        ->assertSee('<h2>Access</h2>', false)
        ->assertDontSee('Note on access')
        ->assertSee('https://library.ed.ac.uk/heritage-collections/old-college-artwork', false)
        ->assertSee('collections/public-art/images/old-college/main-stairway-milenka-soskin.png', false)
        ->assertSee('collections/public-art/images/old-college/main-stairway-chris-close.jpg', false)
        ->assertSee('collections/public-art/images/old-college/raeburn-room-milenka-soskin.jpeg', false)
        ->assertSee('collections/public-art/images/old-college/lee-elder-rooms-milenka-soskin.png', false)
        ->assertSee('Architectural drawing of Main Stairway by Milenka Soskin')
        ->assertSee('Photography: Chris Close')
        ->assertSee('Architectural drawing of Raeburn Room by Milenka Soskin')
        ->assertSee('Architectural drawings of Lee and Elder Rooms by Milenka Soskin');

    // After the client edit, the Chris Close photo of the main-stairway hang
    // appears before the Milenka Soskin architectural drawing of the same
    // space.
    $html = $response->getContent();
    expect(strpos($html, 'main-stairway-chris-close.jpg'))
        ->toBeLessThan(strpos($html, 'main-stairway-milenka-soskin.png'));
});

it('lists Old College in the V2 primary nav and footer Explore section', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/art-on-campus')->assertSuccessful();
    $html = $response->getContent();

    expect(substr_count($html, '/art-on-campus/old-college'))->toBeGreaterThanOrEqual(2)
        ->and(substr_count($html, 'Old College'))->toBeGreaterThanOrEqual(2);
});

it('lists Cast Collections in the V2 primary nav and footer Explore section', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/art-on-campus')->assertSuccessful();
    $html = $response->getContent();

    // Two link instances expected: one in the primary nav, one in the footer
    // Explore list. Both href and visible label should round-trip.
    expect(substr_count($html, '/art-on-campus/cast-collections'))->toBeGreaterThanOrEqual(2)
        ->and(substr_count($html, 'Cast Collections'))->toBeGreaterThanOrEqual(2);
});

it('shows the renamed Paolozzi nav label and the new University Art Collection link in the V2 layout', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/art-on-campus')->assertSuccessful();

    $response
        ->assertSee('Paolozzi Mosaics')
        ->assertSee('University Art Collection')
        ->assertSee('href="'.url('/art').'"', false)
        ->assertDontSee('Paolozzi Project')
        ->assertDontSee('Paolozzi Mosaic Project');
});

it('drops the standalone About entry from the V2 primary nav', function () {
    config(['skylight.public_art_skin_version' => 2]);

    $response = $this->get('/art-on-campus')->assertSuccessful();

    expect($response->getContent())
        ->not->toContain('href="'.url('/art-on-campus/about').'"');
});

it('renders the All Collections utility bar on the /art page header', function () {
    $response = $this->get('/art')->assertSuccessful();

    $response
        ->assertSee('All Collections')
        ->assertSee('https://collections.ed.ac.uk', false)
        ->assertSee('https://www.ed.ac.uk', false);
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
