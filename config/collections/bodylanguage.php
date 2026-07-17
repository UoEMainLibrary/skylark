<?php

return [
    'appname' => 'bodylanguage',
    'fullname' => 'Body Language',
    'theme' => 'bodylanguage',
    'url_prefix' => 'bodylanguage',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'repository_type' => 'archivesspace',
    'repository_version' => '1',

    // Shared ArchivesSpace endpoints (same as Fairbairn / LHSA / Towards Dolly).
    'solr_core' => 'solr/archivesspace',
    'solr_base' => env('ARCHIVESSPACE_SOLR_URL', 'http://lac-archivesspace-live5.is.ed.ac.uk:8983/'),
    'link_url' => env('ARCHIVESSPACE_LINK_URL', 'https://archivesspace.collections.ed.ac.uk'),

    // ArchivesSpace container scope — legacy config points at four resources
    // in repository 2 (Dunfermline, DCPE Old Students, Scottish Gymnastics,
    // Margaret Morris Movement International).
    'handle_prefix' => '/repositories/2/',
    'container_id' => [
        '"/repositories/2/resources/85725"',
        '"/repositories/2/resources/86677"',
        '"/repositories/2/resources/86712"',
        '"/repositories/2/resources/86737"',
    ],
    'container_field' => 'resource',

    'query_restriction' => ['publish' => 'true'],

    'field_mappings' => [
        'Title' => 'title',
        'Creator' => 'creators',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Level' => 'level',
        'Resource Id' => 'resource',
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

    'search_fields' => [
        'Title' => 'title',
        'Subject' => 'subjects',
        'Agent' => 'agents',
        'Creator' => 'creators',
    ],

    'filters' => [
        'Subject' => 'subjects',
        'Person' => 'agents',
    ],
    'filter_delimiter' => ':',
    'date_filters' => [],

    'sort_fields' => [
        'Title' => 'title_sort',
    ],

    'meta_fields' => [
        'Title' => 'title',
        'Agent' => 'agents',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Level' => 'level',
    ],

    'related_fields' => [
        'Parent' => 'parent',
        'Id' => 'id',
    ],
    'related_number' => 15,

    'feed_fields' => [
        'Title' => 'title',
        'Creator' => 'creator',
        'Subject' => 'subjects',
        'Agent' => 'agents',
    ],

    'results_per_page' => 10,
    'default_sort' => '',
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'display_thumbnail' => false,
    'link_bitstream' => false,
    'bitstream_field' => '',
    'thumbnail_field' => '',

    'lightbox' => true,
    'lightbox_mimes' => ['image/jpeg', 'image/gif', 'image/png'],

    'language_default' => 'en',
    'language_options' => ['en'],

    'oaipmhcollection' => '',
    'oaipmhallowed' => true,

    'cache' => false,
    'sitemap_type' => 'external',

    'ga_code' => env('BODYLANGUAGE_GA_CODE', 'G-L20JS09H7H'),
];
