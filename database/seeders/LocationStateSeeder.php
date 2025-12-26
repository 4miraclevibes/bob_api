<?php

namespace Database\Seeders;

use App\Models\LocationState;
use Illuminate\Database\Seeder;

class LocationStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LocationState::create([
            'status' => 'inside',
            'last_activity' => 'tidur',
            'current_location' => null,
            'updated_at' => now(),
        ]);
    }
}
