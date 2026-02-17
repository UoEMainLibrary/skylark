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

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $filterQueries[] = 'search.resourcetype:2';

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $filterQueries[] = "{$key}:{$value}";
        }

        // Set sort if provided
        if (isset($options['sort'])) {
            $order = $options['sort_order'] ?? 'asc';
            $params['sort'] = "{$options['sort']} {$order}";
        }

        // Execute the query with properly formatted filter queries
        $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQuery($params, $filterQueries));

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

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $filterQueries[] = 'search.resourcetype:2';

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $filterQueries[] = "{$key}:{$value}";
        }

        // Add facet fields
        $defaultFacetFields = ['author_filter', 'subject_filter', 'type_filter'];
        $fieldsToFacet = empty($facetFields) ? $defaultFacetFields : $facetFields;

        $facetFieldParams = [];
        foreach ($fieldsToFacet as $field) {
            $facetFieldParams[] = $field;
        }

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQueryWithArrayParams($params, $filterQueries, ['facet.field' => $facetFieldParams]));

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

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $filterQueries[] = 'search.resourcetype:2';

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQuery($params, $filterQueries));

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

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $filterQueries[] = 'search.resourcetype:2';

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $filterQueries[] = "{$key}:{$value}";
        }

        // Add facet fields
        $defaultFacetFields = ['author_filter', 'subject_filter', 'type_filter'];
        $fieldsToFacet = empty($facetFields) ? $defaultFacetFields : $facetFields;

        $facetFieldParams = [];
        foreach ($fieldsToFacet as $field) {
            $facetFieldParams[] = $field;
        }

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQueryWithArrayParams($params, $filterQueries, ['facet.field' => $facetFieldParams]));

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
     * Execute a comprehensive search with highlighting, facets, and spellcheck
     */
    public function searchWithHighlighting(
        string $query,
        array $filters,
        int $offset,
        string $sortBy,
        int $rows,
        array $activeFilters = []
    ): array {
        // Normalize query
        if ($query === '*' || empty($query)) {
            $query = '*:*';
        }

        // Build query parameters
        $params = [
            'q' => $query,
            'start' => $offset,
            'rows' => $rows,
            'wt' => 'json',
            'facet' => 'true',
            'facet.limit' => config('skylight.facet_limit', 10),
            'facet.mincount' => 1,
        ];

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items)
        $filterQueries[] = 'search.resourcetype:2';

        // Apply filters with wildcard support
        foreach ($filters as $filter) {
            // Append wildcards for partial matching (unless filter is exact)
            $filterQueries[] = $filter;
        }

        // Set sort (Solr expects spaces, not plus signs)
        if (! empty($sortBy)) {
            $params['sort'] = str_replace('+', ' ', $sortBy);
        }

        // Add highlighting
        $params['hl'] = 'true';
        $params['hl.fl'] = '*.en';
        $params['hl.simple.pre'] = '<strong>';
        $params['hl.simple.post'] = '</strong>';

        // Add spellcheck
        $params['spellcheck'] = 'true';
        $params['spellcheck.collate'] = 'true';
        $params['spellcheck.onlyMorePopular'] = 'false';
        $params['spellcheck.count'] = 5;

        // Add facet fields from config
        $facetFieldParams = [];
        $configFilters = config('skylight.filters', []);
        foreach ($configFilters as $filterName => $filterField) {
            $facetFieldParams[] = $filterField;
        }

        // Execute the query
        $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQueryWithArrayParams($params, $filterQueries, ['facet.field' => $facetFieldParams]));

        if (! $response->successful()) {
            throw new \Exception("Solr query failed: {$response->status()} - {$response->body()}");
        }

        $data = $response->json();

        // Process results and transform field names
        $docs = [];
        foreach ($data['response']['docs'] ?? [] as $doc) {
            $docs[] = $this->transformFieldNames($doc);
        }

        $total = $data['response']['numFound'] ?? 0;

        // Process highlights
        $highlights = $data['highlighting'] ?? [];

        // Process facets with active/inactive state
        $facets = $this->buildFacetsWithActiveState(
            $data['facet_counts']['facet_fields'] ?? [],
            $activeFilters,
            $configFilters
        );

        // Process spellcheck suggestions
        $suggestions = [];
        if (isset($data['spellcheck']['collations'])) {
            $collations = $data['spellcheck']['collations'];
            for ($i = 0; $i < count($collations); $i += 2) {
                if ($collations[$i] === 'collation' && isset($collations[$i + 1])) {
                    $suggestions[] = $collations[$i + 1];
                }
            }
        }

        return [
            'docs' => $docs,
            'total' => $total,
            'start' => $offset,
            'rows' => $rows,
            'facets' => $facets,
            'highlights' => $highlights,
            'suggestions' => $suggestions,
        ];
    }

    /**
     * Build facets with active/inactive state tracking
     */
    public function buildFacetsWithActiveState(
        array $facetData,
        array $activeFilters,
        array $configFilters
    ): array {
        $facets = [];

        // Reverse map: solr field -> display name
        $fieldToName = array_flip($configFilters);

        foreach ($facetData as $facetField => $facetTerms) {
            $displayName = $fieldToName[$facetField] ?? $facetField;

            $activeTerms = [];
            $inactiveTerms = [];

            // Process alternating key-value pairs from Solr
            for ($i = 0; $i < count($facetTerms); $i += 2) {
                if (isset($facetTerms[$i + 1])) {
                    $termName = $facetTerms[$i];
                    $termCount = $facetTerms[$i + 1];

                    // Extract display name from "|||" delimiter (e.g., "rare books ||| Rare Books" -> "Rare Books")
                    $displayName = $termName;
                    if (str_contains($termName, '|||')) {
                        $parts = preg_split('/\|\|\|/', $termName);
                        if (isset($parts[1])) {
                            $displayName = trim($parts[1]);
                        }
                    }

                    // Check if this term is active
                    $isActive = false;
                    foreach ($activeFilters as $activeFilter) {
                        if (str_contains($activeFilter, $termName)) {
                            $isActive = true;
                            break;
                        }
                    }

                    $term = [
                        'name' => $termName,
                        'display_name' => $displayName,
                        'count' => $termCount,
                        'active' => $isActive,
                    ];

                    if ($isActive) {
                        $activeTerms[] = $term;
                    } else {
                        $inactiveTerms[] = $term;
                    }
                }
            }

            $facets[] = [
                'name' => $displayName,
                'field' => $facetField,
                'terms' => array_merge($activeTerms, $inactiveTerms),
                'active_terms' => $activeTerms,
                'inactive_terms' => $inactiveTerms,
            ];
        }

        return $facets;
    }

    /**
     * Transform Solr field names by removing dots
     */
    protected function transformFieldNames(array $doc): array
    {
        $transformed = [];

        foreach ($doc as $key => $value) {
            // Remove dots from field names (dc.title.en -> dctitleen)
            $newKey = str_replace('.', '', $key);
            $transformed[$newKey] = $value;
        }

        return $transformed;
    }

    /**
     * Get the base URL for direct HTTP access
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Build Solr query string with proper multi-value parameter support
     * Solr expects multiple fq parameters as fq=value1&fq=value2, not fq[0]=value1&fq[1]=value2
     */
    protected function buildSolrQuery(array $params, array $filterQueries): string
    {
        $queryParts = [];

        // Add regular parameters
        foreach ($params as $key => $value) {
            $queryParts[] = urlencode($key).'='.urlencode($value);
        }

        // Add filter queries (multiple fq parameters)
        foreach ($filterQueries as $fq) {
            $queryParts[] = 'fq='.urlencode($fq);
        }

        return '?'.implode('&', $queryParts);
    }

    /**
     * Build Solr query string with support for both filter queries and other array parameters
     * Solr expects multiple parameters with same name as param=value1&param=value2
     */
    protected function buildSolrQueryWithArrayParams(array $params, array $filterQueries, array $arrayParams = []): string
    {
        $queryParts = [];

        // Add regular parameters
        foreach ($params as $key => $value) {
            $queryParts[] = urlencode($key).'='.urlencode($value);
        }

        // Add filter queries (multiple fq parameters)
        foreach ($filterQueries as $fq) {
            $queryParts[] = 'fq='.urlencode($fq);
        }

        // Add array parameters (e.g., facet.field)
        foreach ($arrayParams as $paramName => $values) {
            foreach ($values as $value) {
                $queryParts[] = urlencode($paramName).'='.urlencode($value);
            }
        }

        return '?'.implode('&', $queryParts);
    }
}
