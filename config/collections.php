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
    | Temporarily disabled collections
    |--------------------------------------------------------------------------
    |
    | Comma-separated collection keys in DISABLED_COLLECTIONS (e.g.
    | "bodylanguage" or "bodylanguage,anatomy"). Matching prefixes/hosts
    | return HTTP 503 with a short "temporarily unavailable" page.
    | Routes and config stay in the codebase — flip the env var to re-enable.
    | See docs/collection-migration.md § "Temporarily disable a collection".
    |
    */
    'disabled' => array_values(array_filter(array_map(
        static fn (string $name): string => trim($name),
        explode(',', (string) env('DISABLED_COLLECTIONS', '')),
    ))),

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
        // Routes for the Public Art collection live under /art-on-campus (P004,
        // 2026 client edits) but the per-collection config still ships as
        // config/collections/public-art.php; map the new URL segment back to
        // that config key so middleware keeps loading the right settings.
        'art-on-campus' => 'public-art',
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
    | Set SJAC_HOST for JLSS (e.g. test.sjac.collection.is.ed.ac.uk on staging).
    |
    */
    'domains' => array_filter(
        [
            env('OPENBOOKS_HOST', '') => 'openbooks',
            env('FAIRBAIRN_HOST', '') => 'fairbairn',
            env('SCOTGOVYEARBOOKS_HOST', '') => 'iog',
            env('SJAC_HOST', '') => 'jlss',
            env('POINTSOFARRIVAL_HOST', '') => 'pointsofarrival',
            env('SOPA_HOST', '') => 'physics',
        ],
        fn (string $host): bool => $host !== '',
        ARRAY_FILTER_USE_KEY
    ),
];
