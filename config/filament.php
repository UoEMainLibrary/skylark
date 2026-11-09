<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Full administrator access (non-local)
    |--------------------------------------------------------------------------
    |
    | Comma-separated list of full administrator emails outside local development.
    | St Cecilia’s editors enter through users.cms_role and remain restricted,
    | including locally. Unassigned local users retain development access.
    |
    */
    'admin_emails' => array_values(array_filter(array_map(
        trim(...),
        explode(',', (string) env('FILAMENT_ADMIN_EMAILS', ''))
    ))),

];
