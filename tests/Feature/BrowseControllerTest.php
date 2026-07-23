<?php

use Illuminate\Support\Facades\Http;

/**
 * Legacy skylight ships a `browse.php` controller behind the "More ..." link
 * that dangles at the bottom of each sidebar facet in
 * defaults.search.partials.facets. Every DSpace collection that registers a
 * browse route via CollectionRouteRegistrar's extra_routes hook now uses the
 * shared App\Http\Controllers\BrowseController.
 *
 * These tests pin the behaviour so the "More ..." link doesn't quietly break
 * again on archivemedia / calendars / iconics / speccoll / anatomy.
 */
function fakeBrowseSolr(): void
{
    // Every collection's Solr filter name shows up under one of the keys
    // below; browseTerms picks the right one based on config('skylight.filters').
    $authors = ['bell ||| Bell', 3, 'monro ||| Monro', 5];
    $subjects = ['anatomy ||| Anatomy', 4, 'medicine ||| Medicine', 6];

    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 42, 'docs' => []],
            'facet_counts' => [
                'facet_fields' => [
                    // Authors (varying legacy names per collection)
                    'authorza_filter' => $authors,
                    'dccontributor_filter' => $authors,
                    'author_filter' => $authors,
                    'creator_filter' => $authors,
                    'contributor_filter' => $authors,
                    // Subjects
                    'subject_filter' => $subjects,
                    'dcsubject_filter' => $subjects,
                ],
            ],
        ], 200),
    ]);
}

it('routes /{collection}/browse/{facet} through the shared BrowseController', function (string $prefix, string $facet): void {
    fakeBrowseSolr();

    $html = $this->get("/{$prefix}/browse/{$facet}")
        ->assertSuccessful()
        ->getContent();

    // Blade escapes the `"` in the yielded title.
    expect($html)
        ->toContain('Browse &quot;'.$facet.'&quot;')
        ->toContain('Starts with')
        ->toContain('class="browse_facet_list"');
})->with([
    ['archivemedia', 'Author'],
    ['calendars', 'Subject'],
    ['iconics', 'Subject'],
    ['speccoll', 'Author'],
    ['anatomy', 'Author'],
]);

it('returns 404 for a facet name that isn\'t configured on the collection', function (): void {
    fakeBrowseSolr();

    $this->get('/archivemedia/browse/Nonsense')
        ->assertNotFound();
});

it('links each browsed term back to a properly quoted search filter', function (): void {
    fakeBrowseSolr();

    $html = $this->get('/archivemedia/browse/Author')->assertSuccessful()->getContent();

    // DSpaceService::browseTerms rawurlencodes the whole `<lower> ||| <Display>`
    // string, so spaces come through as %20 and pipes as %7C%7C%7C.
    expect($html)
        ->toContain('/archivemedia/search/*:*/Author:%22bell%20%7C%7C%7C%20Bell%22')
        ->and($html)->toContain('>Bell (3)</a>')
        ->and($html)->toContain('>Monro (5)</a>');
});
