<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

interface Driver
{
    /** Determine if the given email is an administrator. */
    public function isAdmin(string $email): bool;
}
