<?php

it('uses live digital preservation audio URLs on eerc kids pages', function (): void {
    $legacyHtml = view('eerc.pages.kids_only')->render();
    $v2Html = view('eerc-v2.pages.kids_only')->render();

    expect($legacyHtml)
        ->toContain('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/farming_compilation_DG5-1-1-1_and_DG38-9-1-1.mp3')
        ->and($legacyHtml)->not->toContain('test.collections')
        ->and($legacyHtml)->not->toContain('.test/bitstream');

    expect($v2Html)
        ->toContain('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57057/farming_compilation_DG5-1-1-1_and_DG38-9-1-1.mp3')
        ->and($v2Html)->not->toContain('test.collections')
        ->and($v2Html)->not->toContain('.test/bitstream');
});

it('uses root-relative worksheet links on eerc kids v2 page', function (): void {
    $v2Html = view('eerc-v2.pages.kids_only')->render();

    expect($v2Html)
        ->toContain('href="/collections/eerc/images/kids_only_pdfs/Farming.pdf"')
        ->and($v2Html)->toContain('href="/collections/eerc/images/kids_only_pdfs/School%20dinners.pdf"')
        ->and($v2Html)->not->toContain('https://test.skylark.is.ed.ac.uk/collections/eerc/images/kids_only_pdfs/');
});
