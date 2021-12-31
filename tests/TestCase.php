<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

// use Route;

use Illuminate\Support\Facades\Route;
use SnoerenDevelopment\AdminUsers\AdminMiddleware;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SnoerenDevelopment\AdminUsers\AdminUsersServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupRoutes();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app The container object.
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            AdminUsersServiceProvider::class,
        ];
    }

    /**
     * Setup the environment.
     *
     * @param  \Illuminate\Foundation\Application $app The container object.
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('admins.admins', ['admin@example.com']);
        $app['config']->set('admins.driver', 'config');
    }

    /**
     * Setup the routes.
     *
     * @return void
     */
    protected function setupRoutes(): void
    {
        Route::get('admin-route', ['middleware' => AdminMiddleware::class, function () {
            return 'admin content';
        }]);
    }
}
