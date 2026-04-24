<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use App\Routing\CollectionRouteRegistrar;
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
    'home' => [PageController::class, 'openbooksHome'],
    'mirador_view' => 'openbooks.mirador',
    'iiif' => [PageController::class, 'openbooksIiif'],
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/browse/{facet}', [PageController::class, 'openbooksBrowse'])
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
    'home' => [PageController::class, 'alumniHome'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/browse/{facet}', [PageController::class, 'alumniBrowse'])
            ->where('facet', '[A-Za-z]+')
            ->name('browse');
        Route::get('/earlyvet', [PageController::class, 'alumniEarlyVet'])->name('earlyvet');
        Route::get('/extraac', [PageController::class, 'alumniExtraAc'])->name('extraac');
        Route::get('/femalegrad', [PageController::class, 'alumniFemaleGrad'])->name('femalegrad');
        Route::get('/firstmat', [PageController::class, 'alumniFirstMat'])->name('firstmat');
        Route::get('/medsample', [PageController::class, 'alumniMedSample'])->name('medsample');
        Route::get('/newcoll', [PageController::class, 'alumniNewColl'])->name('newcoll');
        Route::get('/roll', [PageController::class, 'alumniRoll'])->name('roll');
        Route::get('/rosner', [PageController::class, 'alumniRosner'])->name('rosner');      
        Route::get('/vetgrad', [PageController::class, 'alumniVetGrad'])->name('vetgrad');
        Route::get('/women', [PageController::class, 'alumniWomen'])->name('women');
        Route::get('/ww1roll', [PageController::class, 'alumniWW1Roll'])->name('ww1roll');
   },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'cockburn',
    'route_name' => 'cockburn',
    'home' => [PageController::class, 'cockburnHome'],
    'mirador_view' => 'cockburn.mirador',
    'iiif' => [PageController::class, 'mimedIiif'],
    'feedback' => true,
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'coimbra-colls',
    'route_name' => 'coimbra-colls',
    'home' => [PageController::class, 'coimbraCollsHome'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/virtual-exhibition', [PageController::class, 'coimbraCollsVirtualExhibition'])->name('virtual-exhibition');
   },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'coimbra',
    'route_name' => 'coimbra',
    'home' => [PageController::class, 'coimbraHome'],
    'mirador_view' => 'mimed.mirador',
    'feedback' => true,
    'extra_routes' => function () {
        Route::get('/intro', [PageController::class, 'coimbraIntro'])->name('intro');
   },
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'mimed',
    'route_name' => 'mimed',
    'home' => [PageController::class, 'mimedHome'],
    'mirador_view' => 'mimed.mirador',
    'iiif' => [PageController::class, 'mimedIiif'],
    'feedback' => true,
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'guardbook',
    'route_name' => 'guardbook',
    'home' => [PageController::class, 'guardbookHome'],
    'mirador_view' => 'mimed.mirador',
    'iiif' => [PageController::class, 'mimedIiif'],
    'feedback' => true,
]);

CollectionRouteRegistrar::registerDspacePrefixedCollection([
    'prefix' => 'art',
    'route_name' => 'art',
    'home' => [PageController::class, 'artHome'],
    'mirador_view' => 'art.mirador',
    'iiif' => [PageController::class, 'artIiif'],
    'feedback' => false,
    'extra_routes' => function () {
        Route::get('/focus', [PageController::class, 'artFocus'])->name('focus');
        Route::get('/comissioning', [PageController::class, 'artComissioning'])->name('comissioning');
        Route::get('/loans', [PageController::class, 'artLoans'])->name('loans');
    },
]);

// EERC Sub-Collection Routes
Route::prefix('eerc')->name('eerc.')->group(function () {
    // EERC Homepage
    Route::get('/', function () {
        $repositoryFactory = app(\App\Services\RepositoryFactory::class);
        $repository = $repositoryFactory->current();

        $subjectFacet = [];
        $personFacet = [];

        if (method_exists($repository, 'browseTerms')) {
            $subjectFacet = $repository->browseTerms('Subject', 10);
            $personFacet = $repository->browseTerms('Person', 10);
        }

        return view(PageController::eercViewName('eerc.home'), [
            'subjectFacet' => $subjectFacet,
            'personFacet' => $personFacet,
        ]);
    })->name('home');

    // EERC Search routes
    Route::post('/redirect', [SearchController::class, 'redirect'])->name('search.redirect');

    Route::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
        ->where('query', '[^/]+')
        ->where('filters', '.*')
        ->name('search.index');

    Route::get('/browse/{facet}', [PageController::class, 'eercBrowse'])
        ->where('facet', 'Subject|Person')
        ->name('browse');

    // EERC bitstream proxy (must be before record.show so /record/{id}/{seq}/{file} is not swallowed as {type})
    Route::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
        ->where('id', '[0-9]+')
        ->where('seq', '[0-9]+')
        ->where('filename', '.+')
        ->name('eerc.record.image');

    // EERC Record detail page
    Route::get('/record/{id}/{type?}', [RecordController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('record.show');

    // EERC Static pages
    Route::get('/resp', [PageController::class, 'resp'])->name('resp');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/people', [PageController::class, 'people'])->name('people');
    Route::get('/using', [PageController::class, 'using'])->name('using');
    Route::get('/overview', [PageController::class, 'overview'])->name('overview');
    Route::get('/exhibition_gallery', [PageController::class, 'exhibitionGallery'])->name('exhibition_gallery');
    Route::get('/kids_only', [PageController::class, 'kidsOnly'])->name('kids_only');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');
    Route::get('/map', [PageController::class, 'map'])->name('map');
    Route::get('/project-history', [PageController::class, 'projectHistory'])->name('project_history');
    Route::get('/creative-engagement', [PageController::class, 'creativeEngagement'])->name('creative_engagement');
    Route::get('/bsl', [PageController::class, 'bsl'])->name('bsl');
});
