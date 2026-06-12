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
