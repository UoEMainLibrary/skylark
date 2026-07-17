<?php

namespace App\Http\Controllers\Collections\Calendars;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * Display the University of Edinburgh Calendars homepage — a static
     * jcarousel of the 15 fixed months plus the intro/gift-shop copy from
     * the legacy Skylight `theme/calendars/views/index.php` template.
     * Sidebar facets are hydrated here rather than in a composer, matching
     * the Physics/Archives Media pattern.
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

        return view('calendars.home', [
            'facets' => $facets,
            'base_search' => $baseSearch,
            'base_parameters' => '',
            'delimiter' => config('skylight.filter_delimiter'),
            'query' => '',
        ]);
    }

    /**
     * Render the David Laing Collection static page (2015 calendar) from
     * the legacy Skylight `static/calendars/laing.php`. Linked from the
     * homepage carousel in the legacy site, retained here so the deep-link
     * to the 2015 calendar subject facet keeps working.
     */
    public function laing()
    {
        return view('calendars.pages.laing');
    }
}
