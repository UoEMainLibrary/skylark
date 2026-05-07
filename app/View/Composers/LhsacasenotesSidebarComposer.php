<?php

namespace App\View\Composers;

use App\Services\RepositoryFactory;
use Illuminate\View\View;

/**
 * Inject the Subject + Person browse-facet sidebars into every
 * lhsacasenotes view that extends `layouts.lhsacasenotes`.
 *
 * Mirrors the legacy CodeIgniter behaviour where every page on the
 * lhsacasenotes site (home, search, record and static pages) renders the
 * same facet sidebar fed by `browseTerms`. Solr failures are swallowed so a
 * VPN/Solr blip cannot blank the page.
 */
class LhsacasenotesSidebarComposer
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function compose(View $view): void
    {
        $repository = $this->repositoryFactory->current();

        $subjectFacet = ['terms' => []];
        $personFacet = ['terms' => []];

        try {
            if (method_exists($repository, 'browseTerms')) {
                $subjectFacet = $repository->browseTerms('Subject', 10);
                $personFacet = $repository->browseTerms('Person', 10);
            }
        } catch (\Throwable $e) {
            report($e);
        }

        $view->with([
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ]);
    }
}
