<?php

namespace App\Services;

use App\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ArchivesSpaceService implements RepositoryInterface
{
    protected string $solrBase;

    protected string $solrCore;

    protected ?string $sessionToken = null;

    public function __construct()
    {
        $this->solrBase = rtrim(config('skylight.solr_base'), '/');
        $this->solrCore = config('skylight.solr_core', 'solr/archivesspace');
    }

    /**
     * Search the ArchivesSpace repository
     */
    public function search(string $query, array $filters = [], int $page = 1, ?string $sortBy = null): array
    {
        $resultsPerPage = config('skylight.results_per_page', 10);
        $start = ($page - 1) * $resultsPerPage;

        // Build Solr query
        $params = [
            'q' => $query === '*' ? '*:*' : $query,
            'wt' => 'json',
            'start' => $start,
            'rows' => $resultsPerPage,
            'facet' => 'true',
            'facet.field' => array_values(config('skylight.filters', [])),
            'facet.mincount' => 1,
        ];

        // Add container filtering
        $containerField = config('skylight.container_field');
        $containerIds = config('skylight.container_id', []);

        if ($containerField && ! empty($containerIds)) {
            $filterQueries = [];
            foreach ($containerIds as $containerId) {
                $filterQueries[] = "{$containerField}:{$containerId}";
            }
            $params['fq'] = $filterQueries;
        }

        // Add additional filters
        if (! empty($filters)) {
            if (! isset($params['fq'])) {
                $params['fq'] = [];
            }
            $params['fq'] = array_merge($params['fq'], $filters);
        }

        // Ensure fq array exists for required filters
        if (! isset($params['fq'])) {
            $params['fq'] = [];
        }

        // Exclude PUI records and only include archival_object and resource types
        // Note: + acts as OR operator in Solr (matching CodeIgniter)
        $params['fq'][] = '-id:*pui';
        $params['fq'][] = 'types:"archival_object"+types:"resource"';

        // Add sorting
        if ($sortBy) {
            $params['sort'] = $sortBy;
        } else {
            // Default sort for EERC
            $collection = config('app.current_collection');
            if ($collection !== 'eerc' && config('skylight.default_sort')) {
                $params['sort'] = config('skylight.default_sort');
            }
        }

        try {
            $response = Http::timeout(30)->get("{$this->solrBase}/{$this->solrCore}/select", $params);

            if (! $response->successful()) {
                Log::error('ArchivesSpace Solr query failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return ['total' => 0, 'docs' => [], 'facets' => []];
            }

            $data = $response->json();

            return [
                'total' => $data['response']['numFound'] ?? 0,
                'docs' => array_map(
                    fn ($doc) => $this->transformFieldNames($doc, true),
                    $data['response']['docs'] ?? []
                ),
                'facets' => $data['facet_counts']['facet_fields'] ?? [],
            ];
        } catch (\Exception $e) {
            Log::error('ArchivesSpace search exception', [
                'message' => $e->getMessage(),
                'query' => $query,
            ]);

            return ['total' => 0, 'docs' => [], 'facets' => []];
        }
    }

    /**
     * Get a single record by ID
     */
    public function getRecord(string $id): ?array
    {
        // For ArchivesSpace, construct the full handle
        $handlePrefix = config('skylight.handle_prefix', '/repositories/15/');
        $fullHandle = $id;

        // If ID doesn't start with the prefix, add it
        if (! str_starts_with($id, $handlePrefix)) {
            $fullHandle = $handlePrefix.'resources/'.$id;
        }

        $params = [
            'q' => 'id:"'.$fullHandle.'" OR id:"'.$id.'"',
            'wt' => 'json',
            'rows' => 1,
            'fl' => '*,json',
        ];

        try {
            $response = Http::timeout(10)->get("{$this->solrBase}/{$this->solrCore}/select", $params);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();

            if (empty($data['response']['docs'])) {
                return null;
            }

            return $this->transformFieldNames($data['response']['docs'][0], false);
        } catch (\Exception $e) {
            Log::error('ArchivesSpace getRecord exception', [
                'message' => $e->getMessage(),
                'id' => $id,
            ]);

            return null;
        }
    }

    public function getRecordWithType(string $id, ?string $type = null): ?array
    {
        // Construct the full URI path based on ID and type
        $handlePrefix = config('skylight.handle_prefix', '/repositories/15/');
        
        // Convert type to plural form for URI path
        $typePath = match($type) {
            'archival_object' => 'archival_objects',
            'resource' => 'resources',
            default => 'resources',
        };
        
        $fullHandle = $handlePrefix.$typePath.'/'.$id;

        $params = [
            'q' => 'id:"'.$fullHandle.'"',
            'wt' => 'json',
            'rows' => 1,
            'fl' => '*,json',
        ];

        try {
            $response = Http::timeout(10)->get("{$this->solrBase}/{$this->solrCore}/select", $params);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();

            if (empty($data['response']['docs'])) {
                return null;
            }

            return $this->transformFieldNames($data['response']['docs'][0], false);
        } catch (\Exception $e) {
            Log::error('ArchivesSpace getRecordWithType exception', [
                'message' => $e->getMessage(),
                'id' => $id,
                'type' => $type,
            ]);

            return null;
        }
    }

    /**
     * Get related items for a record
     */
    public function getRelatedItems(array $record, int $limit = 10): array
    {
        $relatedFields = config('skylight.related_fields', []);

        if (empty($relatedFields)) {
            return [];
        }

        // Build query values from related fields (matching CodeIgniter logic)
        $queryValues = [];
        foreach ($relatedFields as $displayName => $fieldName) {
            // Check both display name and raw field name
            if (isset($record[$displayName])) {
                $values = is_array($record[$displayName]) ? $record[$displayName] : [$record[$displayName]];
                foreach ($values as $value) {
                    if (! empty($value) && is_string($value)) {
                        // Escape special Solr characters (matching CodeIgniter's escaping)
                        $escaped = preg_replace('/[\[\]\(\)\{\}\+\-\:\"\'\%]/', '', $value);
                        $queryValues[] = '"'.$escaped.'"';
                    }
                }
            } elseif (isset($record['_raw'][$fieldName])) {
                $values = is_array($record['_raw'][$fieldName]) ? $record['_raw'][$fieldName] : [$record['_raw'][$fieldName]];
                foreach ($values as $value) {
                    if (! empty($value) && is_string($value)) {
                        $escaped = preg_replace('/[\[\]\(\)\{\}\+\-\:\"\'\%]/', '', $value);
                        $queryValues[] = '"'.$escaped.'"';
                    }
                }
            }
        }

        if (empty($queryValues)) {
            return [];
        }

        // Build filter query string (matching CodeIgniter)
        $filterQuery = implode(' OR ', $queryValues);
        
        $containerField = config('skylight.container_field');
        $containerIds = config('skylight.container_id', []);
        $currentId = $record['Id'] ?? $record['_raw']['id'] ?? null;

        $url = "{$this->solrBase}/{$this->solrCore}/select?q=*:*";
        
        // Add container filter
        if ($containerField && !empty($containerIds)) {
            $url .= '&fq=';
            foreach ($containerIds as $index => $containerId) {
                if ($index > 0) {
                    $url .= '+';
                }
                $url .= $containerField.':'.$containerId;
            }
        }
        
        // Add the related items filter
        $url .= '&fq='.$filterQuery;
        
        // Exclude current record (no URL encoding to preserve slashes)
        if ($currentId) {
            $url .= '&fq=-id:'.$currentId;
        }
        
        // Exclude PUI records and only include archival_object and resource types
        $url .= '&fq=-id:*pui';
        $url .= '&fq=types:"archival_object"+types:"resource"';
        
        $url .= '&rows='.$limit;
        $url .= '&wt=json';

        try {
            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                return [];
            }

            $data = $response->json();
            $relatedItems = [];

            foreach ($data['response']['docs'] ?? [] as $doc) {
                $transformed = $this->transformFieldNames($doc, false);

                // Double-check exclusion in PHP (safety net)
                $docId = $transformed['Id'] ?? $doc['id'] ?? null;
                if ($docId === $currentId) {
                    continue;
                }
                
                $relatedItems[] = $transformed;
            }

            return $relatedItems;
        } catch (\Exception $e) {
            Log::error('ArchivesSpace getRelatedItems exception', ['message' => $e->getMessage()]);

            return [];
        }
    }

    /**
     * Build facets with active state
     */
    public function buildFacetsWithActiveState(array $facetData, array $activeFilters, array $configFilters): array
    {
        $facets = [];
        $fieldToName = array_flip($configFilters);

        foreach ($facetData as $facetField => $facetTerms) {
            $facetDisplayName = $fieldToName[$facetField] ?? $facetField;
            $activeTerms = [];
            $inactiveTerms = [];

            for ($i = 0; $i < count($facetTerms); $i += 2) {
                if (isset($facetTerms[$i + 1])) {
                    $termName = $facetTerms[$i];
                    $termCount = $facetTerms[$i + 1];

                    $termDisplayName = $termName;

                    $isActive = false;
                    $normalizedTermName = str_replace(["\r\n", "\n", "\r", ' '], '+', $termName);

                    foreach ($activeFilters as $activeFilter) {
                        if (str_contains($activeFilter, $normalizedTermName)) {
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
            ];
        }

        return $facets;
    }

    /**
     * Transform field names from ArchivesSpace schema to display names
     */
    public function transformFieldNames(array $record, bool $forSearchResults = false): array
    {
        $fieldMappings = config('skylight.field_mappings', []);
        $transformed = [];

        foreach ($fieldMappings as $displayName => $solrField) {
            if (isset($record[$solrField])) {
                // Special handling for notes field - extract from JSON field instead
                if ($solrField === 'notes') {
                    // Truncate for search results, full text for detail pages
                    $interviewSummary = $this->extractInterviewSummary($record, $forSearchResults);
                    if ($interviewSummary) {
                        $transformed[$displayName] = $interviewSummary;
                    }
                } elseif ($solrField === 'dates') {
                    // Extract dates from JSON field which has full structure
                    $dates = $this->extractDates($record);
                    if (!empty($dates)) {
                        $transformed[$displayName] = $dates;
                    }
                } elseif ($solrField === 'extents') {
                    // Extract extents from JSON field which has full structure
                    $extents = $this->extractExtents($record);
                    if (!empty($extents)) {
                        $transformed[$displayName] = $extents;
                    }
                } else {
                    $transformed[$displayName] = $record[$solrField];
                }
            }
        }

        // Keep ID and other essential fields
        if (isset($record['id'])) {
            $transformed['Id'] = $record['id'];
        }

        // Keep raw record for reference
        $transformed['_raw'] = $record;

        return $transformed;
    }

    /**
     * Extract interview summary from ArchivesSpace JSON field
     * Extracts from notes[0] which contains the scopecontent/biographical interview
     * For search results, only the first subnote is used and truncated
     * For detail pages, all subnotes are concatenated
     */
    protected function extractInterviewSummary(array $record, bool $truncate = true): ?string
    {
        if (!isset($record['json'])) {
            return null;
        }

        $jsonData = is_string($record['json']) ? json_decode($record['json'], true) : $record['json'];

        if (!$jsonData || !isset($jsonData['notes'])) {
            return null;
        }

        // Find the scopecontent note (usually notes[0])
        $scopecontentNote = null;
        foreach ($jsonData['notes'] as $note) {
            if (isset($note['type']) && $note['type'] === 'scopecontent') {
                $scopecontentNote = $note;
                break;
            }
        }

        if (!$scopecontentNote || !isset($scopecontentNote['subnotes'])) {
            return null;
        }

        // For search results, only use first subnote and truncate
        if ($truncate) {
            $content = trim($scopecontentNote['subnotes'][0]['content'] ?? '');
            if (strlen($content) > 200) {
                return substr($content, 0, 200).'...';
            }
            return $content;
        }

        // For detail pages, concatenate all subnotes with paragraph breaks
        $allContent = [];
        foreach ($scopecontentNote['subnotes'] as $subnote) {
            if (isset($subnote['content'])) {
                $allContent[] = trim($subnote['content']);
            }
        }

        return implode("\n\n", $allContent);
    }

    /**
     * Extract dates from ArchivesSpace JSON field
     * Returns array of date objects with label, begin, expression, etc.
     */
    protected function extractDates(array $record): array
    {
        if (!isset($record['json'])) {
            return [];
        }

        $jsonData = is_string($record['json']) ? json_decode($record['json'], true) : $record['json'];

        if (!$jsonData || !isset($jsonData['dates']) || !is_array($jsonData['dates'])) {
            return [];
        }

        return $jsonData['dates'];
    }

    /**
     * Extract extents from ArchivesSpace JSON field
     * Returns array of extent objects with number, extent_type, etc.
     */
    protected function extractExtents(array $record): array
    {
        if (!isset($record['json'])) {
            return [];
        }

        $jsonData = is_string($record['json']) ? json_decode($record['json'], true) : $record['json'];

        if (!$jsonData || !isset($jsonData['extents']) || !is_array($jsonData['extents'])) {
            return [];
        }

        return $jsonData['extents'];
    }

    /**
     * Get API session token for ArchivesSpace API calls
     */
    protected function getSessionToken(): ?string
    {
        if ($this->sessionToken) {
            return $this->sessionToken;
        }

        $apiUrl = config('skylight.archivesspace_url');
        $username = config('skylight.archivesspace_user');
        $password = config('skylight.archivesspace_password');

        if (! $apiUrl || ! $username || ! $password) {
            return null;
        }

        try {
            $response = Http::asForm()->post("{$apiUrl}/users/{$username}/login", [
                'password' => $password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->sessionToken = $data['session'] ?? null;

                return $this->sessionToken;
            }
        } catch (\Exception $e) {
            Log::error('ArchivesSpace authentication failed', ['message' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Get tree structure for a resource (for hierarchical navigation)
     */
    public function getTree(string $resourceId): ?array
    {
        $token = $this->getSessionToken();
        if (! $token) {
            return null;
        }

        $apiUrl = config('skylight.archivesspace_url');
        $treePath = config('skylight.archivesspace_tree');

        try {
            $response = Http::withHeaders([
                'X-ArchivesSpace-Session' => $token,
            ])->get("{$apiUrl}{$treePath}");

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('ArchivesSpace getTree exception', ['message' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Get collection tree structure (alias for getTree with no resourceId required)
     */
    public function getCollectionTree(): array
    {
        $tree = $this->getTree('');
        return $tree ?? ['children' => []];
    }

    /**
     * Search with highlighting support (for compatibility with search controller)
     */
    public function searchWithHighlighting(
        string $query,
        array $filters,
        int $offset,
        string $sortBy,
        int $rows,
        array $urlFilters = []
    ): array {
        if ($query === '*' || empty($query)) {
            $query = '*:*';
        }

        $page = (int) ceil(($offset / $rows)) + 1;
        $start = ($page - 1) * $rows;

        $containerField = config('skylight.container_field');
        $containerIds = config('skylight.container_id', []);
        $configFilters = config('skylight.filters', []);

        $url = "{$this->solrBase}/{$this->solrCore}/select?q=".urlencode($query);
        $url .= '&start='.$start;
        $url .= '&rows='.$rows;
        $url .= '&wt=json';
        $url .= '&fl=*,json';
        $url .= '&facet=true';
        $url .= '&facet.limit='.config('skylight.facet_limit', 10);
        $url .= '&facet.mincount=1';
        $url .= '&hl=true';
        $url .= '&hl.fl=*.en';
        $url .= '&hl.simple.pre='.urlencode('<strong>');
        $url .= '&hl.simple.post='.urlencode('</strong>');

        // Exclude PUI records and only include archival_object and resource types
        // Note: + acts as OR operator in Solr (matching CodeIgniter)
        $url .= '&fq=-id:*pui';
        $url .= '&fq=types:"archival_object"+types:"resource"';

        if ($containerField && ! empty($containerIds)) {
            foreach ($containerIds as $containerId) {
                $url .= '&fq='.urlencode("{$containerField}:{$containerId}");
            }
        }

        // Add filters without URL encoding (like CodeIgniter)
        // Filters already have proper Solr escaping (spaces as +)
        foreach ($filters as $filter) {
            $url .= '&fq='.$filter;
        }

        if ($sortBy) {
            $url .= '&sort='.urlencode(str_replace('+', ' ', $sortBy));
        }

        foreach ($configFilters as $filterName => $filterField) {
            $url .= '&facet.field='.urlencode($filterField);
        }

        try {
            $response = Http::timeout(30)->get($url);

            if (! $response->successful()) {
                Log::error('ArchivesSpace search failed', [
                    'status' => $response->status(),
                    'url' => $url,
                ]);

                return [
                    'total' => 0,
                    'docs' => [],
                    'facets' => [],
                    'highlights' => [],
                    'suggestions' => [],
                ];
            }

            $data = $response->json();

            $docs = array_map(
                fn ($doc) => $this->transformFieldNames($doc, true),
                $data['response']['docs'] ?? []
            );

            $facets = $this->buildFacetsWithActiveState(
                $data['facet_counts']['facet_fields'] ?? [],
                $urlFilters,
                $configFilters
            );

            return [
                'total' => $data['response']['numFound'] ?? 0,
                'docs' => $docs,
                'facets' => $facets,
                'highlights' => $data['highlighting'] ?? [],
                'suggestions' => [],
            ];
        } catch (\Exception $e) {
            Log::error('ArchivesSpace search exception', [
                'message' => $e->getMessage(),
                'query' => $query,
            ]);

            return [
                'total' => 0,
                'docs' => [],
                'facets' => [],
                'highlights' => [],
                'suggestions' => [],
            ];
        }
    }

    /**
     * Browse terms for a specific facet field
     */
    public function browseTerms(string $field = 'Subject', int $rows = 10, int $offset = 0): array
    {
        $configFilters = config('skylight.filters', []);
        $facetField = $configFilters[$field] ?? null;

        if (! $facetField) {
            return ['terms' => [], 'name' => $field, 'count' => 0];
        }

        $containerField = config('skylight.container_field');
        $containerIds = config('skylight.container_id', []);
        $restrictions = config('skylight.query_restriction', []);

        $url = "{$this->solrBase}/{$this->solrCore}/select?q=*:*";

        if ($containerField && ! empty($containerIds)) {
            $url .= '&fq=';
            $containerParts = [];
            foreach ($containerIds as $containerId) {
                $containerParts[] = "{$containerField}:{$containerId}";
            }
            $url .= implode('+', $containerParts);
        }

        foreach ($restrictions as $restrictField => $restrictBy) {
            $url .= '&fq='.urlencode($restrictField).':'.urlencode($restrictBy);
        }

        // Exclude PUI records and only include archival_object and resource types
        // Note: + acts as OR operator in Solr (matching CodeIgniter)
        $url .= '&fq=-id:*pui';
        $url .= '&fq=types:"archival_object"+types:"resource"';

        $url .= '&rows=0&facet.mincount=1';
        $url .= '&facet=true&facet.sort=count&facet.field='.urlencode($facetField).'&facet.limit='.($rows + 1);

        if ($offset > 0) {
            $url .= '&facet.offset='.$offset;
        }

        $url .= '&wt=json';

        try {
            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                Log::error('ArchivesSpace browseTerms failed', ['url' => $url, 'status' => $response->status()]);

                return ['terms' => [], 'name' => $field, 'count' => 0];
            }

            $data = $response->json();
            $facetData = $data['facet_counts']['facet_fields'][$facetField] ?? [];

            $terms = [];
            for ($i = 0; $i < count($facetData); $i += 2) {
                if (isset($facetData[$i + 1]) && count($terms) < $rows) {
                    $termName = $facetData[$i];
                    $termCount = $facetData[$i + 1];

                    $terms[] = [
                        'name' => urlencode($termName),
                        'display_name' => $termName,
                        'count' => $termCount,
                    ];
                }
            }

            return [
                'name' => $field,
                'terms' => $terms,
                'count' => count($terms),
            ];
        } catch (\Exception $e) {
            Log::error('ArchivesSpace browseTerms exception', ['message' => $e->getMessage(), 'url' => $url]);

            return ['terms' => [], 'name' => $field, 'count' => 0];
        }
    }
}
