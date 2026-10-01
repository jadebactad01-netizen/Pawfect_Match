<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Allow only the super administrator.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        if (! $request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->role !== 'super_admin') {
            abort(403);
        }

        return $next($request);
    }
}