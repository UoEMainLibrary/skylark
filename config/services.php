<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'solr' => [
        'endpoint' => [
            'default' => [
                'host' => env('SOLR_HOST', 'localhost'),
                'port' => env('SOLR_PORT', 8080),
                'path' => env('SOLR_PATH', '/'),
                'collection' => env('SOLR_COLLECTION', 'solr/search'),
                'timeout' => 30,
            ],
        ],
        'container_id' => env('SOLR_CONTAINER_ID', '1'),
        'container_field' => env('SOLR_CONTAINER_FIELD', 'location.comm'),
        'results_per_page' => env('SOLR_RESULTS_PER_PAGE', 10),
    ],

    'google_analytics' => [
        'tracking_id' => env('GA_TRACKING_ID'),
    ],

];
