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

    // DSpace filters (commented for ArchivesSpace testing)
    // 'filters' => [
    //     'Type' => 'type_filter',
    //     'Subject' => 'subject_filter',
    //     'Origin' => 'place_filter',
    // ],

    // ArchivesSpace filters (eerc)
    'filters' => [
        'Subject' => 'subjects',
        'Person' => 'agents',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sort Fields Configuration
    |--------------------------------------------------------------------------
    |
    | Available sort options for search results
    |
    */

    // DSpace sort fields (commented for ArchivesSpace testing)
    // 'sort_fields' => [
    //     'Relevancy' => 'score',
    //     'Title' => 'dc.title_sort',
    //     'Subject' => 'dc.subject_sort',
    // ],

    // ArchivesSpace sort fields (eerc)
    'sort_fields' => [
        'Relevancy' => 'score',
        'Title' => 'title_sort',
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

    // DSpace display fields (commented for ArchivesSpace testing)
    // 'searchresult_display' => [
    //     'Title',
    //     'Brief',
    //     'Custodian',
    //     'Subject',
    //     'Type',
    //     'Origin',
    //     'Thumbnail',
    // ],

    // ArchivesSpace display fields (eerc)
    'searchresult_display' => [
        'Title',
        'Custodian',
        'Subject',
        'Agents',
        'Identifier',
        'Brief',
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Mappings
    |--------------------------------------------------------------------------
    |
    | Maps display field names to Solr field names
    |
    */

    // DSpace field mappings (commented for ArchivesSpace testing)
    // 'field_mappings' => [
    //     'Title' => 'dc.title.en',
    //     'Brief' => 'dc.abstract.en',
    //     'Custodian' => 'dc.creator.en',
    //     'Subject' => 'dc.subject.en',
    //     'Type' => 'dc.type.en',
    //     'Origin' => 'dc.coverage.spatial.en',
    //     'Date' => 'dc.coverage.temporal.en',
    //     'Thumbnail' => 'dc.format.thumbnail.en',
    //     'Bitstream' => 'dc.format.original.en',
    // ],

    // ArchivesSpace field mappings (eerc)
    'field_mappings' => [
        'Title' => 'title',
        'Brief' => 'scopecontent',
        'Custodian' => 'creators',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Identifier' => 'component_id',
        'Agents' => 'agents',
        'Date' => 'dates',
        'Thumbnail' => '',
        'Bitstream' => '',
    ],
];
