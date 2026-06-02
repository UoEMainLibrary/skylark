<?php

it('renders jlss search results using mapped title and date fields', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Accession Number' => 'dc.identifier.en',
            'Date' => 'dc.date.created.en',
            'ItemImage' => 'dc.format.bitstream.en',
        ],
        'skylight.searchresult_display' => ['Title', 'Date'],
        'skylight.image_server' => 'https://cantaloupe.example.test',
    ]);

    $html = view('jlss.search.results', [
        'total' => 1,
        'docs' => [[
            'id' => '111152',
            'dctitleen' => ['Poster - Flight Into Egypt'],
            'dcidentifieren' => ['CUL.AGP0010'],
            'dcdatecreateden' => ['1960'],
            'dcformatbitstreamen' => ['identifier-for-image'],
        ]],
        'paginationLinks' => '',
        'facets' => [],
    ])->render();

    expect($html)->toContain('Poster - Flight Into Egypt')
        ->and($html)->toContain('(1960)')
        ->and($html)->not->toContain('Untitled');
});

it('falls back to accession number when jlss title is missing', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Accession Number' => 'dc.identifier.en',
            'Date' => 'dc.date.created.en',
        ],
        'skylight.searchresult_display' => ['Title'],
    ]);

    $html = view('jlss.search.results', [
        'total' => 1,
        'docs' => [[
            'id' => '111152',
            'dcidentifieren' => ['CUL.AGP0010'],
        ]],
        'paginationLinks' => '',
        'facets' => [],
    ])->render();

    expect($html)->toContain('CUL.AGP0010')
        ->and($html)->not->toContain('Untitled');
});

it('renders jlss record metadata using configured field mappings', function (): void {
    $fieldMappings = [
        'Title' => 'dc.title.en',
        'Accession Number' => 'dc.identifier.en',
        'Description' => 'dc.description.en',
        'ItemImage' => 'dc.format.bitstream.en',
    ];

    $html = view('jlss.record.show', [
        'recordTitle' => 'Poster - Flight Into Egypt',
        'record' => [
            'dctitleen' => ['Poster - Flight Into Egypt'],
            'dcidentifieren' => ['CUL.AGP0010'],
            'dcdescriptionen' => ['Catalogue description here'],
            'dcformatbitstreamen' => ['identifier-for-image'],
        ],
        'recordDisplay' => ['Title', 'Accession Number', 'Description'],
        'fieldMappings' => $fieldMappings,
        'relatedItems' => [[
            'id' => '111200',
            'dctitleen' => ['Related poster title'],
        ]],
    ])->render();

    expect($html)->toContain('Poster - Flight Into Egypt')
        ->and($html)->toContain('CUL.AGP0010')
        ->and($html)->toContain('Catalogue description here')
        ->and($html)->toContain('Related Items')
        ->and($html)->toContain('Related poster title')
        ->and($html)->toContain('/jlss/search');
});
