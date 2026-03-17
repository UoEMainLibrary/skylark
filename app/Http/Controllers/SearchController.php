<?php

namespace App\Http\Controllers;

use App\Services\RepositoryFactory;
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

        // Build collection-aware search URL
        $collection = config('app.current_collection', 'clds');
        $prefix = $collection === 'clds' ? '' : "/{$collection}";

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
        $sortBy = $request->get('sort_by', config('skylight.default_sort'));
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

        $collection = config('app.current_collection', 'clds');
        $prefix = $collection === 'clds' ? '' : "/{$collection}";

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
                    // Handle both formats: space-separated (old links) and already-newlined
                    // (from urlencode/urldecode roundtrip in new links).
                    $solrValue = str_replace(' ||| ', "\n|||\n", $filterValue);

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
     * Build base search URL for facets
     */
    protected function buildBaseSearchUrl(string $query, array $filters): string
    {
        $collection = config('app.current_collection', 'clds');
        $prefix = $collection === 'clds' ? '' : "/{$collection}";
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
