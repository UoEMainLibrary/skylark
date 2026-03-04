<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

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

        return view('eerc.home', [
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

    // EERC Record detail page
    Route::get('/record/{id}/{type?}', [RecordController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('record.show');

    // EERC Static pages
    Route::get('/resp', function () {
        return view('eerc.pages.resp');
    })->name('resp');

    Route::get('/about', function () {
        return view('eerc.pages.about');
    })->name('about');

    Route::get('/people', function () {
        return view('eerc.pages.people');
    })->name('people');

    Route::get('/using', function () {
        return view('eerc.pages.using');
    })->name('using');

    Route::get('/overview', function () {
        return view('eerc.pages.overview');
    })->name('overview');

    Route::get('/map', function () {
        return view('eerc.pages.map');
    })->name('map');

    Route::get('/exhibition_gallery', function () {
        return view('eerc.pages.exhibition_gallery');
    })->name('exhibition_gallery');

    Route::get('/kids_only', function () {
        return view('eerc.pages.kids_only');
    })->name('kids_only');

    Route::get('/contact', function () {
        return view('eerc.pages.contact');
    })->name('contact');

    Route::get('/accessibility', function () {
        return view('eerc.pages.accessibility');
    })->name('accessibility');
});
