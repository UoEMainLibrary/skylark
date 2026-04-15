<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collection Information
    |--------------------------------------------------------------------------
    */
    'appname' => 'lhsacasenotes',
    'fullname' => 'Lothian Health Service Archives: Medical Case Notes',
    'theme' => 'lhsacasenotes',
    'url_prefix' => 'lhsacasenotes',

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

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
    */
    'handle_prefix' => '/repositories/13/',
    'container_id' => [
        '/repositories/15/resources/86795',
        '/repositories/13/resources/86679',
        '/repositories/9/resources/86697',

    ],
    'container_field' => 'resource',

    //deal with this $config['skylight_query_restriction'] = array('publish' => 'true');

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
        'Resource_Id' => 'resource',
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
        'Dates' =>'dates',
        'Extent' => 'extents',
        'Identifier' =>'component_id',
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
        'Rights',
        'Language',
        'Scope and Contents',
        'Related',
        'Bibliography',
        'Physical',
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
        'Person' => 'agents',
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
    'related_number' => 10,

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
    */
    'ga_code' => env('EERC_GA_CODE', 'G-974QNLBL9Q'),
];
