<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use SnoerenDevelopment\AdminUsers\Drivers\MySQLDriver;
use SnoerenDevelopment\AdminUsers\Drivers\ConfigDriver;

class AdminUsersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/admins.php' => config_path('admins.php'),
            ], 'config');
        }

        if (!class_exists('AddAdminColumnToUsersTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/../database/migrations/add_admin_column_to_users_table.php.stub' =>
                    database_path("migrations/{$timestamp}_add_admin_column_to_users_table.php"),
            ], 'migrations');
        }

        // Register available and the current drivers.
        $this->app->singleton('admins.driver.config', ConfigDriver::class);
        $this->app->singleton('admins.driver.mysql', MySQLDriver::class);

        $this->app->bind(Driver::class, 'admins.driver.' . config('admins.driver'));

        // Register the gate.
        Gate::define('admin', fn ($user): bool => $user->isAdmin());

        // Register the Blade statement.
        Blade::if('admin', fn () => (bool) Auth::user()?->can('admin'));
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admins.php', 'admins');
    }
}
