<?php

it('renders the corrected Visit Us and Participate tile URLs on the home page', function (): void {
    $html = view('clds.home')->render();

    expect($html)
        ->toContain('https://library.ed.ac.uk/heritage-collections/')
        ->and($html)->toContain('https://www.stcecilias.ed.ac.uk/')
        ->and($html)->toContain('https://www.trg.ed.ac.uk/')
        ->and($html)->toContain('https://biomedical-sciences.ed.ac.uk/anatomy/visit-anatomical-museum')
        ->and($html)->toContain('https://library.ed.ac.uk/heritage-collections/collections-and-search/archives/school-scottish-studies-archives')
        ->and($html)->toContain('https://library.ed.ac.uk/heritage-collections/collections-and-search/archives/new-college-library-archive-collections')
        ->and($html)->toContain('https://www.ed.ac.uk/visit/museums-galleries/geology')
        ->and($html)->toContain('https://library.ed.ac.uk/heritage-collections/skills-volunteers-interns-fellowships/volunteers-interns');
});

it('does not link to the retired tile URLs on the home page', function (): void {
    $html = view('clds.home')->render();

    expect($html)
        ->not->toContain('https://www.ed.ac.uk/information-services/library-museum-gallery/crc"')
        ->and($html)->not->toContain('http://www.stcecilias.ed.ac.uk')
        ->and($html)->not->toContain('https://www.ed.ac.uk/talbot-rice/')
        ->and($html)->not->toContain('https://www.ed.ac.uk/biomedical-sciences/anatomy/visit-anatomical-museum')
        ->and($html)->not->toContain('https://collections.ed.ac.uk/participate')
        ->and($html)->not->toContain('https://www.ed.ac.uk/geosciences/about/history/museum')
        ->and($html)->not->toContain('https://www.ed.ac.uk/information-services/library-museum-gallery/heritage-collections/skills-volunteers-interns-fellowships/volunteers-interns');
});

it('renders the rewritten Mahabharata page body and keeps the IIIF viewer', function (): void {
    $response = $this->get('/mahabharata');

    $response->assertOk();
    $html = $response->getContent();

    expect($html)
        ->toContain('One of the Iconic items in our Collection, this beautiful scroll')
        ->and($html)->toContain('Cultural Heritage Digitisation Service blog')
        ->and($html)->toContain('https://libraryblogs.is.ed.ac.uk/diu/2018/06/22/a-stitch-in-time-mahabharata-delivered-online/')
        ->and($html)->toContain('librarylabs.ed.ac.uk/iiif/uv/?manifest=https://librarylabs.ed.ac.uk/iiif/manifest/mahabharataFinal.json')
        ->and($html)->not->toContain('Digitisation of the Mahabharata Scroll')
        ->and($html)->not->toContain('Conservator Emily Hick had to stabilise');
});
