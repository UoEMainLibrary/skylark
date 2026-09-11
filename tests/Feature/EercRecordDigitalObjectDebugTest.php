<?php

use Illuminate\Support\Facades\Http;

it('classifies a pdf from the file uri when the digital object title is messy', function (): void {
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
                        'title' => 'EL35-1-5-2.pdf ',
                        'file_versions' => [[
                            'file_uri' => 'https://files.example/EL35-1-5-2-tools%20and%20gauges%20-%20Bruntons.pdf',
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
            'Audio links and images' => ['digital-object-1'],
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
        ->toContain('>Transcript</th>')
        ->and($html)->toContain('title="Transcript: EL35-1-5-2"')
        ->and($html)->toContain('https://files.example/EL35-1-5-2-tools%20and%20gauges%20-%20Bruntons.pdf');
});
