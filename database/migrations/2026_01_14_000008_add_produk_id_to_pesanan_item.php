<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only add if column doesn't exist
        if (Schema::hasTable('pesanan_item') && !Schema::hasColumn('pesanan_item', 'produk_id')) {
            Schema::table('pesanan_item', function (Blueprint $table) {
                $table->unsignedBigInteger('produk_id')->after('pesanan_id')->nullable();
                $table->foreign('produk_id')->references('id')->on('produk')->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pesanan_item') && Schema::hasColumn('pesanan_item', 'produk_id')) {
            Schema::table('pesanan_item', function (Blueprint $table) {
                $table->dropForeign(['produk_id']);
                $table->dropColumn('produk_id');
            });
        }
    }
};
