<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Drivers;

use SnoerenDevelopment\AdminUsers\Driver;

class ConfigDriver implements Driver
{
    /**
     * The list of admin emails.
     *
     * @var array<string>
     */
    protected array $emails;

    public function __construct()
    {
        // @phpstan-ignore-next-line
        $this->emails = (array) config('admins.admins');
    }

    /** Determine if the given email is an administrator. */
    public function isAdmin(string $email): bool
    {
        return in_array($email, $this->emails);
    }
}
