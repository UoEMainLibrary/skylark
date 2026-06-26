<?php

it('renders the full legacy accessibility statement for each collection', function (string $path, array $needles): void {
    $response = $this->get($path)->assertSuccessful();

    foreach ($needles as $needle) {
        $response->assertSee($needle, false);
    }
})->with([
    'clds hub' => ['/accessibility', ['statement for', 'https://collections.ed.ac.uk/', 'Preparation of this accessibility statement']],
    'art' => ['/art/accessibility', ['University of Edinburgh Art Collection Website', 'Preparation of this accessibility statement']],
    'openbooks' => ['/openbooks/accessibility', ['Open Books website', 'Preparation of this accessibility statement']],
    'cockburn' => ['/cockburn/accessibility', ['Cockburn Geological Collection Website', 'Preparation of this accessibility statement']],
    'pointsofarrival' => ['/pointsofarrival/accessibility', ['Points of Arrival website', 'Preparation of this accessibility statement']],
    'jlss' => ['/jlss/accessibility', ['Scottish Jewish Archives Centre (SJAC) Digital Collection', 'Preparation of this accessibility statement', '14 March 2024', 'WCAG 2.2']],
    'alumni' => ['/alumni/accessibility', ['Historical Alumni', 'Preparation of this accessibility statement']],
    'guardbook' => ['/guardbook/accessibility', ['Guardbook', 'Preparation of this accessibility statement']],
]);

it('renders the sjac accessibility statement from the March 2024 document', function (): void {
    $this->get('/jlss/accessibility')
        ->assertSuccessful()
        ->assertSee('last reviewed on 14 March 2024', false)
        ->assertSee('Web Content Accessibility Guidelines (WCAG) 2.2 AA standard', false)
        ->assertSee('February 2025', false)
        ->assertSee('info@sjac.org.uk', false)
        ->assertSee('Magnify content to 500%', false)
        ->assertDontSee('July 2022 at the latest', false)
        ->assertDontSee('Security of and Access to Your Personal Data', false)
        ->assertDontSee('Web Content Accessibility Guidelines version 2.1', false);
});

it('does not show the generic collections stub on collection accessibility pages', function (string $path): void {
    $this->get($path)
        ->assertSuccessful()
        ->assertDontSee('We aim to make this site as accessible as possible', false);
})->with([
    '/art/accessibility',
    '/openbooks/accessibility',
    '/cockburn/accessibility',
    '/pointsofarrival/accessibility',
    '/alumni/accessibility',
    '/guardbook/accessibility',
]);
