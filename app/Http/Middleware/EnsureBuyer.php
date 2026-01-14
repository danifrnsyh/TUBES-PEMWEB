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

        // Check role from either 'role' or 'peran' column
        // Database uses enum('Pegawai','Pembeli')
        $peran = trim($user->peran ?? 'Pembeli');
        
        if ($peran !== 'Pembeli') {
            abort(403, "Only pembeli (buyer) can perform this action. Your role: {$peran}");
        }

        return $next($request);
    }
}
