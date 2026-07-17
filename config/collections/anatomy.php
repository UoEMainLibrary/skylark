<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'anatomy',
    'fullname' => 'University of Edinburgh Anatomical Collection',
    'theme' => 'anatomy',
    'url_prefix' => 'anatomy',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    // Legacy Skylight config uses the numeric container id `50` rather than
    // a UUID; overrideable per-env for staging/dev.
    'container_id' => env('ANATOMY_CONTAINER_ID', '50'),
    'container_field' => 'location.coll',

    'oaipmhcollection' => 'hdl_10683_117442',

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Description' => 'dc.description.en',
        'Accession Number' => 'dc.identifier.en',
        'Collection' => 'dc.relation.ispartofpath.en',
        'Cataloguer Notes' => 'dc.description.cataloguernotes.en',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
    ],

    'recorddisplay' => [
        'Title',
        'Description',
        'Accession Number',
        'Cataloguer Notes',
        'Collection',
    ],

    'searchresult_display' => [
        'Author',
        'Title',
        'Medium',
        'Type',
        'Description',
        'Bitstream',
        'Thumbnail',
        'Date',
    ],

    'search_fields' => [
        'Artist' => 'dc.contributor.author.en',
        'Title' => 'dc.title.en',
        'Classification' => 'dc.subject.en',
        'Accession Number' => 'dc.identifier.en',
    ],

    'filters' => [
        'Author' => 'author_filter',
    ],

    'sort_fields' => [
        'Artist' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Artist' => 'dc.contributor.authorfull.en',
        'Classification' => 'dc.subject.classification.en',
        'Date' => 'dc.coverage.temporal.en',
        'Type' => 'dc.type.en',
    ],

    'related_fields' => [
        'Artist' => 'dc.contributor.authorfull.en',
        'Subject' => 'dc.subject.en',
    ],
    'related_number' => 5,

    'feed_fields' => [
        'Title' => 'Title',
        'Artist' => 'Artist',
        'Classification' => 'Classification',
        'Description' => 'Description',
        'Date' => 'Date',
    ],

    'results_per_page' => 10,
    'share_buttons' => false,
    'display_thumbnail' => true,
    'link_bitstream' => true,

    'highlight_fields' => 'dc.title.en,dc.contributor.author.en,dc.subject.en,dc.description.en',

    'ga_code' => env('ANATOMY_GA_CODE', 'G-L20JS09H7H'),
]);
