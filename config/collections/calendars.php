<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'calendars',
    'fullname' => 'University of Edinburgh Calendars',
    'theme' => 'calendars',
    'url_prefix' => 'calendars',

    'adminemail' => 'HeritageCollections@ed.ac.uk',

    // Production DSpace collection UUID (matches Skylight calendars.php non-development branch).
    'container_id' => env('CALENDARS_CONTAINER_ID', '4e5e82a5-c06c-4844-bc65-c6aef272f646'),
    'container_field' => 'location.coll',

    'oaipmhcollection' => 'hdl_10683_19396',

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Calendar Month' => 'dc.title.alternative.en',
        'Creator' => 'dc.contributor.author.en',
        'Reference' => 'dc.identifier.other',
        'Link' => 'dc.identifier.uri',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Date' => 'dc.coverage.temporal',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Description' => 'dc.description.en',
        'Format' => 'dc.format.en',
        'Year' => 'dc.date.issued',
        'Shelf Mark' => 'dc.identifier.other',
    ],

    'schema_links' => [
        'Title' => 'name',
        'Calendar Month' => 'alternateName',
        'Creator' => 'creator',
        'Link' => 'url',
        'Date' => 'temporalCoverage',
        'Thumbnail' => 'thumbnailUrl',
        'Description' => 'description',
        'Year' => 'alternativeName',
        'Shelf Mark' => 'identifier',
    ],

    'recorddisplay' => [
        'Title',
        'Creator',
        'Date',
        'Format',
        'Subject',
        'Calendar Month',
        'Description',
        'Shelf Mark',
    ],

    'searchresult_display' => [
        'Title',
        'Subject',
        'Type',
        'Origin',
        'Bitstream',
        'Thumbnail',
    ],

    'search_fields' => [
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
        'Creator' => 'dc.contributor.author',
    ],

    // Date filter disabled in legacy Skylight upgrade; keep parity here.
    'filters' => [
        'Subject' => 'subject_filter',
    ],

    'sort_fields' => [
        'Title' => 'dc.title_sort',
        'Subject' => 'dc.subject_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'meta_fields' => [
        'Title' => 'dc.title',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    'related_fields' => [
        'Subject' => 'dc.subject.en',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Subject' => 'Subject',
        'Origin' => 'Origin',
        'Identifier' => 'Identifier',
    ],

    'results_per_page' => 15,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_fullwidth' => false,
    'display_thumbnail' => true,
    'link_bitstream' => true,

    'highlight_fields' => 'dc.title.en,dc.creator,dc.subject.en,dc.description.en',

    'ga_code' => env('CALENDARS_GA_CODE', 'G-L20JS09H7H'),
]);
