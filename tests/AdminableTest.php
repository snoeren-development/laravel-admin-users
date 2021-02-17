<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

use Orchestra\Testbench\TestCase;
use SnoerenDevelopment\AdminUsers\Tests\User;

class AdminableTest extends TestCase
{
    /**
     * Test if the user model has the isAdmin method.
     *
     * @return void
     */
    public function testUserHasIsAdminMethod()
    {
        $this->assertTrue(method_exists(new User, 'isAdmin'));
    }

    /**
     * Test if the is admin method returns true when the email exists in the
     * configuration.
     *
     * @return void
     */
    public function testIsAdminReturnsTrue()
    {
        $this->app['config']->set('admins.admins', ['test@example.com', 'other@email.com']);

        $this->assertTrue((new User(['email' => 'test@example.com']))->isAdmin());
    }

    /**
     * Test if the is admin method returns false when the email does not exist
     * in the configuration.
     *
     * @return void
     */
    public function testIsAdminReturnsFalse()
    {
        $this->app['config']->set('admins.admins', ['test@example.com', 'other@email.com']);

        $this->assertFalse((new User(['email' => 'someone@gmail.com']))->isAdmin());
    }
}
