<?php

it('renders the mimed accessibility statement as a standalone Viki-template page', function (): void {
    $html = view('mimed.pages.accessibility')->render();

    expect($html)
        ->toContain('Musical Instruments Museums Edinburgh website')
        // Sections that the previous truncated view omitted.
        ->and($html)->toContain('Contacting us by phone using British Sign Language')
        ->and($html)->toContain('Non accessible content')
        ->and($html)->toContain('Noncompliance with the accessibility regulations')
        ->and($html)->toContain('Disproportionate burden')
        ->and($html)->toContain('Change Log')
        ->and($html)->toContain('Reporting an accessibility problem on a public sector website')
        // Dates from the client-supplied docx (20.08.24 FINAL).
        ->and($html)->toContain('19th August 2024')
        ->and($html)->toContain('13th August 2024')
        // Standalone Viki template typography.
        ->and($html)->toContain('color: #2f5496')
        ->and($html)->toContain('#0563c1')
        // Did not fall through to the generic Collections statement.
        ->and($html)->not->toContain('Accessibility statement for <a href="https://collections.ed.ac.uk/">Collections</a>')
        // No mimed collection layout was pulled in.
        ->and($html)->not->toContain('/collections/mimed/');
});

it('serves the mimed accessibility route as a standalone page', function (): void {
    $response = $this->get('/mimed/accessibility');

    $response->assertSuccessful();

    $html = $response->getContent();

    expect($html)
        ->toContain('Musical Instruments Museums Edinburgh website')
        ->and($html)->toContain('Change Log')
        // Should not include the mimed site header or navigation.
        ->and($html)->not->toContain('Search MIMEd')
        ->and($html)->not->toContain('/mimed/about');
});

it('leads with catalogue search and links to its featured instruments and St Cecilia’s Hall', function (): void {
    $this->get('/mimed')->assertSuccessful()
        ->assertSeeInOrder(['Search the catalogue', 'Featured instruments', 'About this collection'])
        ->assertSee(route('mimed.search.redirect'))
        ->assertSee(route('mimed.record.show', ['id' => 16327]))
        ->assertSee(route('stcecilias.home'))
        ->assertSee('reopened in 2017')
        ->assertSee('Musical Instrument Collection')
        ->assertSee('university-logo.png')
        ->assertSee('library-branding-baton.png')
        ->assertSee('Research')
        ->assertDontSee('the two collections will be brought together');
});

it('renders the catalogue results and keeps the existing record and pagination URLs', function (): void {
    config(['skylight.field_mappings' => ['Title' => 'dc.title', 'ImageUri' => 'dc.image']]);

    $html = view('mimed.search.results', [
        'query' => 'harpsichord',
        'total' => 15,
        'startRow' => 1,
        'endRow' => 10,
        'docs' => [['id' => '16327', 'dctitle' => ['Triple-manual harpsichord'], 'dcimage' => ['https://images.is.ed.ac.uk/luna/example.jpg']]],
        'base_search' => url('/mimed/search/harpsichord'),
        'base_parameters' => '',
        'paginationLinks' => '<a href="/mimed/search/harpsichord?offset=10">2</a>',
    ])->render();

    expect($html)->toContain('Triple-manual harpsichord', '/mimed/record/16327?highlight=harpsichord', '?offset=10', 'Enlarge image of');
});

it('links the IIIF logo to the instrument manifest', function (): void {
    $html = view('mimed.record.show', [
        'recordTitle' => 'Harpsichord',
        'fieldMappings' => ['ImageUri' => 'image', 'Bitstream' => 'bitstream'],
        'record' => ['image' => ['image.jpg'], 'bitstream' => ['file##manifest.json##description##10683/16327##1']],
        'recordDisplay' => [],
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)->toContain('href="'.url('/mimed/record/16327/1/manifest.json').'" aria-label="IIIF manifest"')
        ->toContain('collections/mimed/images/iiiflogo.png', 'alt="IIIF manifest"', 'images/uv.png', 'images/mirador-logo.png', 'images/LUNAIIIF.png', 'images/cc-by.png');
});

it('serves the supporting pages in the catalogue design', function (string $page): void {
    $this->get('/mimed/'.$page)->assertSuccessful()
        ->assertSee('class="mimed-catalogue"', false)
        ->assertSee('aria-label="Collection information"', false)
        ->assertDontSee('collections/mimed/css/style.css');
})->with(['about', 'iiif', 'feedback', 'licensing', 'takedown']);

it('keeps shared IIIF information routes in their own collection layouts', function (string $collection): void {
    $response = $this->get('/'.$collection.'/iiif')->assertSuccessful()
        ->assertViewIs($collection.'.pages.iiif')
        ->assertSee('International Image Interoperability Framework');

    if ($collection === 'mimed') {
        $response->assertSee('class="mimed-catalogue"', false);
    } else {
        $response->assertDontSee('class="mimed-catalogue"', false)
            ->assertDontSee('collections/mimed/css/catalogue.css');
    }
})->with(['mimed', 'cockburn', 'guardbook']);
