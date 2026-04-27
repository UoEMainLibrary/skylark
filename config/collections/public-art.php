<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'public-art',
    'fullname' => 'Public Art',
    'theme' => 'public-art',
    'url_prefix' => 'public-art',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'oaipmhcollection' => 'hdl_10683_53855',
    'oaipmhallowed' => true,

    'container_field' => 'location.coll',
    'container_id' => env('PUBLIC_ART_CONTAINER_ID', '8c47f237-0884-4044-930b-61d574c63c50'),

    'field_mappings' => [
        'ID' => 'id',
        'Collection' => 'collection',
        'Relation' => 'dc.relation',
        'Identifier' => 'dc.identifier',
        'Title' => 'dc.title.en',
        'Creator' => 'dc.creator',
        'Dates' => 'dc.coverage.temporal.en',
        'Country' => 'dc.coverage.spatialcountry.en',
        'City' => 'dc.coverage.spatialcity.en',
        'Format' => 'dc.format',
        'Format Extent' => 'dc.format.extent',
        'Description' => 'dc.description.en',
        'Identifier Citation' => 'dc.identifier.citation',
        'Source URI' => 'dc.source.uri',
        'License' => 'dc.license',
        'Rights Holder' => 'dc.rights.holder',
        'Artist' => 'dc.contributor.authorfull.en',
        'Author' => 'dc.contributor.author.en',
        'Rights' => 'dc.rights',
        'Original' => 'dim.original',
        'Identifier URI' => 'dc.identifier.uri',
        'Subject' => 'dc.subject',
        'Spatial Coverage' => 'dc.coverage.spatial.en',
        'Image Name' => 'dc.format.original',
        'Image URI' => 'dc.identifier.imageUri',
        'ImageUri' => 'dc.identifier.imageUri',
        'Artist Biography' => 'dc.contributor.authorbio.en',
        'Map Reference' => 'dc.coverage.spatialcoord.en',
        'Location' => 'dc.coverage.spatialloc.en',
        'Alt Image' => 'dc.image.primary.en',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
    ],

    'recorddisplay' => [
        'Title',
        'Artist',
        'Creator',
        'Dates',
        'City',
        'Country',
        'Format',
        'Format Extent',
        'Description',
        'Subject',
        'Artist Biography',
    ],

    'searchresult_display' => [
        'Title',
        'Instrument',
        'Artist',
        'Subject',
        'Abstract',
        'Bitstream',
        'Thumbnail',
    ],

    'search_fields' => [
        'Title' => 'dc.title',
        'Type' => 'dc.type',
        'Artist' => 'dc.contributor.author',
        'Place Made' => 'dc.coverage.spatial',
        'Accession Number' => 'dc.identifier.en',
    ],

    'filters' => [
        'Title' => 'title_filter',
    ],

    'sort_fields' => [
        'Artist' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'related_fields' => [
        'Instrument' => 'dc.type.en',
        'Genus' => 'dc.type.genus.en',
    ],
    'related_number' => 30,

    'meta_fields' => [
        'Title' => 'dc.title',
        'Alternative Title' => 'dc.title.alternative.en',
        'Artist' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Artist' => 'Maker',
        'Subject' => 'Subject',
        'Country' => 'Country',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'results_per_page' => 30,
    'show_facets' => true,
    'share_buttons' => false,
    'cache' => false,

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en',

    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'homepage_fullwidth' => true,

    'ga_code' => env('PUBLIC_ART_GA_CODE', 'G-L20JS09H7H'),
]);
