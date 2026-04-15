<?php

/*
| For adding collections and migrating from legacy Skylight, see docs/collection-migration.md
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Default Collection
    |--------------------------------------------------------------------------
    |
    | This is the default collection that will be used when no collection
    | prefix is detected in the URL. Typically this is your main collection.
    |
    */
    'default' => env('DEFAULT_COLLECTION', 'clds'),

    /*
    |--------------------------------------------------------------------------
    | Available Collections
    |--------------------------------------------------------------------------
    |
    | List of all available collections. Each collection should have a
    | corresponding configuration file in config/collections/{name}.php
    |
    */
    'available' => [
        'clds',
        'eerc',
        'mimed',
        'art',
        'openbooks',
        'coimbra-colls',
        'guardbook',
        'coimbra',
        'alumni',
        'cockburn',
        'stcecilias',
        'public-art',
        'lhsacasenotes',
        'towardsdolly',
        'speccoll',
        'iconics',
        'archivemedia',
        'geddes',
        'anatomy',
        'calendars',
        'physics',
        'pointsofarrival',
        'bodylanguage',
        'fairbairn',
        'jlss',
        'iog',
    ],

    /*
    |--------------------------------------------------------------------------
    | Collection Detection
    |--------------------------------------------------------------------------
    |
    | How to detect which collection is being accessed:
    | - 'prefix': Use URL prefix (e.g., /eerc/search)
    | - 'subdomain': Use subdomain (e.g., eerc.collections.ed.ac.uk)
    | - 'domain': Use full domain (e.g., eerc.ed.ac.uk)
    |
    */
    'detection' => 'prefix',

    /*
    |--------------------------------------------------------------------------
    | URL Prefixes
    |--------------------------------------------------------------------------
    |
    | Map URL prefixes to collection names when using prefix detection
    |
    */
    'prefixes' => [
        'eerc' => 'eerc',
        'mimed' => 'mimed',
        'art' => 'art',
        'openbooks' => 'openbooks',
        'coimbra-colls' => 'coimbra-colls',
        'guardbook' => 'guardbook',
        'coimbra' => 'coimbra',
        'alumni' => 'alumni',
        'cockburn' => 'cockburn',
        'stcecilias' => 'stcecilias',
        'public-art' => 'public-art',
        'lhsacasenotes' => 'lhsacasenotes',
        'towardsdolly' => 'towardsdolly',
        'speccoll' => 'speccoll',
        'iconics' => 'iconics',
        'archivemedia' => 'archivemedia',
        'geddes' => 'geddes',
        'anatomy' => 'anatomy',
        'calendars' => 'calendars',
        'physics' => 'physics',
        'pointsofarrival' => 'pointsofarrival',
        'bodylanguage' => 'bodylanguage',
        'fairbairn' => 'fairbairn',
        'jlss' => 'jlss',
        'iog' => 'iog',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dedicated hostnames (same routes as the prefixed collection, at URL root)
    |--------------------------------------------------------------------------
    |
    | Map full hostnames to collection keys. Checked before prefix detection.
    | Set OPENBOOKS_HOST locally (e.g. openbooks.skylark.test) and on staging.
    |
    */
    'domains' => array_filter(
        [
            env('OPENBOOKS_HOST', '') => 'openbooks',
            env('FAIRBAIRN_HOST', '') => 'fairbairn',
            env('SCOTGOVYEARBOOKS_HOST', '') => 'iog',
            env('SJAC_HOST', '') => 'jlss',
            env('POINTSOFARRIVAL_HOST', '') => 'pointsofarrival',
        ],
        fn (string $host): bool => $host !== '',
        ARRAY_FILTER_USE_KEY
    ),
];
