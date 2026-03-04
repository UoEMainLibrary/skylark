<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collection Information
    |--------------------------------------------------------------------------
    */
    'appname' => 'clds',
    'fullname' => 'Edinburgh University Collections',
    'theme' => 'clds',
    'url_prefix' => null, // No prefix for main collection

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'adminemail' => 'HeritageCollections@ed.ac.uk',

    /*
    |--------------------------------------------------------------------------
    | Repository Configuration
    |--------------------------------------------------------------------------
    */
    'repository_type' => 'dspace',
    'repository_version' => '6',

    /*
    |--------------------------------------------------------------------------
    | Solr Configuration
    |--------------------------------------------------------------------------
    */
    'solr_core' => '',
    'solr_base' => env('SOLR_URL', 'http://collectionsinternal.is.ed.ac.uk:8080/solr/search/'),

    /*
    |--------------------------------------------------------------------------
    | Container Configuration
    |--------------------------------------------------------------------------
    */
    'handle_prefix' => env('SKYLIGHT_HANDLE_PREFIX', '10683'),
    'container_id' => env('APP_ENV') === 'production'
        ? '12779059-f8a5-4a44-9f85-08772679bf3f'
        : '7f32ba59-795e-40e8-b869-5b2a5114a4be',
    'container_field' => 'location.coll',
    'query_restriction' => [],

    /*
    |--------------------------------------------------------------------------
    | Field Mappings (DSpace Dublin Core Schema)
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Display Configuration
    |--------------------------------------------------------------------------
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
    | Search Configuration
    |--------------------------------------------------------------------------
    */
    'search_fields' => [
        'Keywords' => 'text',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter Configuration
    |--------------------------------------------------------------------------
    */
    'filters' => [
        'Type' => 'type_filter',
        'Subject' => 'subject_filter',
        'Origin' => 'place_filter',
    ],
    'filter_delimiter' => ':',
    'date_filters' => [],

    /*
    |--------------------------------------------------------------------------
    | Sort Configuration
    |--------------------------------------------------------------------------
    */
    'sort_fields' => [
        'Relevancy' => 'score',
        'Title' => 'dc.title_sort',
        'Subject' => 'dc.subject_sort',
    ],
    'default_sort' => 'score desc',

    /*
    |--------------------------------------------------------------------------
    | Related Items Configuration
    |--------------------------------------------------------------------------
    */
    'related_fields' => [
        'Type' => 'dc.type.en',
        'Subject' => 'dc.subject.en',
    ],
    'related_number' => 10,

    /*
    |--------------------------------------------------------------------------
    | Meta Fields
    |--------------------------------------------------------------------------
    */
    'meta_fields' => [
        'Title' => 'dc.title',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feed Fields
    |--------------------------------------------------------------------------
    */
    'feed_fields' => [
        'Title' => 'Title',
        'Subject' => 'Subject',
        'Origin' => 'Origin',
        'Identifier' => 'Identifier',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Options
    |--------------------------------------------------------------------------
    */
    'results_per_page' => env('SKYLIGHT_RESULTS_PER_PAGE', 20),
    'facet_limit' => 10,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'homepage_fullwidth' => true,
    'search_header' => true,
    'display_thumbnail' => true,
    'link_bitstream' => true,
    'bitstream_field' => '',
    'thumbnail_field' => '',

    /*
    |--------------------------------------------------------------------------
    | Lightbox Configuration
    |--------------------------------------------------------------------------
    */
    'lightbox' => true,
    'lightbox_mimes' => ['image/jpeg', 'image/gif', 'image/png'],

    /*
    |--------------------------------------------------------------------------
    | Language Configuration
    |--------------------------------------------------------------------------
    */
    'language_default' => 'en',
    'language_options' => ['en', 'ko', 'jp'],
    'highlight_fields' => 'dc.title.en,dc.creator,dc.subject.en,dc.description.en,dc.relation.ispartof.en',

    /*
    |--------------------------------------------------------------------------
    | OAI-PMH Configuration
    |--------------------------------------------------------------------------
    */
    'oaipmhcollection' => 'hdl_10683_4',
    'oaipmhallowed' => true,

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => false,

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    */
    'sitemap_type' => 'internal',

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    */
    'ga_code' => env('APP_ENV') === 'production' ? 'G-L20JS09H7H' : 'G-8VP4HF0K5M',
];
