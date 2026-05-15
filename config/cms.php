<?php

/*
|--------------------------------------------------------------------------
| CMS configuration
|--------------------------------------------------------------------------
|
| Single source of truth for which public pages are CMS-managed. The page
| Blade templates and the Filament resources both read this registry, so
| adding a page is a one-line change here plus a composer registration in
| AppServiceProvider plus the @if(...)-wrapped editable region in the
| Blade.
|
| - `enabled`: global on/off switch. When false, every managed page renders
|   its existing static HTML fallback. When true, pages render the CMS
|   `body` (and any image fields) from cms_pages instead. Pages flagged
|   `always_cms => true` ignore the toggle (their static fallback has
|   already been removed from the Blade — currently only the RESP V2 home).
|
| - `images`: how many image upload fields the Filament form exposes for
|   this page. Per-page Blade is responsible for actually rendering them.
|
*/

return [

    'enabled' => env('CMS_ENABLED', false),

    'pages' => [

        'eerc' => [
            'home' => [
                'title' => 'Home',
                'images' => 0,
                'always_cms' => true,
            ],
            'about' => [
                'title' => 'About',
                'images' => 0,
            ],
            'resp' => [
                'title' => 'About the Project',
                'images' => 1,
            ],
            'project-history' => [
                'title' => 'Project History (also rendered at /eerc/people)',
                'images' => 1,
            ],
            'overview' => [
                'title' => 'Browse the Collections (intro paragraph)',
                'images' => 0,
            ],
            'contact' => [
                'title' => 'Contact (intro paragraph)',
                'images' => 0,
            ],
            'accessibility' => [
                'title' => 'Accessibility',
                'images' => 0,
            ],
            'bsl' => [
                'title' => 'British Sign Language (BSL)',
                'images' => 0,
            ],
        ],

        'public-art' => [
            'artcollection' => [
                'title' => 'University Art Collection',
                'images' => 0,
            ],
            'licensing' => [
                'title' => 'Licensing & Copyright',
                'images' => 0,
            ],
            'takedown' => [
                'title' => 'Takedown Policy',
                'images' => 0,
            ],
            'accessibility' => [
                'title' => 'Accessibility',
                'images' => 0,
            ],
            'feedback' => [
                'title' => 'Contact (Feedback)',
                'images' => 0,
            ],
        ],

    ],

];
