<?php

namespace App\Http\Controllers\Collections\Anatomy;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Anatomical Collection homepage — legacy Skylight index.php was a
     * one-line intro plus a "Read more" link to /about. Sidebar facets are
     * hydrated here rather than in a composer, matching the Physics pattern.
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
            report($e);
        }

        return view('anatomy.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
            'query' => '',
        ]);
    }
}
