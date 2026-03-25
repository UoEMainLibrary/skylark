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
    ],
];
