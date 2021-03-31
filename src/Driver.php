<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

interface Driver
{
    /**
     * Determine if the given email is an administrator.
     *
     * @param  string $email The email.
     * @return boolean
     */
    public function isAdmin(string $email): bool;
}
