<?php

namespace Database\Seeders;

use App\Models\PantryIngredient;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PantryIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Grain
        PantryIngredient::create([
            'ingredient_name' => 'beras',
            'category' => 'grain',
            'unit' => 'kg',
            'quantity' => 5.0,
            'min_quantity' => 1.0,
            'purchase_date' => Carbon::now()->subDays(5),
            'purchase_price' => 15000,
            'is_active' => true,
        ]);

        PantryIngredient::create([
            'ingredient_name' => 'mie instan',
            'category' => 'grain',
            'unit' => 'bungkus',
            'quantity' => 10,
            'min_quantity' => 3,
            'purchase_date' => Carbon::now()->subDays(3),
            'purchase_price' => 3000,
            'is_active' => true,
        ]);

        // Spice
        PantryIngredient::create([
            'ingredient_name' => 'garam',
            'category' => 'spice',
            'unit' => 'gram',
            'quantity' => 500,
            'min_quantity' => 100,
            'purchase_date' => Carbon::now()->subDays(10),
            'purchase_price' => 5000,
            'is_active' => true,
        ]);

        PantryIngredient::create([
            'ingredient_name' => 'bawang merah',
            'category' => 'spice',
            'unit' => 'pcs',
            'quantity' => 20,
            'min_quantity' => 5,
            'purchase_date' => Carbon::now()->subDays(2),
            'purchase_price' => 10000,
            'is_active' => true,
        ]);

        PantryIngredient::create([
            'ingredient_name' => 'bawang putih',
            'category' => 'spice',
            'unit' => 'pcs',
            'quantity' => 15,
            'min_quantity' => 5,
            'purchase_date' => Carbon::now()->subDays(2),
            'purchase_price' => 8000,
            'is_active' => true,
        ]);

        // Oil
        PantryIngredient::create([
            'ingredient_name' => 'minyak goreng',
            'category' => 'oil',
            'unit' => 'liter',
            'quantity' => 2.0,
            'min_quantity' => 0.5,
            'purchase_date' => Carbon::now()->subDays(7),
            'purchase_price' => 25000,
            'is_active' => true,
        ]);

        // Vegetable
        PantryIngredient::create([
            'ingredient_name' => 'wortel',
            'category' => 'vegetable',
            'unit' => 'pcs',
            'quantity' => 5,
            'min_quantity' => 2,
            'purchase_date' => Carbon::now()->subDays(1),
            'purchase_price' => 8000,
            'is_active' => true,
        ]);

        PantryIngredient::create([
            'ingredient_name' => 'kentang',
            'category' => 'vegetable',
            'unit' => 'pcs',
            'quantity' => 8,
            'min_quantity' => 3,
            'purchase_date' => Carbon::now()->subDays(1),
            'purchase_price' => 12000,
            'is_active' => true,
        ]);

        // Sauce
        PantryIngredient::create([
            'ingredient_name' => 'kecap manis',
            'category' => 'sauce',
            'unit' => 'botol',
            'quantity' => 2,
            'min_quantity' => 1,
            'purchase_date' => Carbon::now()->subDays(5),
            'purchase_price' => 15000,
            'is_active' => true,
        ]);

        PantryIngredient::create([
            'ingredient_name' => 'sambal',
            'category' => 'sauce',
            'unit' => 'botol',
            'quantity' => 1,
            'min_quantity' => 1,
            'purchase_date' => Carbon::now()->subDays(3),
            'purchase_price' => 10000,
            'is_active' => true,
        ]);
    }
}
