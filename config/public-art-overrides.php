<?php

/**
 * Site-wide presentation overrides for the V2 Public Art collection.
 *
 * Loaded automatically by Laravel as config('public-art-overrides.*'). The
 * sibling per-collection file config/collections/public-art.php is loaded
 * separately by App\Http\Middleware\CollectionMiddleware and only contains
 * upstream-data wiring (field mappings, Solr settings, etc.).
 *
 * Per-artwork content (Artist, Dates, Description, Media, etc.) is managed
 * upstream in DSpace and is NOT overridden here. Only site-wide layout
 * decisions live in this file:
 *
 *  - 'labels'        : recorddisplay key -> display label (V2 only).
 *  - 'browse_order'  : artwork titles in date order, newest first. Used to
 *                      reorder the "Browse all artworks" page; titles not
 *                      listed are appended in their upstream order.
 */
return [
    'labels' => [
        'Format' => 'Media',
        'Format Extent' => 'Dimensions',
    ],

    'browse_order' => [
        'Ideas',
        'The Basic Material is Not the Word but the Letter',
        'Canter',
        'The Next Big Thing...is a Series of Little Things',
        'Rhino head',
        'bite / Haynes Nano Stage',
        'Interleaved',
        'The Protégé',
        'The Dreamer',
        'Parthenope',
        'Sprinting Afghan Hound',
        'Egeria',
        'Galapagos',
        'Let my blood be a seed of freedom',
        'Orbis',
        'Kido',
        'Sculptural Relief on Sanderson Building',
        'Sculptural Relief Crew Building',
        'Geology',
        'Ashworth Laboratories Reliefs',
        'Old College War Memorial',
        'Edinburgh College of Art War Memorial',
        'A Torch Racer [Golden Boy]',
        'William Dick',
        'David Brewster',
        'Startled Horse Rising',
    ],
];
