<?php

use Illuminate\Support\Js;

function renderMimedManifestRecord(array $record): string
{
    return view('mimed.record.show', [
        'recordTitle' => 'Piccolo',
        'fieldMappings' => config('collections.mimed.field_mappings'),
        'record' => $record,
        'recordDisplay' => [],
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();
}

it('prefers manifest metadata for the viewer and every manifest link', function (mixed $value): void {
    $html = renderMimedManifestRecord([
        'dcidentifiermanifest' => $value,
        'dcidentifierimageUrien' => ['https://images.is.ed.ac.uk/luna/image.jpg'],
        'dcformatoriginalen' => ['application/json##manifest.json##0##10683/17530##1'],
    ]);

    $manifest = 'https://id.collections.ed.ac.uk/ark:/12345/example';

    expect($html)
        ->toContain('/mimed/mirador?manifest='.urlencode($manifest))
        ->toContain('https://librarylabs.ed.ac.uk/iiif/uv/?manifest='.urlencode($manifest))
        ->toContain('https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.urlencode($manifest))
        ->toContain('href="'.$manifest.'" target="_blank" class="iiiflogo"')
        ->not->toContain('/mimed/record/17530/1/manifest.json', 'n2t.net');
})->with([
    'array' => [['https://n2t.net/ark:/12345/example']],
    'scalar' => ['https://n2t.net/ark:/12345/example'],
    'blank first value' => [['', ' https://n2t.net/ark:/12345/example ']],
]);

it('uses a metadata manifest without requiring an old image URI or bitstream', function (): void {
    $html = renderMimedManifestRecord([
        'dcidentifiermanifest' => ['https://n2t.net/ark:/12345/example'],
    ]);

    expect($html)->toContain('data-mimed-viewer', '/mimed/mirador?manifest=', 'id.collections.ed.ac.uk');
});

it('retains the bitstream manifest when metadata is absent empty or invalid', function (array $metadata): void {
    $html = renderMimedManifestRecord(array_merge([
        'dcidentifierimageUrien' => ['image.jpg'],
        'dcformatoriginalen' => ['application/json##manifest.json##0##10683/16327##1'],
    ], $metadata));

    $manifest = url('/mimed/record/16327/1/manifest.json');

    expect($html)->toContain('/mimed/mirador?manifest='.urlencode($manifest))
        ->toContain('href="'.$manifest.'" target="_blank" class="iiiflogo"');
})->with([
    'absent' => [[]],
    'empty array' => [['dcidentifiermanifest' => []]],
    'blank' => [['dcidentifiermanifest' => ['   ']]],
    'null' => [['dcidentifiermanifest' => null]],
    'invalid URL' => [['dcidentifiermanifest' => ['not a URL']]],
    'unsafe scheme' => [['dcidentifiermanifest' => ['javascript:alert(1)']]],
]);

it('leaves other manifest hosts and occurrences of n2t.net in paths and queries alone', function (): void {
    $manifest = 'https://example.org/n2t.net/manifest?source=https://n2t.net/ark:/12345/example&size=1';
    $html = renderMimedManifestRecord(['dcidentifiermanifest' => [$manifest]]);

    expect($html)->toContain('href="'.e($manifest).'" target="_blank" class="iiiflogo"')
        ->toContain('/mimed/mirador?manifest='.urlencode($manifest));
});

it('omits the viewer and manifest links when neither source is available', function (): void {
    expect(renderMimedManifestRecord([]))->not->toContain('data-mimed-viewer', 'class="iiiflogo"');
});

it('keeps search thumbnail hosts and record links while loading image failure handling', function (): void {
    config(['skylight.field_mappings' => config('collections.mimed.field_mappings')]);

    $html = view('mimed.search.results', [
        'query' => '*:*',
        'total' => 1,
        'startRow' => 1,
        'endRow' => 1,
        'docs' => [['id' => '17530', 'dctitleen' => ['Piccolo'], 'dcidentifierimageUrien' => ['https://images.is.ed.ac.uk/luna/image.jpg']]],
        'base_search' => url('/mimed/search/*:*'),
        'base_parameters' => '',
        'paginationLinks' => '',
    ])->render();

    expect($html)->toContain('src="https://images.is.ed.ac.uk/luna/image.jpg"', '/mimed/record/17530', 'Piccolo', 'collections/mimed/js/record-images.js')
        ->not->toContain('imagelinks.is.ed.ac.uk');
});

it('passes manifest query strings safely into Mirador JavaScript', function (): void {
    $manifest = 'https://id.collections.ed.ac.uk/ark:/12345/example?one=1&two=2';
    $html = view('mimed.mirador', compact('manifest'))->render();

    expect($html)->toContain('loadedManifest: '.Js::from($manifest))
        ->not->toContain('one=1&amp;two=2');
});
