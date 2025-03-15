<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(8)->create(
            [
                'role' => 'user',
                'email_verified_at' => now(),
                'email_confirmed' => false
            ]
        );

        User::factory(1)->create(
            [
                'email' => 'user@user.com',
                'password' => 'User123.',
                'role' => 'user',
                'email_verified_at' => now(),
                'email_confirmed' => false
            ]
        );
        
        User::factory()->create([
            'name' => 'Admin Rafael',
            'email' => 'admin@admin.com',
            'password' => 'Admin123.',
            'email_confirmed' => false,
            'role' => 'admin',
        ]);

        // Products
        Product::create([
            'name' => 'Gaming Mouse',
            'description' => 'High precision gaming mouse with customizable buttons.',
            'category' => 'Peripherals',
            'brand' => 'Logitech',
            'price' => 59.99,
            'quantity' => 100
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard',
            'description' => 'RGB mechanical keyboard with tactile switches.',
            'category' => 'Peripherals',
            'brand' => 'Corsair',
            'price' => 129.99,
            'quantity' => 50
        ]);

        Product::create([
            'name' => 'Gaming Monitor',
            'description' => '27-inch 144Hz gaming monitor with 1ms response time.',
            'category' => 'Displays',
            'brand' => 'ASUS',
            'price' => 299.99,
            'quantity' => 30
        ]);

        Product::create([
            'name' => 'Graphics Card',
            'description' => 'NVIDIA GeForce RTX 3080 with 10GB GDDR6X memory.',
            'category' => 'Components',
            'brand' => 'NVIDIA',
            'price' => 699.99,
            'quantity' => 20
        ]);

        Product::create([
            'name' => 'Gaming Headset',
            'description' => 'Surround sound gaming headset with noise-cancelling mic.',
            'category' => 'Peripherals',
            'brand' => 'SteelSeries',
            'price' => 99.99,
            'quantity' => 75
        ]);
    }
}
