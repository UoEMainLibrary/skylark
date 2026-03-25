<?php

/**
 * Shared defaults for DSpace-backed collections.
 *
 * New prefixed collections should typically use:
 *   return array_merge(require __DIR__.'/defaults/dspace.php', [ ...overrides... ]);
 *
 * @see docs/collection-migration.md
 */
return [
    'repository_type' => 'dspace',
    'repository_version' => '6',

    'solr_core' => '',
    'solr_base' => env('SOLR_URL', 'http://collectionsinternal.is.ed.ac.uk:8080/solr/search/'),

    'handle_prefix' => env('SKYLIGHT_HANDLE_PREFIX', '10683'),
    'container_field' => 'location.coll',
    'query_restriction' => [],

    'filter_delimiter' => ':',
    'date_filters' => [],

    'results_per_page' => env('SKYLIGHT_RESULTS_PER_PAGE', 20),
    'facet_limit' => env('SKYLIGHT_FACET_LIMIT', 10),

    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'homepage_fullwidth' => true,
    'search_header' => true,
    'display_thumbnail' => true,
    'link_bitstream' => true,
    'bitstream_field' => '',
    'thumbnail_field' => '',

    'lightbox' => true,
    'lightbox_mimes' => ['image/jpeg', 'image/gif', 'image/png'],

    'language_default' => 'en',
    'language_options' => ['en', 'ko', 'jp'],

    'cache' => false,
    'sitemap_type' => 'internal',
    'oaipmhallowed' => true,
];
