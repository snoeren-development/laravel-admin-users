<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

class AdminableTest extends TestCase
{
    /**
     * Test if the user model has the isAdmin method.
     *
     * @return void
     */
    public function testUserHasIsAdminMethod(): void
    {
        $this->assertTrue(method_exists(new User, 'isAdmin'));
    }

    /**
     * Test if the is admin method returns true when the email exists in the
     * configuration.
     *
     * @return void
     */
    public function testIsAdminReturnsTrue(): void
    {
        $this->assertTrue((new User(['email' => 'admin@example.com']))->isAdmin());
    }

    /**
     * Test if the is admin method returns false when the email does not exist
     * in the configuration.
     *
     * @return void
     */
    public function testIsAdminReturnsFalse(): void
    {
        $this->assertFalse((new User(['email' => 'user@example.com']))->isAdmin());
    }
}
