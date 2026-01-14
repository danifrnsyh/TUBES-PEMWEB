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
        // Run other seeders
        $this->call([
            TestUserSeeder::class,
            ProductSeeder::class,
        ]);
        
        $this->command->info('Database seeded successfully!');
    }
}
