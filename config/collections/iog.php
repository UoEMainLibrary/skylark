<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'iog',
    'fullname' => 'Scottish Government Yearbooks',
    'theme' => 'iog',
    'url_prefix' => 'iog',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    // Dev DSpace community UUID is the default so local Skylark works without
    // any env override (matches the Points of Arrival pattern). Production
    // sets IOG_CONTAINER_ID=48aea4e8-2840-47e5-931e-5b1ae117ce78 explicitly.
    'container_id' => env('IOG_CONTAINER_ID', 'e99d9f85-ef2f-4de4-820b-9561cb759fec'),

    'oaipmhcollection' => 'hdl_10683_22746',
    'sitemap_type' => 'external',

    // Solr / UI field names ported from Skylight config/scottishgovernmentyearbooks.ed.ac.uk.php
    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'Date' => 'dc.date.issued',
        'Accession Date' => 'dc.date.accessioned_dt',
        'Number of Pages' => 'dc.coverage.spatial',
        'Citation' => 'dc.identifier.citation.en',
        'ISBN' => 'dc.identifier.isbn',
        'Page Numbers' => 'dc.format.extent',
        'Publisher' => 'dc.publisher.en',
        'Series' => 'dc.relation.ispartofseries.en',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail',
        'Link' => 'dc.identifier.uri.en',
    ],

    'recorddisplay' => [
        'Title',
        'Series',
        'Author',
        'Subject',
        'Citation',
        'Date',
        'Page Numbers',
        'Number of Pages',
        'Publisher',
        'ISBN',
        'Type',
        'Abstract',
    ],

    'searchresult_display' => [
        'Title',
        'Series',
        'Author',
        'Subject',
        'Type',
        'Abstract',
    ],

    'search_fields' => [
        'Keywords' => 'text',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
        'Author' => 'dc.creator',
        'Series' => 'dc.relation.ispartofseries',
    ],

    'filters' => [
        'Author' => 'author_filter',
        'Subject' => 'subject_filter',
    ],

    'date_filters' => [],

    'sort_fields' => [
        'Author' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
        'Date' => 'dc.date.issued_dt',
    ],
    'default_sort' => 'dc.title_sort asc',

    'related_fields' => [
        'Title' => 'dc.title.en',
        'Subject' => 'dc.subject.en',
        'Author' => 'dc.contributor.author.en',
    ],
    'related_number' => 10,

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.creator',
        'Abstract' => 'dc.description.abstract',
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

    'schema_links' => [
        'Title' => 'name',
        'Author' => 'author',
        'Subject' => 'keywords',
        'Type' => 'additionalType',
        'Abstract' => 'description',
        'Date' => 'dateCreated',
        'Citation' => 'citation',
        'ISBN' => 'isbn',
        'Publisher' => 'publisher',
        'Series' => 'isPartOf',
        'Page Numbers' => 'pageStart',
        'Number of Pages' => 'numberOfPages',
        'Thumbnail' => 'thumbnailUrl',
        'Link' => 'url',
    ],

    'bitstream_field' => 'dc.format.original.en',
    'thumbnail_field' => 'dc.format.thumbnail',
    'display_thumbnail' => false,
    'link_bitstream' => true,
    'lightbox' => true,
    'lightbox_mimes' => ['image/jpeg', 'image/gif', 'image/png'],

    'results_per_page' => 10,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,

    'solr_document_field_list' => '*',
    'highlight_fields' => 'dc.title.en,dc.contributor.author.en,dc.subject.en,dc.description.abstract.en,dc.relation.ispartofseries.en',

    'ga_code' => env('IOG_GA_CODE', ''),
]);
