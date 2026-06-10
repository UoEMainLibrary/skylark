<?php

it('rewrites kids activity audio through the bitstream proxy when enabled', function (): void {
    config([
        'services.dspace.rewrite_bitstream_urls' => true,
        'app.url' => 'https://collections.is.ed.ac.uk',
    ]);

    $legacyHtml = view('eerc.pages.kids_only')->render();
    $v2Html = view('eerc-v2.pages.kids_only')->render();

    $proxied = 'https://collections.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/farming_compilation_DG5-1-1-1_and_DG38-9-1-1.mp3';

    expect($legacyHtml)
        ->toContain($proxied)
        ->and($legacyHtml)->not->toContain('digitalpreservation.is.ed.ac.uk');

    expect($v2Html)
        ->toContain($proxied)
        ->and($v2Html)->not->toContain('digitalpreservation.is.ed.ac.uk');
});

it('keeps digital preservation audio URLs when rewrite is disabled', function (): void {
    config(['services.dspace.rewrite_bitstream_urls' => false]);

    $legacyHtml = view('eerc.pages.kids_only')->render();
    $v2Html = view('eerc-v2.pages.kids_only')->render();

    $source = 'https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/farming_compilation_DG5-1-1-1_and_DG38-9-1-1.mp3';

    expect($legacyHtml)->toContain($source)
        ->and($v2Html)->toContain($source);
});

it('uses root-relative worksheet links on eerc kids v2 page', function (): void {
    $v2Html = view('eerc-v2.pages.kids_only')->render();

    expect($v2Html)
        ->toContain('href="/collections/eerc/images/kids_only_pdfs/Farming.pdf"')
        ->and($v2Html)->toContain('href="/collections/eerc/images/kids_only_pdfs/School%20dinners.pdf"')
        ->and($v2Html)->not->toContain('https://test.skylark.is.ed.ac.uk/collections/eerc/images/kids_only_pdfs/');
});
