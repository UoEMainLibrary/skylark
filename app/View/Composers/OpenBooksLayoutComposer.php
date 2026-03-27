<?php

namespace App\View\Composers;

use App\Services\RepositoryFactory;
use App\Support\CollectionUrl;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OpenBooksLayoutComposer
{
    public function __construct(
        protected RepositoryFactory $repositoryFactory
    ) {}

    public function compose(View $view): void
    {
        $facets = [];
        $containerId = trim((string) config('skylight.container_id'));

        if ($containerId === '') {
            Log::warning('Open Books sidebar facets skipped: OPENBOOKS_CONTAINER_ID (skylight.container_id) is not set.');
        } else {
            try {
                $repository = $this->repositoryFactory->current();
                if (method_exists($repository, 'searchWithHighlighting')) {
                    $result = $repository->searchWithHighlighting('*:*', [], 0, '', 0, []);
                    $facets = $result['facets'] ?? [];
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $view->with([
            'sidebar_facets' => $facets,
            'sidebar_base_search' => CollectionUrl::url('search/*:*'),
            'sidebar_delimiter' => config('skylight.filter_delimiter'),
            'sidebar_base_parameters' => '',
        ]);
    }
}
