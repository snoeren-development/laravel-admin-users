<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Drivers;

use SnoerenDevelopment\AdminUsers\Driver;

class ConfigDriver implements Driver
{
    /**
     * The list of admin emails.
     *
     * @var array
     */
    protected $emails;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->emails = config('admins.admins');
    }

    /**
     * Determine if the given email is an administrator.
     *
     * @param  string $email The email.
     * @return boolean
     */
    public function isAdmin(string $email): bool
    {
        return in_array($email, $this->emails);
    }
}
