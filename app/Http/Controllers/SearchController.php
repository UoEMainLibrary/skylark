<?php

namespace App\Http\Controllers;

use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        protected RepositoryFactory $repositoryFactory
    ) {}

    /**
     * Get collection-aware view name, respecting skin version for EERC.
     */
    protected function collectionView(string $view): string
    {
        $collection = config('app.current_collection', 'clds');
        $collectionView = "{$collection}.{$view}";

        if ($collection === 'eerc') {
            return PageController::eercViewName($collectionView);
        }

        return view()->exists($collectionView) ? $collectionView : $view;
    }

    /**
     * Handle search form POST and redirect to GET URL
     */
    public function redirect(Request $request)
    {
        $query = $request->input('q', '*');

        // Sanitize query
        if (empty($query) || $query === '*') {
            $query = '*';
        }

        $prefix = CollectionUrl::pathPrefix();

        return redirect("{$prefix}/search/{$query}");
    }

    /**
     * Display search results
     */
    public function index(Request $request, string $query = '*')
    {
        // Extract filter segments from the raw URI to preserve %2F inside filter values.
        // $request->segments() decodes %2F to / before splitting, which breaks filters
        // containing slashes (e.g., "Mouthpiece/Mouthpieces/Musical Instrument").
        $filterSegments = $this->extractFilterSegments($request, $query);

        // Parse filters from URL segments
        $parsedFilters = $this->parseFilters($filterSegments);

        // Get pagination and sort parameters
        $offset = (int) $request->get('offset', 0);
        $sortBy = $request->get('sort_by', '');
        $rows = (int) $request->get('num_results', config('skylight.results_per_page'));

        // Get repository service for current collection
        $repository = $this->repositoryFactory->current();

        // Execute search
        try {
            $results = $repository->searchWithHighlighting(
                $query,
                $parsedFilters['solr_filters'],
                $offset,
                $sortBy,
                $rows,
                $parsedFilters['url_filters']
            );
        } catch (\Exception $e) {
            return view($this->collectionView('search.error'), [
                'error' => $e->getMessage(),
                'query' => $query,
            ]);
        }

        // Build base search URL for facets and pagination
        $baseSearch = $this->buildBaseSearchUrl($query, $filterSegments);

        // Build base parameters for sort
        $baseParameters = $request->getQueryString() ? '?'.$request->getQueryString() : '';
        $baseParameters = preg_replace('/[?&]sort_by=[^&]*/', '', $baseParameters);

        // Calculate row display
        $startRow = $offset + 1;
        $endRow = min($offset + $rows, $results['total']);

        // Build pagination links
        $paginationLinks = $this->buildPaginationLinks(
            $results['total'],
            $rows,
            $offset,
            $baseSearch,
            $baseParameters
        );

        // Prepare view data
        $data = [
            'docs' => $results['docs'],
            'total' => $results['total'],
            'query' => $query,
            'searchbox_query' => ($query === '*' || $query === '*:*') ? '' : urldecode($query),
            'base_search' => $baseSearch,
            'base_parameters' => $baseParameters,
            'facets' => $results['facets'],
            'highlights' => $results['highlights'],
            'suggestions' => $results['suggestions'],
            'startRow' => $startRow,
            'endRow' => $endRow,
            'offset' => $offset,
            'rows' => $rows,
            'sort_by' => $sortBy,
            'sort_options' => config('skylight.sort_fields'),
            'paginationLinks' => $paginationLinks,
            'active_filters' => $parsedFilters['url_filters'],
            'delimiter' => config('skylight.filter_delimiter'),
        ];

        return view($this->collectionView('search.results'), $data);
    }

    /**
     * Extract filter segments from the raw request URI.
     *
     * Filter values may contain "/" (encoded as %2F in the URL).
     * Using $request->segments() decodes %2F to "/" before splitting,
     * which corrupts those filters. The raw URI preserves %2F, so
     * splitting on literal "/" correctly separates filter segments.
     */
    protected function extractFilterSegments(Request $request, string $query): array
    {
        $rawUri = strtok($request->getRequestUri(), '?');

        $prefix = CollectionUrl::pathPrefix();

        // Try both encoded and raw forms of the query in the path
        $needles = [
            "{$prefix}/search/{$query}/",
            "{$prefix}/search/".rawurlencode($query).'/',
        ];

        $filterString = '';
        foreach ($needles as $needle) {
            $pos = strpos($rawUri, $needle);
            if ($pos !== false) {
                $filterString = substr($rawUri, $pos + strlen($needle));
                break;
            }
        }

        if (empty($filterString)) {
            return [];
        }

        // Split on literal "/" — encoded slashes (%2F) inside values are preserved
        $rawSegments = explode('/', $filterString);

        return array_map('urldecode', array_filter($rawSegments, fn ($s) => $s !== ''));
    }

    /**
     * Parse filter segments from URL
     */
    protected function parseFilters(array $segments): array
    {
        $solrFilters = [];
        $urlFilters = [];
        $configFilters = config('skylight.filters', []);
        $delimiter = config('skylight.filter_delimiter');

        foreach ($segments as $segment) {
            $urlFilters[] = $segment;

            // Split by delimiter (e.g., Type:"Image")
            $parts = explode($delimiter, $segment, 2);

            if (count($parts) === 2) {
                $filterName = urldecode($parts[0]);
                $filterValue = $parts[1];

                // Map display name to Solr field
                if (isset($configFilters[$filterName])) {
                    $solrField = $configFilters[$filterName];

                    // Restore newlines around "|||" — Solr stores them with \n delimiters.
                    // Handles all variants: no spaces, space-separated, or already-newlined.
                    $solrValue = preg_replace('/\s*\|\|\|\s*/', "\n|||\n", $filterValue);

                    $solrFilters[] = "{$solrField}:{$solrValue}";
                }
            }
        }

        return [
            'solr_filters' => $solrFilters,
            'url_filters' => $urlFilters,
        ];
    }

    /**
     * Display the advanced search form
     */
    public function advancedForm()
    {
        $searchFields = config('skylight.search_fields', []);

        return view($this->collectionView('search.advanced'), [
            'searchFields' => $searchFields,
        ]);
    }

    /**
     * Handle advanced search form POST — build URL and redirect to GET
     */
    public function advancedPost(Request $request)
    {
        $searchFields = config('skylight.search_fields', []);
        $prefix = CollectionUrl::pathPrefix();

        $filterUrl = '';
        foreach ($searchFields as $label => $field) {
            $escapedLabel = str_replace(' ', '_', $label);
            $val = trim((string) $request->input($escapedLabel, ''));
            if ($val !== '') {
                $filterUrl .= '/'.rawurlencode($label).':'.$val;
            }
        }

        $operator = $request->input('operator', 'OR');

        return redirect("{$prefix}/advanced/search{$filterUrl}?operator={$operator}");
    }

    /**
     * Display advanced search results
     */
    public function advancedSearch(Request $request, ?string $filters = null)
    {
        $prefix = CollectionUrl::pathPrefix();
        $searchFields = config('skylight.search_fields', []);
        $configFilters = config('skylight.filters', []);
        $delimiter = config('skylight.filter_delimiter', ':');
        $rows = (int) $request->get('num_results', config('skylight.results_per_page'));
        $offset = (int) $request->get('offset', 0);
        $sortBy = $request->get('sort_by', '');
        $operator = $request->get('operator', 'OR');

        // Parse filter segments from the URL path
        $rawUri = strtok($request->getRequestUri(), '?');
        $searchPrefix = "{$prefix}/advanced/search/";
        $pos = strpos($rawUri, $searchPrefix);
        $filterString = $pos !== false ? substr($rawUri, $pos + strlen($searchPrefix)) : '';

        $solrFilters = [];
        $urlFilters = [];
        $savedSearch = [];
        $message = '<h3>Currently searching the following fields:</h3>';

        if (! empty($filterString)) {
            $rawSegments = explode('/', $filterString);
            foreach ($rawSegments as $segment) {
                if (empty($segment)) {
                    continue;
                }
                $decoded = urldecode($segment);
                $urlFilters[] = $segment;
                $parts = explode($delimiter, $decoded, 2);

                if (count($parts) === 2) {
                    $fieldLabel = $parts[0];
                    $fieldValue = $parts[1];

                    if (isset($searchFields[$fieldLabel])) {
                        $solrFilters[] = $searchFields[$fieldLabel].':'.$fieldValue;
                        $savedSearch[$fieldLabel] = $fieldValue;
                        $message .= '<strong>'.$fieldLabel.'</strong> : '.urldecode($fieldValue).'<br/>';
                    }
                }
            }
        }

        $repository = $this->repositoryFactory->current();

        try {
            $results = $repository->searchWithHighlighting(
                '*:*',
                $solrFilters,
                $offset,
                $sortBy,
                $rows,
                []
            );
        } catch (\Exception $e) {
            return view($this->collectionView('search.error'), [
                'error' => $e->getMessage(),
                'query' => '*:*',
            ]);
        }

        $baseSearch = url("{$prefix}/advanced/search");
        foreach ($urlFilters as $f) {
            $baseSearch .= '/'.$f;
        }

        $baseParameters = '?operator='.$operator;
        if (! empty($sortBy)) {
            $baseParameters .= '&sort_by='.$sortBy;
        }

        $startRow = $offset + 1;
        $endRow = min($offset + $rows, $results['total']);

        $paginationLinks = $this->buildPaginationLinks(
            $results['total'],
            $rows,
            $offset,
            $baseSearch,
            $baseParameters
        );

        $data = [
            'docs' => $results['docs'],
            'total' => $results['total'],
            'query' => '*:*',
            'searchbox_query' => '',
            'base_search' => $baseSearch,
            'base_parameters' => $baseParameters,
            'facets' => $results['facets'],
            'highlights' => $results['highlights'],
            'suggestions' => $results['suggestions'] ?? [],
            'startRow' => $startRow,
            'endRow' => $endRow,
            'offset' => $offset,
            'rows' => $rows,
            'sort_by' => $sortBy,
            'sort_options' => config('skylight.sort_fields'),
            'paginationLinks' => $paginationLinks,
            'active_filters' => [],
            'delimiter' => $delimiter,
            'message' => $message,
            'searchFields' => $searchFields,
            'savedSearch' => $savedSearch,
            'operator' => $operator,
        ];

        return view($this->collectionView('search.results'), $data);
    }

    /**
     * Build base search URL for facets
     */
    protected function buildBaseSearchUrl(string $query, array $filters): string
    {
        $prefix = CollectionUrl::pathPrefix();
        $url = url("{$prefix}/search/{$query}");

        foreach ($filters as $filter) {
            $url .= '/'.rawurlencode($filter);
        }

        return $url;
    }

    /**
     * Build pagination links
     */
    protected function buildPaginationLinks(
        int $total,
        int $rows,
        int $offset,
        string $baseUrl,
        string $baseParameters
    ): string {
        $currentPage = floor($offset / $rows) + 1;
        $totalPages = max(1, ceil($total / $rows));
        $numLinks = 4; // Number of links on each side

        $links = '<ul class="pagination pagination-sm pagination-xs">';

        // Previous link
        if ($currentPage > 1) {
            $prevOffset = ($currentPage - 2) * $rows;
            $prevUrl = $baseUrl.$baseParameters.($baseParameters ? '&' : '?')."offset={$prevOffset}";
            $links .= "<li><a href=\"{$prevUrl}\">&laquo;</a></li>";
        }

        // Page links
        $start = max(1, $currentPage - $numLinks);
        $end = min($totalPages, $currentPage + $numLinks);

        for ($i = $start; $i <= $end; $i++) {
            $pageOffset = ($i - 1) * $rows;
            $pageUrl = $baseUrl.$baseParameters.($baseParameters ? '&' : '?')."offset={$pageOffset}";

            if ($i == $currentPage) {
                $links .= "<li class=\"active\"><span>{$i}</span></li>";
            } else {
                $links .= "<li><a href=\"{$pageUrl}\">{$i}</a></li>";
            }
        }

        // Next link
        if ($currentPage < $totalPages) {
            $nextOffset = $currentPage * $rows;
            $nextUrl = $baseUrl.$baseParameters.($baseParameters ? '&' : '?')."offset={$nextOffset}";
            $links .= "<li><a href=\"{$nextUrl}\">&raquo;</a></li>";
        }

        $links .= '</ul>';

        return $links;
    }
}
