<?php

use App\Http\Controllers\SearchController;
use App\Services\RepositoryFactory;
use Illuminate\Support\Facades\Http;

/**
 * The homepage tiles on collections like stcecilias link to phrase-quoted
 * search URLs, e.g. /stcecilias/search/%22Keyboard+grouping%22. Laravel
 * decodes the {query} route parameter, so the SearchController receives the
 * raw string `"Keyboard+grouping"` (literal `"` characters).
 *
 * Historically, SearchController::buildBaseSearchUrl() interpolated that raw
 * value straight back into the URL used for pagination and facet anchors:
 *   <a href="https://.../search/"Keyboard+grouping"?offset=20">2</a>
 * The unescaped `"` inside the href attribute closed it early, so the
 * browser navigated to `.../search/` → 404.
 *
 * These tests lock in the encoded shape so the pagination link is
 * indistinguishable (aside from the ?offset) from the homepage tile that
 * kicked the user into the results view.
 */
function invokeBuildBaseSearchUrl(string $query, array $filters = []): string
{
    $controller = new SearchController(app(RepositoryFactory::class));
    $ref = new ReflectionMethod($controller, 'buildBaseSearchUrl');
    $ref->setAccessible(true);

    return $ref->invoke($controller, $query, $filters);
}

it('re-encodes the {query} route segment so double quotes cannot break the href attribute', function (): void {
    // Laravel hands us the decoded string (literal `"`s, literal `+`).
    $url = invokeBuildBaseSearchUrl('"Keyboard+grouping"');

    expect($url)
        ->toContain('/search/%22Keyboard+grouping%22')
        ->and($url)->not->toContain('/search/"')
        ->and($url)->not->toContain('grouping"');
});

it('preserves `:` in the query so Solr syntax like *:* stays readable in the URL', function (): void {
    $url = invokeBuildBaseSearchUrl('*:*');

    expect($url)->toContain('/search/*:*');
});

it('preserves `+` in the query so legacy CI phrase URLs keep working', function (): void {
    // `+` in a path segment is a literal `+`, not a space. Legacy skylight
    // links used `+` between words inside the quoted phrase.
    $url = invokeBuildBaseSearchUrl('"foo+bar"');

    expect($url)->toContain('/search/%22foo+bar%22');
});

it('encodes spaces as %20 so they survive round-tripping through an href attribute', function (): void {
    $url = invokeBuildBaseSearchUrl('foo bar');

    expect($url)->toContain('/search/foo%20bar');
});

it('rebuilds a working pagination href when the query contains a quoted phrase', function (): void {
    // A minimal Solr fake so /stcecilias/search/... returns >20 hits and
    // therefore renders a page-2 anchor.
    Http::fake([
        '*' => Http::response([
            'response' => [
                'numFound' => 42,
                'start' => 0,
                'docs' => array_fill(0, 20, ['id' => '1', 'title' => ['t']]),
            ],
            'facet_counts' => ['facet_fields' => []],
            'highlighting' => [],
        ], 200),
    ]);

    $html = $this->get('/stcecilias/search/%22Keyboard+grouping%22')
        ->assertSuccessful()
        ->getContent();

    // The bug produced `/stcecilias/search/"Keyboard+grouping"?offset=20`,
    // which the browser truncated to `/stcecilias/search/`. Assert the
    // properly encoded shape survives all the way to the rendered href.
    expect($html)
        ->toContain('/stcecilias/search/%22Keyboard+grouping%22?offset=20')
        ->and($html)->not->toContain('/search/"Keyboard')
        ->and($html)->not->toContain('grouping"?offset=');
});
