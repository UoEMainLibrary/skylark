<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'openbooks',
    'fullname' => 'Open Books',
    'theme' => 'openbooks',
    'url_prefix' => 'openbooks',

    'adminemail' => 'HeritageCollections@ed.ac.uk',

    // Production DSpace community UUID (matches Skylight openbooks.is.ed.ac.uk.php non-development branch).
    'container_id' => env('OPENBOOKS_CONTAINER_ID', 'ca96f537-4877-4ddb-8d17-63b65433b9d3'),

    // Solr / UI field names aligned with Skylight config/openbooks(.is.ed.ac.uk).php
    'field_mappings' => [
        'Title' => 'dc.title.en',
        'Alternative Title' => 'dc.title.alternative.en',
        'Author' => 'dc.contributor.authorza.en',
        'Pamphlet Author' => 'dc.creator.en',
        'Subject' => 'dc.subject.en',
        'Doc Author' => 'dc.contributor.author.en',
        'Type' => 'dc.type.en',
        'Abstract' => 'dc.description.abstract.en',
        'Number of Pages' => 'dc.extent.noOfPages.en',
        'Page Numbers' => 'dc.extent.pageNumbers.en',
        'Date Scanned' => 'dc.date.created',
        'Document Date' => 'dc.coverage.temporal',
        'Shelfmark' => 'dc.identifier.en',
        'Pamphlet No' => 'dc.identifier.other.en',
        'Pamphlet Title' => 'dc.title.alternative.en',
        'Date' => 'dc.date.created',
        'Bitstream' => 'dc.format.original.en',
        'Thumbnail' => 'dc.format.thumbnail',
        'Description' => 'dc.description.en',
        'Collection' => 'dc.relation.ispartof.en',
        'Identifier' => 'dc.identifier.en',
        'Rights' => 'dc.rights.en',
        'Place' => 'dc.coverage.spatial.en',
        'Link' => 'dc.identifier.uri.en',
        'ImageUri' => 'dc.identifier.imageUri.en',
        'Accession Number' => 'dc.identifier.en',
    ],

    'recorddisplay' => [
        'Title',
        'Alternative Title',
        'Author',
        'Pamphlet Author',
        'Subject',
        'Type',
        'Number of Pages',
        'Page Numbers',
        'Date Scanned',
        'Document Date',
        'Shelfmark',
        'Pamphlet No',
        'Pamphlet Title',
        'Collection',
        'Description',
        'Abstract',
    ],

    'searchresult_display' => [
        'Author',
        'Title',
        'Type',
        'Subject',
        'Bitstream',
        'Document Date',
        'Shelfmark',
    ],

    'search_fields' => [
        'Title' => 'dc.title',
        'Author' => 'dc.contributor.authorza.en',
        'Subject' => 'dc.subject',
        'Type' => 'dc.type',
        'Collection' => 'dc.relation.ispartof.en',
    ],

    // Sidebar/browse facets only — matches Skylight openbooks.php (no Type facet there).
    'filters' => [
        'Author' => 'authorza_filter',
        'Subject' => 'subject_filter',
        'Collection' => 'collection_filter',
        'Date' => 'datetemporal_filter',
    ],

    'date_filters' => [],

    'sort_fields' => [
        'Relevancy' => 'score',
        'Title' => 'dc.title_sort',
        'Author' => 'dc.contributor.authorza_sort',
        'Date' => 'dc.date.issued_dt',
    ],
    'default_sort' => 'dc.title_sort asc',

    'related_fields' => [
        'Author' => 'dc.contributor.authorza.en',
        'Subject' => 'dc.subject.en',
        'Type' => 'dc.type.en',
    ],
    'related_number' => 10,

    'schema_links' => [
        'Title' => 'name',
        'Alternative Title' => 'alternativeName',
        'Author' => 'author',
        'Pamphlet Author' => 'author',
        'Subject' => 'keywords',
        'Doc Author' => 'contributor',
        'Type' => 'additionalType',
        'Number of Pages' => 'numberOfPages',
        'Date Scanned' => 'dateModified',
        'Document Date' => 'dateCreated',
        'Shelfmark' => 'identifier',
        'Pamphlet Title' => 'alternateName',
        'Abstract' => 'description',
        'Date' => 'dateCreated',
        'Thumbnail' => 'thumbnailUrl',
        'Description' => 'description',
        'Collection' => 'isPartOf',
        'Link' => 'url',
        'ImageUri' => 'image',
    ],

    'meta_fields' => [
        'Title' => 'dc.title',
        'Author' => 'dc.contributor.authorza.en',
        'Subject' => 'dc.subject',
        'Date' => 'dc.date.issued',
        'Type' => 'dc.type',
    ],

    'feed_fields' => [
        'Title' => 'Title',
        'Author' => 'Author',
        'Subject' => 'Subject',
        'Type' => 'Type',
        'Date' => 'Date',
    ],

    'results_per_page' => 10,

    // Return all stored fields so search hits include authorza, bitstreams, shelfmark, etc. (Skylight parity).
    'solr_document_field_list' => '*',

    'highlight_fields' => 'dc.title.en,dc.contributor.authorza.en,dc.contributor.author.en,dc.subject.en,dc.description.en,dc.relation.ispartof.en',

    'oaipmhcollection' => '',

    'ga_code' => env('OPENBOOKS_GA_CODE', ''),
]);
