# Laravel Admin Users
[![Latest version on Packagist](https://img.shields.io/packagist/v/snoeren-development/laravel-admin-users.svg?style=flat-square)](https://packagist.org/packages/snoeren-development/laravel-admin-users)
[![Software License](https://img.shields.io/github/license/snoeren-development/laravel-admin-users?style=flat-square)](LICENSE)
[![Build status](https://img.shields.io/github/workflow/status/snoeren-development/laravel-admin-users/PHP%20Tests?style=flat-square)](https://github.com/snoeren-development/laravel-admin-users/actions)
[![Downloads](https://img.shields.io/packagist/dt/snoeren-development/laravel-admin-users?style=flat-square)](https://packagist.org/packages/snoeren-development/laravel-admin-users)

This small package adds a configuration and user model trait to define
administrators within your application.

## Installation
Install the package using Composer:
```bash
composer require snoeren-development/laravel-admin-users
```

### Requirements
This package requires at least PHP 7.3 and Laravel 7.

## Usage
Add the `SnoerenDevelopment\AdminUsers\Adminable` trait to your user model and
define administrator users using the `ADMINS=` environment variable. The variable
should contain a comma separated list of email addresses of your application
administrators.

### Using the middleware
This package comes with middleware. This middleware checks if the user is an
administrator. If not, the middleware throws a 401 unauthorised exception.

Add the middleware to your `$routeMiddleware` list in the HTTP kernel to use.
```php
// Kernel.php
'admin' => \SnoerenDevelopment\AdminUsers\AdminMiddleware::class,
```

### Grant administrators all permissions
```php
// AuthServiceProvider.php

use Illuminate\Support\Facades\Gate;

public function boot()
{
    $this->registerPolicies();

    Gate::before(function ($user, $ability) {
        if ($user->isAdmin()) {
            return true;
        }
    });
}
```

### Check for administrators using the Gate
```php
// AuthServiceProvider.php

use Illuminate\Support\Facades\Gate;

public function boot()
{
    $this->registerPolicies();

    Gate::define('admin', function (User $user) {
        if ($user->isAdmin()) {
            return true;
        }
    });
}
```

### Publishing the configuration file
You can publish the configuration file to your project using
`php artisan vendor:publish`. Then select the admin package.

## Testing
```bash
composer test
```

## Credits
- [Michael Snoeren](https://github.com/MSnoeren)
- [All Contributors](https://github.com/snoeren-development/laravel-admin-users/graphs/contributors)

## License
The MIT license. See [LICENSE](LICENSE) for more information.
