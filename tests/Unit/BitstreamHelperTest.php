<?php

use App\Helpers\BitstreamHelper;
use Tests\TestCase;

uses(TestCase::class);

it('rejects json mime even when filename ends with .pdf', function () {
    $s = 'application/json##0340008c.pdf##123##10683/121624##1##';
    expect(BitstreamHelper::isPdf($s))->toBeFalse();
});

it('accepts application/pdf', function () {
    $s = 'application/pdf##scan.pdf##123##10683/121624##2##';
    expect(BitstreamHelper::isPdf($s))->toBeTrue();
});

it('accepts octet-stream with .pdf filename when mime is generic', function () {
    $s = 'application/octet-stream##scan.pdf##123##10683/121624##1##';
    expect(BitstreamHelper::isPdf($s))->toBeTrue();
});

it('orders application/pdf before octet-stream for download', function () {
    $octet = 'application/octet-stream##a.pdf##0##10683/1##5##';
    $real = 'application/pdf##b.pdf##0##10683/1##3##';
    $ordered = BitstreamHelper::orderPdfBitstreamsForDownload([$octet, $real]);
    expect($ordered[0])->toBe($real);
    expect($ordered[1])->toBe($octet);
});

it('builds collection-prefixed bitstream proxy URL when collection path prefix is set', function () {
    config(['app.collection_path_prefix' => '/openbooks']);
    $meta = 'application/pdf##doc.pdf##1000##10683/121624##1##';
    expect(BitstreamHelper::getCollectionProxiedUrl($meta))
        ->toContain('/openbooks/record/121624/1/doc.pdf');
});

it('builds root bitstream proxy URL when collection path prefix is empty', function () {
    config(['app.collection_path_prefix' => '']);
    $meta = 'application/pdf##doc.pdf##1000##10683/121624##1##';
    $url = BitstreamHelper::getCollectionProxiedUrl($meta);
    expect($url)->toContain('/record/121624/1/doc.pdf');
    expect($url)->not->toContain('/openbooks/');
});

it('rewrites bitstream URLs to the configured rewrite base URL', function () {
    config([
        'services.dspace.rewrite_bitstream_urls' => true,
        'services.dspace.rewrite_base_url' => 'http://localhost:8080',
        'app.url' => 'http://localhost',
    ]);

    $url = BitstreamHelper::rewriteBitstreamUrl('https://digitalpreservation.is.ed.ac.uk/bitstream/handle/20.500.12734/57108/image.jpg');

    expect($url)->toBe('http://localhost:8080/bitstream/handle/20.500.12734/57108/image.jpg');
});

it('drops webm bitstreams when an mp4 sibling is present', function () {
    $mp4 = 'video/mp4##clip.mp4##0##10683/22138##2##';
    $webm = 'video/webm##clip.webm##0##10683/22138##3##';

    expect(BitstreamHelper::preferMp4VideoBitstreams([$webm, $mp4]))
        ->toBe([$mp4]);
});

it('keeps webm when no mp4 is available', function () {
    $webm = 'video/webm##clip.webm##0##10683/22138##3##';

    expect(BitstreamHelper::preferMp4VideoBitstreams([$webm]))
        ->toBe([$webm]);
});

it('renders mp4 always and webm only when the record has no mp4', function () {
    expect(BitstreamHelper::shouldRenderVideoFilename('clip.mp4', true))->toBeTrue()
        ->and(BitstreamHelper::shouldRenderVideoFilename('clip.webm', true))->toBeFalse()
        ->and(BitstreamHelper::shouldRenderVideoFilename('clip.webm', false))->toBeTrue()
        ->and(BitstreamHelper::shouldRenderVideoFilename('photo.jpg', true))->toBeFalse();
});
