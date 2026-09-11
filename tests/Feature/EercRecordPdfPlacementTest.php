<?php

use Illuminate\Support\Facades\Http;

it('links paired eerc jpgs to their matching pdfs and hides those pdfs from transcripts', function (): void {
    $this->withoutVite();

    config([
        'skylight.solr_base' => 'https://solr.example/',
        'skylight.solr_core' => 'archivesspace',
    ]);

    Http::fake([
        '*' => Http::sequence()
            ->push([
                'response' => [
                    'docs' => [[
                        'json' => json_encode([
                            'title' => 'EL35-1-5-1.jpg',
                            'file_versions' => [[
                                'file_uri' => 'https://files.example/EL35-1-5-1.jpg',
                            ]],
                        ]),
                    ]],
                ],
            ], 200)
            ->push([
                'response' => [
                    'docs' => [[
                        'json' => json_encode([
                            'title' => 'EL35-1-5-1.pdf',
                            'file_versions' => [[
                                'file_uri' => 'https://files.example/EL35-1-5-1-Publications-relating-to-Bruntons.pdf',
                            ]],
                        ]),
                    ]],
                ],
            ], 200),
    ]);

    $html = view('eerc-v2.record.show', [
        'record' => [
            'Title' => 'EL35/1 Denis Bell',
            'Identifier' => ['EL35-1-5-1'],
            'Audio links and images' => ['digital-object-1', 'digital-object-2'],
        ],
        'recordTitle' => 'EL35/1 Denis Bell',
        'recordDisplay' => ['Identifier', 'Audio links and images'],
        'fieldMappings' => [],
        'filters' => [],
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)
        ->toContain('PDF links')
        ->toContain('href="https://files.example/EL35-1-5-1-Publications-relating-to-Bruntons.pdf"')
        ->and($html)->toContain('src="https://files.example/EL35-1-5-1.jpg"')
        ->and($html)->toContain('title="Photograph EL35-1-5-1"')
        ->and($html)->not->toContain('>Transcript</th>');
});

it('keeps non-exception eerc record pdfs in the transcript section', function (): void {
    $this->withoutVite();

    config([
        'skylight.solr_base' => 'https://solr.example/',
        'skylight.solr_core' => 'archivesspace',
    ]);

    Http::fake([
        '*' => Http::response([
            'response' => [
                'docs' => [[
                    'json' => json_encode([
                        'title' => 'AB1-1-1-general-transcript.pdf',
                        'file_versions' => [[
                            'file_uri' => 'https://files.example/AB1-1-1-general-transcript.pdf',
                        ]],
                    ]),
                ]],
            ],
        ], 200),
    ]);

    $html = view('eerc-v2.record.show', [
        'record' => [
            'Title' => 'AB1/1 General Record',
            'Identifier' => ['AB1-1-1'],
            'Audio links and images' => ['digital-object-1'],
        ],
        'recordTitle' => 'AB1/1 General Record',
        'recordDisplay' => ['Identifier', 'Audio links and images'],
        'fieldMappings' => [],
        'filters' => [],
        'bitstreamField' => '',
        'thumbnailField' => '',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)
        ->toContain('>Transcript</th>')
        ->and($html)->toContain('title="Transcript: AB1-1-1-general-transcript"')
        ->and($html)->not->toContain('title="PDF document: AB1-1-1-general-transcript"');
});
