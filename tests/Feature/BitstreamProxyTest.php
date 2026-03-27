<?php

use Illuminate\Support\Facades\Http;

it('returns 404 for .pdf path when upstream returns JSON manifest', function () {
    Http::fake([
        '*' => Http::response(
            '{"@type":"sc:Manifest","@context":"http://iiif.io/api/presentation/2/context.json"}',
            200,
            ['Content-Type' => 'application/json; charset=utf-8']
        ),
    ]);

    $this->get('/record/1/1/0340100c.pdf')->assertNotFound();
});

it('returns 404 for .pdf path when upstream returns manifest-shaped JSON with octet-stream', function () {
    Http::fake([
        '*' => Http::response(
            '{"@type":"sc:Manifest","sequences":[]}',
            200,
            ['Content-Type' => 'application/octet-stream']
        ),
    ]);

    $this->get('/record/1/1/doc.pdf')->assertNotFound();
});

it('joins DSPACE_BITSTREAM_URL without trailing slash correctly', function () {
    config(['services.dspace.bitstream_url' => 'https://example.test/bitstream/10683']);

    Http::fake(function (\Illuminate\Http\Client\Request $request) {
        expect($request->url())->toBe('https://example.test/bitstream/10683/121770/1/file.pdf');

        return Http::response('%PDF-1.4 ', 200, ['Content-Type' => 'application/pdf']);
    });

    $this->get('/record/121770/1/file.pdf')->assertSuccessful();
});
