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

it('drops malformed facet filters produced by broken URLs', function (): void {
    config([
        'skylight.filters' => [
            'Author' => 'authorza_filter',
            'Collection' => 'collection_filter',
        ],
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
        'Author:"herschel,+sir+william+\n|||\n+Herschel,+Sir+William"',
        'Collection:"n',
        'Collection:"National Library"',
    ]);

    expect($parsed['solr_filters'])
        ->toHaveCount(2)
        ->and($parsed['solr_filters'][0])->toContain('authorza_filter:')
        ->toContain('Herschel,+Sir+William')
        ->and($parsed['solr_filters'][1])->toBe('collection_filter:"National Library"');
});
