<?php
declare(strict_types = 1);

return [

    /*
    |--------------------------------------------------------------------------
    | Application Administrators
    |--------------------------------------------------------------------------
    |
    | Define your application administrators here using a comma-separated
    | list of email addresses.
    |
    */

    'admins' => (array) explode(',', env('ADMINS')),

];
