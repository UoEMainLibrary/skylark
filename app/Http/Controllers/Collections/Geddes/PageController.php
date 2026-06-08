<?php

namespace App\Http\Controllers\Collections\Geddes;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionViewResolver;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function home()
    {
        return view(CollectionViewResolver::geddes('geddes.home'));
    }

    public function history()
    {
        return view(CollectionViewResolver::geddes('geddes.pages.history'));
    }

    public function people()
    {
        return view(CollectionViewResolver::geddes('geddes.pages.people'));
    }

    public function research()
    {
        return view(CollectionViewResolver::geddes('geddes.pages.research'));
    }

    public function contact()
    {
        return view(CollectionViewResolver::geddes('geddes.pages.contact'));
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

        return view(CollectionViewResolver::geddes('geddes.pages.browse'), [
            'browseFacet' => $facet,
            'browseData' => $browseData,
        ]);
    }
}
