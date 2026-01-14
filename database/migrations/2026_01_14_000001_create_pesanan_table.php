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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique();
            $table->unsignedBigInteger('pembeli_id');
            $table->bigInteger('total');
            $table->enum('status', ['pending', 'dibayar', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->string('catatan')->nullable();
            $table->string('alamat_kirim');
            $table->bigInteger('ongkir')->default(0);
            $table->enum('metode_pembayaran', ['Bayar Ditempat', 'Transfer']);
            $table->timestamps();

            $table->foreign('pembeli_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
