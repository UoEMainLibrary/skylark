<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'speccoll',
    'fullname' => 'Special Collections',
    'theme' => 'speccoll',
    'url_prefix' => 'speccoll',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    // Production DSpace collection UUID (matches Skylight speccoll.php non-development branch).
    'container_id' => env('SPECCOLL_CONTAINER_ID', '05a4fd68-f752-4d4e-a4fc-030d2642091c'),
    'container_field' => 'location.coll',

    // IIIF manifest endpoint used by the record viewer / gallery. Live env
    // stays pointed at librarylabs; override per environment if needed.
    'manifest_endpoint' => env('SPECCOLL_MANIFEST_ENDPOINT', 'https://librarylabs.ed.ac.uk/iiif/speccollprototype/manifest/'),

    'oaipmhcollection' => 'hdl_10683_14558',

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Shelfmark' => 'dc.identifier.en',
        'Date' => 'dc.date.created.en',
        'Type' => 'dc.type.en',
        'Collection' => 'dc.relation.ispartof.en',
        'Bitstream' => 'dc.format.original.en',
        'ImageURI' => 'dc.identifier.imageUri.en',
        'Images' => 'dc.format.extent.en',
        'Manifest' => 'dc.identifier.manifest.en',
        'Contributor' => 'dc.contributor.other.en',
        'Notes' => 'dc.description.comments.en',
        'Publisher' => 'dc.publisher.en',
        'Date of publication' => 'dc.date.issued.en',
        'Creator' => 'dc.creator.en',
        'Place of publication' => 'dc.coverage.spatial.en',
        'Full Title' => 'dc.title.alternative.en',
    ],

    'recorddisplay' => [
        'Title',
        'Author',
        'Shelfmark',
        'Date',
        'Collection',
        'Contributor',
        'Notes',
        'Publisher',
        'Date of publication',
        'Creator',
        'Place of Publication',
        'Type',
    ],

    'searchresult_display' => [
        'Title',
        'Author',
        'Shelfmark',
        'Date',
        'Bitstream',
    ],

    'search_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Shelfmark' => 'dc.identifier.en',
        'Date' => 'dc.date.created.en',
    ],

    'filters' => [
        'Author' => 'author_filter',
        'Type' => 'type_filter',
        'Collection' => 'collection_filter',
    ],

    'sort_fields' => [
        'Maker' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Shelfmark' => 'dc.identifier.en',
        'Date' => 'dc.date.created.en',
    ],

    'related_fields' => [
        'Title' => 'dc.title.en',
        'Author' => 'dc.contributor.author.en',
        'Shelfmark' => 'dc.identifier.en',
    ],
    'related_number' => 6,

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Maker' => 'Maker',
        'Shelfmark' => 'Shelfmark',
        'Date' => 'Date',
    ],

    'results_per_page' => 20,
    'show_facets' => false,
    'share_buttons' => false,
    'display_thumbnail' => true,
    'link_bitstream' => true,

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.identifier.en',

    'ga_code' => env('SPECCOLL_GA_CODE', 'G-2S53K9QHRX'),
]);
