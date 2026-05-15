<?php

namespace App\Http\Controllers\Collections\Cockburn;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the Cockburn homepage with browse facets and the five most-
     * recently-added documents.
     */
    public function home()
    {
        $repository = $this->repositoryFactory->current();

        $facets = [];
        $docs = [];
        $baseSearch = CollectionUrl::url('search/*:*');

        try {
            $results = $repository->searchWithHighlighting('*:*', [], 0, '', 0);
            $facets = $results['facets'] ?? [];
        } catch (\Exception $e) {
            // FIXME: legacy code dd()'d here; preserved as part of the wider
            // services-cleanup follow-up.
            dd($e->getMessage());
        }

        try {
            $recentResults = $repository->searchWithHighlighting('*:*', [], 0, 'system_create_dt desc', 5);
            $docs = $recentResults['docs'] ?? [];
        } catch (\Exception $e) {
            // Solr unreachable — render without recent docs
        }

        return view('cockburn.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
            'docs' => $docs,
            'query' => '',
        ]);
    }
}
