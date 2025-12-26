<?php

namespace Database\Seeders;

use App\Models\Cigarette;
use Illuminate\Database\Seeder;

class CigaretteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data pembelian rokok
        Cigarette::create([
            'type' => 'purchase',
            'brand' => 'Sampoerna',
            'quantity' => 1,
            'price' => 38000,
            'total_price' => 38000,
            'notes' => 'Beli rokok pertama kali',
        ]);

        Cigarette::create([
            'type' => 'purchase',
            'brand' => 'Djarum',
            'quantity' => 2,
            'price' => 35000,
            'total_price' => 70000,
            'notes' => 'Beli 2 pack sekaligus',
        ]);

        // Data konsumsi rokok
        for ($i = 0; $i < 15; $i++) {
            Cigarette::create([
                'type' => 'consume',
                'quantity' => 1,
                'notes' => 'Ngerokok ' . ($i + 1),
            ]);
        }
    }
}
