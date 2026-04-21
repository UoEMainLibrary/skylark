<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'cockburn',
    'fullname' => 'Cockburn Collection',
    'theme' => 'cockburn',
    'url_prefix' => 'cockburn',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'container_id' => env('ART_CONTAINER_ID', 'dbf9e7d0-e031-4ed1-bfe5-30d5b450903f'),

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'Measurements' => 'dc.format.extent.en',
        'Description' => 'dc.description.en',
        'Labels' => 'dc.description.inscription.en',
        'Other context' => 'dc.description.level1.en',
        'Related document' => 'dc.relation.relateddocument.en',
        //trying to recreate mimed's treatment of place
        'Place' => 'dc.coverage.spatial.en',
        'Place Certainty' => 'dc.coverage.spatialrole.en',
        'Date' => 'dc.date.issued',
        'Accession Number' => 'dc.identifier.en',
        'Accession Date' => 'dc.date.accessioned_dt',
        'Bitstream'=> 'dc.format.original.en',
        'Thumbnail'=> 'dc.format.thumbnail.en',
        'ImageUri' => 'dc.identifier.imageUri.en',
        'ArchivesSpace Number' => 'dc.identifier.archive',
    ],

    'recorddisplay' => [
        'Title',
        'Author',
        'Subject',
        'Type',
        'Place', 
        'Place Certainty',
        'Measurements',
        'Labels',
        'Description',
        'Other context',
        'Related document',
        'Accession Number',
    ],

    'searchresult_display' => [
        'Title',
        'Author',
        'Subject',
        'Type',
        'Abstract',
    ],

    'search_fields' => [
        'Title' => 'dc.title.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
        //mimed place copying
        'Place' => 'dc.coverage.spatial',
        'Author' => 'dc.contributor.author',
        'Accession Number' => 'dc.identifier.en',
    ],

    'filters' => [
        'Author' => 'author_filter',
        'Type' => 'type_filter', 
        'Place' => 'place_filter', 
        'Date' => 'date_filter',
    ],

    'sort_fields' => [
        'Title' => 'title_sort',
    ],
    'default_sort' => 'dc.contributor.author_sort+asc',

    'related_fields' => [
        'Artist' => 'dc.contributor.authorfull.en', 
        'Subject' => 'dc.subject.en', 
        'Type' => 'dc.type.en',
    ],
    'related_number' => 5,

    'meta_fields' => [
        'Title' => 'dc.title',
        'Author' => 'dc.contributor.author',
        'Description' => 'dc.description.en',
        'Subject' => 'dc.subject.en',
        'Date' => 'dc.date.issued',
        'Type' => 'dc.type.en',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Subject' => 'Subject',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'results_per_page' => 10,

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,dc.description.en,dc.relation.ispartof.en',

    'oaipmhcollection' => 'hdl_10683_19104',

    'ga_code' => env('COCKBURN_GA_CODE', 'G-9JWTY9TLXS'),
]);
