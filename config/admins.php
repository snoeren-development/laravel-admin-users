<?php
declare(strict_types = 1);

return [

    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | Define the driver to check administrator status against. The driver
    | is either "config" or "mysql".
    |
    */

    'driver' => env('ADMINS_DRIVER', 'config'),

    /*
    |--------------------------------------------------------------------------
    | Application administrators.
    |--------------------------------------------------------------------------
    |
    | Define your application administrators here using a comma-separated
    | list of email addresses. The use this list of administrators, the config
    | driver should be used.
    |
    */

    'admins' => (array) explode(',', env('ADMINS', '')),

];
