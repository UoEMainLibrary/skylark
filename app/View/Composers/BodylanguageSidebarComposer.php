<?php

namespace App\View\Composers;

use App\Services\RepositoryFactory;
use Illuminate\View\View;

/**
 * Inject Subject + Person browse-facet sidebars into bodylanguage layout pages.
 *
 * Bodylanguage exposes `Person` in the filters config; internally it maps to
 * the ArchivesSpace `agents` facet. `browseTerms` reads the display label
 * ("Person") from `skylight.filters` and does the mapping for us.
 */
class BodylanguageSidebarComposer
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
