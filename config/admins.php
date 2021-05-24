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
    | list of email addresses. Also, don't forget to use the "config" driver.
    |
    */

    'admins' => (array) explode(',', env('ADMINS', '')),

    /*
    |--------------------------------------------------------------------------
    | MySQL Driver
    |--------------------------------------------------------------------------
    |
    | cache
    | ---
    | The MySQL driver queries your database on every request when the cache
    | is disabled. As admin users are pretty static and won't change often,
    | you can enter a cache length in seconds below. 0 will disable caching
    | and retrieve admins fresh every request. Default: 60 seconds
    |
    | table
    | ---
    | Specify the name of the table where the MySQL driver will look for
    | emails. Make sure this table contains an "email" and "is_admin" column.
    | Default: users
    |
    */

    'mysql' => [
        'cache' => (int) env('ADMINS_MYSQL_CACHE', 60),
        'table' => env('ADMINS_MYSQL_TABLE', 'users'),
    ],

];
