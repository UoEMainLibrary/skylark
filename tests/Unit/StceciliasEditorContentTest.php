<?php

use App\Support\StceciliasEditorContent;

it('preserves paragraph boundaries when preparing imported content for editing', function (string $html, string $expected): void {
    expect(StceciliasEditorContent::normalize($html))->toBe($expected);
})->with([
    ['<div>First paragraph.</div><div>Second paragraph.</div>', '<p>First paragraph.</p><p>Second paragraph.</p>'],
    ['<div><div><strong>Original description</strong></div></div><p>Booking details.</p>', '<p><strong>Original description</strong></p><p>Booking details.</p>'],
    ['<div>Introduction<div>Details</div>Conclusion</div>', '<p>Introduction</p><p>Details</p><p>Conclusion</p>'],
    ['<div><p>Introduction</p><ul><li>Item</li></ul></div>', '<p>Introduction</p><ul><li>Item</li></ul>'],
]);
