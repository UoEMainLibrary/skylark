<?php

namespace App\Http\Controllers\Collections\Alumni;

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
     * Display the Alumni homepage with browse facets.
     */
    public function home()
    {
        $repository = $this->repositoryFactory->current();
        $facets = [];
        $baseSearch = CollectionUrl::url('search/*:*');

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            // FIXME: legacy code dd()'d the exception here. Should at least
            // be reported, but leaving the exact error-handling decision to
            // the wider services-cleanup follow-up.
            dd($e->getMessage(), $e);
        }

        return view('alumni.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
     * Display the Alumni browse page for a configured facet (e.g. "Collection",
     * "Year").
     *
     * Mirrors the legacy CodeIgniter /alumni/browse/{facet} endpoint: shows a
     * paginated list of all values for the chosen facet, with a "starts-with"
     * prefix filter and the usual sidebar facets.
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

        return view('alumni.browse', [
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

    /*
    |--------------------------------------------------------------------------
    | Static story / highlight pages.
    |--------------------------------------------------------------------------
    */

    public function extraAc()
    {
        return view('alumni.pages.extraac');
    }

    public function earlyVet()
    {
        return view('alumni.pages.earlyvet');
    }

    public function femaleGrad()
    {
        return view('alumni.pages.femalegrad');
    }

    public function firstMat()
    {
        return view('alumni.pages.firstmat');
    }

    public function medSample()
    {
        return view('alumni.pages.medsample');
    }

    public function newColl()
    {
        return view('alumni.pages.newcoll');
    }

    public function roll()
    {
        return view('alumni.pages.roll');
    }

    public function rosner()
    {
        return view('alumni.pages.rosner');
    }

    public function vetGrad()
    {
        return view('alumni.pages.vetgrad');
    }

    public function women()
    {
        return view('alumni.pages.women');
    }

    public function ww1Roll()
    {
        return view('alumni.pages.ww1roll');
    }
}
