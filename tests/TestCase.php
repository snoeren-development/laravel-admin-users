<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use Illuminate\Support\Facades\Route;
use SnoerenDevelopment\AdminUsers\AdminMiddleware;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SnoerenDevelopment\AdminUsers\AdminUsersServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /** Setup the test environment. */
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
     * Define the environment.
     *
     * @param  \Illuminate\Foundation\Application $app The container object.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('admins.admins', ['admin@example.com']);
        $app['config']->set('admins.driver', 'config');
    }

    /** Setup the routes. */
    protected function setupRoutes(): void
    {
        Route::get('admin-route', fn (): string => 'admin content')
            ->middleware(AdminMiddleware::class);
    }
}
