<?php

namespace App\Providers;

use App\Services\SolrService;
use App\View\Composers\CmsPageComposer;
use App\View\Composers\EercNavComposer;
use App\View\Composers\LhsacasenotesSidebarComposer;
use App\View\Composers\OpenBooksLayoutComposer;
use App\View\Composers\RespHomeComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SolrService::class, function ($app) {
            return new SolrService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.eerc-v2', EercNavComposer::class);
        View::composer('eerc-v2.home', RespHomeComposer::class);
        View::composer('layouts.openbooks', OpenBooksLayoutComposer::class);
        View::composer('lhsacasenotes.partials.sidebar', LhsacasenotesSidebarComposer::class);

        // CMS-managed pages — see config/cms.php for the registry. Each
        // composer injects $cms (CmsPage|null) and $cmsEnabled (bool).
        // RESP V2 home stays on the legacy RespHomeComposer for one more
        // commit; the seeder/migration step retires it and switches the
        // home view to use CmsPageComposer too.
        $this->registerCmsPageComposers();
    }

    /**
     * Wire the per-page CmsPageComposer for every entry in config('cms.pages').
     */
    protected function registerCmsPageComposers(): void
    {
        $viewMap = [
            'eerc' => [
                'about' => 'eerc-v2.pages.about',
                'resp' => 'eerc-v2.pages.resp',
                'project-history' => 'eerc-v2.pages.project_history',
                'overview' => 'eerc-v2.pages.overview',
                'contact' => 'eerc-v2.pages.contact',
                'accessibility' => 'eerc-v2.pages.accessibility',
                'bsl' => 'eerc-v2.pages.bsl',
            ],
            'public-art' => [
                'artcollection' => 'public-art-v2.pages.artcollection',
                'licensing' => 'public-art-v2.pages.licensing',
                'takedown' => 'public-art-v2.pages.takedown',
                'accessibility' => 'public-art-v2.pages.accessibility',
                'feedback' => 'public-art-v2.pages.feedback',
            ],
        ];

        foreach (config('cms.pages', []) as $collection => $pages) {
            foreach ($pages as $slug => $config) {
                $view = $viewMap[$collection][$slug] ?? null;
                if ($view === null) {
                    continue;
                }
                View::composer($view, fn ($v) => (new CmsPageComposer($collection, $slug))->compose($v));
            }
        }
    }
}
