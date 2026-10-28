<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

trait Adminable // @phpstan-ignore trait.unused
{
    /** Determine whether the model has admin rights. */
    public function isAdmin(): bool
    {
        $email = $this->getAdminEmail();

        return $email !== null && app(Driver::class)->isAdmin($email);
    }

    /** Retrieve the email to check admin status against. */
    public function getAdminEmail(): ?string
    {
        $email = $this->getAttribute('email');

        return is_string($email) ? $email : null;
    }
}
