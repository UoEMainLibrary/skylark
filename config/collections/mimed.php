<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Collection Information
    |--------------------------------------------------------------------------
    */
    'appname' => 'mimed',
    'fullname' => 'MUSICAL INSTRUMENT MUSEUMS EDINBURGH',
    'theme' => 'mimed',
    'url_prefix' => 'mimed',

    /*
    |--------------------------------------------------------------------------
    | Contact Information
    |--------------------------------------------------------------------------
    */
    'adminemail' => 'schgals@ed.ac.uk',

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
    'container_id' => env('MIMED_CONTAINER_ID', 'adb5ed4d-6b42-4c8a-a6d1-afc0c08943f9'),
    'container_field' => 'location.coll',

    /*
    |--------------------------------------------------------------------------
    | Field Mappings (DSpace/LIDO Schema)
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Display Configuration
    |--------------------------------------------------------------------------
    */
    'recorddisplay' => [
        'Alternative Title',
        'Instrument',
        'Instrument Family',
        'Maker',
        'Subject',
        'Abstract',
        'Place Made',
        'Date Made',
        'Description',
        'Other Information',
        'Notes',
        'Decorations',
        'Measurements',
        'Provenance',
        'Inscription',
        'Signature',
        'Collection',
        'Rights Holder',
        'Accession Number',
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

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    */
    'search_fields' => [
        'Title' => 'dc.title',
        'Type' => 'dc.type',
        'Maker' => 'dc.contributor.author',
        'Place Made' => 'dc.coverage.spatial',
        'Accession Number' => 'dc.identifier.en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter Configuration
    |--------------------------------------------------------------------------
    */
    'filters' => [
        'Instrument' => 'type_filter',
        'Maker' => 'author_filter',
        'Place Made' => 'place_filter',
        'Period' => 'period_filter',
        'Collection' => 'collection_filter',
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
        'Maker' => 'dc.contributor.author_sort',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort asc',

    /*
    |--------------------------------------------------------------------------
    | Related Items Configuration
    |--------------------------------------------------------------------------
    */
    'related_fields' => [
        'Instrument' => 'dc.type.en',
        'Genus' => 'dc.type.genus.en',
        'Identifier' => 'dc.identifier.en',
    ],
    'related_number' => 10,

    /*
    |--------------------------------------------------------------------------
    | Schema.org Mappings
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | Meta Fields
    |--------------------------------------------------------------------------
    */
    'meta_fields' => [
        'Title' => 'dc.title',
        'Alternative Title' => 'dc.title.alternative.en',
        'Maker' => 'dc.contributor.author.en',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feed Fields
    |--------------------------------------------------------------------------
    */
    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Maker' => 'Maker',
        'Subject' => 'Subject',
        'Country' => 'Country',
        'Description' => 'Abstract',
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
    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en',

    /*
    |--------------------------------------------------------------------------
    | OAI-PMH Configuration
    |--------------------------------------------------------------------------
    */
    'oaipmhcollection' => 'hdl_10683_14558',
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
    | Google Analytics
    |--------------------------------------------------------------------------
    */
    'ga_code' => env('MIMED_GA_CODE', ''),
];
