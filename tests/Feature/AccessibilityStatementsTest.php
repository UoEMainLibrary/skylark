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
    'jlss' => ['/jlss/accessibility', ['Scottish Jewish Archives Centre (SJAC) Digital Collection', 'prepared on 15 September 2021']],
]);

it('renders the sjac statement from the test-deployment branch wording', function (): void {
    $this->get('/jlss/accessibility')
        ->assertSuccessful()
        ->assertSee('July 2022 at the latest', false)
        ->assertSee('prepared on 15 September 2021', false);
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
]);
