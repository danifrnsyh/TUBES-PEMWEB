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
        Schema::create('pesanan_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('produk_id');
            $table->string('nama_produk');
            $table->string('sku');
            $table->integer('jumlah');
            $table->bigInteger('harga_unit');
            $table->bigInteger('subtotal');
            $table->enum('metode', ['Bayar Ditempat', 'Transfer']);
            $table->enum('status', ['pending', 'berhasil', 'gagal'])->default('pending');
            $table->string('bukti')->nullable();
            $table->timestamps();

            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_item');
    }
};
