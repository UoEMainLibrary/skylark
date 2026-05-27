<?php

namespace App\Http\Controllers\Collections\Towardsdolly;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function home()
    {
        return view('towardsdolly.home');
    }

    public function history()
    {
        return view('towardsdolly.pages.history');
    }

    public function people()
    {
        return view('towardsdolly.pages.people');
    }

    public function catalogues()
    {
        return view('towardsdolly.pages.catalogues');
    }

    public function audio()
    {
        return view('towardsdolly.pages.audio');
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

        return view('towardsdolly.pages.browse', [
            'browseFacet' => $facet,
            'browseData' => $browseData,
        ]);
    }
}
