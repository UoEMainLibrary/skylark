<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'physics',
    'fullname' => 'School of Physics and Astronomy Image Archive',
    'theme' => 'physics',
    'url_prefix' => 'physics',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'container_id' => env('PHYSICS_CONTAINER_ID', 'df0d9c26-2b73-4cce-8ed7-d047b1a0884e'),

    'oaipmhcollection' => 'hdl_10683_8',

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.creator.en',
        'Department' => 'dc.creator.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Description' => 'dc.description.en',
        'Date' => 'dc.date.issued',
        'Accession Date' => 'dc.date.accessioned_dt',
    ],

    'recorddisplay' => [
        'Title',
        'Department',
        'Date',
        'Subject',
        'Type',
        'Description',
    ],

    'searchresult_display' => [
        'Title',
        'Author',
        'Subject',
        'Type',
        'Abstract',
        'File',
        'Thumbnail',
    ],

    'search_fields' => [
        'Title' => 'dc.title.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Author' => 'dc.creator.en',
    ],

    // Legacy notes the date filter is broken since the Skylight upgrade — keep
    // it disabled to match the live site.
    'filters' => [
        'Department' => 'creator_filter',
        'Subject' => 'subject_filter',
    ],

    'sort_fields' => [
        'Title' => 'dc.title_sort',
        'Date' => 'dc.date.issued_dt',
        'Department' => 'dc.creator_sort',
    ],

    'meta_fields' => [
        'Title' => 'dc.title',
        'Author' => 'dc.creator',
        'Subject' => 'dc.subject',
        'Date' => 'dc.date.issued_dt',
        'Type' => 'dc.type',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Subject' => 'Subject',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    // Live SOPA renders only Date in the related-items tags; matching cockburn's
    // related shape keeps the sidebar useful without diverging from Skylight.
    'related_fields' => [
        'Author' => 'dc.creator.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
    ],
    'related_number' => 5,

    'results_per_page' => 10,
    'share_buttons' => false,

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,dc.description.en,dc.relation.ispartof.en',

    'ga_code' => env('PHYSICS_GA_CODE', 'G-9FSG51QXZL'),
]);
