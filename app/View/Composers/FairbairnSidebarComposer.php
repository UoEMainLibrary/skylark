<?php

namespace App\View\Composers;

use App\Services\RepositoryFactory;
use Illuminate\View\View;

/**
 * Inject Subject + Agent browse-facet sidebars into fairbairn layout pages.
 */
class FairbairnSidebarComposer
{
    public function __construct(protected RepositoryFactory $repositoryFactory) {}

    public function compose(View $view): void
    {
        $repository = $this->repositoryFactory->current();

        $subjectFacet = ['terms' => []];
        $agentFacet = ['terms' => []];

        try {
            if (method_exists($repository, 'browseTerms')) {
                $subjectFacet = $repository->browseTerms('Subject', 10);
                $agentFacet = $repository->browseTerms('Agent', 10);
            }
        } catch (\Throwable $e) {
            report($e);
        }

        $view->with([
            'subjectFacet' => $subjectFacet,
            'agentFacet' => $agentFacet,
        ]);
    }
}
