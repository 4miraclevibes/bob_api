<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::create([
            'recipe_name' => 'Nasi Goreng',
            'category' => 'rice',
            'difficulty' => 'easy',
            'cooking_time' => 15,
            'servings' => 2,
            'ingredients' => [
                ['ingredient_name' => 'beras', 'quantity' => 0.3, 'unit' => 'kg'],
                ['ingredient_name' => 'minyak goreng', 'quantity' => 0.05, 'unit' => 'liter'],
                ['ingredient_name' => 'bawang merah', 'quantity' => 3, 'unit' => 'pcs'],
                ['ingredient_name' => 'bawang putih', 'quantity' => 2, 'unit' => 'pcs'],
                ['ingredient_name' => 'kecap manis', 'quantity' => 0.1, 'unit' => 'botol'],
            ],
            'instructions' => '1. Panaskan minyak, tumis bawang merah dan bawang putih. 2. Masukkan nasi, aduk rata. 3. Tambahkan kecap manis, aduk hingga merata. 4. Sajikan.',
            'tags' => ['cepat', 'mudah', 'favorit'],
            'is_favorite' => true,
            'last_cooked_at' => Carbon::now()->subDays(2),
            'cook_count' => 5,
        ]);

        Recipe::create([
            'recipe_name' => 'Mie Goreng',
            'category' => 'noodle',
            'difficulty' => 'easy',
            'cooking_time' => 10,
            'servings' => 1,
            'ingredients' => [
                ['ingredient_name' => 'mie instan', 'quantity' => 1, 'unit' => 'bungkus'],
                ['ingredient_name' => 'minyak goreng', 'quantity' => 0.03, 'unit' => 'liter'],
                ['ingredient_name' => 'bawang merah', 'quantity' => 2, 'unit' => 'pcs'],
            ],
            'instructions' => '1. Rebus mie hingga matang. 2. Panaskan minyak, tumis bawang merah. 3. Masukkan mie, tambahkan bumbu, aduk rata.',
            'tags' => ['cepat', 'mudah'],
            'is_favorite' => false,
            'last_cooked_at' => Carbon::now()->subDays(5),
            'cook_count' => 3,
        ]);

        Recipe::create([
            'recipe_name' => 'Capcay',
            'category' => 'fried',
            'difficulty' => 'medium',
            'cooking_time' => 20,
            'servings' => 2,
            'ingredients' => [
                ['ingredient_name' => 'wortel', 'quantity' => 2, 'unit' => 'pcs'],
                ['ingredient_name' => 'kentang', 'quantity' => 2, 'unit' => 'pcs'],
                ['ingredient_name' => 'minyak goreng', 'quantity' => 0.05, 'unit' => 'liter'],
                ['ingredient_name' => 'bawang putih', 'quantity' => 3, 'unit' => 'pcs'],
            ],
            'instructions' => '1. Potong sayuran. 2. Panaskan minyak, tumis bawang putih. 3. Masukkan sayuran, tambahkan air sedikit. 4. Masak hingga matang.',
            'tags' => ['sehat', 'sayuran'],
            'is_favorite' => true,
            'last_cooked_at' => null,
            'cook_count' => 0,
        ]);

        Recipe::create([
            'recipe_name' => 'Nasi Putih',
            'category' => 'rice',
            'difficulty' => 'easy',
            'cooking_time' => 30,
            'servings' => 4,
            'ingredients' => [
                ['ingredient_name' => 'beras', 'quantity' => 0.5, 'unit' => 'kg'],
            ],
            'instructions' => '1. Cuci beras. 2. Masak dengan rice cooker. 3. Tunggu hingga matang.',
            'tags' => ['dasar', 'mudah'],
            'is_favorite' => false,
            'last_cooked_at' => Carbon::now()->subDays(1),
            'cook_count' => 10,
        ]);
    }
}
