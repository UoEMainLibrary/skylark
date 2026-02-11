<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SolrService
{
    protected string $baseUrl;

    protected string $containerId;

    protected string $containerField;

    protected int $resultsPerPage;

    public function __construct()
    {
        $config = config('services.solr');

        // Build the base URL for DSpace Solr
        // Using direct HTTP client due to Solarium issues with DSpace's non-standard Solr setup
        $this->baseUrl = env('SOLR_BASE_URL', 'http://localhost:8080/solr/search/');

        $this->containerId = $config['container_id'];
        $this->containerField = $config['container_field'];
        $this->resultsPerPage = $config['results_per_page'];
    }

    /**
     * Execute a search query against Solr
     */
    public function search(string $query = '*:*', array $filters = [], array $options = []): array
    {
        $start = $options['start'] ?? 0;
        $rows = $options['rows'] ?? $this->resultsPerPage;

        // Build query parameters
        $params = [
            'q' => $query,
            'start' => $start,
            'rows' => $rows,
            'wt' => 'json',
        ];

        // Apply container scoping
        $params['fq'][] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $params['fq'][] = 'search.resourcetype:2';

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $params['fq'][] = "{$key}:{$value}";
        }

        // Set sort if provided
        if (isset($options['sort'])) {
            $order = $options['sort_order'] ?? 'asc';
            $params['sort'] = "{$options['sort']} {$order}";
        }

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select", $params);

        if (! $response->successful()) {
            throw new \Exception("Solr query failed: {$response->status()} - {$response->body()}");
        }

        $data = $response->json();

        // Process results
        $docs = $data['response']['docs'] ?? [];
        $total = $data['response']['numFound'] ?? 0;

        return [
            'docs' => $docs,
            'total' => $total,
            'start' => $start,
            'rows' => $rows,
        ];
    }

    /**
     * Execute a search query with faceting
     */
    public function searchWithFacets(string $query = '*:*', array $filters = [], array $facetFields = []): array
    {
        // Build query parameters
        $params = [
            'q' => $query,
            'rows' => $this->resultsPerPage,
            'wt' => 'json',
            'facet' => 'true',
            'facet.limit' => 10,
        ];

        // Apply container scoping
        $params['fq'][] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $params['fq'][] = 'search.resourcetype:2';

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $params['fq'][] = "{$key}:{$value}";
        }

        // Add facet fields
        $defaultFacetFields = ['author_filter', 'subject_filter', 'type_filter'];
        $fieldsToFacet = empty($facetFields) ? $defaultFacetFields : $facetFields;

        foreach ($fieldsToFacet as $field) {
            $params['facet.field'][] = $field;
        }

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select", $params);

        if (! $response->successful()) {
            throw new \Exception("Solr query failed: {$response->status()} - {$response->body()}");
        }

        $data = $response->json();

        // Process results
        $docs = $data['response']['docs'] ?? [];
        $total = $data['response']['numFound'] ?? 0;

        // Process facets
        $facets = [];
        $facetFields = $data['facet_counts']['facet_fields'] ?? [];

        foreach ($facetFields as $facetName => $facetData) {
            $terms = [];
            // Solr returns facet data as alternating key-value pairs
            for ($i = 0; $i < count($facetData); $i += 2) {
                if (isset($facetData[$i + 1])) {
                    $terms[] = [
                        'value' => $facetData[$i],
                        'count' => $facetData[$i + 1],
                    ];
                }
            }
            $facets[$facetName] = $terms;
        }

        return [
            'docs' => $docs,
            'total' => $total,
            'facets' => $facets,
        ];
    }

    /**
     * Retrieve a single record by ID
     */
    public function getRecord(string $id, bool $includeHighlight = false): ?array
    {
        // Build query parameters
        $params = [
            'q' => "handle:\"{$id}\" OR id:\"{$id}\"",
            'rows' => 1,
            'wt' => 'json',
        ];

        // Apply container scoping
        $params['fq'][] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $params['fq'][] = 'search.resourcetype:2';

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select", $params);

        if (! $response->successful()) {
            throw new \Exception("Solr query failed: {$response->status()} - {$response->body()}");
        }

        $data = $response->json();
        $docs = $data['response']['docs'] ?? [];

        if (empty($docs)) {
            return null;
        }

        return $docs[0];
    }

    /**
     * Get facets for a query without returning documents
     */
    public function getFacets(string $query = '*:*', array $filters = [], array $facetFields = []): array
    {
        // Build query parameters
        $params = [
            'q' => $query,
            'rows' => 0,
            'wt' => 'json',
            'facet' => 'true',
            'facet.limit' => 10,
        ];

        // Apply container scoping
        $params['fq'][] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $params['fq'][] = 'search.resourcetype:2';

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $params['fq'][] = "{$key}:{$value}";
        }

        // Add facet fields
        $defaultFacetFields = ['author_filter', 'subject_filter', 'type_filter'];
        $fieldsToFacet = empty($facetFields) ? $defaultFacetFields : $facetFields;

        foreach ($fieldsToFacet as $field) {
            $params['facet.field'][] = $field;
        }

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select", $params);

        if (! $response->successful()) {
            throw new \Exception("Solr query failed: {$response->status()} - {$response->body()}");
        }

        $data = $response->json();
        $total = $data['response']['numFound'] ?? 0;

        // Process facets
        $facets = [];
        $facetFields = $data['facet_counts']['facet_fields'] ?? [];

        foreach ($facetFields as $facetName => $facetData) {
            $terms = [];
            // Solr returns facet data as alternating key-value pairs
            for ($i = 0; $i < count($facetData); $i += 2) {
                if (isset($facetData[$i + 1])) {
                    $terms[] = [
                        'value' => $facetData[$i],
                        'count' => $facetData[$i + 1],
                    ];
                }
            }
            $facets[$facetName] = $terms;
        }

        return [
            'total' => $total,
            'facets' => $facets,
        ];
    }

    /**
     * Get the base URL for direct HTTP access
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}
