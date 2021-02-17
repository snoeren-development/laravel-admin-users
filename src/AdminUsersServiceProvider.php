<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

use Illuminate\Support\ServiceProvider;

class AdminUsersServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/admins.php' => config_path('admins.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admins.php', 'admins');
    }
}
