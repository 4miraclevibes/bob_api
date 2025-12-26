<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Makanan
        Food::create([
            'category' => 'food',
            'item_name' => 'Nasi Goreng',
            'cost' => 25000,
            'quantity' => 1,
            'location' => 'Warung Makan Pak Budi',
            'notes' => 'Nasi goreng spesial',
        ]);

        Food::create([
            'category' => 'food',
            'item_name' => 'Mie Ayam',
            'cost' => 20000,
            'quantity' => 1,
            'location' => 'Mie Ayam Bu Siti',
            'notes' => 'Mie ayam pangsit',
        ]);

        Food::create([
            'category' => 'food',
            'item_name' => 'Bakso',
            'cost' => 18000,
            'quantity' => 1,
            'location' => 'Bakso Malang',
            'notes' => 'Bakso urat',
        ]);

        // Minuman
        Food::create([
            'category' => 'drink',
            'item_name' => 'Es Teh Manis',
            'cost' => 5000,
            'quantity' => 2,
            'location' => 'Warung Makan Pak Budi',
            'notes' => 'Es teh manis',
        ]);

        Food::create([
            'category' => 'drink',
            'item_name' => 'Kopi Hitam',
            'cost' => 8000,
            'quantity' => 1,
            'location' => 'Kedai Kopi',
            'notes' => 'Kopi hitam tanpa gula',
        ]);

        // Snack
        Food::create([
            'category' => 'snack',
            'item_name' => 'Keripik Singkong',
            'cost' => 10000,
            'quantity' => 1,
            'location' => 'Toko Kelontong',
            'notes' => 'Keripik singkong pedas',
        ]);

        Food::create([
            'category' => 'snack',
            'item_name' => 'Cokelat',
            'cost' => 15000,
            'quantity' => 2,
            'location' => 'Minimarket',
            'notes' => 'Cokelat batangan',
        ]);
    }
}
