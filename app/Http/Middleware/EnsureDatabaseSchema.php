<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EnsureDatabaseSchema
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Auto-fix database schema if needed
        try {
            if (Schema::hasTable('pesanan_item') && !Schema::hasColumn('pesanan_item', 'produk_id')) {
                DB::statement('ALTER TABLE `pesanan_item` ADD COLUMN `produk_id` BIGINT UNSIGNED NULL AFTER `pesanan_id`');
            }
        } catch (\Exception $e) {
            // Silently fail - column might already exist
        }

        return $next($request);
    }
}
