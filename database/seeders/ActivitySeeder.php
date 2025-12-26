<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Aktivitas yang sudah selesai
        Activity::create([
            'activity_type' => 'beli_makan',
            'description' => 'Beli makan siang di warung',
            'location_status' => 'outside',
            'started_at' => Carbon::now()->subHours(3),
            'ended_at' => Carbon::now()->subHours(2),
            'is_active' => false,
            'notes' => 'Sudah pulang dari beli makan',
        ]);

        Activity::create([
            'activity_type' => 'futsal',
            'description' => 'Futsal dengan teman',
            'location_status' => 'outside',
            'started_at' => Carbon::yesterday()->setTime(19, 0),
            'ended_at' => Carbon::yesterday()->setTime(21, 0),
            'is_active' => false,
            'notes' => 'Futsal di lapangan dekat kost',
        ]);

        Activity::create([
            'activity_type' => 'nongkrong',
            'description' => 'Nongkrong di cafe',
            'location_status' => 'outside',
            'started_at' => Carbon::now()->subDays(2)->setTime(20, 0),
            'ended_at' => Carbon::now()->subDays(2)->setTime(23, 0),
            'is_active' => false,
            'notes' => 'Nongkrong dengan teman kuliah',
        ]);

        // Aktivitas aktif (masih berlangsung)
        Activity::create([
            'activity_type' => 'tidur',
            'description' => 'Tidur siang',
            'location_status' => 'inside',
            'started_at' => Carbon::now()->subHours(1),
            'ended_at' => null,
            'is_active' => true,
            'notes' => 'Masih tidur',
        ]);
    }
}
