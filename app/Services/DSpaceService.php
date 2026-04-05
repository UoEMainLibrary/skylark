<?php

namespace App\Services;

use App\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Http;

class DSpaceService implements RepositoryInterface
{
    protected string $baseUrl;

    protected string $containerId;

    protected string $containerField;

    protected int $resultsPerPage;

    protected bool $isDSpace;

    protected string $handlePrefix;

    protected bool $filterSort;

    public function __construct()
    {
        $fallback = config('services.solr');

        $this->baseUrl = env('SOLR_BASE_URL', 'http://localhost:8080/solr/search/');
        $this->containerId = config('skylight.container_id', $fallback['container_id']);
        $this->containerField = config('skylight.container_field', $fallback['container_field']);
        $this->resultsPerPage = config('skylight.results_per_page', $fallback['results_per_page']);
        $this->isDSpace = config('skylight.repository_type', 'dspace') === 'dspace';
        $this->handlePrefix = config('skylight.handle_prefix', '10683');
        $this->filterSort = (bool) config('skylight.filter_sort', false);
    }

    /**
     * Execute a search query against Solr
     */
    public function search(string $query, array $filters = [], int $page = 1, ?string $sortBy = null): array
    {
        $start = ($page - 1) * $this->resultsPerPage;
        $rows = $this->resultsPerPage;

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

        // Apply resource type filter (DSpace items only)
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

        // Apply additional filters
        foreach ($filters as $key => $value) {
            $filterQueries[] = "{$key}:{$value}";
        }

        // Set sort if provided
        if ($sortBy) {
            $params['sort'] = $sortBy;
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

        // Apply resource type filter (DSpace items only)
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

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
        // Construct full handle (e.g., 10683/51352)
        $fullHandle = $this->handlePrefix.'/'.$id;

        // Build query parameters
        $params = [
            'q' => "handle:\"{$fullHandle}\" OR id:\"{$id}\"",
            'rows' => 1,
            'wt' => 'json',
        ];

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items only)
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

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

        // Transform field names (remove dots)
        return $this->transformFieldNames($docs[0]);
    }

