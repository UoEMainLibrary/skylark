<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collection Information
    |--------------------------------------------------------------------------
    */
    'appname' => 'eerc',
    'fullname' => 'Regional Ethnology of Scotland Project',
    'theme' => 'eerc',
    'url_prefix' => 'eerc',

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
    | ArchivesSpace API Configuration
    |--------------------------------------------------------------------------
    */
    'archivesspace_user' => env('ARCHIVESSPACE_API_USER', 'apiread'),
    'archivesspace_password' => env('ARCHIVESSPACE_API_PASSWORD', 'K1X7QNOrkViWihRo'),
    'archivesspace_url' => env('ARCHIVESSPACE_API_URL', 'https://aspaceapi.collections.ed.ac.uk'),
    'archivesspace_tree' => '/repositories/15/resources/86984/tree',

    /*
    |--------------------------------------------------------------------------
    | Container Configuration
    |--------------------------------------------------------------------------
    */
    'handle_prefix' => '/repositories/15/',
    'container_id' => ['"/repositories/15/resources/86984"'],
    'container_field' => 'resource',
    'excluded_records' => [
        '/repositories/15/archival_objects/190197',
        '/repositories/15/archival_objects/208190',
        '/repositories/15/archival_objects/228537',
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Mappings (ArchivesSpace Schema)
    |--------------------------------------------------------------------------
    */
    'field_mappings' => [
        'Title' => 'title',
        'Interviewer' => 'creators',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Level' => 'level',
        'Resource_Id' => 'resource',
        'Date' => 'create_time',
        'Component Unique Identifier' => 'component_id',
        'Interview summary' => 'notes',
        'JSON' => 'json',
        'Notable persons / organisations' => 'agents',
        'Publish' => 'publish',
        'Language' => 'langmaterial',
        'Biographical history' => 'bioghist',
        'Related' => 'relatedmaterial',
        'Physical' => 'phystech',
        'Access' => 'accessrestrict',
        'Usage Statement' => 'userestrict',
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
        'Audio links and images' => 'digital_object_uris',
        'Processing Information' => 'processinfo',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Configuration
    |--------------------------------------------------------------------------
    */
    'recorddisplay' => [
        'Identifier',
        'Interviewer',
        'Dates',
        'Extent',
        'Extent Type',
        'Notable persons / organisations',
        'Subject',
        'Biographical history',
        'Rights',
        'Interview summary',
        'Related',
        'Bibliography',
        'Physical',
        'Access',
        'Usage Statement',
        'Alternative Format',
        'Audio links and images',
        'Language',
        'Processing Information',
    ],

    'searchresult_display' => [
        'Title',
        'Interviewer',
        'Subject',
        'Notable persons/organisations',
        'Identifier',
        'Interview summary',
    ],

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    */
    'search_fields' => [
        'Title' => 'title',
        'Id' => 'id',
        'Subject' => 'subjects',
        'Notable persons/organisations' => 'agents',
        'Interviewer' => 'creators',
        'Identifier' => 'component_id',
        'Interview summary' => 'scopecontent',
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
        'Resource_Id' => 'resource',
    ],
    'related_number' => 10,

    /*
    |--------------------------------------------------------------------------
    | Meta Fields
    |--------------------------------------------------------------------------
    */
    'meta_fields' => [
        'Title' => 'title',
        'Notable persons/organisations' => 'agents',
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
        'Interviewer' => 'creator',
        'Subject' => 'subjects',
        'Notable persons/organisations' => 'agents',
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
    'ga_code' => env('EERC_GA_CODE', ''),
];
