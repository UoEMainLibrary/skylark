<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/**
 * @return array<string, mixed>
 */
function fairbairnConfig(): array
{
    return require config_path('collections/fairbairn.php');
}

it('registers every expected fairbairn named route', function (string $name): void {
    expect(Route::has($name))->toBeTrue("route [$name] is missing");
})->with([
    'fairbairn.home',
    'fairbairn.search.redirect',
    'fairbairn.search.index',
    'fairbairn.record.show',
    'fairbairn.about',
    'fairbairn.licensing',
    'fairbairn.takedown',
    'fairbairn.accessibility',
    'fairbairn.feedback',
    'fairbairn.browse',
]);

it('does NOT register DSpace-only routes for fairbairn', function (string $name): void {
    expect(Route::has($name))->toBeFalse("route [$name] should not be registered for fairbairn");
})->with([
    'fairbairn.mirador',
    'fairbairn.iiif',
    'fairbairn.advanced',
    'fairbairn.advanced.form',
    'fairbairn.advanced.post',
    'fairbairn.advanced.search',
]);

it('registers fairbairn routes on the configured dedicated host', function (): void {
    expect(env('FAIRBAIRN_HOST'))->toBe('fairbairn.testing')
        ->and(config('collections.domains'))->toHaveKey('fairbairn.testing');

    $hasDomainHome = collect(app('router')->getRoutes())->contains(
        fn ($route) => $route->uri() === '/' && $route->getDomain() === 'fairbairn.testing'
    );

    expect($hasDomainHome)->toBeTrue();
});

it('exposes /record/{id}/{type?} for ArchivesSpace records', function (): void {
    $route = Route::getRoutes()->match(Request::create('/fairbairn/record/20528/archival_object', 'GET'));

    expect($route->getControllerClass())->toBe(RecordController::class)
        ->and($route->getActionMethod())->toBe('show')
        ->and($route->getName())->toBe('fairbairn.record.show');
});

it('serves the fairbairn home page', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/fairbairn')
        ->assertSuccessful()
        ->assertSee('W. Ronald D. Fairbairn (1889-1964)', false)
        ->assertSee('Wellcome Trust', false);
});

it('serves every fairbairn static page', function (string $path): void {
    fakeArchivesSpaceSolr();

    $this->get("/fairbairn/{$path}")->assertSuccessful();
})->with([
    'about',
    'licensing',
    'takedown',
    'accessibility',
    'feedback',
]);

it('serves the fairbairn home page at / on a configured dedicated host', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('http://fairbairn.testing/')
        ->assertSuccessful()
        ->assertSee('W. Ronald D. Fairbairn (1889-1964)', false);
});

it('uses root-relative collection links on a dedicated host', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('http://fairbairn.testing/about')
        ->assertSuccessful()
        ->assertSee('href="http://fairbairn.testing/about"', false)
        ->assertDontSee('/fairbairn/about', false);
});

it('serves a search results page with Subject and Agent facet headings', function (): void {
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 0, 'docs' => []],
            'facet_counts' => [
                'facet_fields' => [
                    'subjects' => ['Psychoanalysis', 5],
                    'agents' => ['W. Ronald D. Fairbairn', 2],
                ],
            ],
        ], 200),
    ]);

    $this->get('/fairbairn/search/*:*')
        ->assertSuccessful()
        ->assertSee('Subject', false)
        ->assertSee('Agent', false)
        ->assertSee('Psychoanalysis', false);
});

it('accepts a Subject facet filter URL without encoding errors', function (): void {
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 1, 'docs' => []],
            'facet_counts' => [
                'facet_fields' => [
                    'subjects' => ['Articles', 1],
                    'agents' => [],
                ],
            ],
        ], 200),
    ]);

    $this->get('/fairbairn/search/*:*/Subject:"Articles"')
        ->assertSuccessful()
        ->assertSee('Articles', false);
});

it('renders a deselect link that clears an active Subject facet filter', function (): void {
    Http::fake([
        '*' => Http::response([
            'response' => ['numFound' => 1, 'docs' => []],
            'facet_counts' => [
                'facet_fields' => [
                    'subjects' => ['Articles', 1, 'Typescripts', 2],
                    'agents' => [],
                ],
            ],
        ], 200),
    ]);

    $response = $this->get('/fairbairn/search/*:*/Subject:"Articles"')
        ->assertSuccessful();

    preg_match('/class="deselect" href=[\'"]([^\'"]+)[\'"]/', $response->getContent(), $matches);

    expect($matches[1] ?? '')->toBe(url('/fairbairn/search/*:*'));
});

it('accepts a Subject facet filter URL with plus-encoded spaces', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/fairbairn/search/*:*/Subject:"object+relations"')
        ->assertSuccessful();
});

it('renders the collection-specific accessibility statement', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/fairbairn/accessibility')
        ->assertSuccessful()
        ->assertSee('Accessibility statement for', false)
        ->assertSee('W. Ronald D. Fairbairn', false)
        ->assertSee('fairbairn.ac.uk', false)
        ->assertDontSee('University Collections website', false);
});

it('renders the fairbairn Google Analytics tag from the resolved ga_code', function (): void {
    fakeArchivesSpaceSolr();

    $expected = fairbairnConfig()['ga_code'];

    expect($expected)->not->toBeEmpty();

    $this->get('/fairbairn')
        ->assertSuccessful()
        ->assertSee($expected)
        ->assertSee('https://www.googletagmanager.com/gtag/js', false);
});

it('uses ArchivesSpace as its repository type', function (): void {
    expect(fairbairnConfig()['repository_type'])->toBe('archivesspace');
});

it('scopes search to the fairbairn repository container', function (): void {
    fakeArchivesSpaceSolr();

    $this->get('/fairbairn/search/*:*')->assertSuccessful();

    $config = fairbairnConfig();
    $containerField = $config['container_field'];
    $containerId = $config['container_id'][0];

    Http::assertSent(function ($request) use ($containerField, $containerId) {
        $url = (string) $request->url();

        if (! str_contains($url, '/select?')) {
            return false;
        }

        $expected = '&fq='.$containerField.':'.str_replace('"', '%22', $containerId);

        return str_contains($url, $expected);
    });
});

it('exposes Subject and Agent filters in config', function (): void {
    expect(fairbairnConfig()['filters'])->toBe([
        'Subject' => 'subjects',
        'Agent' => 'agents',
    ]);
});

it('points the GA code at FAIRBAIRN_GA_CODE', function (): void {
    $contents = file_get_contents(config_path('collections/fairbairn.php'));

    expect($contents)->toContain("env('FAIRBAIRN_GA_CODE'");
});

it('routes /search/{query} via SearchController@index', function (): void {
    $route = Route::getRoutes()->match(Request::create('/fairbairn/search/*:*', 'GET'));

    expect($route->getControllerClass())->toBe(SearchController::class)
        ->and($route->getActionMethod())->toBe('index');
});
