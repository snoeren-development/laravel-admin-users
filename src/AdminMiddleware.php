<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request The request object.
     * @param  \Closure                 $next    The next handler.
     * @return mixed
     */
    public function handle($request, Closure $next) // phpcs:ignore
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|null $user */
        $user = $request->user();

        // @phpstan-ignore-next-line
        abort_unless($user?->isAdmin() === true, 401);

        return $next($request);
    }
}
