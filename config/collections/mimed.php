<?php

return [
    'appname' => 'mimed',
    'fullname' => 'Musical Instrument Museums Edinburgh',
    'theme' => 'mimed',
    'url_prefix' => 'mimed',

    'adminemail' => 'schgals@ed.ac.uk',

    'repository_type' => 'dspace',
    'repository_version' => '6',

    'solr_core' => '',
    'solr_base' => env('SOLR_URL', 'http://collectionsinternal.is.ed.ac.uk:8080/solr/search/'),

    'handle_prefix' => env('SKYLIGHT_HANDLE_PREFIX', '10683'),
    'container_id' => env('MIMED_CONTAINER_ID', 'adb5ed4d-6b42-4c8a-a6d1-afc0c08943f9'),
    'container_field' => 'location.coll',
    'query_restriction' => [],

    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Alternative Title' => 'dc.title.alternative.en',
        'Maker' => 'dc.contributor.author.en',
        'Author' => 'dc.contributor.author.en',
        'Country' => 'lido.country.en',
        'City' => 'lido.city.en',
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
        'Description' => 'dc.description.en',
        'Other Information' => 'dc.description.usage.en',
        'Collection' => 'dc.relation.ispartof.en',
        'Notes' => 'dc.description.cataloguernotes',
        'Measurements' => 'dc.format.extent.en',
        'Signature' => 'dc.format.signature.en',
        'Inscription' => 'dc.format.inscription.en',
        'Rights Holder' => 'dc.rights.holder.en',
        'Instrument Family' => 'dc.type.family.en',
        'Genus' => 'dc.type.genus.en',
        'Provenance' => 'dc.provenance.en',
        'Decorations' => 'dc.description.decoration.en',
        'Link' => 'dc.identifier.uri',
        'ImageUri' => 'dc.identifier.imageUri.en',
        'Permalink' => 'dc.contributor.authorpermalink',
        'Parent Collection' => 'dc.relation.ispartof.en',
        'Sub Collections' => 'dc.relation.haspart.en',
        'Internal URI' => 'cld.internalURI.en',
        'ASpace URI' => 'cld.externalURI.ArchivesSpace',
        'LUNA URI' => 'cld.externalURI.LUNA',
        'LMS URI' => 'cld.externalURI.LMS',
        'Other URI' => 'cld.externalURI.other',
    ],

    'recorddisplay' => [
        'Alternative Title', 'Instrument', 'Instrument Family', 'Maker', 'Subject',
        'Abstract', 'Place Made', 'Date Made', 'Description', 'Other Information',
        'Notes', 'Decorations', 'Measurements', 'Provenance', 'Inscription',
        'Signature', 'Collection', 'Rights Holder', 'Accession Number',
    ],

    'searchresult_display' => [
        'Title', 'Instrument', 'Maker', 'Subject', 'Abstract', 'Bitstream', 'Thumbnail',
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
        'Period' => 'period_filter',
        'Collection' => 'collection_filter',
    ],
    'filter_delimiter' => ':',
    'date_filters' => [],

    'sort_fields' => [
        'Maker' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'related_fields' => [
        'Instrument' => 'dc.type.en',
        'Genus' => 'dc.type.genus.en',
        'Identifier' => 'dc.identifier.en',
    ],
    'related_number' => 10,

    'meta_fields' => [
        'Title' => 'dc.title',
        'Alternative Title' => 'dc.title.alternative.en',
        'Maker' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Maker' => 'Maker',
        'Subject' => 'Subject',
        'Country' => 'Country',
        'Description' => 'Abstract',
        'Date' => 'Date',
    ],

    'results_per_page' => 10,
    'facet_limit' => 10,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'homepage_fullwidth' => true,
    'search_header' => true,
    'display_thumbnail' => true,
    'link_bitstream' => true,
    'bitstream_field' => '',
    'thumbnail_field' => '',

    'lightbox' => true,
    'lightbox_mimes' => ['image/jpeg', 'image/gif', 'image/png'],

    'language_default' => 'en',
    'language_options' => ['en', 'ko', 'jp'],
    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en',

    'oaipmhcollection' => 'hdl_10683_14558',
    'oaipmhallowed' => true,

    'schema_links' => [
        'Title' => 'name',
        'Alternative Title' => 'alternativeName',
        'Maker' => 'creator',
        'Author' => 'author',
        'Subject' => 'about',
        'Instrument' => 'name',
        'Abstract' => 'description',
        'Date' => 'dateCreated',
        'Thumbnail' => 'thumbnailUrl',
        'Place Made' => 'locationCreated',
        'Date Made' => 'dateCreated',
        'Period' => 'temporalCoverage',
        'Accession Number' => 'identifier',
        'Description' => 'description',
        'Collection' => 'isPartOf',
        'Notes' => 'musicalKey',
        'Rights Holder' => 'copyrightHolder',
        'Instrument Family' => 'category',
        'Link' => 'url',
        'ImageUri' => 'image',
    ],

    'cache' => false,
    'sitemap_type' => 'internal',

    'ga_code' => env('APP_ENV') === 'production' ? 'G-L20JS09H7H' : 'G-8VP4HF0K5M',
];
