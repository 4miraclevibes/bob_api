<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed semua tabel
        $this->call([
            CigaretteSeeder::class,
            FoodSeeder::class,
            ActivitySeeder::class,
            TransportSeeder::class,
            BiographySeeder::class,
            LocationStateSeeder::class,
            PantryIngredientSeeder::class,
            RecipeSeeder::class,
            TeamsScheduleSeeder::class,
            PersonalScheduleSeeder::class,
            DailyLearningQuestionSeeder::class,
        ]);
    }
}
