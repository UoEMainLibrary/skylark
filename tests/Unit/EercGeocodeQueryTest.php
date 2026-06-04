<?php

use App\Support\EercGeocodeQuery;

it('builds simplified nominatim queries for hebridean subject headings', function (): void {
    $queries = EercGeocodeQuery::searchQueries(
        'Shawbost (Siabost), Isle of Lewis (Eilean Leòdhais), Scotland'
    );

    expect($queries)->not->toBeEmpty()
        ->and($queries[0])->toContain('Shawbost (Siabost)')
        ->and(collect($queries)->contains(fn (string $q) => str_contains($q, 'Shawbost, Isle of Lewis')))->toBeTrue();
});

it('corrects common isle typos in geocode queries', function (): void {
    $queries = EercGeocodeQuery::searchQueries(
        'Duntulm (Dùn Thuilm), Ilsle of Skye  (An t-Eilean Sgitheanach), Scotland'
    );

    expect($queries[0])->toContain('Isle of Skye')
        ->not->toContain('Ilsle');
});

it('adds scotland suffix for short place names', function (): void {
    expect(EercGeocodeQuery::searchQueries('Cairnholly')[0])->toBe('Cairnholly, Scotland, UK');
});
