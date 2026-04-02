<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'coimbra-colls',
    'fullname' => 'Coimbra Collections',
    'theme' => 'coimbra-colls',
    'url_prefix' => 'coimbra-colls',
    'image_server' => 'https://cantaloupe.is.ed.ac.uk',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'container_id' => env('COIMBRA_COLLS_CONTAINER_ID', 'ff66d5b2-78da-4ab7-9f6f-b2d0c17d55ad'),

    'field_mappings' => [
        'ID'                                    => 'dc.identifier.en',
        'Title'                                 => 'dc.title.en',
        'Creator'                               => 'dc.creator.en',
        'Date'                                  => 'dc.coverage.temporal.en',
        'Place of Origin'                       => 'dc.coverage.spatial.en',
        'Institution'                           => 'dc.relation.ispartof.en',
        'Material/Medium'                       => 'dc.format.en',
        'Dimensions'                            => 'dc.format.extent.en',
        'Description'                           => 'dc.description.en',
        'Institutional Link to Object'          => 'dc.identifier.citation.en',
        'Institutional Link to Online Portal'   => 'dc.source.uri.en',
        'Image License'                         => 'dc.license.en',
        'Image Rights Holder'                   => 'dc.rights.holder.en',
        'Photographic Credits'                  => 'dc.contributor.en',
        'Metadata Rights'                       => 'dc.rights.en',
        'Image File Name'                       => 'dc.format.bitstream.en',
        'Logo'                                  => 'dc.format.original.en',
        'Image URL'                             => 'dc.identifier.imageUri',
        'Tags'                                  => 'dc.subject.en',
        'Category'                              => 'dc.relation.ispartofexhibition.en',
        'Logo Thumbnail'                        => 'dc.format.thumbnail.en',
        'Institutional Web URL'                 => 'dc.relation.uri.en',
        'Institutional Map Reference'           => 'cld.hasLocation.coord.en',
        'Additional URLs'                       => 'dc.description.uri.en',
        'University Contact'                    => 'dc.contributor.en',
        'Contact email'                         => 'dc.contributor.otheremail.en',
        'Date of Submission'                    => 'dc.date.submitted.en',
        'Items accumulated (date)'              => 'cld.accumulationDateRange.en',
        'Items created (date)'                  => 'cld.contentsDateRange',
        'Image rights'                          => 'dc.rights.en',
        'Type'                                  => 'cld.type.en',
        'Physical Location'                     => 'cld.hasLocation.en',
        'Featured image'                        => 'dc.title.alternative.en',
    ],

    'recorddisplay' => [
        'Creator',
        'Institution',
        'Type',
        'Place of Origin',
        'Date',
        'Description',
        'Institutional Link to Object',
        'Institutional Link to Online Portal',
        'Tags',
        'Items accumulated (date)',
        'Items created (date)',
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

    'search_fields' => [
        'Title' => 'dc.title',
        'Type' => 'dc.type',
        'Maker' => 'dc.contributor.author',
        'Place Made' => 'dc.coverage.spatial',
        'Accession Number' => 'dc.identifier.en',
    ],

    'filters' => [
        'Category' => 'exhibition_filter',
        'Institution'=> 'collection_filter',
        'Tags' => 'subject_filter',
    ],

    'sort_fields' => [
        'Maker' => 'dc.contributor.author_sort ',
        'Title' => 'dc.title_sort',
    ],
    'default_sort' => 'dc.title_sort+asc',

    'related_fields' => [
        'Institution' => 'dc.relation.ispartof'
    ],
    'related_number' => 20,

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

    'results_per_page' => 80,

    'highlight_fields' => 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en',

    'oaipmhcollection' => 'hdl_10683_53855',

    'ga_code' => env('COIMBRA_COLLS_GA_CODE', ''),
]);
