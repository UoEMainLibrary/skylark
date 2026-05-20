<?php

beforeEach(function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.creator.en',
            'Type' => 'dc.type.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
            'Date' => 'dc.date.issued',
        ],
        'skylight.filters' => [
            'Department' => 'creator_filter',
            'Subject' => 'subject_filter',
        ],
    ]);
});

it('renders the SOPA intro paragraph on the Physics home page', function (): void {
    $html = view('physics.home', ['docs' => []])->render();

    expect($html)
        ->toContain('This collection is intended primarily for University use.')
        ->and($html)->toContain('use your University email address')
        // Empty docs → no recent-items strip rendered.
        ->and($html)->not->toContain('Recently added items');
});

it('renders the Recently added items list on the Physics home page', function (): void {
    $html = view('physics.home', [
        'docs' => [
            [
                'id' => '102876',
                'dctitleen' => ['Royal Observatory Edinburgh'],
                'dccreatoren' => ['Physics and Astronomy'],
            ],
            [
                'id' => '102020',
                'dctitleen' => ['Charles Barkla Plaque'],
                'dccreatoren' => ['Physics and Astronomy'],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('<h3>Recently added items</h3>')
        ->and($html)->toContain('<ul class="listing">')
        ->and($html)->toContain('href="./record/102876"')
        ->and($html)->toContain('Royal Observatory Edinburgh')
        ->and($html)->toContain('Charles Barkla Plaque')
        ->and($html)->toContain('Author:"Physics+and+Astronomy"')
        ->and($html)->toContain('class="first"')
        ->and($html)->toContain('class="last"');
});

it('renders the Related Items sidebar on the Physics record page with the legacy date tag', function (): void {
    $html = view('physics.record.show', [
        'record' => [
            'dctitleen' => ['Royal Observatory Edinburgh'],
        ],
        'recordTitle' => 'Royal Observatory Edinburgh',
        'recordDisplay' => [],
        'descriptionDisplay' => [],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
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
        'bitstreams' => [],
        'relatedItems' => [
            [
                'id' => '7422',
                'dctitleen' => ['Royal Observatory Edinburgh logo'],
                'dctypeen' => ['Image'],
                'dcdateissued' => ['2011-08-03'],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('<h4>Related Items</h4>')
        ->and($html)->toContain('<ul class="related">')
        ->and($html)->toContain('href="./record/7422"')
        ->and($html)->toContain('Royal Observatory Edinburgh logo')
        ->and($html)->toContain('(2011-08-03)')
        ->and($html)->toContain('small-icon media-image');
});

it('falls back to facets in the sidebar when no related items are passed', function (): void {
    $html = view('physics.record.show', [
        'record' => ['dctitleen' => ['Test SOPA record']],
        'recordTitle' => 'Test SOPA record',
        'recordDisplay' => [],
        'descriptionDisplay' => [],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => array_keys(config('skylight.filters', [])),
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
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)->not->toContain('<h4>Related Items</h4>');
});

it('renders the physics accessibility statement under the physics layout', function (): void {
    $html = view('physics.pages.accessibility')->render();

    expect($html)
        ->toContain('Accessibility')
        ->and($html)->toContain('School of Physics and Astronomy Image Archive (SOPA)')
        ->and($html)->toContain('https://www.w3.org/TR/WCAG22/#audio-description-prerecorded')
        // Confirm the broken legacy Outlook-cache link did not slip through.
        ->and($html)->not->toContain('vgalt/AppData/Local/Microsoft')
        // Confirm we did not nest <html>/<head>/<body> tags inside the layout body.
        ->and($html)->not->toContain('<body lang=EN-US');
});

it('uses the correct jquery-ui asset path in the physics layout', function (): void {
    $html = view('physics.pages.about')->render();

    expect($html)
        ->toContain('/assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js')
        ->and($html)->not->toContain('/ssets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js');
});

it('points the physics header logo at the collection root, not /physics/home', function (): void {
    $html = view('physics.pages.about')->render();

    expect($html)
        ->not->toContain('href="'.url('/physics/home').'"')
        ->and($html)->toContain('href="'.url('/physics').'"');
});

it('renders a <base href> pointing at the collection root so relative links resolve', function (): void {
    config([
        'app.collection_path_prefix' => '/physics',
        'skylight.url_prefix' => 'physics',
    ]);

    $html = view('physics.pages.about')->render();

    expect($html)->toContain('<base href="'.url('/physics').'/">');
});

it('serves the physics home page at /physics', function (): void {
    $this->get('/physics')->assertSuccessful();
});

it('serves the advanced search form at /physics/advanced/form', function (): void {
    $this->get('/physics/advanced/form')
        ->assertSuccessful()
        ->assertSee('Advanced Search', false)
        ->assertSee('action="'.url('/physics/advanced/post').'"', false)
        ->assertSee('name="Title"', false)
        ->assertSee('name="Author"', false)
        ->assertSee('name="operator"', false);
});

it('serves the physics home page at / on a configured dedicated host', function (): void {
    $this->withHeaders(['Host' => 'sopacollection.testing'])
        ->get('/')
        ->assertSuccessful();
});

it('loads SOPA-specific skylight config when /physics is requested', function (): void {
    $this->get('/physics')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('physics')
        ->and(config('skylight.fullname'))->toBe('School of Physics and Astronomy Image Archive')
        ->and(config('skylight.theme'))->toBe('physics')
        ->and(config('skylight.container_id'))->toBe(env('PHYSICS_CONTAINER_ID', 'df0d9c26-2b73-4cce-8ed7-d047b1a0884e'))
        ->and(config('skylight.oaipmhcollection'))->toBe('hdl_10683_8');
});
