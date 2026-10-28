<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use Illuminate\Foundation\Auth\User as AuthUser;

class AdminMiddlewareTest extends TestCase
{
    /** Test if a guest receives an unauthorized error. */
    public function testGuestCannotVisitAdminProtectedRoute(): void
    {
        $this
            ->get('admin-route')
            ->assertUnauthorized();
    }

    /** Test if a regular user receives a forbidden error. */
    public function testUserCannotVisitAdminProtectedRoute(): void
    {
        $this
            ->actingAs(new User(['email' => 'user@example.com']))
            ->get('admin-route')
            ->assertForbidden();
    }

    /** Test if a user model without the Adminable trait is forbidden. */
    public function testUserWithoutTraitCannotVisitAdminProtectedRoute(): void
    {
        $this
            ->actingAs((new AuthUser)->forceFill(['email' => 'admin@example.com']))
            ->get('admin-route')
            ->assertForbidden();
    }

    /** Test if an admin can pass through the middleware. */
    public function testAdminCanVisitAdminProtectedRoute(): void
    {
        $this
            ->actingAs(new User(['email' => 'admin@example.com']))
            ->get('admin-route')
            ->assertOk()
            ->assertSee('admin content');
    }
}
