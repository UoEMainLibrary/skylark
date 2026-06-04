<?php

use App\Http\Controllers\SearchController;
use App\Services\RepositoryFactory;

it('returns vpn-aware message when search backend denies access', function (): void {
    config(['app.current_collection' => 'jlss']);

    $controller = new class(app(RepositoryFactory::class)) extends SearchController
    {
        public function failForTest(Throwable $e, string $query)
        {
            return $this->searchFailureResponse($e, $query);
        }
    };

    $response = $controller->failForTest(
        new Exception('Solr query failed: 403 - '),
        'test'
    );

    expect($response->getStatusCode())->toBe(503)
        ->and($response->getContent())->toContain('repository access is denied')
        ->and($response->getContent())->toContain('connect to the VPN');
});

it('treats Solr syntax errors as client errors', function (): void {
    $controller = new class(app(RepositoryFactory::class)) extends SearchController
    {
        public function check(Throwable $e): bool
        {
            return $this->isSolrQueryClientError($e);
        }
    };

    expect($controller->check(new Exception('Solr query failed: 400 - SyntaxError')))->toBeTrue()
        ->and($controller->check(new Exception('Solr query failed: 500 - Internal Error')))->toBeFalse();
});

it('keeps generic message for non-access-denied errors', function (): void {
    config(['app.current_collection' => 'jlss']);

    $controller = new class(app(RepositoryFactory::class)) extends SearchController
    {
        public function failForTest(Throwable $e, string $query)
        {
            return $this->searchFailureResponse($e, $query);
        }
    };

    $response = $controller->failForTest(
        new Exception('Solr query failed: 500 - Internal Error'),
        'test'
    );

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getContent())->toContain('There was a problem performing your search');
});
