<?php

beforeEach(function (): void {
    config(['skylight.resp_skin_version' => 2]);
});

it('renders separate exhibition thumbnails for the All in a Day work publication and film', function (): void {
    $html = view('eerc-v2.pages.exhibition_gallery')->render();

    expect(substr_count($html, 'sm:w-[calc((100%-2rem)/3)]'))->toBe(6)
        ->and($html)->toContain('collections/eerc/images/v2/am-cover.jpg')
        ->and($html)->toContain('All in A Day&rsquo;s Work publication')
        ->and($html)->toContain('href="#days-work-film"')
        ->and($html)->toContain('collections/eerc/images/v2/all-in-a-days-work-film-poster.jpeg')
        ->and($html)->toContain('All in A Day&rsquo;s Work film')
        ->and($html)->toContain('id="days-work-film"');
});

it('renders the replacement creative engagement crop without tightly cropping the fish wife image', function (): void {
    $html = view('eerc-v2.pages.creative_engagement')->render();

    expect($html)->toContain('collections/eerc/images/v2/creative/EL35-3-4-2-crop.jpg')
        ->and($html)->toContain('woman carrying a basket on her back')
        ->and($html)->toContain('object-contain')
        ->and($html)->toContain('md:w-48');
});

it('does not include Shetland or high northern pins in the generated EERC map data', function (): void {
    $mapData = json_decode(file_get_contents(public_path('data/eerc_map_locations.json')), true, flags: JSON_THROW_ON_ERROR);
    $locations = $mapData['locations'] ?? [];

    $shetlandLocations = array_filter($locations, function (array $location): bool {
        return str_contains(strtolower($location['name'] ?? ''), 'shetland')
            || str_contains(strtolower($location['name'] ?? ''), 'lerwick')
            || str_contains(strtolower($location['name'] ?? ''), 'whalsay')
            || str_contains(strtolower($location['name'] ?? ''), 'unst')
            || str_contains(strtolower($location['name'] ?? ''), 'yell');
    });

    $highNorthernLocations = array_filter(
        $locations,
        static fn (array $location): bool => (float) ($location['latitude'] ?? 0) >= 58,
    );

    expect($locations)->not->toBeEmpty()
        ->and($shetlandLocations)->toBeEmpty()
        ->and($highNorthernLocations)->toBeEmpty();
});
