<?php

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
