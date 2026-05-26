<?php

return [
    'appname' => 'towardsdolly',
    'fullname' => 'Towards Dolly',
    'theme' => 'towardsdolly',
    'url_prefix' => 'towardsdolly',
    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'repository_type' => 'archivesspace',
    'repository_version' => '1',

    'solr_core' => 'solr/archivesspace',
    'solr_base' => env('ARCHIVESSPACE_SOLR_URL', 'http://lac-archivesspace-live5.is.ed.ac.uk:8983/'),
    'link_url' => env('ARCHIVESSPACE_LINK_URL', 'https://archivesspace.collections.ed.ac.uk'),

    'archivesspace_user' => env('ARCHIVESSPACE_API_USER', 'apiread'),
    'archivesspace_password' => env('ARCHIVESSPACE_API_PASSWORD', 'K1X7QNOrkViWihRo'),
    'archivesspace_url' => env('ARCHIVESSPACE_API_URL', 'https://aspaceapi.collections.ed.ac.uk'),
    'archivesspace_tree' => '/repositories/2/resources/85710/tree',

    'handle_prefix' => '/repositories/2/',
    'container_id' => [
        '"/repositories/2/resources/40"',
        '"/repositories/2/resources/83825"',
        '"/repositories/2/resources/84761"',
        '"/repositories/2/resources/85246"',
        '"/repositories/2/resources/85257"',
        '"/repositories/2/resources/85258"',
        '"/repositories/2/resources/85271"',
        '"/repositories/2/resources/85710"',
        '"/repositories/2/resources/85711"',
        '"/repositories/2/resources/85712"',
        '"/repositories/2/resources/85713"',
        '"/repositories/2/resources/85754"',
        '"/repositories/2/resources/85760"',
        '"/repositories/2/resources/85804"',
        '"/repositories/2/resources/85824"',
        '"/repositories/2/resources/85826"',
        '"/repositories/2/resources/85829"',
        '"/repositories/2/resources/85835"',
        '"/repositories/2/resources/85862"',
    ],
    'container_field' => 'resource',
    'query_restriction' => ['publish' => 'true'],

    'field_mappings' => [
        'Title' => 'title',
        'Creator' => 'creators',
        'Subject' => 'subjects',
        'Agent' => 'agents',
        'Type' => 'primary_type',
        'Level' => 'level',
        'Dates' => 'dates',
        'Extent' => 'extents',
        'Identifier' => 'component_id',
        'Parent' => 'parent',
        'Parent_Id' => 'parent_id',
        'Parent_Type' => 'parent_type',
        'Bibliography' => 'note_bibliography',
        'Id' => 'id',
        'Scope and Contents' => 'scopecontent',
        'Physical Description' => 'physdesc',
        'JSON' => 'json',
    ],

    'recorddisplay' => [
        'Identifier',
        'Creator',
        'Dates',
        'Extent',
        'Agent',
        'Subject',
        'Scope and Contents',
        'Bibliography',
        'Physical Description',
    ],

    'searchresult_display' => [
        'Title',
        'Creator',
        'Subject',
        'Agent',
        'Identifier',
    ],

    'search_fields' => [
        'Title' => 'title',
        'Subject' => 'subjects',
        'Person' => 'agents',
        'Creator' => 'creators',
    ],

    'filters' => [
        'Subject' => 'subjects',
        'Person' => 'agents',
        'Agent' => 'agents',
    ],
    'filter_delimiter' => ':',
    'date_filters' => [],

    'sort_fields' => [
        'Title' => 'title_sort',
    ],

    'related_fields' => [
        'Parent' => 'parent',
        'Id' => 'id',
    ],
    'related_number' => 10,

    'meta_fields' => [
        'Title' => 'title',
        'Agent' => 'agents',
        'Subject' => 'subjects',
        'Type' => 'primary_type',
        'Level' => 'level',
    ],

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

    'ga_code' => env('TOWARDSDOLLY_GA_CODE', 'G-3DSGX7YDRF'),
];
