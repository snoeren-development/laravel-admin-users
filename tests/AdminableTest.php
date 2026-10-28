<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Tests;

use InvalidArgumentException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use SnoerenDevelopment\AdminUsers\Driver;

class AdminableTest extends TestCase
{
    /** Test if the is admin method returns true for a configured email. */
    public function testIsAdminReturnsTrue(): void
    {
        $this->assertTrue((new User(['email' => 'admin@example.com']))->isAdmin());
    }

    /** Test if the is admin method returns false for an unknown email. */
    public function testIsAdminReturnsFalse(): void
    {
        $this->assertFalse((new User(['email' => 'user@example.com']))->isAdmin());
    }

    /** Test if a user without an email is never an admin. */
    public function testUserWithoutEmailIsNotAdmin(): void
    {
        $this->assertFalse((new User)->isAdmin());
        $this->assertFalse((new User(['email' => '']))->isAdmin());
    }

    /** Test if empty entries in the admin list don't grant admin rights. */
    public function testEmptyAdminEntriesAreIgnored(): void
    {
        config(['admins.admins' => ['', ' ', 'admin@example.com']]);

        $this->assertFalse((new User(['email' => '']))->isAdmin());
        $this->assertFalse((new User(['email' => ' ']))->isAdmin());
    }

    /** Test if whitespace around configured emails is ignored. */
    public function testWhitespaceAroundAdminEntriesIsIgnored(): void
    {
        config(['admins.admins' => ['first@example.com', ' second@example.com ']]);

        $this->assertTrue((new User(['email' => 'second@example.com']))->isAdmin());
    }

    /** Test if emails are compared strictly. */
    public function testEmailsAreComparedStrictly(): void
    {
        config(['admins.admins' => ['1e3']]);

        $this->assertFalse((new User(['email' => '1000']))->isAdmin());
    }

    /** Test if config changes are picked up at runtime. */
    public function testConfigChangesArePickedUp(): void
    {
        $user = new User(['email' => 'admin@example.com']);
        $this->assertTrue($user->isAdmin());

        config(['admins.admins' => []]);
        $this->assertFalse($user->isAdmin());
    }

    /** Test if an unknown driver results in a clear exception. */
    public function testUnknownDriverThrows(): void
    {
        config(['admins.driver' => 'unknown']);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Admin users driver [unknown] is not supported.');

        $this->app->make(Driver::class);
    }

    /** Test the admin gate. */
    public function testAdminGate(): void
    {
        $this->assertTrue(Gate::forUser(new User(['email' => 'admin@example.com']))->allows('admin'));
        $this->assertFalse(Gate::forUser(new User(['email' => 'user@example.com']))->allows('admin'));
    }

    /** Test the admin Blade directive. */
    public function testAdminBladeDirective(): void
    {
        $template = '@admin yes @else no @endadmin';

        $this->assertSame('no', trim(Blade::render($template)));

        $this->actingAs(new User(['email' => 'user@example.com']));
        $this->assertSame('no', trim(Blade::render($template)));

        $this->actingAs(new User(['email' => 'admin@example.com']));
        $this->assertSame('yes', trim(Blade::render($template)));
    }
}
