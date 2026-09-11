<?php

/**
 * Record links on the physics and cockburn search results pages historically
 * built their `?highlight=` param by string-concatenating the raw decoded
 * query onto the href:
 *
 *     <a href="{{ url('/physics/record/' . $doc['id'].'?highlight='.$query) }}">
 *
 * That's the same class of bug as buildBaseSearchUrl(): if the user landed on
 * the results page with a quoted phrase (e.g. `"Keyboard grouping"`) the raw
 * `"` closed the anchor's href attribute early and clicking any record link
 * dropped the query string entirely (and the `#highlight` scroll target with
 * it).
 *
 * Both views now wrap the query in `urlencode(...)` when building the URL.
 * These tests render the views directly with a quoted-phrase query so the
 * encoded href shape is locked in.
 */
function renderResultsWithQuery(string $view, string $query): string
{
    config([
        'skylight.field_mappings' => [
            'Title' => 'dc.title.en',
            'Author' => 'dc.contributor.author.en',
            'Date' => 'dc.date.issued.en',
        ],
    ]);

    return view($view, [
        'query' => $query,
        'docs' => [[
            'id' => '42',
            'dctitleen' => ['Some record title'],
        ]],
        'total' => 1,
        'startRow' => 1,
        'endRow' => 1,
        'sort_options' => ['Title' => 'dc.title_sort'],
        'sort_by' => '',
        'base_search' => './search/'.$query,
        'base_parameters' => '',
        'paginationLinks' => '',
        'facets' => [],
        'highlights' => [],
        'active_filters' => [],
        'delimiter' => '|||',
    ])->render();
}

it('physics search results build a properly encoded ?highlight= link when the query is a quoted phrase', function (): void {
    $html = renderResultsWithQuery('physics.search.results', '"Keyboard grouping"');

    expect($html)
        ->toContain('/physics/record/42?highlight=%22Keyboard+grouping%22')
        ->and($html)->not->toContain('?highlight="Keyboard')
        ->and($html)->not->toContain('grouping"');
});

it('cockburn search results build a properly encoded ?highlight= link when the query is a quoted phrase', function (): void {
    $html = renderResultsWithQuery('cockburn.search.results', '"Keyboard grouping"');

    expect($html)
        ->toContain('/cockburn/record/42?highlight=%22Keyboard+grouping%22')
        ->and($html)->not->toContain('?highlight="Keyboard')
        ->and($html)->not->toContain('grouping"');
});
