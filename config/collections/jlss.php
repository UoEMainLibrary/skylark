<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'jlss',
    'fullname' => 'Jewish Lives Scottish Spaces',
    'theme' => 'jlss',
    'url_prefix' => 'jlss',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',
    'image_server' => env('CANTALOUPE_SERVER', 'https://cantaloupe.is.ed.ac.uk'),

    'oaipmhcollection' => '',
    'oaipmhallowed' => true,

    'container_field' => 'location.coll',
    'container_id' => env('JLSS_CONTAINER_ID', '6d02c71d-c4f3-4385-a963-26186e66d78b'),

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Alternative Title' => 'dc.title.alternative.en',
        'Artist' => 'dc.contributor.authorfull.en',
        'Author' => 'dc.contributor.author.en',
        'Classification' => 'dc.subject.classification.en',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'OldDate' => 'dc.coverage.temporal.en',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Description' => 'dc.description.en',
        'Rights' => 'dc.rights.holder.en',
        'Accession Number' => 'dc.identifier.en',
        'Collection' => 'dc.relation.ispartof.en',
        'Provenance' => 'dc.description.provenance',
        'Material' => 'dc.format.en',
        'Dimensions' => 'dc.format.extent.en',
        'Signature' => 'dc.format.signature.en',
        'Inscription' => 'dc.format.inscription.en',
        'Subject' => 'dc.subject.en',
        'Place Made' => 'dc.coverage.spatial.en',
        'Period' => 'dc.coverage.temporalperiod.en',
        'Link' => 'dc.identifier.uri',
        'Tags' => 'dc.subject.crowdsourced.en',
        'ImageUri' => 'dc.identifier.imageUri.en',
        'Permalink' => 'dc.contributor.authorpermalink.en',
        'SketchFabURI' => 'dc.identifier.sketchuri.en',
        'Collection-Description' => 'dc.description.other.en',
        'ItemImage' => 'dc.format.bitstream.en',
        'Date' => 'dc.date.created.en',
        'Id' => 'id',
        'Parent_Id' => 'parent_id',
        'Parent_Type' => 'parent_type',
    ],

    'recorddisplay' => [
        'Permalink',
        'Artist',
        'Title',
        'Alternative Title',
        'OldDate',
        'Period',
        'Description',
        'Material',
        'Dimensions',
        'Type',
        'Place Made',
        'Date',
        'Subject',
        'Collection',
        'Classification',
        'Signature',
        'Inscription',
        'Accession Number',
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
        'Tags' => 'dc.subject.crowdsourced.en',
    ],

    'filters' => [
        'Collection' => 'collection_filter',
    ],

    'sort_fields' => [
        'Subject' => 'dc.subject_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.contributor.author_sort+asc',

    'related_fields' => [
        'Artist' => 'dc.contributor.authorfull.en',
        'Subject' => 'dc.subject.en',
    ],
    'related_number' => 10,

    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Artist' => 'dc.contributor.authorfull.en',
        'Description' => 'dc.description.en',
        'Classification' => 'dc.subject.classification.en',
        'Date' => 'dc.coverage.temporal.en',
        'Type' => 'dc.type.en',
        'Tags' => 'dc.subject.crowdsourced.en',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Artist' => 'Artist',
        'Classification' => 'Classification',
        'Description' => 'Description',
        'Date' => 'Date',
    ],

    'results_per_page' => 10,
    'facet_limit' => 15,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,

    'display_thumbnail' => false,
    'link_bitstream' => false,
    'bitstream_field' => '',
    'thumbnail_field' => '',

    'ga_code' => env('JLSS_GA_CODE', 'G-1JKP69ESME'),
]);
