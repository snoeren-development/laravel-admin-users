<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

trait Adminable
{
    /**
     * Determine whether the model has admin rights.
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return in_array($this->email, config('admins.admins'));
    }
}
