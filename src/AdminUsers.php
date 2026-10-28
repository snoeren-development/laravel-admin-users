<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

final class AdminUsers
{
    /** Determine whether the given user is an administrator. */
    public static function check(mixed $user): bool
    {
        return is_object($user)
            && method_exists($user, 'isAdmin')
            && $user->isAdmin() === true;
    }
}
