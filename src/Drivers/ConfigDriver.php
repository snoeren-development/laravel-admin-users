<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Drivers;

use Illuminate\Contracts\Config\Repository;
use SnoerenDevelopment\AdminUsers\Driver;
use SnoerenDevelopment\AdminUsers\Support\Emails;

class ConfigDriver implements Driver
{
    public function __construct(protected Repository $config)
    {
        //
    }

    /** Determine if the given email is an administrator. */
    public function isAdmin(string $email): bool
    {
        return Emails::contains($this->getEmails(), $email);
    }

    /**
     * Retrieve the list of emails.
     *
     * @return list<string>
     */
    public function getEmails(): array
    {
        return Emails::normalize($this->config->get('admins.admins', []));
    }
}
