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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code')->nullable();
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(1);
            $table->string('type'); // 'apartment', 'house', 'land', dll
            $table->decimal('area', 8, 2); // luas dalam m2
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('available'); // 'available', 'sold', 'inactive'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
