<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBuyer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'buyer') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Hanya pembeli yang dapat mengakses halaman ini');
    }
}
