<?php

namespace App\Providers;

use App\Services\SolrService;
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
    }
}
