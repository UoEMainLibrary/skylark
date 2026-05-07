<?php

namespace App\Routing;

use App\Http\Controllers\PageController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;

class CollectionRouteRegistrar
{
    /**
     * Register standard DSpace collection routes under a URL prefix (search, record, mirador, advanced, static pages).
     * Optional domain_hosts register the same routes at the site root for dedicated hostnames (unnamed routes).
     *
     * @param  array{
     *     prefix: string,
     *     route_name: string,
     *     domain_hosts?: list<string>,
     *     home: array{0: class-string, 1: string}|Closure,
     *     mirador_view: string,
     *     iiif?: array{0: class-string, 1: string},
     *     feedback?: bool,
     *     about?: array{0: class-string, 1: string}|Closure,
     *     extra_routes?: Closure
     * }  $definition
     */
    public static function registerDspacePrefixedCollection(array $definition): void
    {
        $prefix = $definition['prefix'];
        $routeName = $definition['route_name'];

        foreach ($definition['domain_hosts'] ?? [] as $host) {
            RouteFacade::domain($host)->group(function () use ($definition) {
                self::registerDspaceRoutes($definition, '', false);
            });
        }

        RouteFacade::prefix($prefix)->name($routeName.'.')->group(function () use ($definition, $prefix) {
            self::registerDspaceRoutes($definition, $prefix, true);
        });
    }

    /**
     * @param  bool  $assignNames  When false, routes are unnamed (dedicated-domain duplicate).
     */
    private static function registerDspaceRoutes(array $definition, string $redirectPrefix, bool $assignNames): void
    {
        $miradorView = $definition['mirador_view'];

        $named = static function (Route $route, string $suffix) use ($assignNames): void {
            if ($assignNames) {
                $route->name($suffix);
            }
        };

        $named(RouteFacade::get('/', $definition['home']), 'home');

        $named(RouteFacade::post('/redirect', [SearchController::class, 'redirect']), 'search.redirect');

        $named(RouteFacade::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
            ->where('query', '[^/]+')
            ->where('filters', '.*'), 'search.index');

        $named(RouteFacade::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
            ->where('id', '[0-9]+')
            ->where('seq', '[0-9]+'), 'record.image');

        $named(RouteFacade::get('/record/{id}', [RecordController::class, 'show'])
            ->where('id', '[0-9]+'), 'record.show');

        $named(RouteFacade::get('/mirador', function (Request $request) use ($miradorView) {
            $manifest = filter_var($request->query('manifest', ''), FILTER_VALIDATE_URL) ?: '';

            return view($miradorView, ['manifest' => $manifest]);
        }), 'mirador');

        $advancedRedirect = static function () use ($redirectPrefix) {
            if ($redirectPrefix === '') {
                return redirect('/advanced/form');
            }

            return redirect('/'.$redirectPrefix.'/advanced/form');
        };
        $named(RouteFacade::get('/advanced', $advancedRedirect), 'advanced');
        $named(RouteFacade::get('/advanced/form', [SearchController::class, 'advancedForm']), 'advanced.form');
        $named(RouteFacade::post('/advanced/post', [SearchController::class, 'advancedPost']), 'advanced.post');
        $named(RouteFacade::get('/advanced/search/{filters?}', [SearchController::class, 'advancedSearch'])
            ->where('filters', '.*'), 'advanced.search');

        $aboutAction = $definition['about'] ?? [PageController::class, 'about'];
        $named(RouteFacade::get('/about', $aboutAction), 'about');

        if (isset($definition['iiif'])) {
            $named(RouteFacade::get('/iiif', $definition['iiif']), 'iiif');
        }

        $named(RouteFacade::get('/licensing', [PageController::class, 'licensing']), 'licensing');
        $named(RouteFacade::get('/takedown', [PageController::class, 'takedown']), 'takedown');
        $named(RouteFacade::get('/accessibility', [PageController::class, 'accessibility']), 'accessibility');

        if ($definition['feedback'] ?? false) {
            $named(RouteFacade::get('/feedback', [PageController::class, 'feedback']), 'feedback');
        }

        if (isset($definition['extra_routes']) && $definition['extra_routes'] instanceof Closure) {
            ($definition['extra_routes'])();
        }
    }

    /**
     * Register standard ArchivesSpace collection routes under a URL prefix.
     *
     * Mirrors {@see registerDspacePrefixedCollection()} but emits only the
     * routes that ArchivesSpace-backed collections actually use. Notable
     * differences:
     *
     *  - Record route accepts an optional `{type}` segment so URIs like
     *    `/lhsacasenotes/record/165250/archival_object` resolve to
     *    {@see RecordController::show()} (which forwards to
     *    `getRecordWithType()`).
     *  - DSpace-only routes (`/mirador`, `/iiif`, `/advanced/*`) are NOT
     *    registered.
     *  - Bitstream proxy and image routes are gated behind `images => true`
     *    (lhsacasenotes does not need them).
     *
     * @param  array{
     *     prefix: string,
     *     route_name: string,
     *     home: array{0: class-string, 1: string}|Closure,
     *     images?: bool,
     *     feedback?: bool,
     *     extra_routes?: Closure
     * }  $definition
     */
    public static function registerArchiveSpacePrefixedCollection(array $definition): void
    {
        $prefix = $definition['prefix'];
        $routeName = $definition['route_name'];

        RouteFacade::prefix($prefix)->name($routeName.'.')->group(function () use ($definition): void {
            self::registerArchiveSpaceRoutes($definition);
        });
    }

    private static function registerArchiveSpaceRoutes(array $definition): void
    {
        RouteFacade::get('/', $definition['home'])->name('home');

        RouteFacade::post('/redirect', [SearchController::class, 'redirect'])->name('search.redirect');

        RouteFacade::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
            ->where('query', '[^/]+')
            ->where('filters', '.*')
            ->name('search.index');

        if ($definition['images'] ?? false) {
            RouteFacade::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
                ->where('id', '[0-9]+')
                ->where('seq', '[0-9]+')
                ->where('filename', '.+')
                ->name('record.image');
        }

        RouteFacade::get('/record/{id}/{type?}', [RecordController::class, 'show'])
            ->where('id', '[0-9]+')
            ->name('record.show');

        RouteFacade::get('/about', [PageController::class, 'about'])->name('about');
        RouteFacade::get('/licensing', [PageController::class, 'licensing'])->name('licensing');
        RouteFacade::get('/takedown', [PageController::class, 'takedown'])->name('takedown');
        RouteFacade::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');

        if ($definition['feedback'] ?? false) {
            RouteFacade::get('/feedback', [PageController::class, 'feedback'])->name('feedback');
        }

        if (isset($definition['extra_routes']) && $definition['extra_routes'] instanceof Closure) {
            ($definition['extra_routes'])();
        }
    }
}
