<?php

use App\Http\Controllers\SearchController;
use App\Services\RepositoryFactory;

/**
 * Legacy skylight (CI's Pagination library) rendered pagination as a
 * &nbsp;-separated run of <a> anchors around a <span class="curpage">N</span>
 * marker. Every collection stylesheet targets `.pagination a`, `.curpage`,
 * `.pagination .prev`/`.next` and expects that shape — Bootstrap
 * `<ul class="pagination"><li>` markup renders as bulleted anchors and looks
 * like a broken paginator, which is what the "old pagination thing" client
 * feedback was pointing at.
 *
 * These tests lock the SearchController's pagination markup to the legacy
 * shape so that regression is caught in tests, not by eyeballing search
 * pages.
 */
function buildPagination(int $total, int $rows, int $offset): string
{
    $controller = new SearchController(app(RepositoryFactory::class));
    $ref = new ReflectionMethod($controller, 'buildPaginationLinks');
    $ref->setAccessible(true);

    return $ref->invoke($controller, $total, $rows, $offset, './search/*:*', '');
}

it('returns an empty string when the result set fits on a single page', function (): void {
    expect(buildPagination(5, 15, 0))->toBe('');
});

it('emits legacy &nbsp;-separated markup with <span class="curpage"> for page 1', function (): void {
    // 130 results, 15 per page = 9 pages, current = 1.
    $out = buildPagination(130, 15, 0);

    expect($out)
        ->toContain('<span class="curpage">1</span>')
        ->and($out)->toContain('<a href="./search/*:*?offset=15">2</a>')
        ->and($out)->toContain('<a href="./search/*:*?offset=30">3</a>')
        // Next chevron uses &gt; (single legacy angle bracket, not &raquo;)
        ->and($out)->toContain('<a href="./search/*:*?offset=15">&gt;</a>')
        // Last » jump lands on the final page offset
        ->and($out)->toContain('<a href="./search/*:*?offset=120">Last &rsaquo;</a>')
        // No bootstrap <ul> or <li> wrapper survives
        ->and($out)->not->toContain('<ul')
        ->and($out)->not->toContain('<li')
        ->and($out)->not->toContain('pagination-sm')
        ->and($out)->not->toContain('class="active"');
});

it('shows a previous < link on page 2 and drops the First « link near the start of the list', function (): void {
    // page 2 of 9
    $out = buildPagination(130, 15, 15);

    expect($out)
        ->toContain('<a href="./search/*:*?offset=0">&lt;</a>')
        ->and($out)->toContain('<span class="curpage">2</span>')
        ->and($out)->toContain('<a href="./search/*:*?offset=30">&gt;</a>')
        // Not far enough from the start to earn a First « link.
        ->and($out)->not->toContain('&lsaquo; First');
});

it('shows a First « link when the current page is far enough from the start', function (): void {
    // page 7 of 9 with numLinks=4 → First appears (cur > numLinks+1)
    $out = buildPagination(130, 15, 90);

    expect($out)
        ->toContain('&lsaquo; First')
        ->and($out)->toContain('<span class="curpage">7</span>');
});

it('drops the Next > and Last » links when we\'re already on the final page', function (): void {
    // page 9 of 9
    $out = buildPagination(130, 15, 120);

    expect($out)
        ->toContain('<span class="curpage">9</span>')
        ->and($out)->toContain('<a href="./search/*:*?offset=105">&lt;</a>')
        // No trailing Next chevron / Last jump on the last page
        ->and($out)->not->toContain('">&gt;</a>')
        ->and($out)->not->toContain('Last &rsaquo;');
});

it('joins offset with &amp; when the base query already contains parameters', function (): void {
    $controller = new SearchController(app(RepositoryFactory::class));
    $ref = new ReflectionMethod($controller, 'buildPaginationLinks');
    $ref->setAccessible(true);

    $out = $ref->invoke($controller, 130, 15, 15, './search/*:*', '?operator=OR');

    expect($out)
        ->toContain('./search/*:*?operator=OR&offset=0')
        ->and($out)->toContain('./search/*:*?operator=OR&offset=30');
});
