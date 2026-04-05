<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'guardbook',
    'fullname' => 'Guardbook',
    'theme' => 'guardbook',
    'url_prefix' => 'guardbook',

    'adminemail' => 'HeritageCollections@ed.ac.uk',

    'container_id' => env('GUARDBOOK_CONTAINER_ID', '7525d19f-cde5-4987-95d1-004c2a940aa6'),

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Subject' => 'dc.subject.en',
        'Shelfmark' => 'dc.identifier.en',
        'Bitstream' => 'dc.format.original.en',
        'Link' => 'dc.identifier.uri.en',
    ],

    'schema_links' => [
      'Title'=>'name',
      'Subject'=>'about',
      'Shelfmark'=>'identifier',
      'Link'=>'url',
    ],

    'recorddisplay' => [
        'Title',
        'Subject',
        'Shelfmark',
    ],

    'searchresult_display' => [
        'Title',
        'Subject',
        'Shelfmark',
    ],

    'search_fields' => [
        'Subject' => 'dc.subject',
    ],

    'filters' => [
        'A-Z' => 'subject_filter',
    ],

    'sort_fields' => [
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'related_fields' => [
        'Subject' => 'dc.subject.en',
    ],
    'related_number' => 5,

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Subject' => 'dc.subject',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Subject' => 'Subject',
    ],

    'results_per_page' => 10,

    'oaipmhcollection' => 'hdl_10683_52783',

    'ga_code' => env('GUARDBOOK_GA_CODE', 'G-WVFLQ94VQP'),

    'facet_limit' => 26,

    'filter_sort' => true,
]);
