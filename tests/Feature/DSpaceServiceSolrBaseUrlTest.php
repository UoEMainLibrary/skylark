<?php

use App\Services\DSpaceService;

afterEach(function (): void {
    putenv('SOLR_BASE_URL');
    putenv('SOLR_URL');
});

it('prefers collection solr_base over environment variables', function (): void {
    config(['skylight.solr_base' => 'http://from-config:8080/solr/search/']);
    putenv('SOLR_BASE_URL=http://from-solr-base-url:8080/solr/search/');
    putenv('SOLR_URL=http://from-solr-url:8080/solr/search/');

    $service = new DSpaceService;

    expect($service->getBaseUrl())->toBe('http://from-config:8080/solr/search/');
});
