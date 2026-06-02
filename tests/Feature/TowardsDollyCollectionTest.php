<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

function fakeTowardsDollyArchivesSpace(): void
{
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => ['facet_fields' => []],
        ], 200),
    ]);
}

function towardsDollyConfig(): array
{
    return require config_path('collections/towardsdolly.php');
}

it('registers expected towardsdolly named routes', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [$name] is missing");
})->with([
    'towardsdolly.home',
    'towardsdolly.search.redirect',
    'towardsdolly.search.index',
    'towardsdolly.record.show',
    'towardsdolly.about',
    'towardsdolly.licensing',
    'towardsdolly.takedown',
    'towardsdolly.accessibility',
    'towardsdolly.feedback',
    'towardsdolly.history',
    'towardsdolly.people',
    'towardsdolly.catalogues',
    'towardsdolly.audio',
    'towardsdolly.browse',
]);

it('does not register DSpace-only routes for towardsdolly', function (string $name): void {
    expect(Route::has($name))->toBeFalse("route [$name] should not be registered for towardsdolly");
})->with([
    'towardsdolly.mirador',
    'towardsdolly.iiif',
    'towardsdolly.advanced',
    'towardsdolly.advanced.form',
    'towardsdolly.advanced.post',
    'towardsdolly.advanced.search',
    'towardsdolly.record.image',
]);

it('resolves ArchivesSpace record urls with optional type segment', function (): void {
    $route = Route::getRoutes()->match(Request::create('/towardsdolly/record/52099/archival_object', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('towardsdolly.record.show');
});

it('routes search urls through SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/towardsdolly/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});

it('serves the towardsdolly homepage', function (): void {
    fakeTowardsDollyArchivesSpace();

    $this->get('/towardsdolly')
        ->assertSuccessful()
        ->assertSee('Towards Dolly: Edinburgh, Roslin and the Birth of Modern Genetics')
        ->assertSee('Project Blog');
});

it('serves the towardsdolly static pages', function (string $path): void {
    fakeTowardsDollyArchivesSpace();

    $this->get("/towardsdolly/{$path}")->assertSuccessful();
})->with([
    'about',
    'history',
    'people',
    'catalogues',
    'audio',
    'feedback',
    'licensing',
    'takedown',
    'accessibility',
    'browse/Subject',
]);

it('renders about page videos for towardsdolly', function (): void {
    fakeTowardsDollyArchivesSpace();

    $this->get('/towardsdolly/about')
        ->assertSuccessful()
        ->assertSee('collections/towardsdolly/videos/Towards_Dolly_Wellcome_Trust_showreel.mp4', false)
        ->assertSee('collections/towardsdolly/videos/0051021v-001.mp4', false);
});

it('serves search results with empty ArchivesSpace responses', function (): void {
    fakeTowardsDollyArchivesSpace();

    $this->get('/towardsdolly/search/*:*')
        ->assertSuccessful()
        ->assertSee('No results found');
});

it('uses ArchiveSpace repository configuration for towardsdolly', function (): void {
    expect(towardsDollyConfig()['repository_type'])->toBe('archivesspace')
        ->and(towardsDollyConfig()['handle_prefix'])->toBe('/repositories/2/')
        ->and(towardsDollyConfig()['query_restriction'])->toBe(['publish' => 'true']);
});

it('keeps container ids quoted for valid Solr fq clauses', function (): void {
    $containerIds = towardsDollyConfig()['container_id'];

    expect($containerIds)->toBeArray()->not->toBeEmpty();

    foreach ($containerIds as $id) {
        expect($id)
            ->toStartWith('"')
            ->toEndWith('"')
            ->toContain('/repositories/2/resources/');
    }
});

it('points ga_code at TOWARDSDOLLY_GA_CODE', function (): void {
    $contents = file_get_contents(config_path('collections/towardsdolly.php'));

    expect($contents)
        ->toContain("env('TOWARDSDOLLY_GA_CODE'")
        ->not->toContain("env('EERC_GA_CODE'");
});
