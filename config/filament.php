<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin panel access (non-local)
    |--------------------------------------------------------------------------
    |
    | Comma-separated list of user emails allowed to use Filament when
    | APP_ENV is not local. Local environments allow any authenticated user.
    |
    */
    'admin_emails' => array_values(array_filter(array_map(
        trim(...),
        explode(',', (string) env('FILAMENT_ADMIN_EMAILS', ''))
    ))),

];
