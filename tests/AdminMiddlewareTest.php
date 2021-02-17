<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

class AdminMiddlewareTest extends TestCase
{
    /**
     * Test if a guest receives an unauthorized error.
     *
     * @return void
     */
    public function testGuestCannotVisitAdminProtectedRoute(): void
    {
        $this
            ->call('GET', 'admin-route')
            ->assertUnauthorized();
    }

    /**
     * Test if a user receives an unauthorized error.
     *
     * @return void
     */
    public function testUserCannotVisitAdminProtectedRoute(): void
    {
        $user = new User(['email' => 'user@example.com']);

        $this
            ->actingAs($user)
            ->call('GET', 'admin-route')
            ->assertUnauthorized();
    }

    /**
     * Test if an admin can pass through the middleware.
     *
     * @return void
     */
    public function testAdminCanVisitAdminProtectedRoute(): void
    {
        $user = new User(['email' => 'admin@example.com']);

        $this
            ->actingAs($user)
            ->call('GET', 'admin-route')
            ->assertOk()
            ->assertSee('admin content');
    }
}
