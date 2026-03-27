<?php

use App\Helpers\BitstreamHelper;

uses(Tests\TestCase::class);

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
