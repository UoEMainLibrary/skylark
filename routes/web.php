<?php

use App\Http\Controllers\Collections\Alumni\PageController as AlumniController;
use App\Http\Controllers\Collections\Art\PageController as ArtController;
use App\Http\Controllers\Collections\Cockburn\PageController as CockburnController;
use App\Http\Controllers\Collections\Coimbra\PageController as CoimbraController;
use App\Http\Controllers\Collections\CoimbraColls\PageController as CoimbraCollsController;
use App\Http\Controllers\Collections\Eerc\PageController as EercController;
use App\Http\Controllers\Collections\Guardbook\PageController as GuardbookController;
use App\Http\Controllers\Collections\Lhsacasenotes\PageController as LhsacasenotesController;
use App\Http\Controllers\Collections\Mimed\PageController as MimedController;
use App\Http\Controllers\Collections\Openbooks\PageController as OpenbooksController;
use App\Http\Controllers\Collections\PublicArt\PageController as PublicArtController;
use App\Http\Controllers\Collections\Stcecilias\PageController as StceciliasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use App\Routing\CollectionRouteRegistrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * Dedicated collection hostnames (OPENBOOKS_HOST, etc.) register Route::domain(...) groups here
 * before the unconstrained `/` route so GET / resolves to the collection home, not clds.home.
 */
CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'openbooks',
    'route_name' => 'openbooks',
    'domain_hosts' => array_keys(array_filter(
        config('collections.domains', []),
        static fn (string $collection): bool => $collection === 'openbooks',
    )),
    'home' => [OpenbooksController::class, 'home'],
    'mirador_view' => 'openbooks.mirador',
    'iiif' => [OpenbooksController::class, 'iiif'],
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/browse/{facet}', [OpenbooksController::class, 'browse'])
            ->where('facet', '[A-Za-z]+');
    },
]);

Route::get('/', function () {
    return view('clds.home');
})->name('home');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/feedback', [PageController::class, 'feedback'])->name('feedback');
Route::get('/mahabharata', [PageController::class, 'mahabharata'])->name('mahabharata');
Route::get('/collections-as-data', [PageController::class, 'collectionsAsData'])->name('collections-as-data');
Route::get('/argyle-meeting', [PageController::class, 'argyleMeeting'])->name('argyle-meeting');
Route::get('/csp', [PageController::class, 'csp'])->name('csp');
Route::get('/directory', [PageController::class, 'directory'])->name('directory');
Route::get('/licensing', [PageController::class, 'licensing'])->name('licensing');
Route::get('/participate', [PageController::class, 'participate'])->name('participate');
Route::get('/takedown', [PageController::class, 'takedown'])->name('takedown');
Route::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');

// Search routes
Route::post('/redirect', [SearchController::class, 'redirect'])->name('search.redirect');

Route::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
    ->where('query', '[^/]+')
    ->where('filters', '.*')
    ->name('search.index');

// Image proxy route for DSpace bitstreams (must come BEFORE record.show)
Route::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
    ->where('id', '[0-9]+')
    ->where('seq', '[0-9]+')
    ->name('record.image');

