<?php

it('links to the Art on Campus collection from the /art primary navigation', function (): void {
    $html = view('art.pages.licensing')->render();

    expect($html)
        ->toContain('href="'.url('/art-on-campus').'"')
        ->and($html)->toContain('>Art on Campus<');
});
