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
    'handle_prefix' => env('SKYLIGHT_HANDLE_PREFIX', '10683'),

    /*
    |--------------------------------------------------------------------------
    | Filters Configuration
    |--------------------------------------------------------------------------
    |
    | Maps display names to Solr filter field names
    |
    */

    // DSpace filters (clds)
    'filters' => [
        'Type' => 'type_filter',
        'Subject' => 'subject_filter',
        'Origin' => 'place_filter',
    ],

    // ArchivesSpace filters (eerc) - for reference/testing
    // 'filters' => [
    //     'Subject' => 'subjects',
    //     'Person' => 'agents',
    // ],

    /*
    |--------------------------------------------------------------------------
    | Sort Fields Configuration
    |--------------------------------------------------------------------------
    |
    | Available sort options for search results
    |
    */

    // DSpace sort fields (clds)
    'sort_fields' => [
        'Relevancy' => 'score',
        'Title' => 'dc.title_sort',
        'Subject' => 'dc.subject_sort',
    ],

    // ArchivesSpace sort fields (eerc) - for reference/testing
    // 'sort_fields' => [
    //     'Relevancy' => 'score',
    //     'Title' => 'title_sort',
    // ],

    'default_sort' => 'score desc',

    /*
    |--------------------------------------------------------------------------
    | Search Result Display Fields
    |--------------------------------------------------------------------------
    |
    | Fields to display in search results
    |
    */

    // DSpace display fields (clds)
    'searchresult_display' => [
        'Title',
        'Brief',
        'Custodian',
        'Subject',
        'Type',
        'Origin',
        'Thumbnail',
    ],

    // ArchivesSpace display fields (eerc) - for reference/testing
    // 'searchresult_display' => [
    //     'Title',
    //     'Custodian',
    //     'Subject',
    //     'Agents',
    //     'Identifier',
    //     'Brief',
    // ],

    /*
    |--------------------------------------------------------------------------
    | Record Display Fields
    |--------------------------------------------------------------------------
    |
    | Fields to display on individual record pages
    |
    */

    'recorddisplay' => [
        'Title',
        'Type',
        'Summary',
        'Description',
        'Custodian',
        'Custodial History',
        'Origin',
        'Date',
        'Identifier',
        'Further Resources',
    ],

    /*
    |--------------------------------------------------------------------------
    | Related Items Configuration
    |--------------------------------------------------------------------------
    |
    | Fields used to find related items
    |
    */

    'related_fields' => [
        'Type' => 'dc.type.en',
        'Subject' => 'dc.subject.en',
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

    // DSpace field mappings (clds)
    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Brief' => 'dc.abstract.en',
        'Summary' => 'dc.description.abstract.en',
        'Description' => 'dc.description.en',
        'Custodian' => 'dc.creator.en',
        'Custodial History' => 'cld.custodialHistory.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Origin' => 'dc.coverage.spatial.en',
        'Date' => 'dc.coverage.temporal.en',
        'Identifier' => 'dc.identifier.other',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Bitstream' => 'dc.format.original.en',
        'Parent Collection' => 'dc.relation.ispartof.en',
        'Sub Collections' => 'dc.relation.haspart.en',
        'Internal URI' => 'cld.internalURI.en',
        'ASpace URI' => 'cld.externalURI.ArchivesSpace',
        'LUNA URI' => 'cld.externalURI.LUNA',
        'LMS URI' => 'cld.externalURI.LMS',
        'Other URI' => 'cld.externalURI.other',
    ],

    // ArchivesSpace field mappings (eerc) - for reference/testing
    // 'field_mappings' => [
    //     'Title' => 'title',
    //     'Brief' => 'scopecontent',
    //     'Custodian' => 'creators',
    //     'Subject' => 'subjects',
    //     'Type' => 'primary_type',
    //     'Identifier' => 'component_id',
    //     'Agents' => 'agents',
    //     'Date' => 'dates',
    //     'Thumbnail' => '',
    //     'Bitstream' => '',
    // ],
];