// Record detail page
Route::get('/record/{id}', [RecordController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('record.show');

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'alumni',
    'route_name' => 'alumni',
    'home' => [AlumniController::class, 'home'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/browse/{facet}', [AlumniController::class, 'browse'])
            ->where('facet', '[A-Za-z]+')
            ->name('browse');
        Route::get('/earlyvet', [AlumniController::class, 'earlyVet'])->name('earlyvet');
        Route::get('/extraac', [AlumniController::class, 'extraAc'])->name('extraac');
        Route::get('/femalegrad', [AlumniController::class, 'femaleGrad'])->name('femalegrad');
        Route::get('/firstmat', [AlumniController::class, 'firstMat'])->name('firstmat');
        Route::get('/medsample', [AlumniController::class, 'medSample'])->name('medsample');
        Route::get('/newcoll', [AlumniController::class, 'newColl'])->name('newcoll');
        Route::get('/roll', [AlumniController::class, 'roll'])->name('roll');
        Route::get('/rosner', [AlumniController::class, 'rosner'])->name('rosner');
        Route::get('/vetgrad', [AlumniController::class, 'vetGrad'])->name('vetgrad');
        Route::get('/women', [AlumniController::class, 'women'])->name('women');
        Route::get('/ww1roll', [AlumniController::class, 'ww1Roll'])->name('ww1roll');
    },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'cockburn',
    'route_name' => 'cockburn',
    'home' => [CockburnController::class, 'home'],
    'mirador_view' => 'cockburn.mirador',
    'iiif' => [MimedController::class, 'iiif'],
    'feedback' => true,
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'coimbra-colls',
    'route_name' => 'coimbra-colls',
    'home' => [CoimbraCollsController::class, 'home'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/virtual-exhibition', [CoimbraCollsController::class, 'virtualExhibition'])->name('virtual-exhibition');
    },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'coimbra',
    'route_name' => 'coimbra',
    'home' => [CoimbraController::class, 'home'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/intro', [CoimbraController::class, 'intro'])->name('intro');
    },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'mimed',
    'route_name' => 'mimed',
    'home' => [MimedController::class, 'home'],
    'mirador_view' => 'mimed.mirador',
    'iiif' => [MimedController::class, 'iiif'],
    'feedback' => true,
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'guardbook',
    'route_name' => 'guardbook',
    'home' => [GuardbookController::class, 'home'],
    'mirador_view' => 'mimed.mirador',
    'iiif' => [MimedController::class, 'iiif'],
    'feedback' => true,
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'art',
    'route_name' => 'art',
    'home' => [ArtController::class, 'home'],
    'mirador_view' => 'art.mirador',
    'iiif' => [ArtController::class, 'iiif'],
    'feedback' => false,
    'extra_routes' => function () {
        Route::get('/focus', [ArtController::class, 'focus'])->name('focus');
        Route::get('/comissioning', [ArtController::class, 'comissioning'])->name('comissioning');
        Route::get('/loans', [ArtController::class, 'loans'])->name('loans');
    },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'art-on-campus',
    'route_name' => 'public-art',
    'home' => [PublicArtController::class, 'home'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    // The About page content has been folded into the home page (see P002/P005
    // of the 2026 client edits), so /art-on-campus/about now 301-redirects to
    // the home page. Old bookmarks keep working, the named `public-art.about`
    // route still resolves, and the standalone About blade has been deleted.
    'about' => fn () => redirect('/art-on-campus', 301),
    'extra_routes' => function () {
        Route::get('/paolozzi', [PublicArtController::class, 'paolozzi'])->name('paolozzi');
        Route::get('/artcollection', [PublicArtController::class, 'artCollection'])->name('artcollection');
    },
]);

/*
 * Legacy /public-art* URL → /art-on-campus* 301 redirects. The collection moved
 * URL prefix in the 2026 edits round; this catch-all forwards bookmarks, search
 * engine results and external links from the old prefix to the new one while
 * preserving deep paths and query strings.
 */
Route::get('/public-art{path}', function (Request $request, string $path = '') {
    $target = '/art-on-campus'.$path;
    $query = $request->getQueryString();
    if ($query !== null && $query !== '') {
        $target .= '?'.$query;
    }

    return redirect($target, 301);
})->where('path', '(/.*)?');

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'stcecilias',
    'route_name' => 'stcecilias',
    'home' => [StceciliasController::class, 'home'],
    // Mirror viewer used for IIIF deep-zoom; the Mirador route is registered
    // by the registrar even though the legacy site renders its own
    // OpenSeadragon viewer inline on the record page.
    'mirador_view' => 'stcecilias.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/iiif', [StceciliasController::class, 'iiif'])->name('iiif');

        // Legacy "More …" link from the search-results facet sidebar.
        Route::get('/browse/{facet}', [StceciliasController::class, 'browse'])
            ->where('facet', '[^/]+')
            ->name('browse');
    },
]);

CollectionRouteRegistrar::registerArchiveSpacePrefixedCollection([
    'prefix' => 'lhsacasenotes',
    'route_name' => 'lhsacasenotes',
    'home' => [LhsacasenotesController::class, 'home'],
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/history', [LhsacasenotesController::class, 'history'])->name('history');
        Route::get('/people', [LhsacasenotesController::class, 'people'])->name('people');
        Route::get('/tuberculosis', [LhsacasenotesController::class, 'tuberculosis'])->name('tuberculosis');
        Route::get('/achievements', [LhsacasenotesController::class, 'achievements'])->name('achievements');
        Route::get('/catalogues', [LhsacasenotesController::class, 'catalogues'])->name('catalogues');
    },
]);

// EERC Sub-Collection Routes — hand-rolled because the legacy site has its
// own browse-by-facet endpoint, sidebar facets on every static page, and a
// bitstream proxy that needs to sit ahead of record.show. Converting it to
// CollectionRouteRegistrar is part of the wider routes-per-collection
// follow-up.
Route::prefix('eerc')->name('eerc.')->group(function () {
    Route::get('/', [EercController::class, 'home'])->name('home');

    Route::post('/redirect', [SearchController::class, 'redirect'])->name('search.redirect');

    Route::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
        ->where('query', '[^/]+')
        ->where('filters', '.*')
        ->name('search.index');

    Route::get('/browse/{facet}', [EercController::class, 'browse'])
        ->where('facet', 'Subject|Person')
        ->name('browse');

    // Bitstream proxy must be registered before record.show so
    // /record/{id}/{seq}/{file} is not swallowed as {type}.
    Route::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
        ->where('id', '[0-9]+')
        ->where('seq', '[0-9]+')
        ->where('filename', '.+')
        ->name('eerc.record.image');

    Route::get('/record/{id}/{type?}', [RecordController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('record.show');

    Route::get('/resp', [EercController::class, 'resp'])->name('resp');
    Route::get('/about', [EercController::class, 'about'])->name('about');
    Route::get('/people', [EercController::class, 'people'])->name('people');
    Route::get('/using', [EercController::class, 'using'])->name('using');
    Route::get('/overview', [EercController::class, 'overview'])->name('overview');
    Route::get('/exhibition_gallery', [EercController::class, 'exhibitionGallery'])->name('exhibition_gallery');
    Route::get('/kids_only', [EercController::class, 'kidsOnly'])->name('kids_only');
    Route::get('/contact', [EercController::class, 'contact'])->name('contact');
    Route::get('/accessibility', [EercController::class, 'accessibility'])->name('accessibility');
    Route::get('/map', [EercController::class, 'map'])->name('map');
    Route::get('/project-history', [EercController::class, 'projectHistory'])->name('project_history');
    Route::get('/creative-engagement', [EercController::class, 'creativeEngagement'])->name('creative_engagement');
    Route::get('/bsl', [EercController::class, 'bsl'])->name('bsl');
});
