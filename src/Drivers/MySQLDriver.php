<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Drivers;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Database\ConnectionResolverInterface;
use SnoerenDevelopment\AdminUsers\Driver;
use SnoerenDevelopment\AdminUsers\Support\Emails;

class MySQLDriver implements Driver
{
    /** The cache key used to store the admin emails. */
    public const string CACHE_KEY = 'admin-users.admins';

    public function __construct(
        protected Config $config,
        protected Cache $cache,
        protected ConnectionResolverInterface $db,
    ) {
        //
    }

    /** Determine if the given email is an administrator. */
    public function isAdmin(string $email): bool
    {
        return Emails::contains($this->getCachedEmails(), $email);
    }

    /**
     * Retrieve the (cached) list of emails.
     *
     * @return list<string>
     */
    public function getCachedEmails(): array
    {
        $ttl = $this->config->get('admins.mysql.cache', 60);
        $ttl = is_numeric($ttl) ? (int) $ttl : 60;

        if ($ttl <= 0) {
            return $this->getEmails();
        }

        return Emails::normalize($this->cache->remember(
            self::CACHE_KEY,
            $ttl,
            fn (): array => $this->getEmails(),
        ));
    }

    /**
     * Retrieve the list of emails from the database.
     *
     * @return list<string>
     */
    public function getEmails(): array
    {
        $connection = $this->config->get('admins.mysql.connection');
        $table = $this->config->get('admins.mysql.table', 'users');

        return Emails::normalize(
            $this->db
                ->connection(is_string($connection) && $connection !== '' ? $connection : null)
                ->table(is_string($table) && $table !== '' ? $table : 'users')
                ->where('is_admin', true)
                ->pluck('email')
                ->all()
        );
    }

    /** Forget the cached list of emails. */
    public function flush(): void
    {
        $this->cache->forget(self::CACHE_KEY);
    }
}
