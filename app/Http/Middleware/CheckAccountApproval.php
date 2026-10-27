<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountApproval
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (
            $user
            && $user->role === 'adopter'
            && $user->approval_status !== 'Approved'
            && ! $request->routeIs('account.pending')
            && ! $request->routeIs('account.resubmit')
            && ! $request->is('logout')
        ) {
            return redirect()->route('account.pending');
        }

        return $next($request);
    }
}