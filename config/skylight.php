<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Search Results Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for search results display and pagination
    |
    */

    'results_per_page' => env('SKYLIGHT_RESULTS_PER_PAGE', 20),
    'facet_limit' => 10,
    'filter_delimiter' => ':',

    /*
    |--------------------------------------------------------------------------
    | Filters Configuration
    |--------------------------------------------------------------------------
    |
    | Maps display names to Solr filter field names
    |
    */

    'filters' => [
        'Type' => 'type_filter',
        'Subject' => 'subject_filter',
        'Origin' => 'place_filter',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sort Fields Configuration
    |--------------------------------------------------------------------------
    |
    | Available sort options for search results
    |
    */

    'sort_fields' => [
        'Relevancy' => 'score',
        'Title' => 'dc.title_sort',
        'Subject' => 'dc.subject_sort',
    ],

    'default_sort' => 'score desc',

    /*
    |--------------------------------------------------------------------------
    | Search Result Display Fields
    |--------------------------------------------------------------------------
    |
    | Fields to display in search results
    |
    */

    'searchresult_display' => [
        'Title',
        'Brief',
        'Custodian',
        'Subject',
        'Type',
        'Origin',
        'Thumbnail',
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Mappings
    |--------------------------------------------------------------------------
    |
    | Maps display field names to Solr field names
    |
    */

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Brief' => 'dc.abstract.en',
        'Custodian' => 'dc.creator.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Origin' => 'dc.coverage.spatial.en',
        'Date' => 'dc.coverage.temporal.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Bitstream' => 'dc.format.original.en',
    ],
];
