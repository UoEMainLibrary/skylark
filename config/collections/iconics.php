<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'iconics',
    'fullname' => 'Library and University Collections - Iconics',
    'theme' => 'iconics',
    'url_prefix' => 'iconics',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    // Production DSpace collection UUID (matches Skylight iconics.php non-development branch).
    'container_id' => env('ICONICS_CONTAINER_ID', '5fe7777e-d6df-47fb-be57-5fa5db719bef'),
    'container_field' => 'location.coll',

    'oaipmhcollection' => 'hdl_10683_117182',

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject.en',
        'Tags' => 'dc.subject.crowdsourced.en',
        'Link' => 'dc.identifier.uri',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'Date' => 'dc.coverage.temporal.en',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Description' => 'dc.description.en',
        'Identifier' => 'dc.identifier.other.en',
        'Shelfmark' => 'dc.identifier.en',
    ],

    'schema_links' => [
        'Title' => 'name',
        'Author' => 'creator',
        'Subject' => 'about',
        'Tags' => 'keywords',
        'Link' => 'url',
        'Abstract' => 'description',
        'Date' => 'dateCreated',
        'Thumbnail' => 'thumbnail',
        'Description' => 'description',
        'Identifier' => 'identifier',
        'Shelfmark' => 'identifier',
    ],

    'recorddisplay' => [
        'Author',
        'Date',
        'Type',
        'Subject',
        'Shelfmark',
        'Identifier',
    ],

    'searchresult_display' => [
        'Title',
        'Author',
        'Subject',
        'Type',
        'Abstract',
    ],

    'search_fields' => [
        'Keywords' => 'text',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Author' => 'dc.contributor.author',
        'Tags' => 'dc.subject.crowdsourced.en',
    ],

    'filters' => [
        'Subject' => 'subject_filter',
        'Type' => 'type_filter',
        'Tags' => 'tags_filter',
    ],

    'sort_fields' => [
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Abstract' => 'dc.description.abstract.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Bitstream' => 'dc.format.original',
        'Thumbnail' => 'dc.format.thumbnail',
    ],

    'related_fields' => [
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
    ],
    'related_number' => 5,

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Subject' => 'Subject',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'results_per_page' => 20,
    'facet_limit' => 30,

    'homepage_recentitems' => false,
    'homepage_randomitems' => true,
    'homepage_fullwidth' => true,
    'search_header' => false,

    'display_thumbnail' => true,
    'link_bitstream' => true,

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,dc.description.en',

    'ga_code' => env('ICONICS_GA_CODE', 'G-L20JS09H7H'),
]);
