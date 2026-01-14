<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSeller
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'seller') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Hanya penjual yang dapat mengakses halaman ini');
    }
}
