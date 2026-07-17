<?php

namespace App\Http\Controllers\Collections\Archivemedia;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the Archives Media homepage with sidebar browse facets.
     *
     * Mirrors the legacy Skylight archivemedia index — an intro block only
     * (no recent-items strip). The sidebar `defaults.search.partials.facets`
     * partial reads `$facets`, `$base_search`, `$base_parameters`, and
     * `$delimiter` from the view, so we resolve them here rather than in a
     * view composer.
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

        return view('archivemedia.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
            'query' => '',
        ]);
    }

    /**
     * Render the IIIF explainer static page.
     */
    public function iiif()
    {
        return view('archivemedia.pages.iiif');
    }
}
