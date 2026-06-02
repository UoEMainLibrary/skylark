<?php

use App\Http\Controllers\SearchController;
use App\Services\RepositoryFactory;

it('keeps jlss legacy newline-delimited facet values for Solr filters', function (): void {
    config([
        'skylight.filters' => ['Collection' => 'collection_filter'],
        'skylight.filter_delimiter' => ':',
    ]);

    $controller = new class(app(RepositoryFactory::class)) extends SearchController
    {
        public function parseForTest(array $segments): array
        {
            return $this->parseFilters($segments);
        }
    };

    $parsed = $controller->parseForTest([
        "Collection:\"theatre\n|||\nTheatre\"",
    ]);

    expect($parsed['solr_filters'])->toBe([
        "collection_filter:\"theatre\n|||\nTheatre\"",
    ])->and($parsed['solr_filters'][0])->toContain("\n|||\n");
});
