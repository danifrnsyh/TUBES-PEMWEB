<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produk_gambar', function (Blueprint $table) {
            // Change created_at to have a default value
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
        });
    }

    public function down(): void
    {
        Schema::table('produk_gambar', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->change();
        });
    }
};
