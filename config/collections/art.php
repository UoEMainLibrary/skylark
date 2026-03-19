<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collection Information
    |--------------------------------------------------------------------------
    */
    'appname' => 'art',
    'fullname' => 'University of Edinburgh Art Collection',
    'theme' => 'art',
    'url_prefix' => 'art',

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'adminemail' => 'HeritageCollections@ed.ac.uk',

    /*
    |--------------------------------------------------------------------------
    | Repository Configuration
    |--------------------------------------------------------------------------
    */
    'repository_type' => 'dspace',

    /*
    |--------------------------------------------------------------------------
    | Container Configuration
    |--------------------------------------------------------------------------
    */
    'handle_prefix' => env('SKYLIGHT_HANDLE_PREFIX', '10683'),
    'container_id' => env('ART_CONTAINER_ID', '75dce59d-3693-4450-b062-4b0e6b158584'),
    'container_field' => 'location.coll',

    /*
    |--------------------------------------------------------------------------
    | Field Mappings
    |--------------------------------------------------------------------------
    */
    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Alternative Title' => 'dc.title.alternative.en',
        'Artist' => 'dc.contributor.authorfull.en',
        'Author' => 'dc.contributor.author.en',
        'Classification' => 'dc.subject.classification.en',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'Date' => 'dc.coverage.temporal.en',
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
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema.org Mappings
    |--------------------------------------------------------------------------
    */
    'schema_links' => [
        'Title' => 'name',
        'Alternative Title' => 'alternativeName',
        'Artist' => 'creator',
        'Author' => 'creator',
        'Classification' => 'keywords',
        'Date' => 'dateCreated',
        'Thumbnail' => 'thumbnailUrl',
        'Description' => 'description',
        'Rights' => 'copyrightHolder',
        'Accession Number' => 'identifier',
        'Collection' => 'isPartOf',
        'Material' => 'material',
        'Signature' => 'creator',
        'Subject' => 'about',
        'Place Made' => 'locationCreated',
        'Period' => 'temporalCoverage',
        'Link' => 'url',
        'ImageUri' => 'image',
        'Tags' => 'keywords',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Configuration
    |--------------------------------------------------------------------------
    */
    'recorddisplay' => [
        'Permalink',
        'Artist',
        'Title',
        'Alternative Title',
        'Date',
        'Period',
        'Description',
        'Material',
        'Dimensions',
        'Type',
        'Place Made',
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

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    */
    'search_fields' => [
        'Artist' => 'dc.contributor.author.en',
        'Title' => 'dc.title.en',
        'Classification' => 'dc.subject.en',
        'Accession Number' => 'dc.identifier.en',
        'Tags' => 'dc.subject.crowdsourced.en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter Configuration
    |--------------------------------------------------------------------------
    */
    'filters' => [
        'Artist' => 'author_filter',
        'Classification' => 'classification_filter',
        'Collection' => 'collection_filter',
        'Period' => 'period_filter',
        'Tags' => 'tags_filter',
    ],
    'filter_delimiter' => ':',
    'date_filters' => [],

    /*
    |--------------------------------------------------------------------------
    | Sort Configuration
    |--------------------------------------------------------------------------
    */
    'sort_fields' => [
        'Relevancy' => 'score',
        'Artist' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.contributor.author_sort+asc',

    /*
    |--------------------------------------------------------------------------
    | Related Items Configuration
    |--------------------------------------------------------------------------
    */
    'related_fields' => [
        'Artist' => 'dc.contributor.authorfull.en',
        'Subject' => 'dc.subject.en',
    ],
    'related_number' => 5,

    /*
    |--------------------------------------------------------------------------
    | Meta Fields
    |--------------------------------------------------------------------------
    */
    'meta_fields' => [
        'Title' => 'dc.title.en',
        'Artist' => 'dc.contributor.authorfull.en',
        'Description' => 'dc.description.en',
        'Classification' => 'dc.subject.classification.en',
        'Date' => 'dc.coverage.temporal.en',
        'Type' => 'dc.type.en',
        'Tags' => 'dc.subject.crowdsourced.en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feed Fields
    |--------------------------------------------------------------------------
    */
    'feed_fields' => [
        'Title' => 'Title',
        'Artist' => 'Artist',
        'Classification' => 'Classification',
        'Description' => 'Description',
        'Date' => 'Date',
    ],

    /*
    |--------------------------------------------------------------------------
    | Display Options
    |--------------------------------------------------------------------------
    */
    'results_per_page' => 10,
    'share_buttons' => false,
    'homepage_recentitems' => false,
    'homepage_randomitems' => false,
    'display_thumbnail' => true,
    'link_bitstream' => true,

    /*
    |--------------------------------------------------------------------------
    | Lightbox Configuration
    |--------------------------------------------------------------------------
    */
    'lightbox' => true,
    'lightbox_mimes' => ['image/jpeg', 'image/gif', 'image/png'],

    /*
    |--------------------------------------------------------------------------
    | Highlight Fields
    |--------------------------------------------------------------------------
    */
    'highlight_fields' => 'dc.title.en,dc.contributor.author.en,dc.subject.en,dc.description.en',

    /*
    |--------------------------------------------------------------------------
    | OAI-PMH Configuration
    |--------------------------------------------------------------------------
    */
    'oaipmhcollection' => 'hdl_10683_6',
    'oaipmhallowed' => true,

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => false,

    /*
    |--------------------------------------------------------------------------
    | Sitemap Configuration
    |--------------------------------------------------------------------------
    */
    'sitemap_type' => 'internal',

    /*
    |--------------------------------------------------------------------------
    | Facet Configuration
    |--------------------------------------------------------------------------
    */
    'facet_limit' => 10,

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    */
    'ga_code' => env('ART_GA_CODE', ''),
];
