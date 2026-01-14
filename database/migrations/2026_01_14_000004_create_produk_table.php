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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penambah_id');
            $table->unsignedBigInteger('kategori_id');
            $table->string('nama', 255);
            $table->string('deskripsi', 255);
            $table->string('sku', 255)->unique();
            $table->bigInteger('harga');
            $table->integer('stok');
            $table->integer('berat_gram');
            $table->string('dimensi', 100);
            $table->string('gambar_utama', 255);
            $table->enum('status', ['aktif', 'nonaktif', 'habis'])->default('aktif');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori_produk');
            $table->foreign('penambah_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
