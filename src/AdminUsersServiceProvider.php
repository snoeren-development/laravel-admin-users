<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

use InvalidArgumentException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use SnoerenDevelopment\AdminUsers\Drivers\MySQLDriver;
use SnoerenDevelopment\AdminUsers\Drivers\ConfigDriver;

class AdminUsersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admins.php', 'admins');

        // Register the available drivers.
        $this->app->singleton('admins.driver.config', ConfigDriver::class);
        $this->app->singleton('admins.driver.mysql', MySQLDriver::class);

        // Resolve the configured driver lazily so config changes are respected.
        $this->app->bind(Driver::class, function (Application $app): Driver {
            $config = $app->make(Repository::class);
            $driver = $config->get('admins.driver', 'config');
            $driver = is_string($driver) ? $driver : get_debug_type($driver);
            $abstract = 'admins.driver.' . $driver;

            if (!$app->bound($abstract)) {
                throw new InvalidArgumentException(sprintf(
                    'Admin users driver [%s] is not supported.',
                    $driver,
                ));
            }

            $instance = $app->make($abstract);

            if (!$instance instanceof Driver) {
                throw new InvalidArgumentException(sprintf(
                    'Admin users driver [%s] must implement %s.',
                    $driver,
                    Driver::class,
                ));
            }

            return $instance;
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/admins.php' => config_path('admins.php'),
            ], 'config');

            $this->publishesMigrations([
                __DIR__ . '/../database/migrations/add_admin_column_to_users_table.php.stub' =>
                    database_path('migrations/add_admin_column_to_users_table.php'),
            ], 'migrations');
        }

        // Register the gate.
        Gate::define('admin', fn (mixed $user): bool => AdminUsers::check($user));

        // Register the Blade statement.
        Blade::if('admin', fn (): bool => Auth::user()?->can('admin') === true);
    }
}
