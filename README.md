# Laravel Admin Users

[![Latest version on Packagist](https://img.shields.io/packagist/v/snoeren-development/laravel-admin-users.svg?style=flat-square)](https://packagist.org/packages/snoeren-development/laravel-admin-users)
[![Software License](https://img.shields.io/github/license/snoeren-development/laravel-admin-users?style=flat-square)](LICENSE)
[![Build status](https://img.shields.io/github/actions/workflow/status/snoeren-development/laravel-admin-users/php.yml?branch=main&style=flat-square)](https://github.com/snoeren-development/laravel-admin-users/actions)
[![Downloads](https://img.shields.io/packagist/dt/snoeren-development/laravel-admin-users?style=flat-square)](https://packagist.org/packages/snoeren-development/laravel-admin-users)

This small package adds a configuration and user model trait to define
administrators within your application.

## Installation

Install the package using Composer:

```bash
composer require snoeren-development/laravel-admin-users
```

### Requirements

This package requires at least PHP 8.3 and Laravel 12.

## Usage

Add the `SnoerenDevelopment\AdminUsers\Adminable` trait to your user model and
define administrator users using the `ADMINS=` environment variable. The variable
should contain a comma separated list of email addresses of your application
administrators. Whitespace around the addresses and empty entries are ignored.

```dotenv
ADMINS=admin@example.com,other-admin@example.com
```

Email addresses are compared exactly (case-sensitive). By default the `email`
attribute of the user is used; override `getAdminEmail()` on your model to use a
different attribute.

### Using the middleware

This package comes with middleware. This middleware checks if the user is an
administrator. Guests receive a `401 Unauthorized` response and authenticated
users without admin rights receive a `403 Forbidden` response.

Register a middleware alias in `bootstrap/app.php`:

```php
use SnoerenDevelopment\AdminUsers\AdminMiddleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => AdminMiddleware::class,
    ]);
})
```

Or use the class directly on your routes:

```php
Route::get('/admin', AdminController::class)->middleware(AdminMiddleware::class);
```

### Grant administrators all permissions

```php
// AppServiceProvider.php

use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::before(function ($user, string $ability) {
        if ($user->isAdmin()) {
            return true;
        }
    });
}
```

### Using the gate via Blade

```blade
{{-- Using the gate via the can-statement. --}}
@can('admin')
    The current user is an admin!
@else
    The current user is not an admin!
@endcan

{{-- Using the custom if-statement --}}
@admin
    The current user is an admin!
@else
    The current user is not an admin!
@endadmin
```

### Publishing the configuration file

You can publish the configuration file to your project using:

```bash
php artisan vendor:publish --provider="SnoerenDevelopment\AdminUsers\AdminUsersServiceProvider" --tag=config
```

### Using the MySQL driver

Publish and run the migration or manually add the `is_admin` column to your users
table:

```bash
php artisan vendor:publish --provider="SnoerenDevelopment\AdminUsers\AdminUsersServiceProvider" --tag=migrations
php artisan migrate
```

Set the driver to `mysql` in your `.env` file using `ADMINS_DRIVER=mysql`. Despite
its name, this driver works with any database supported by Laravel. The following
options are available:

| Variable                  | Default  | Description                                           |
|---------------------------|----------|-------------------------------------------------------|
| `ADMINS_MYSQL_CACHE`      | `60`     | Cache duration in seconds. `0` disables caching.      |
| `ADMINS_MYSQL_TABLE`      | `users`  | Table containing the `email` and `is_admin` columns.  |
| `ADMINS_MYSQL_CONNECTION` | default  | Database connection to use.                           |

After changing admin rights you can clear the cached list of administrators:

```php
app(\SnoerenDevelopment\AdminUsers\Drivers\MySQLDriver::class)->flush();
```

## Testing

```bash
composer test
```

## Credits

- [Michael Snoeren](https://github.com/MSnoeren)
- [All Contributors](https://github.com/snoeren-development/laravel-admin-users/graphs/contributors)

## License

The MIT license. See [LICENSE](LICENSE) for more information.
