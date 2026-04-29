<?php

it('renders creative engagement reference images without boxed wrappers', function (): void {
    $html = view('eerc-v2.pages.creative_engagement')->render();

    expect($html)
        ->toContain('collections/eerc/images/v2/creative/EL35-3-4-2-crop.jpg')
        ->and($html)->toContain('collections/eerc/images/v2/creative/image2.jpeg')
        ->and($html)->not->toContain('bg-gray-50/80 p-1.5 shadow-sm ring-1 ring-gray-100');
});
