<?php

namespace App\Http\Controllers;

use App\Services\DSpaceService;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

/**
 * Shared /browse/{facet} endpoint for DSpace collections that don't have a
 * bespoke browse implementation.
 *
 * Mirrors legacy skylight's `browse.php` controller: given a facet name,
 * fetch a paginated A-Z list of terms from Solr, feed them into the
 * legacy browse_facets view, and expose a "Starts with" prefix filter.
 *
 * The "More ..." link at the bottom of each sidebar facet in
 * defaults.search.partials.facets points here.
 */
class BrowseController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function show(Request $request, string $facet): View
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

        // Prefer a collection-specific browse view when the theme provides
        // one, otherwise fall back to the shared defaults view.
        $theme = config('skylight.theme');
        $view = $theme && ViewFacade::exists($theme.'.browse')
            ? $theme.'.browse'
            : 'defaults.browse';

        return view($view, [
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
            'base_search' => CollectionUrl::url('search/*:*'),
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }
}
