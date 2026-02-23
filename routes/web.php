<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Search routes
Route::post('/redirect', [SearchController::class, 'redirect'])->name('search.redirect');

Route::get('/search/{query}/{filters?}', [SearchController::class, 'index'])
    ->where('query', '.*')
    ->where('filters', '.*')
    ->name('search.index');

// Image proxy test endpoint (for debugging)
Route::get('/record/test-proxy', [RecordController::class, 'testProxy'])->name('record.test');

// Image proxy route for DSpace bitstreams
Route::get('/record/{id}/{seq}/{filename}', [RecordController::class, 'proxyImage'])
    ->where('id', '[0-9]+')
    ->where('seq', '[0-9]+')
    ->name('record.image');
