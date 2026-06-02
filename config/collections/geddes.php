<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'geddes',
    'fullname' => 'Evergreen - Geddes Project',
    'theme' => 'geddes',
    'url_prefix' => 'geddes',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'oaipmhcollection' => 'hdl_10683_103618',
    'oaipmhallowed' => true,
    'sitemap_type' => 'external',

    'container_field' => 'location.coll',
    'container_id' => env('GEDDES_CONTAINER_ID', 'a57dc7be-900f-4677-a5e9-8bd1609337b9'),

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Creator' => 'dc.creator.en',
        'Description' => 'dc.description.en',
        'Extent and Media' => 'dc.format.en',
        'Places' => 'dc.coverage.spatial.en',
        'Identifier' => 'dc.identifier.en',
        'Publisher' => 'dc.publisher.en',
        'Link' => 'dc.identifier.uri.en',
        'Subject' => 'dc.subject.en',
        'Date' => 'dc.coverage.temporal.en',
        'Rights' => 'dc.rights.en',
        'Source' => 'dc.source.en',
        'Parent' => 'dc.relation.ispartof.en',
        'ImageUri' => 'dc.identifier.imageUri.en',
        'Language' => 'dc.language.en',
        'Id' => 'id',
        'Parent_Id' => 'parent_id',
        'Parent_Type' => 'parent_type',
    ],

    'recorddisplay' => [
        'Title',
        'Creator',
        'Description',
        'Identifier',
        'Extent and Media',
        'Places',
        'Publisher',
        'Subject',
        'Date',
        'Rights',
        'Source',
        'Language',
    ],

    'searchresult_display' => [
        'Title',
        'Creator',
        'Subject',
    ],

    'search_fields' => [
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
        'Author' => 'dc.contributor.authorza.en',
        'Collection' => 'dc.relation.ispartof.en',
    ],

    'filters' => [
        'Author' => 'creator_filter',
        'Subject' => 'subject_filter',
        'Place' => 'place_filter',
        'Collection' => 'collection_filter',
        'Date' => 'datetemporal_filter',
    ],

    'sort_fields' => [
        'Title' => 'dc.title_sort',
    ],

    'related_fields' => [
        'Creator' => 'dc.creator.en',
        'Subject' => 'dc.subject.en',
        'Title' => 'dc.title.en',
    ],

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.authorza.en',
        'Subject' => 'dc.subject',
        'Date' => 'dc.date.issued',
        'Type' => 'dc.type',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Subject' => 'Subject',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'results_per_page' => 30,
    'facet_limit' => 5,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'homepage_fullwidth' => true,

    'display_thumbnail' => false,
    'link_bitstream' => true,
    'bitstream_field' => 'dc.format.original.en',
    'thumbnail_field' => 'dc.format.thumbnail',

    'ga_code' => env('GEDDES_GA_CODE', 'G-D2DMYXD2F8'),
]);
