<?php

namespace App\Http\Controllers\Collections\Fairbairn;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function home()
    {
        return view('fairbairn.home');
    }

    public function browse(string $facet)
    {
        $filters = config('skylight.filters', []);

        if (! isset($filters[$facet])) {
            abort(404);
        }

        $repository = $this->repositoryFactory->current();

        if (! method_exists($repository, 'browseTerms')) {
            abort(404);
        }

        $browseData = $repository->browseTerms($facet, 500);

        return view('fairbairn.pages.browse', [
            'browseFacet' => $facet,
            'browseData' => $browseData,
        ]);
    }
}
