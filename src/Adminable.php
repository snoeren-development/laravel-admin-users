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
        return app(Driver::class)->isAdmin($this->getAdminEmail());
    }

    /**
     * Retrieve the email to check admin status against.
     *
     * @return string
     */
    public function getAdminEmail(): string
    {
        return $this->email;
    }
}
