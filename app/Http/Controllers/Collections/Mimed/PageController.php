<?php

namespace App\Http\Controllers\Collections\Mimed;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the MIMEd homepage with browse facets.
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
            // Solr unreachable — render without facets
        }

        return view('mimed.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
        ]);
    }

    /**
     * Display the MIMEd IIIF page.
     *
     * Also reused as the IIIF page for the cockburn and guardbook
     * collections — see routes/web.php.
     */
    public function iiif()
    {
        return view('mimed.pages.iiif');
    }
}
