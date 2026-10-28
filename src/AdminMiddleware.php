<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\AdminUsers;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Guests receive a 401 Unauthorized response, authenticated users without
     * admin rights receive a 403 Forbidden response.
     *
     * @param \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if($user === null, 401);
        abort_unless(AdminUsers::check($user), 403);

        return $next($request);
    }
}