    /**
     * Get related items for a record.
     *
     * Matches the old CodeIgniter behaviour: takes the first value from each
     * related field and runs a free-text OR query (no field prefix), so
     * "Clarinet" can match in title, description, subject, etc.
     */
    public function getRelatedItems(array $record, int $limit = 10): array
    {
        $relatedFieldMappings = config('skylight.related_fields', []);

        if (empty($relatedFieldMappings)) {
            return [];
        }

        // Collect the first value from each configured related field
        $queryTerms = [];
        foreach ($relatedFieldMappings as $displayName => $solrField) {
            $fieldKey = str_replace('.', '', $solrField);

            if (isset($record[$fieldKey]) && ! empty($record[$fieldKey])) {
                $values = is_array($record[$fieldKey]) ? $record[$fieldKey] : [$record[$fieldKey]];
                $firstValue = $values[0] ?? null;

                if (! empty($firstValue)) {
                    $queryTerms[] = '"'.addcslashes($firstValue, '"').'"';
                }
            }
        }

        if (empty($queryTerms)) {
            return [];
        }

        // Get current record ID for exclusion
        $currentId = $record['Id'] ?? $record['id'] ?? null;
        if (! $currentId) {
            return [];
        }

        $fullHandle = $this->handlePrefix.'/'.$currentId;

        // Free-text OR query with handle exclusion (matches old CI behaviour)
        $params = [
            'q' => implode(' OR ', $queryTerms).' -handle:"'.$fullHandle.'"',
            'rows' => 5,
            'wt' => 'json',
        ];

        $filterQueries = [];
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQuery($params, $filterQueries));

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json();
            $docs = $data['response']['docs'] ?? [];
        } catch (\Exception $e) {
            return [];
        }

        return array_map(fn ($doc) => $this->transformFieldNames($doc), $docs);
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

        // Apply resource type filter (DSpace items only)
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

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

        if ($this->filterSort) {
            $params['facet.sort'] = 'index';
        }

        $documentFieldList = config('skylight.solr_document_field_list');
        if (is_string($documentFieldList) && $documentFieldList !== '') {
            $params['fl'] = $documentFieldList;
        }

        // Build filter queries array
        $filterQueries = [];

        // Apply container scoping
        $filterQueries[] = "{$this->containerField}:{$this->containerId}";

        // Apply resource type filter (DSpace items only)
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

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

        // Add facet fields from config (standard + date facets)
        $facetFieldParams = [];
        $configFilters = config('skylight.filters', []);
        foreach ($configFilters as $filterField) {
            $facetFieldParams[] = $filterField;
        }
        foreach (config('skylight.date_filters', []) as $filterField) {
            if (! in_array($filterField, $facetFieldParams, true)) {
                $facetFieldParams[] = $filterField;
            }
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

        // Reverse map: solr field -> display name (filters + date facets)
        $fieldToName = array_flip($configFilters);
        foreach (config('skylight.date_filters', []) as $label => $solrField) {
            $fieldToName[$solrField] = $label;
        }

        foreach ($facetData as $facetField => $facetTerms) {
            $facetDisplayName = $fieldToName[$facetField] ?? $facetField;

            $activeTerms = [];
            $inactiveTerms = [];

            // Process alternating key-value pairs from Solr
            for ($i = 0; $i < count($facetTerms); $i += 2) {
                if (isset($facetTerms[$i + 1])) {
                    $termName = $facetTerms[$i];
                    $termCount = $facetTerms[$i + 1];

                    // Extract display name from "|||" delimiter (e.g., "rare books ||| Rare Books" -> "Rare Books")
                    $termDisplayName = $termName;
                    if (str_contains($termName, '|||')) {
                        $parts = preg_split('/\|\|\|/', $termName);
                        if (isset($parts[1])) {
                            $termDisplayName = trim($parts[1]);
                        }
                    }

                    // Check if this term is active
                    // activeFilters contains URL segments like: Type:"rare+books+|||+Rare+Books"
                    // termName is the raw Solr value like: "rare books\n|||\nRare Books" (with newlines)
                    $isActive = false;

                    // Normalize term for comparison: collapse newlines to spaces
                    $normalizedTermName = str_replace(["\r\n", "\n", "\r"], ' ', $termName);

                    foreach ($activeFilters as $activeFilter) {
                        // Normalize the active filter the same way (decode + to space)
                        $normalizedFilter = str_replace('+', ' ', $activeFilter);
                        if (str_contains($normalizedFilter, $normalizedTermName)) {
                            $isActive = true;
                            break;
                        }
                    }

                    $term = [
                        'name' => $termName,
                        'display_name' => $termDisplayName,
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
                'name' => $facetDisplayName,
                'field' => $facetField,
                'terms' => array_merge($activeTerms, $inactiveTerms),
                'active_terms' => $activeTerms,
                'inactive_terms' => $inactiveTerms,
                'queries' => [],
            ];
        }

        return $facets;
    }

    /**
     * Browse facet terms (Skylight-compatible shape for theme browse pages).
     *
     * @return array{rows: int, facet: array{name: string, terms: list<array{name: string, display_name: string, count: int}>, termcount: int}}
     */
    public function browseTerms(string $field, int $rows = 30, int $offset = 0, string $prefix = ''): array
    {
        $filters = config('skylight.filters', []);
        $dateFilters = config('skylight.date_filters', []);
        $facetField = $filters[$field] ?? $dateFilters[$field] ?? null;

        if ($facetField === null || $this->containerId === '') {
            return [
                'rows' => 0,
                'facet' => ['name' => $field, 'terms' => [], 'termcount' => 0],
            ];
        }

        $offset = max(0, $offset);
        $rows = max(1, $rows);
        $limit = $rows + 1;

        $params = [
            'q' => '*:*',
            'rows' => 0,
            'wt' => 'json',
            'facet' => 'true',
            'facet.mincount' => 1,
            'facet.sort' => 'index',
            'facet.field' => $facetField,
            'facet.limit' => $limit,
            'facet.offset' => $offset,
        ];

        if ($prefix !== '') {
            $params['facet.prefix'] = $prefix;
        }

        $filterQueries = [
            "{$this->containerField}:{$this->containerId}",
        ];
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

        $queryString = $this->buildSolrQuery($params, $filterQueries);
        $response = Http::timeout(30)->get("{$this->baseUrl}select{$queryString}");

        if (! $response->successful()) {
            return [
                'rows' => 0,
                'facet' => ['name' => $field, 'terms' => [], 'termcount' => 0],
            ];
        }

        $data = $response->json();
        $numFound = (int) ($data['response']['numFound'] ?? 0);
        $facetPairs = $data['facet_counts']['facet_fields'][$facetField] ?? [];

        $terms = [];
        for ($i = 0; $i < count($facetPairs); $i += 2) {
            if (! isset($facetPairs[$i + 1])) {
                break;
            }
            $rawName = $facetPairs[$i];
            $count = $facetPairs[$i + 1];
            $displayName = $rawName;
            if (str_contains((string) $rawName, '|||')) {
                $parts = preg_split('/\|\|\|/', (string) $rawName);
                if (isset($parts[1])) {
                    $displayName = trim($parts[1]);
                }
            }
            $terms[] = [
                'name' => rawurlencode(str_replace(["\r\n", "\n", "\r"], ' ', (string) $rawName)),
                'display_name' => $displayName,
                'count' => $count,
            ];
            if (count($terms) >= $rows) {
                break;
            }
        }

        return [
            'rows' => $numFound,
            'facet' => [
                'name' => $field,
                'terms' => $terms,
                'termcount' => count($terms),
            ],
        ];
    }

    /**
     * Total number of distinct facet values for browse pagination.
     */
    public function countBrowseTerms(string $field, string $prefix = ''): int
    {
        $filters = config('skylight.filters', []);
        $dateFilters = config('skylight.date_filters', []);
        $facetField = $filters[$field] ?? $dateFilters[$field] ?? null;

        if ($facetField === null || $this->containerId === '') {
            return 0;
        }

        $params = [
            'q' => '*:*',
            'rows' => 0,
            'wt' => 'json',
            'facet' => 'true',
            'facet.mincount' => 1,
            'facet.sort' => 'index',
            'facet.field' => $facetField,
            'facet.limit' => 100000,
        ];

        if ($prefix !== '') {
            $params['facet.prefix'] = $prefix;
        }

        $filterQueries = [
            "{$this->containerField}:{$this->containerId}",
        ];
        if ($this->isDSpace) {
            $filterQueries[] = 'search.resourcetype:2';
        }

        $response = Http::timeout(30)->get("{$this->baseUrl}select".$this->buildSolrQuery($params, $filterQueries));

        if (! $response->successful()) {
            return 0;
        }

        $data = $response->json();
        $facetPairs = $data['facet_counts']['facet_fields'][$facetField] ?? [];

        return (int) (count($facetPairs) / 2);
    }

    /**
     * Transform Solr field names by removing dots
     */
    public function transformFieldNames(array $doc): array
    {
        $transformed = [];

        foreach ($doc as $key => $value) {
            $newKey = str_replace('.', '', $key);
            $transformed[$newKey] = $value;
        }

        // Extract numeric ID from handle (e.g., "10683/18492" -> "18492")
        if (isset($doc['handle'])) {
            $handleParts = explode('/', $doc['handle']);
            $transformed['id'] = end($handleParts);
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
