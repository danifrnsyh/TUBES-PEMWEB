<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureBuyer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        $role = trim(strtolower($user->role ?? ''));
        if ($role !== 'pembeli') {
            abort(403, 'Only pembeli can perform this action.');
        }

        return $next($request);
    }
}
