<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use SnoerenDevelopment\AdminUsers\Drivers\MySQLDriver;

class MySQLDriverTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('email');
        });

        (require __DIR__ . '/../database/migrations/add_admin_column_to_users_table.php.stub')->up();

        DB::table('users')->insert([
            ['email' => 'admin@example.com', 'is_admin' => true],
            ['email' => 'user@example.com', 'is_admin' => false],
        ]);

        config([
            'admins.driver' => 'mysql',
            'admins.admins' => [],
        ]);
    }

    /** Define the environment. */
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);

        $app['config']->set('database.default', 'testing');
        $app['config']->set('cache.default', 'array');
    }

    /** Test if admins are read from the database. */
    public function testIsAdmin(): void
    {
        $this->assertTrue((new User(['email' => 'admin@example.com']))->isAdmin());
        $this->assertFalse((new User(['email' => 'user@example.com']))->isAdmin());
        $this->assertFalse((new User(['email' => 'unknown@example.com']))->isAdmin());
    }

    /** Test if the admin list is cached and can be flushed. */
    public function testAdminsAreCached(): void
    {
        $user = new User(['email' => 'user@example.com']);
        $this->assertFalse($user->isAdmin());

        DB::table('users')->where('email', 'user@example.com')->update(['is_admin' => true]);
        $this->assertFalse($user->isAdmin());

        $this->app->make(MySQLDriver::class)->flush();
        $this->assertTrue($user->isAdmin());
    }

    /** Test if caching can be disabled. */
    public function testCacheCanBeDisabled(): void
    {
        config(['admins.mysql.cache' => 0]);

        $user = new User(['email' => 'user@example.com']);
        $this->assertFalse($user->isAdmin());

        DB::table('users')->where('email', 'user@example.com')->update(['is_admin' => true]);
        $this->assertTrue($user->isAdmin());
        $this->assertFalse(Cache::has(MySQLDriver::CACHE_KEY));
    }

    /** Test if the migration can be rolled back. */
    public function testMigrationCanBeRolledBack(): void
    {
        (require __DIR__ . '/../database/migrations/add_admin_column_to_users_table.php.stub')->down();

        $this->assertFalse(Schema::hasColumn('users', 'is_admin'));
    }
}
