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
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        abort_unless($user && $user->isAdmin(), 401);

        return $next($request);
    }
}
