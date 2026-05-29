<?php

it('renders geddes search title using mapped solr fields', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Identifier' => 'dc.identifier.en',
            'ImageUri' => 'dc.identifier.imageUri.en',
        ],
        'skylight.searchresult_display' => ['Title', 'Identifier'],
    ]);

    $html = view('geddes.search.results', [
        'total' => 1,
        'docs' => [[
            'id' => '12345',
            'dctitleen' => ['Expected Geddes Title'],
            'dcidentifieren' => ['GB 123 Ref 42'],
        ]],
        'paginationLinks' => '',
        'facets' => [],
    ])->render();

    expect($html)->toContain('Expected Geddes Title')
        ->and($html)->toContain('GB 123 Ref 42')
        ->and($html)->not->toContain('Untitled');
});

it('falls back to identifier when geddes search title is missing', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Identifier' => 'dc.identifier.en',
        ],
        'skylight.searchresult_display' => ['Title', 'Identifier'],
    ]);

    $html = view('geddes.search.results', [
        'total' => 1,
        'docs' => [[
            'id' => '99999',
            'dcidentifieren' => ['GB 237 Fallback Ref'],
        ]],
        'paginationLinks' => '',
        'facets' => [],
    ])->render();

    expect($html)->toContain('GB 237 Fallback Ref')
        ->and($html)->not->toContain('Untitled');
});

it('renders clickable geddes sidebar facet links', function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
        ],
        'skylight.searchresult_display' => ['Title'],
    ]);

    $html = view('geddes.search.results', [
        'total' => 1,
        'docs' => [[
            'id' => '12345',
            'dctitleen' => ['Expected Geddes Title'],
        ]],
        'paginationLinks' => '',
        'facets' => [[
            'name' => 'Author',
            'terms' => [[
                'name' => "dykes, robert\n|||\nDykes, Robert",
                'display_name' => 'Dykes, Robert',
                'count' => 7,
            ]],
        ]],
        'base_search' => 'http://skylark.test/geddes/search/*:*',
        'base_parameters' => '',
    ])->render();

    expect($html)
        ->toContain('href="http://skylark.test/geddes/search/*:*/Author:%22dykes%2C+robert+%7C%7C%7C+Dykes%2C+Robert%22"')
        ->and($html)->toContain('Dykes, Robert');
});

it('renders geddes record metadata using configured field mappings', function (): void {
    $fieldMappings = [
        'Title' => 'dc.title.en',
        'Identifier' => 'dc.identifier.en',
        'Link' => 'dc.identifier.uri.en',
        'ImageUri' => 'dc.identifier.imageUri.en',
    ];

    $html = view('geddes.record.show', [
        'recordTitle' => 'Expected Geddes Record Title',
        'record' => [
            'dctitleen' => ['Expected Geddes Record Title'],
            'dcidentifieren' => ['GB 123 Ref 42'],
            'dcidentifierurien' => ['https://example.test/catalogue'],
            'dcidentifierimageUrien' => ['https://images.example.test/item.jpg'],
        ],
        'recordDisplay' => ['Title', 'Identifier'],
        'fieldMappings' => $fieldMappings,
    ])->render();

    expect($html)->toContain('Expected Geddes Record Title')
        ->and($html)->toContain('GB 123 Ref 42')
        ->and($html)->toContain('More information');
});

it('falls back to identifier when geddes record title is missing', function (): void {
    $fieldMappings = [
        'Title' => 'dc.title.en',
        'Identifier' => 'dc.identifier.en',
    ];

    $html = view('geddes.record.show', [
        'recordTitle' => 'Untitled',
        'record' => [
            'dcidentifieren' => ['GB 237 Fallback Ref'],
        ],
        'recordDisplay' => ['Identifier'],
        'fieldMappings' => $fieldMappings,
    ])->render();

    expect($html)->toContain('GB 237 Fallback Ref');
});
