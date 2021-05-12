<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Drivers;

use Illuminate\Support\Facades\DB;
use SnoerenDevelopment\AdminUsers\Driver;

class MySQLDriver implements Driver
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
        $this->emails = DB::table('users')
            ->where('is_admin', 1)
            ->get('email')
            ->pluck('email');
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
