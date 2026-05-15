<?php

namespace App\Http\Controllers\Collections\Openbooks;

use App\Http\Controllers\Controller;
use App\Services\DSpaceService;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the Open Books homepage with facets.
     */
    public function home()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0, []);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            report($e);
        }

        return view('openbooks.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
     * Display the Open Books IIIF page.
     */
    public function iiif()
    {
        return view('openbooks.pages.iiif');
    }

    /**
     * Browse all values for a facet (Skylight /browse/{facet}).
     */
    public function browse(Request $request, string $facet): View
    {
        $facet = urldecode($facet);
        $allowed = array_merge(
            array_keys(config('skylight.filters', [])),
            array_keys(config('skylight.date_filters', []))
        );
        if (! in_array($facet, $allowed, true)) {
            abort(404);
        }

        $repository = $this->repositoryFactory->current();
        if (! $repository instanceof DSpaceService) {
            abort(404);
        }

        $rows = 30;
        $offset = max(0, (int) $request->query('offset', 0));
        $prefix = (string) $request->query('prefix', '');

        $browseData = $repository->browseTerms($facet, $rows, $offset, $prefix);
        $collectionTotal = (int) ($browseData['rows'] ?? 0);
        $facetBlock = $browseData['facet'] ?? ['name' => $facet, 'terms' => [], 'termcount' => 0];
        $termsOnPage = $facetBlock['terms'] ?? [];

        $totalFacetValues = $repository->countBrowseTerms($facet, $prefix);
        $browseUrl = $prefix !== ''
            ? CollectionUrl::url('browse/'.$facet).'?prefix='.urlencode($prefix)
            : CollectionUrl::url('browse/'.$facet);

        $prevOffset = max(0, $offset - $rows);
        $nextOffset = $offset + $rows;
        $hasPrev = $offset > 0;
        $hasNext = $nextOffset < $totalFacetValues;
        $queryJoin = str_contains($browseUrl, '?') ? '&' : '?';

        return view('openbooks.browse', [
            'browseFacet' => $facet,
            'facet' => $facetBlock,
            'collectionTotal' => $collectionTotal,
            'browseUrl' => $browseUrl,
            'offset' => $offset,
            'rows' => $rows,
            'prefix' => $prefix,
            'totalFacetValues' => $totalFacetValues,
            'startRow' => $totalFacetValues > 0 ? $offset + 1 : 0,
            'endRow' => min($offset + count($termsOnPage), $totalFacetValues),
            'hasPrev' => $hasPrev,
            'hasNext' => $hasNext,
            'prevUrl' => $hasPrev ? $browseUrl.$queryJoin.'offset='.$prevOffset : '',
            'nextUrl' => $hasNext ? $browseUrl.$queryJoin.'offset='.$nextOffset : '',
            'base_search' => CollectionUrl::url('search/*'),
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }
}
