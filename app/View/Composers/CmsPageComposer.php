<?php

namespace App\View\Composers;

use App\Models\CmsPage;
use App\Support\Cms;
use Illuminate\View\View;

/**
 * Injects two pieces of context into every CMS-managed page Blade:
 *
 *   $cms        — the CmsPage row for (collection, slug), or null
 *   $cmsEnabled — whether the Blade should render the CMS content
 *
 * Pages then guard their editable region with
 *
 *   @if($cmsEnabled && $cms)
 *     {!! $cms->body !!} ...
 *
 *   @else
 *     <static HTML fallback>
 *
 *   @endif
 *
 * `$cmsEnabled` is true when the global `CMS_ENABLED` flag is on, OR
 * when the page is flagged `always_cms` in config/cms.php (currently
 * just the RESP V2 home, whose static fallback was already removed).
 */
class CmsPageComposer
{
    public function __construct(
        protected string $collection,
        protected string $slug,
    ) {}

    public function compose(View $view): void
    {
        $shouldRender = Cms::shouldRenderCms($this->collection, $this->slug);

        $view->with([
            // Only hit the database when we actually need the row — keeps
            // the public site fast on the default CMS_ENABLED=false path
            // and lets feature tests that don't seed cms_pages render
            // these pages without a "no such table" error.
            'cms' => $shouldRender ? CmsPage::lookup($this->collection, $this->slug) : null,
            'cmsEnabled' => $shouldRender,
        ]);
    }
}
