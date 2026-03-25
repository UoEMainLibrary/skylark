<?php

namespace App\Routing;

use App\Http\Controllers\PageController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CollectionRouteRegistrar
{
    /**
     * Register standard DSpace collection routes under a URL prefix (search, record, mirador, advanced, static pages).
     *
     * @param  array{
     *     prefix: string,
     *     route_name: string,
     *     home: array{0: class-string, 1: string}|Closure,
     *     mirador_view: string,
     *     iiif?: array{0: class-string, 1: string},
     *     feedback?: bool,
     *     extra_routes?: Closure
     * }  $definition
     */
    public static function registerDspacePrefixedCollection(array $definition): void
    {
        $prefix = $definition['prefix'];
        $routeName = $definition['route_name'];
        $miradorView = $definition['mirador_view'];

        Route::prefix($prefix)->name($routeName.'.')->group(function () use ($definition, $prefix, $miradorView) {
            Route::get('/', $definition['home'])->name('home');

            Route::post('/redirect', [SearchController::class, 'redirect'])->name('search.redirect');

            Route::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
                ->where('query', '[^/]+')
                ->where('filters', '.*')
                ->name('search.index');

            Route::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
                ->where('id', '[0-9]+')
                ->where('seq', '[0-9]+')
                ->name('record.image');

            Route::get('/record/{id}', [RecordController::class, 'show'])
                ->where('id', '[0-9]+')
                ->name('record.show');

            Route::get('/mirador', function (Request $request) use ($miradorView) {
                $manifest = filter_var($request->query('manifest', ''), FILTER_VALIDATE_URL) ?: '';

                return view($miradorView, ['manifest' => $manifest]);
            })->name('mirador');

            Route::get('/advanced', fn () => redirect("/{$prefix}/advanced/form"))->name('advanced');
            Route::get('/advanced/form', [SearchController::class, 'advancedForm'])->name('advanced.form');
            Route::post('/advanced/post', [SearchController::class, 'advancedPost'])->name('advanced.post');
            Route::get('/advanced/search/{filters?}', [SearchController::class, 'advancedSearch'])
                ->where('filters', '.*')
                ->name('advanced.search');

            Route::get('/about', [PageController::class, 'about'])->name('about');

            if (isset($definition['iiif'])) {
                Route::get('/iiif', $definition['iiif'])->name('iiif');
            }

            Route::get('/licensing', [PageController::class, 'licensing'])->name('licensing');
            Route::get('/takedown', [PageController::class, 'takedown'])->name('takedown');
            Route::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');

            if ($definition['feedback'] ?? false) {
                Route::get('/feedback', [PageController::class, 'feedback'])->name('feedback');
            }

            if (isset($definition['extra_routes']) && $definition['extra_routes'] instanceof Closure) {
                ($definition['extra_routes'])();
            }
        });
    }
}
