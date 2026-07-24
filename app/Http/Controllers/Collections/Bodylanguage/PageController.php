<?php

namespace App\Http\Controllers\Collections\Bodylanguage;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function home()
    {
        return view('bodylanguage.home');
    }

    public function catalogue()
    {
        return view('bodylanguage.pages.catalogue');
    }

    public function contact()
    {
        return view('bodylanguage.pages.contact');
    }

    public function people()
    {
        return view('bodylanguage.pages.people');
    }

    /**
     * Facet browse endpoint (Subject | Person).
     *
     * Mirrors the Fairbairn / LHSA browse pattern — the underlying
     * ArchivesSpace facet is stored under `agents` for Person, so use the
     * exposed `filters` config as the source of truth.
     */
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

        return view('bodylanguage.pages.browse', [
            'browseFacet' => $facet,
            'browseData' => $browseData,
        ]);
    }
}
