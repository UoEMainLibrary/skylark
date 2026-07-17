<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * Stub every outbound Solr call so the test suite doesn't need live DSpace.
 */
function fakeCalendarsSolr(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

it('registers every expected calendars named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [{$name}] is missing");
})->with([
    'calendars.home',
    'calendars.search.redirect',
    'calendars.search.index',
    'calendars.record.show',
    'calendars.record.image',
    'calendars.mirador',
    'calendars.advanced',
    'calendars.advanced.form',
    'calendars.advanced.post',
    'calendars.advanced.search',
    'calendars.about',
    'calendars.licensing',
    'calendars.takedown',
    'calendars.accessibility',
    'calendars.feedback',
    'calendars.laing',
]);

it('routes /calendars/search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/calendars/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('routes /calendars/record/{id} via RecordController@show', function (): void {
    $route = Route::getRoutes()->match(Request::create('/calendars/record/12345', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('calendars.record.show');
});

it('serves the calendars home page at /calendars with the legacy 2016 carousel', function (): void {
    fakeCalendarsSolr();

    $this->get('/calendars')
        ->assertSuccessful()
        ->assertSee('University Calendar 2016', false)
        ->assertSee('Georg Braun', false)
        ->assertSee('data-jcarousel', false)
        ->assertSee('./record/52833', false);
});

it('serves every calendars static page', function (string $path): void {
    fakeCalendarsSolr();

    $this->get("/calendars/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'feedback',
    'accessibility',
    'laing',
]);

it('links the Laing 2015 calendar with the double-encoded subject filter shape', function (): void {
    $html = view('calendars.pages.laing')->render();

    expect($html)
        // Never a literal `|||` in href — double-encoded as %7C%7C%7C.
        ->not->toContain('|||')
        ->and($html)->toContain('/Subject:%22images+from+the+david+laing+collection+2015%7C%7C%7CImages+from+the+David+Laing+Collection+2015%22');
});

it('loads calendars-specific skylight config when /calendars is requested', function (): void {
    fakeCalendarsSolr();

    $this->get('/calendars')->assertSuccessful();

    expect(config('skylight.appname'))->toBe('calendars')
        ->and(config('skylight.fullname'))->toBe('University of Edinburgh Calendars')
        ->and(config('skylight.theme'))->toBe('calendars')
        ->and(config('skylight.url_prefix'))->toBe('calendars')
        ->and(config('skylight.container_field'))->toBe('location.coll')
        ->and(config('skylight.container_id'))->toBe(env('CALENDARS_CONTAINER_ID', '4e5e82a5-c06c-4844-bc65-c6aef272f646'))
        ->and(config('skylight.oaipmhcollection'))->toBe('hdl_10683_19396')
        ->and(config('skylight.results_per_page'))->toBe(15);
});
