<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Property;
use App\Models\Order;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test seller user
        $seller = User::create([
            'name' => 'Penjual Test',
            'email' => 'seller@propertyhub.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 123',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
        ]);

        // Create test buyer user
        $buyer = User::create([
            'name' => 'Pembeli Test',
            'email' => 'buyer@propertyhub.com',
            'password' => bcrypt('password'),
            'role' => 'buyer',
            'phone' => '082345678901',
            'address' => 'Jl. Sudirman No. 456',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
        ]);

        // Create additional sellers
        for ($i = 2; $i <= 3; $i++) {
            User::create([
                'name' => "Penjual $i",
                'email' => "seller$i@propertyhub.com",
                'password' => bcrypt('password'),
                'role' => 'seller',
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => "Jl. Jalan No. $i",
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
            ]);
        }

        // Create additional buyers
        for ($i = 2; $i <= 3; $i++) {
            User::create([
                'name' => "Pembeli $i",
                'email' => "buyer$i@propertyhub.com",
                'password' => bcrypt('password'),
                'role' => 'buyer',
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => "Jl. Rumah No. $i",
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
            ]);
        }

        // Create test properties
        $properties_data = [
            [
                'title' => 'Apartemen Modern di Tengah Kota',
                'description' => 'Apartemen modern dengan fasilitas lengkap, lokasi strategis di pusat bisnis kota.',
                'address' => 'Jl. Sudirman No. 100',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12190',
                'price' => 500000000,
                'stock' => 5,
                'type' => 'apartment',
                'area' => 85,
                'bedrooms' => 2,
                'bathrooms' => 1,
            ],
            [
                'title' => 'Rumah Minimalis 2 Lantai',
                'description' => 'Rumah minimalis dengan desain modern, cocok untuk keluarga muda.',
                'address' => 'Jl. Gatot Subroto No. 50',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12930',
                'price' => 750000000,
                'stock' => 3,
                'type' => 'house',
                'area' => 150,
                'bedrooms' => 3,
                'bathrooms' => 2,
            ],
            [
                'title' => 'Tanah Premium di Area Berkembang',
                'description' => 'Tanah dengan luas besar di lokasi yang terus berkembang, cocok untuk investasi.',
                'address' => 'Jl. BSD Boulevard',
                'city' => 'Tangerang',
                'province' => 'Banten',
                'postal_code' => '15331',
                'price' => 300000000,
                'stock' => 2,
                'type' => 'land',
                'area' => 500,
                'bedrooms' => null,
                'bathrooms' => null,
            ],
            [
                'title' => 'Ruang Kantor di Gedung Komersial',
                'description' => 'Ruang kantor dengan fasilitas modern, dilengkapi dengan AC dan parking.',
                'address' => 'Jl. Pancoran Selatan',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12780',
                'price' => 1000000000,
                'stock' => 10,
                'type' => 'commercial',
                'area' => 200,
                'bedrooms' => null,
                'bathrooms' => 2,
            ],
            [
                'title' => 'Villa Mewah dengan Kolam Renang',
                'description' => 'Villa mewah dengan kolam renang pribadi dan pemandangan yang indah.',
                'address' => 'Jl. Mega Kuningan',
                'city' => 'Jakarta',
                'province' => 'DKI Jakarta',
                'postal_code' => '12950',
                'price' => 2500000000,
                'stock' => 1,
                'type' => 'house',
                'area' => 800,
                'bedrooms' => 5,
                'bathrooms' => 4,
            ],
        ];

        // Create properties with sellers
        $sellers = User::where('role', 'seller')->get();
        $property_index = 0;

        foreach ($properties_data as $data) {
            $seller = $sellers[$property_index % $sellers->count()];
            Property::create(array_merge($data, [
                'seller_id' => $seller->id,
                'status' => 'available',
            ]));
            $property_index++;
        }

        // Create sample orders
        $buyers = User::where('role', 'buyer')->get();
        $properties = Property::all();

        foreach ($buyers->slice(0, 2) as $buyer) {
            foreach ($properties->slice(0, 2) as $property) {
                Order::create([
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)) . '-' . time(),
                    'buyer_id' => $buyer->id,
                    'seller_id' => $property->seller_id,
                    'property_id' => $property->id,
                    'quantity' => 1,
                    'price' => $property->price,
                    'total_price' => $property->price,
                    'status' => 'pending',
                    'ordered_at' => now(),
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
    }
}
