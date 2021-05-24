<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Drivers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
        $cacheLength = config('admins.mysql.cache');

        $this->emails = $cacheLength === 0
            ? $this->getEmails()
            : Cache::remember('admin-users.admins', $cacheLength, function () {
                return $this->getEmails();
            });
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

    /**
     * Retrieve the list of emails.
     *
     * @return array
     */
    public function getEmails(): array
    {
        return DB::table(config('admins.mysql.table'))
            ->where('is_admin', 1)
            ->get('email')
            ->pluck('email')
            ->toArray();
    }
}
