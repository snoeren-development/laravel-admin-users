<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SnoerenDevelopment\AdminUsers\AdminUsersServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
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
}
