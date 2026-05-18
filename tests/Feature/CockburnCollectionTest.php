<?php

beforeEach(function (): void {
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Type' => 'dc.type.en',
            'Thumbnail' => 'dc.format.thumbnail.en',
            'ImageUri' => 'dc.identifier.imageUri.en',
        ],
    ]);
});

it('renders the Recently added items list on the Cockburn home page', function (): void {
    $html = view('cockburn.home', [
        'docs' => [
            [
                'id' => '123328',
                'dctitleen' => ['Modern trace fossils - raindrops'],
                'dccontributorauthoren' => ['Unknown'],
            ],
            [
                'id' => '123427',
                'dctitleen' => ['Chalcedony var. Flint'],
                'dccontributorauthoren' => ['Unknown'],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('<h3>Recently added items</h3>')
        ->and($html)->toContain('<ul class="listing">')
        ->and($html)->toContain('href="./record/123328"')
        ->and($html)->toContain('Modern trace fossils - raindrops')
        ->and($html)->toContain('Chalcedony var. Flint')
        ->and($html)->toContain('Author:"Unknown"')
        ->and($html)->toContain('class="first"')
        ->and($html)->toContain('class="last"');
});

it('omits the Recently added items heading when no recent docs are passed', function (): void {
    $html = view('cockburn.home', ['docs' => []])->render();

    expect($html)
        ->not->toContain('Recently added items')
        ->and($html)->not->toContain('<ul class="listing">');
});

it('renders the Related Items sidebar on the Cockburn record page', function (): void {
    $html = view('cockburn.record.show', [
        'record' => [
            'dctitleen' => ['Geology Teaching Slide'],
        ],
        'recordTitle' => 'Geology Teaching Slide',
        'recordDisplay' => [],
        'descriptionDisplay' => [],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => [],
        'bitstreamField' => '',
        'thumbnailField' => '',
        'parentCollectionField' => '',
        'subCollectionField' => '',
        'internalUriField' => '',
        'aspaceUriField' => '',
        'lunaUriField' => '',
        'lmsUriField' => '',
        'otherUriField' => '',
        'highlightQuery' => '',
        'bitstreams' => [],
        'relatedItems' => [
            [
                'id' => '123186',
                'dctitleen' => ['Geology Teaching Slide'],
                'dctypeen' => ['English lantern slide/Slide'],
                'dcidentifierimageUrien' => [
                    'http://images.is.ed.ac.uk/luna/servlet/iiif/UoEsha~5~5~143483~508908/full/full/0/default.jpg',
                ],
            ],
        ],
    ])->render();

    expect($html)
        ->toContain('<h4>Related Items</h4>')
        ->and($html)->toContain('<ul class="related">')
        ->and($html)->toContain('class="related-record" href="./record/123186"')
        ->and($html)
        ->toContain('http://images.is.ed.ac.uk/luna/servlet/iiif/UoEsha~5~5~143483~508908/full/,50/0/default.jpg')
        ->and($html)
        ->toContain('http://images.is.ed.ac.uk/luna/servlet/iiif/UoEsha~5~5~143483~508908/full/full/0/default.jpg')
        ->and($html)->toContain('Type:%22english+lantern+slide%2Fslide+%7C%7C%7C+English+lantern+slide%2FSlide%22')
        ->and($html)->toContain('English lantern slide/Slide')
        ->and($html)->not->toContain('full/full/0/default.jpg/full/');
});

it('falls back to facets in the sidebar when no related items are passed', function (): void {
    $html = view('cockburn.record.show', [
        'record' => ['dctitleen' => ['Test record']],
        'recordTitle' => 'Test record',
        'recordDisplay' => [],
        'descriptionDisplay' => [],
        'fieldMappings' => config('skylight.field_mappings'),
        'filters' => [],
        'bitstreamField' => '',
        'thumbnailField' => '',
        'parentCollectionField' => '',
        'subCollectionField' => '',
        'internalUriField' => '',
        'aspaceUriField' => '',
        'lunaUriField' => '',
        'lmsUriField' => '',
        'otherUriField' => '',
        'highlightQuery' => '',
        'bitstreams' => [],
        'relatedItems' => [],
    ])->render();

    expect($html)->not->toContain('<h4>Related Items</h4>');
});

it('uses the correct (typo-free) jquery-ui asset path in the cockburn layout', function (): void {
    $html = view('cockburn.pages.about')->render();

    expect($html)
        ->toContain('/assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js')
        ->and($html)->not->toContain('/ssets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js');
});

it('renders a <base href> pointing at the collection root so relative links resolve', function (): void {
    // Without this, ./record/X on /cockburn/record/Y resolves to
    // /cockburn/record/record/X and 404s.
    config([
        'app.collection_path_prefix' => '/cockburn',
        'skylight.url_prefix' => 'cockburn',
    ]);

    $html = view('cockburn.pages.about')->render();

    expect($html)->toContain('<base href="'.url('/cockburn').'/">');
});
