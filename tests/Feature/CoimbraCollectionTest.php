<?php

it('renders the coimbra exhibition accessibility statement as a standalone Viki-template page', function (): void {
    $html = view('coimbra.pages.accessibility')->render();

    expect($html)
        // Collection-specific title and dates from the client-supplied source.
        ->toContain('Coimbra Exhibition website')
        ->and($html)->toContain('27th October 2025')
        ->and($html)->toContain('2nd October 2025')
        ->and($html)->toContain('Change Log')
        ->and($html)->toContain('Interactive maps')
        // Standalone Viki template typography.
        ->and($html)->toContain('color: #2f5496')
        ->and($html)->toContain('#0563c1')
        // Did not fall through to the generic /accessibility statement.
        ->and($html)->not->toContain('Accessibility statement for <a href="https://collections.ed.ac.uk/">Collections</a>')
        // Word template scaffolding stripped.
        ->and($html)->not->toContain('FIRST_STATEMENT_DATE')
        ->and($html)->not->toContain('rgb(0,120,0)')
        // No collection layout was pulled in.
        ->and($html)->not->toContain('coimbra-cf');
});

it('serves the coimbra exhibition accessibility route as a standalone page', function (): void {
    $response = $this->get('/coimbra/accessibility');

    $response->assertSuccessful();

    $html = $response->getContent();

    expect($html)
        ->toContain('Coimbra Exhibition website')
        ->and($html)->toContain('2nd October 2025')
        // No coimbra nav, footer or theme markup should appear on this page.
        ->and($html)->not->toContain('Coimbra Group')
        ->and($html)->not->toContain('Hosted by The University of Edinburgh');
});

it('points the coimbra footer accessibility link at the absolute collection URL', function (): void {
    $html = view('layouts.coimbra', ['page_title' => 'Test'])->render();

    expect($html)
        ->toContain('href="'.url('/coimbra/accessibility').'"')
        ->and($html)->not->toContain('href="./accessibility"');
});
