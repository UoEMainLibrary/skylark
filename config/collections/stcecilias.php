<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'stcecilias',
    'fullname' => "St Cecilia's Hall",
    // Theme name in the legacy is the singular "stcecilia"; assets live at
    // public/collections/stcecilia/ to match.
    'theme' => 'stcecilia',
    'url_prefix' => 'stcecilias',

    'adminemail' => 'HeritageCollections@ed.ac.uk',

    'oaipmhcollection' => 'hdl_10683_14558',
    'oaipmhallowed' => true,

    'container_field' => 'location.coll',
    'container_id' => env('STCECILIAS_CONTAINER_ID', '5f407bc8-1f6c-4ab7-830a-66fac8e07c7f'),

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Alternative Title' => 'dc.title.alternative.en',
        'Maker' => 'dc.contributor.author.en',
        'Author' => 'dc.contributor.author.en',
        'Country' => 'dc.coverage.spatialcountry.en',
        'City' => 'dc.coveragespatialcity.en',
        'Subject' => 'dc.subject.en',
        'Instrument' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'Date' => 'dc.date.created',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail.en',
        'Place Made' => 'dc.coverage.spatial.en',
        'Date Made' => 'dc.coverage.temporal.en',
        'Period' => 'dc.coverage.temporalperiod.en',
        'Accession Number' => 'dc.identifier.en',
        'Technical Description' => 'dc.description.en',
        'Other Information' => 'dc.description.usage.en',
        'Collection' => 'dc.relation.ispartof.en',
        'Notes' => 'dc.description.cataloguernotes',
        'Measurements' => 'dc.format.extent.en',
        'Signature Date' => 'dc.format.signature.en',
        'Inscription' => 'dc.format.inscription.en',
        'Rights Holder' => 'dc.rights.holder.en',
        'Instrument Family' => 'dc.type.family.en',
        'Genus' => 'dc.type.genus.en',
        'Provenance' => 'dc.provenance.en',
        'Decorations' => 'dc.description.decoration.en',
        'Link' => 'dc.identifier.uri.en',
        'Maker Biography' => 'dc.contributor.authorbio.en',
        'Associated Musician Name' => 'dc.contributor.assocfull.en',
        'Associated Musician' => 'dc.contributor.assoc.en',
        'Piccolo Description' => 'dc.description.piccolo.en',
        'Short Description' => 'dc.description.level1.en',
        'Description' => 'dc.description.level2.en',
        'Associated Musician Biography' => 'dc.contributor.assocbio.en',
        'Instrument Type' => 'dc.type.desc.en',
        'Instrument Type History' => 'dc.type.history.en',
        'ImageURI' => 'dc.identifier.imageUri',
        'Rights Statement' => 'dc.rights.en',
        'Case' => 'dc.coverage.spatialcase.en',
        'Gallery' => 'dc.coverage.spatialgallery.en',
        'Maker Name' => 'dc.contributor.authorfull.en',
        'Hornbostel Sachs Classification' => 'dc.subject.classification.en',
        'Grouping' => 'dc.coverage.spatiallogical.en',
        'Specific Type' => 'dc.type.specific.en',
    ],

    'recorddisplay' => [
        'Title',
        'Alternative Title',
        'Instrument',
        'Instrument Family',
        'Maker',
        'Subject',
        'Place Made',
        'Date Made',
        'Measurements (in mm)',
        'Inscription',
        'Author',
        'Country',
        'City',
        'Subject',
        'Abstract',
        'Date',
        'Period',
        'Accession Number',
        'Technical Description',
        'Other Information',
        'Collection',
        'Notes',
        'Signature',
        'Rights Holder',
        'Genus',
        'Provenance',
        'Decorations',
        'Maker Biography',
        'Associated Musician Full',
        'Associated Musician',
        'Piccolo Description',
        'Short Description',
        'Description',
        'Associated Musician Biography',
        'Instrument Type',
        'Instrument Type History',
    ],

    'searchresult_display' => [
        'Title',
        'Instrument',
        'Maker',
        'Subject',
        'Abstract',
        'Bitstream',
        'Thumbnail',
    ],

    'meta_fields' => [
        'Title' => 'dc.title',
        'Alternative Title' => 'dc.title.alternative.en',
        'Maker' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    'search_fields' => [
        'Title' => 'dc.title',
        'Type' => 'dc.type',
        'Maker' => 'dc.contributor.author',
        'Place Made' => 'dc.coverage.spatial',
        'Accession Number' => 'dc.identifier.en',
    ],

    'filters' => [
        'Instrument' => 'type_filter',
        'Maker' => 'author_filter',
        'Place Made' => 'place_filter',
        'Gallery' => 'gallery_filter',
    ],

    'sort_fields' => [
        'Maker' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'related_fields' => [
        'Instrument' => 'dc.type.en',
    ],
    'related_number' => 6,

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Maker' => 'Maker',
        'Subject' => 'Subject',
        'Country' => 'Country',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en',

    'results_per_page' => 20,
    // The legacy site deliberately disables the facet sidebar (the wider
    // browse experience is driven by the home-page instrument-grouping grid
    // instead).
    'show_facets' => false,
    'share_buttons' => false,

    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'homepage_fullwidth' => true,

    'ga_code' => env('STCECILIAS_GA_CODE', 'G-L20JS09H7H'),
]);
