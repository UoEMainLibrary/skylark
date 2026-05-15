<?php

namespace App\Http\Controllers\Collections\Eerc;

use App\Http\Controllers\Controller;
use App\Services\RepositoryFactory;
use App\Support\CollectionViewResolver;

class PageController extends Controller
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    /**
     * EERC homepage. Mirrors the legacy hand-rolled closure that previously
     * lived in routes/web.php — top-of-page Subject + Person facets driven
     * straight off the repository.
     */
    public function home()
    {
        $repository = $this->repositoryFactory->current();

        $subjectFacet = [];
        $personFacet = [];

        if (method_exists($repository, 'browseTerms')) {
            $subjectFacet = $repository->browseTerms('Subject', 10);
            $personFacet = $repository->browseTerms('Person', 10);
        }

        return view(CollectionViewResolver::eerc('eerc.home'), [
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ]);
    }

    /**
     * Display the EERC About page.
     */
    public function about()
    {
        return $this->pageWithSidebar('eerc.pages.about');
    }

    /**
     * Display the EERC Accessibility Statement page.
     */
    public function accessibility()
    {
        return $this->pageWithSidebar('eerc.pages.accessibility');
    }

    /**
     * Display the EERC Overview / Browse Collections page.
     */
    public function overview()
    {
        $repository = $this->repositoryFactory->current();

        $tree = method_exists($repository, 'getCollectionTree')
            ? $repository->getCollectionTree()
            : ['children' => []];

        // Match the legacy site, which only displays the first 5 top-level
        // branches.
        if (! empty($tree['children'])) {
            $tree['children'] = array_slice($tree['children'], 0, 5);
        }

        $subjectFacet = ['terms' => []];
        $personFacet = ['terms' => []];

        if (method_exists($repository, 'browseTerms')) {
            $subjectFacet = $repository->browseTerms('Subject', 10);
            $personFacet = $repository->browseTerms('Person', 10);
        }

        return view(CollectionViewResolver::eerc('eerc.pages.overview'), [
            'tree' => $tree,
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ]);
    }

    public function people()
    {
        return $this->pageWithSidebar('eerc.pages.people');
    }

    public function resp()
    {
        return $this->pageWithSidebar('eerc.pages.resp');
    }

    public function using()
    {
        return $this->pageWithSidebar('eerc.pages.using');
    }

    public function exhibitionGallery()
    {
        return $this->pageWithSidebar('eerc.pages.exhibition_gallery');
    }

    public function kidsOnly()
    {
        return $this->pageWithSidebar('eerc.pages.kids_only');
    }

    public function contact()
    {
        return $this->pageWithSidebar('eerc.pages.contact');
    }

    public function map()
    {
        return $this->pageWithSidebar('eerc.pages.map');
    }

    /**
     * Display the EERC Project History page (v2 replacement for People).
     */
    public function projectHistory()
    {
        return $this->pageWithSidebar('eerc.pages.project_history');
    }

    public function creativeEngagement()
    {
        return $this->pageWithSidebar('eerc.pages.creative_engagement');
    }

    public function bsl()
    {
        return $this->pageWithSidebar('eerc.pages.bsl');
    }

    /**
     * Browse all Subject or Person facet terms (sidebar "View all" target).
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

        return $this->pageWithSidebar('eerc.pages.browse', [
            'browseFacet' => $facet,
            'browseData' => $browseData,
        ]);
    }

    /**
     * Render an EERC page with the standard sidebar facets attached and the
     * skin version respected.
     */
    protected function pageWithSidebar(string $view, array $extraData = [])
    {
        $repository = $this->repositoryFactory->current();

        $subjectFacet = ['terms' => []];
        $personFacet = ['terms' => []];

        if (method_exists($repository, 'browseTerms')) {
            $subjectFacet = $repository->browseTerms('Subject', 10);
            $personFacet = $repository->browseTerms('Person', 10);
        }

        return view(CollectionViewResolver::eerc($view), array_merge([
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ], $extraData));
    }
}
