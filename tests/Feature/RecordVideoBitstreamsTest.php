<?php

use App\Http\Controllers\RecordController;
use App\Services\RepositoryFactory;

function parseRecordVideos(array $record): array
{
    config(['app.collection_path_prefix' => '/mimed']);

    $controller = new RecordController(app(RepositoryFactory::class));
    $ref = new ReflectionMethod($controller, 'parseBitstreams');
    $ref->setAccessible(true);

    return $ref->invoke($controller, $record, 'dcformatoriginalen', 'dcformatthumbnailen');
}

it('parses record videos with collection proxy URLs and prefers mp4 over webm', function (): void {
    $parsed = parseRecordVideos([
        'dcformatoriginalen' => [
            'video/webm##demo.webm##0##10683/15260##2##',
            'video/mp4##demo.mp4##0##10683/15260##1##',
        ],
    ]);

    expect($parsed['video'])->toHaveCount(1)
        ->and($parsed['video'][0]['filename'])->toBe('demo.mp4')
        ->and($parsed['video'][0]['uri'])->toContain('/mimed/record/15260/1/demo.mp4')
        ->and($parsed['video'][0]['uri'])->not->toContain('demo.webm');
});

it('renders a single mimed video player when both mp4 and webm bitstreams exist', function (): void {
    $parsed = parseRecordVideos([
        'dcformatoriginalen' => [
            'video/mp4##clip.mp4##0##10683/15260##1##',
            'video/webm##clip.webm##0##10683/15260##2##',
        ],
    ]);

    $html = view('mimed.record.show', [
        'record' => ['dctitleen' => ['Test video record']],
        'recordTitle' => 'Test video record',
        'recordDisplay' => [],
        'fieldMappings' => [
            'Title' => 'dc.title.en',
            'Bitstream' => 'dc.format.original.en',
        ],
        'filters' => [],
        'bitstreamField' => 'dcformatoriginalen',
        'thumbnailField' => '',
        'bitstreams' => $parsed,
        'relatedItems' => [],
    ])->render();

    expect(substr_count(strtolower($html), '<video'))->toBe(1)
        ->and($html)->toContain('clip.mp4')
        ->and($html)->not->toContain('clip.webm');
});

it('renders a single art video player when both mp4 and webm bitstreams exist', function (): void {
    $parsed = parseRecordVideos([
        'dcformatoriginalen' => [
            'video/mp4##clip.mp4##0##10683/20515##1##',
            'video/webm##clip.webm##0##10683/20515##2##',
        ],
    ]);

    $html = view('art.record.show', [
        'record' => ['dctitleen' => ['Test art video']],
        'recordTitle' => 'Test art video',
        'recordDisplay' => [],
        'fieldMappings' => [
            'Title' => 'dc.title.en',
            'Bitstream' => 'dc.format.original.en',
        ],
        'filters' => [],
        'bitstreamField' => 'dcformatoriginalen',
        'thumbnailField' => '',
        'bitstreams' => $parsed,
        'relatedItems' => [],
    ])->render();

    expect(substr_count(strtolower($html), '<video'))->toBe(1)
        ->and($html)->toContain('clip.mp4')
        ->and($html)->not->toContain('clip.webm');
});
