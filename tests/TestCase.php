<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use Route;
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
     * @return array
     */
    protected function getPackageProviders($app)
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
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('admins.admins', ['admin@example.com']);
    }

    /**
     * Setup the routes.
     *
     * @return void
     */
    protected function setupRoutes()
    {
        Route::get('admin-route', ['middleware' => AdminMiddleware::class, function () {
            return 'admin content';
        }]);
    }
}
