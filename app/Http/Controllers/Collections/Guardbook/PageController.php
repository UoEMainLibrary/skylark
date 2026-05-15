<?php

namespace App\Http\Controllers\Collections\Guardbook;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the Guardbook homepage with browse facets.
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
            // FIXME: legacy code dd()'d here; preserved as part of the wider
            // services-cleanup follow-up.
            dd($e->getMessage(), $e);
        }

        return view('guardbook.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }
}
