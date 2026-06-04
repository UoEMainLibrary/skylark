<?php

use App\Support\SolrFilterQuery;

it('accepts well-formed quoted Solr filter queries', function (): void {
    expect(SolrFilterQuery::isValid('collection_filter:"National Library"'))->toBeTrue()
        ->and(SolrFilterQuery::isValid("collection_filter:\"theatre\n|||\nTheatre\""))->toBeTrue();
});

it('rejects truncated quoted Solr filter queries', function (): void {
    expect(SolrFilterQuery::isValid('collection_filter:"n'))->toBeFalse()
        ->and(SolrFilterQuery::isValid('collection_filter:"National'))->toBeFalse();
});

it('deduplicates and drops invalid filters', function (): void {
    $filters = [
        'authorza_filter:"Herschel"',
        'authorza_filter:"Herschel"',
        'collection_filter:"n',
        'collection_filter:"National Library"',
    ];

    expect(SolrFilterQuery::onlyValid($filters))->toBe([
        'authorza_filter:"Herschel"',
        'collection_filter:"National Library"',
    ]);
});
