<?php

namespace App\Http\Controllers;

use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
use App\Support\CollectionViewResolver;
use App\Support\SolrFilterQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            return CollectionViewResolver::eerc($collectionView);
        }

        if ($collection === 'public-art') {
            $resolved = CollectionViewResolver::publicArt($collectionView);

            return view()->exists($resolved) ? $resolved : $view;
        }

        if ($collection === 'geddes') {
            $resolved = CollectionViewResolver::geddes($collectionView);

            return view()->exists($resolved) ? $resolved : $view;
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
            return $this->searchFailureResponse($e, $query);
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

        // Locate the start of the {query} segment in the raw URI. We can't
        // rely on matching the (already partially-decoded) $query against the
        // raw URI because Laravel decodes "%22" → '"' etc. but leaves "+" as
        // a literal "+", so neither rawurlencode($query) nor urlencode($query)
        // will reliably match in all real-world URLs (e.g. when the link was
        // generated by the legacy CodeIgniter site, which uses + for spaces).
        $searchPrefix = "{$prefix}/search/";
        $pos = strpos($rawUri, $searchPrefix);
        if ($pos === false) {
            return [];
        }

        $afterSearch = substr($rawUri, $pos + strlen($searchPrefix));

        // Skip over the {query} path segment to reach the optional filters.
        $slashPos = strpos($afterSearch, '/');
        if ($slashPos === false) {
            return [];
        }

        $filterString = substr($afterSearch, $slashPos + 1);
        if ($filterString === '') {
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

                    // Legacy DSpace facets store compound values with line breaks around
                    // the "|||" delimiter (e.g. "theatre\n|||\nTheatre"), so preserve
                    // that representation when converting URL filters to Solr fq values.
                    $solrValue = preg_replace('/\s*\|\|\|\s*/', "\n|||\n", $filterValue);

                    $solrFilters[] = "{$solrField}:{$solrValue}";
                }
            }
        }

        return [
            'solr_filters' => SolrFilterQuery::onlyValid($solrFilters),
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
     *
     * Builds a Solr `q` Lucene query from the user-supplied search fields
     * combined with the chosen operator (AND/OR). We do not use `fq` for the
     * user terms because the legacy DSpace 6 client wrapped fq values with
     * `*value*` substring wildcards — without that wrapping, `fq=text:test`
     * matches only documents whose text field equals exactly "test" (and
     * `text` is typically a copy field that is searchable as the default
     * field, not as a direct fq target). Putting the terms into `q` lets
     * Solr apply its analyzer and default search field correctly.
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
        $operator = strtoupper($request->get('operator', 'OR')) === 'AND' ? 'AND' : 'OR';

        // Parse filter segments from the URL path
        $rawUri = strtok($request->getRequestUri(), '?');
        $searchPrefix = "{$prefix}/advanced/search/";
        $pos = strpos($rawUri, $searchPrefix);
        $filterString = $pos !== false ? substr($rawUri, $pos + strlen($searchPrefix)) : '';

        // Fall back to the route parameter when the URI doesn't include the
        // expected prefix (e.g. dedicated host that mounts the routes at /).
        if ($filterString === '' && is_string($filters) && $filters !== '') {
            $filterString = $filters;
        }

        $urlFilters = [];
        $savedSearch = [];
        $queryClauses = [];
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
                    $fieldValue = trim($parts[1]);

                    if ($fieldValue === '' || ! isset($searchFields[$fieldLabel])) {
                        continue;
                    }

                    $solrField = $searchFields[$fieldLabel];
                    $savedSearch[$fieldLabel] = $fieldValue;
                    $message .= '<strong>'.$fieldLabel.'</strong> : '.$fieldValue.'<br/>';

                    // Wrap unquoted multi-word values in parentheses so that the
                    // operator joining clauses doesn't accidentally split them.
                    $clauseValue = $fieldValue;
                    if (! str_starts_with($clauseValue, '"') && str_contains($clauseValue, ' ')) {
                        $clauseValue = '('.$clauseValue.')';
                    }

                    // For the special `text` copy field (which DSpace exposes
                    // as the default search field), drop the field prefix so
                    // Solr falls back to its `df` rather than trying to query
                    // `text` directly as a Lucene field.
                    if ($solrField === 'text' || $solrField === '_text_') {
                        $queryClauses[] = $clauseValue;
                    } else {
                        $queryClauses[] = $solrField.':'.$clauseValue;
                    }
                }
            }
        }

        $queryString = empty($queryClauses)
            ? '*:*'
            : implode(' '.$operator.' ', $queryClauses);

        $repository = $this->repositoryFactory->current();

        try {
            $results = $repository->searchWithHighlighting(
                $queryString,
                [],
                $offset,
                $sortBy,
                $rows,
                []
            );
        } catch (\Exception $e) {
            return $this->searchFailureResponse($e, $queryString);
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
            'query' => $queryString,
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
     * Build base search URL for facets.
     *
     * Uses urlencode (space → "+") and then restores the literal ":" between the
     * facet name and value to match the legacy CodeIgniter URL style
     * (e.g. /Collection:%22students+of+medicine%22). Keeping this format
     * consistent with what the facet Blade partials generate is what allows
     * the "Remove" links (which run a preg_replace against $base_search) to
     * actually strip the matching segment.
     */
    protected function buildBaseSearchUrl(string $query, array $filters): string
    {
        $prefix = CollectionUrl::pathPrefix();
        $url = url("{$prefix}/search/{$query}");

        foreach ($filters as $filter) {
            $encoded = urlencode($filter);
            // Keep ":" literal so Facet:"value" segments are recognisable and
            // match the patterns produced by the facet partials.
            $encoded = str_replace('%3A', ':', $encoded);
            $url .= '/'.$encoded;
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

    protected function searchFailureResponse(\Throwable $e, string $query)
    {
        if ($this->isSolrQueryClientError($e)) {
            Log::warning('Search skipped invalid Solr filter query', [
                'query' => $query,
                'collection' => config('app.current_collection'),
                'message' => Str::limit($e->getMessage(), 500),
            ]);
        } elseif (! $this->isSearchBackendAccessDenied($e)) {
            report($e);
        }

        $isAccessDenied = $this->isSearchBackendAccessDenied($e);
        $status = $isAccessDenied ? 503 : 500;
        $message = $isAccessDenied
            ? 'Search is temporarily unavailable because the repository access is denied. If you are working locally, connect to the VPN and try again.'
            : 'There was a problem performing your search. Please try again later.';

        $errorView = $this->collectionView('search.error');
        if (! view()->exists($errorView)) {
            return response($message, $status);
        }

        return response()->view($errorView, [
            'error' => $e->getMessage(),
            'query' => $query,
            'accessDenied' => $isAccessDenied,
            'friendlyMessage' => $message,
        ], $status);
    }

    protected function isSearchBackendAccessDenied(\Throwable $e): bool
    {
        $message = $e->getMessage();

        return Str::contains($message, [
            'Solr query failed: 401',
            'Solr query failed: 403',
            'Access denied',
        ]);
    }

    protected function isSolrQueryClientError(\Throwable $e): bool
    {
        return Str::contains($e->getMessage(), 'Solr query failed: 400');
    }
}
