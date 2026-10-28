<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers\Support;

/** @internal */
final class Emails
{
    /**
     * Normalize a list of emails: trim them and drop non-string and empty
     * values. An empty entry must never be able to match a user without an
     * email address.
     *
     * @return list<string>
     */
    public static function normalize(mixed $emails): array
    {
        if (is_string($emails)) {
            $emails = explode(',', $emails);
        }

        if (!is_iterable($emails)) {
            return [];
        }

        $normalized = [];

        foreach ($emails as $email) {
            if (!is_string($email)) {
                continue;
            }

            $email = trim($email);

            if ($email !== '') {
                $normalized[] = $email;
            }
        }

        return $normalized;
    }

    /**
     * Determine whether the given email is part of the list using a strict
     * comparison.
     *
     * @param list<string> $emails
     */
    public static function contains(array $emails, string $email): bool
    {
        $email = trim($email);

        return $email !== '' && in_array($email, $emails, true);
    }
}
