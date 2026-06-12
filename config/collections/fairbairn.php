<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collection Information
    |--------------------------------------------------------------------------
    */
    'appname' => 'fairbairn',
    'fullname' => 'W. Ronald D. Fairbairn',
    'theme' => 'fairbairn',
    'url_prefix' => 'fairbairn',

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'adminemail' => 'lac-fairbairn@mlist.is.ed.ac.uk',

    /*
    |--------------------------------------------------------------------------
    | Repository Configuration
    |--------------------------------------------------------------------------
    */
    'repository_type' => 'archivesspace',
    'repository_version' => '1',

    /*
    |--------------------------------------------------------------------------
    | Solr Configuration
    |--------------------------------------------------------------------------
    */
    'solr_core' => 'solr/archivesspace',
    'solr_base' => env('ARCHIVESSPACE_SOLR_URL', 'http://lac-archivesspace-live5.is.ed.ac.uk:8983/'),
    'link_url' => env('ARCHIVESSPACE_LINK_URL', 'https://archivesspace.collections.ed.ac.uk'),

    /*
    |--------------------------------------------------------------------------
    | Container Configuration
    |--------------------------------------------------------------------------
    |
    | Mirrors skylight-local/config/fairbairn.ac.uk.php — repository-level
    | scope via container_field `repository`.
    */
    'handle_prefix' => '/repositories/6/',
    'container_id' => ['"/repositories/6"'],
    'container_field' => 'repository',

    /*
    |--------------------------------------------------------------------------
    | Query Restriction
    |--------------------------------------------------------------------------
    */
    'query_restriction' => [],

    /*
    |--------------------------------------------------------------------------
    | Field Mappings (ArchivesSpace Schema)
    |--------------------------------------------------------------------------
    */
    'field_mappings' => [
        'Title' => 'title',
        'Creator' => 'creators',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Level' => 'level',
        'Date' => 'create_time',
        'JSON' => 'json',
        'Agent' => 'agents',
        'Publish' => 'publish',
        'Notes' => 'notes',
        'Language' => 'langmaterial',
        'Scope and Contents' => 'scopecontent',
        'Related' => 'relatedmaterial',
        'Physical' => 'phystech',
        'Access' => 'accessrestrict',
        'Rights' => 'rights_statements',
        'Dates' => 'dates',
        'Extent' => 'extents',
        'Identifier' => 'component_id',
        'Parent' => 'parent',
        'Parent_Id' => 'parent_id',
        'Parent_Type' => 'parent_type',
        'Bibliography' => 'note_bibliography',
        'Id' => 'id',
        'Alternative Format' => 'altformavail',
        'Physical Description' => 'physdesc',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Configuration
    |--------------------------------------------------------------------------
    */
    'recorddisplay' => [
        'Identifier',
        'Creator',
        'Dates',
        'Extent',
        'Extent Type',
        'Agent',
        'Subject',
        'Notes',
        'Rights',
        'Language',
        'Scope and Contents',
        'Related',
        'Bibliography',
        'Physical',
        'Physical Description',
        'Access',
        'Alternative Format',
    ],

    'searchresult_display' => [
        'Title',
        'Creator',
        'Subject',
        'Agent',
    ],

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    */
    'search_fields' => [
        'Title' => 'title',
        'Subject' => 'subjects',
        'Agent' => 'agents',
        'Creator' => 'creators',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter Configuration
    |--------------------------------------------------------------------------
    */
    'filters' => [
        'Subject' => 'subjects',
        'Agent' => 'agents',
    ],
    'filter_delimiter' => ':',
    'date_filters' => [],

    /*
    |--------------------------------------------------------------------------
    | Sort Configuration
    |--------------------------------------------------------------------------
    */
    'sort_fields' => [
        'Title' => 'title_sort',
    ],

    /*
    |--------------------------------------------------------------------------
    | Related Items Configuration
    |--------------------------------------------------------------------------
    */
    'related_fields' => [
        'Parent' => 'parent',
        'Id' => 'id',
    ],
    'related_number' => 20,

    /*
    |--------------------------------------------------------------------------
    | Meta Fields
    |--------------------------------------------------------------------------
    */
    'meta_fields' => [
        'Title' => 'title',
        'Agent' => 'agents',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Level' => 'level',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feed Fields
    |--------------------------------------------------------------------------
    */
    'feed_fields' => [
        'Title' => 'title',
        'Creator' => 'creator',
        'Subject' => 'subjects',
        'Agent' => 'agents',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Options
    |--------------------------------------------------------------------------
    */
    'results_per_page' => 10,
    'default_sort' => '',
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'display_thumbnail' => false,
    'link_bitstream' => false,
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
    'language_options' => ['en'],

    /*
    |--------------------------------------------------------------------------
    | OAI-PMH Configuration
    |--------------------------------------------------------------------------
    */
    'oaipmhcollection' => '',
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
    'sitemap_type' => 'external',

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    |
    | Production: G-1HP342X330. Development/staging: G-X4CRLZFCQM.
    */
    'ga_code' => env('FAIRBAIRN_GA_CODE', 'G-1HP342X330'),
];
