<?php

namespace App\Http\Controllers\Collections\Stcecilias;

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
     * St Cecilia's Hall — collection home page (instrument-grouping grid).
     *
     * Shared static-page actions (about, licensing, takedown, accessibility,
     * feedback) are still served by the root PageController and auto-resolve
     * to `stcecilias.pages.<name>` via the per-collection view convention;
     * the IIIF info page is custom and rendered by {@see iiif()} below.
     */
    public function home()
    {
        return view('stcecilias.home');
    }

    /**
     * St Cecilia's Hall — IIIF / Mirador info page.
     */
    public function iiif()
    {
        return view('stcecilias.pages.iiif');
    }

    /**
     * St Cecilia's Hall — paginated browse-by-facet page (legacy "More …"
     * link from the Refine Results sidebar lands here).
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

        return view('stcecilias.pages.browse', [
            'browseFacet' => $facet,
            'facet' => $facetBlock,
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
