<?php

$dspaceDefaults = require __DIR__.'/defaults/dspace.php';

return array_merge($dspaceDefaults, [
    'appname' => 'coimbra',
    'fullname' => 'Coimbra Virtual Exhibition',
    'theme' => 'coimbra',
    'url_prefix' => 'coimbra',
    'image_server' => 'https://cantaloupe.is.ed.ac.uk',

    'adminemail' => 'lddt@mlist.is.ed.ac.uk',

    'container_id' => env('COIMBRA_COLLS_CONTAINER_ID', '3cc3272b-0e39-4b95-8408-ad8f09de47d3'),

    'field_mappings' => [
        'ID'                                    => 'dc.identifier.en',
        'Title'                                 => 'dc.title.en',
        'Creator'                               => 'dc.creator.en',
        'Date'                                  => 'dc.coverage.temporal.en',
        'Place of Origin'                       => 'dc.coverage.spatialcountry.en',
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
        'Institutional Map Reference'           => 'dc.coverage.spatial.en',
        'Additional URLs'                       => 'dc.description.uri.en',
        'University Contact'                    => 'dc.contributor.en',
        //'Contact email'                         => 'dc.contributor.otheremail.en',
        'Date of Submission'                    => 'dc.date.submitted.en',
    ],

    'recorddisplay' => [
        'Creator',
        'Institution',
        'Place of Origin',
        'Date',
        'Description',
        'Tags',
    ],

    'descriptiondisplay' => [
        'Dimensions',
        'Material/Medium',
        'Category',
        'Institutional Link to Object',
        'Institutional Link to Online Portal',
        'Image License',
        'Image Rights Holder',
        'Photographic Credits',
        'Metadata Rights',
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
        'Institution' => 'dc.relation.ispartof',
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

    'ga_code' => env('COIMBRA_COLLS_GA_CODE', 'G-7V53PR5CW5'),
]);
