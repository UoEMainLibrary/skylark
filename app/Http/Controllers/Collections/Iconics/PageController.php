<?php

namespace App\Http\Controllers\Collections\Iconics;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the Iconics homepage: intro block plus a random-items strip.
     *
     * Mirrors the legacy Skylight iconics index (`homepage_randomitems`
     * true). Sidebar facets are hydrated here rather than in a composer,
     * matching the Physics / Cockburn convention.
     */
    public function home()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $randomItems = [];
        $baseSearch = CollectionUrl::url('search/*:*');

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            report($e);
        }

        try {
            // Legacy random_items view pulls a random slice of the collection.
            // Solr's `random_{seed}` field gives us a stable-per-request order.
            $seed = random_int(1, 100000);
            $randomResults = $repository->searchWithHighlighting('*:*', [], 0, 'random_'.$seed.' asc', 8);
            $randomItems = $randomResults['docs'] ?? [];
        } catch (\Exception $e) {
            // Solr unreachable — render intro block without random items.
        }

        return view('iconics.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
            'randomItems' => $randomItems,
            'query' => '',
        ]);
    }

    /**
     * Render the IIIF explainer static page.
     */
    public function iiif()
    {
        return view('iconics.pages.iiif');
    }
}
