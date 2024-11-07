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
     * @var array<string>
     */
    protected array $emails;

    public function __construct()
    {
        // @phpstan-ignore-next-line
        $cacheLength = (int) config('admins.mysql.cache');

        // @phpstan-ignore-next-line
        $this->emails = Cache::remember(
            key: 'admin-users.admins',
            ttl: $cacheLength,
            callback: fn () => $this->getEmails()
        );
    }

    /** Determine if the given email is an administrator. */
    public function isAdmin(string $email): bool
    {
        return in_array($email, $this->emails);
    }

    /**
     * Retrieve the list of emails.
     *
     * @return array<string>
     */
    public function getEmails(): array
    {
        // @phpstan-ignore-next-line
        return DB::table((string) config('admins.mysql.table'))
            ->where('is_admin', 1)
            ->pluck('email')
            ->toArray();
    }
}
