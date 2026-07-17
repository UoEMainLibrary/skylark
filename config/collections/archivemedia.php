<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'archivemedia',
    'fullname' => 'Archives Media',
    'theme' => 'archivemedia',
    'url_prefix' => 'archivemedia',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    // Production DSpace community UUID (matches Skylight archivemedia.php non-development branch).
    'container_id' => env('ARCHIVEMEDIA_CONTAINER_ID', '656322c0-3cfd-453f-8d2b-1aa94bc0b082'),
    // Archives Media scopes by community, not collection (matches legacy CI site).
    'container_field' => 'location.comm',

    'oaipmhcollection' => 'hdl_10683_22154',
    'sitemap_type' => 'external',

    'field_mappings' => [
        'Date' => 'dc.coverage.temporal.en',
        'Description' => 'dc.description.en',
        'Abstract' => 'dc.description.abstract',
        'Format' => 'dc.format.en',
        'Extent' => 'dc.format.extent',
        'Title' => 'dc.title.en',
        'Collection' => 'dc.relation.ispartofpath.en',
        'Section' => 'dc.relation.subpartof.en',
        'Box' => 'dc.relation.boxpartof.en',
        'EQ' => 'dc.format.extenteq.en',
        'Radius' => 'dc.format.extentradius.en',
        'Stylus' => 'dc.format.extentstylus.en',
        'Identifier' => 'dc.identifier.en',
        'Subject' => 'dc.subject.en',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
    ],

    'schema_links' => [
        'Title' => 'name',
        'Author' => 'author',
        'Subject' => 'keywords',
        'Type' => 'about',
        'Date' => 'dateCreated',
        'Identifier' => 'identifier',
        'Collection' => 'Collection',
        'Description' => 'description',
    ],

    'recorddisplay' => [
        'Date',
        'Description',
        'Abstract',
        'Format',
        'Extent',
        'Title',
        'Collection',
        'Section',
        'Box',
        'EQ',
        'Radius',
        'Stylus',
        'Identifier',
        'Subject',
    ],

    'searchresult_display' => [
        'Title',
        'Author',
        'Subject',
        'Type',
    ],

    'search_fields' => [
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
        'Author' => 'dc.contributor.authorza.en',
        'Collection' => 'dc.relation.ispartof.en',
    ],

    'filters' => [
        'Author' => 'authorza_filter',
        'Subject' => 'subject_filter',
        'Collection' => 'collection_filter',
        'Date' => 'datetemporal_filter',
    ],

    'sort_fields' => [
        'Author' => 'dc.contributor.authorza_sort',
        'Title' => 'dc.title_sort',
        'Date' => 'dc.date.issued_dt',
    ],

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.authorza.en',
        'Subject' => 'dc.subject',
        'Date' => 'dc.date.issued',
        'Type' => 'dc.type',
    ],

    'related_fields' => [
        'Type' => 'dc.type.en',
        'Section' => 'dc.relation.subpartof.en',
        'Box' => 'dc.relation.boxpartof.en',
        'Subject' => 'dc.subject.en',
        'Date' => 'dc.coverage.temporal.en',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Subject' => 'Subject',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'results_per_page' => 10,
    'display_thumbnail' => false,
    'link_bitstream' => true,

    'ga_code' => env('ARCHIVEMEDIA_GA_CODE', 'G-L20JS09H7H'),
]);
