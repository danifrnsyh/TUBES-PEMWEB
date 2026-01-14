<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a seller user first
        $seller = User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Test Seller',
                'email' => 'seller@test.com',
                'password' => Hash::make('password123'),
                'role' => 'seller',
            ]
        );

        // Create product categories
        $kategoriSofa = KategoriProduk::firstOrCreate(
            ['slug' => 'sofa'],
            [
                'nama' => 'Sofa',
                'deskripsi' => 'Koleksi sofa berkualitas premium',
            ]
        );

        $kategoriMeja = KategoriProduk::firstOrCreate(
            ['slug' => 'meja'],
            [
                'nama' => 'Meja',
                'deskripsi' => 'Meja makan dan meja kerja pilihan',
            ]
        );

        // Create products
        Produk::firstOrCreate(
            ['sku' => 'SOFA-001'],
            [
                'penambah_id' => $seller->id,
                'kategori_id' => $kategoriSofa->id,
                'nama' => 'Sofa L Premium Hitam',
                'deskripsi' => 'Sofa L dengan desain modern, bahan kulit sintetis berkualitas tinggi',
                'harga' => 5000000,
                'stok' => 10,
                'berat_gram' => 50000,
                'dimensi' => '240x180x90cm',
                'gambar_utama' => 'produk/sofa-1.jpg',
                'status' => 'aktif',
            ]
        );

        Produk::firstOrCreate(
            ['sku' => 'MEJA-001'],
            [
                'penambah_id' => $seller->id,
                'kategori_id' => $kategoriMeja->id,
                'nama' => 'Meja Makan 6 Kursi Kayu Jati',
                'deskripsi' => 'Meja makan berkualitas dengan material kayu jati asli',
                'harga' => 3500000,
                'stok' => 8,
                'berat_gram' => 80000,
                'dimensi' => '200x100x75cm',
                'gambar_utama' => 'produk/meja-1.jpg',
                'status' => 'aktif',
            ]
        );

        Produk::firstOrCreate(
            ['sku' => 'SOFA-002'],
            [
                'penambah_id' => $seller->id,
                'kategori_id' => $kategoriSofa->id,
                'nama' => 'Sofa Minimalis Putih Cream',
                'deskripsi' => 'Sofa 3 seater dengan desain minimalis modern yang elegan',
                'harga' => 2800000,
                'stok' => 15,
                'berat_gram' => 40000,
                'dimensi' => '210x85x85cm',
                'gambar_utama' => 'produk/sofa-2.jpg',
                'status' => 'aktif',
            ]
        );
    }
}
