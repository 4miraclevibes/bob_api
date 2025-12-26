<?php

namespace Database\Seeders;

use App\Models\PersonalSchedule;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonalScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonalSchedule::create([
            'title' => 'Minisoccer',
            'description' => 'Minisoccer dengan teman',
            'schedule_date' => Carbon::now()->addDays(2),
            'start_time' => Carbon::now()->addDays(2)->setTime(19, 0),
            'end_time' => Carbon::now()->addDays(2)->setTime(21, 0),
            'location' => 'Lapangan Futsal dekat kost',
            'activity_type' => 'minisoccer',
            'is_all_day' => false,
            'reminder_before' => 30,
            'status' => 'scheduled',
            'notes' => 'Bawa sepatu futsal',
        ]);

        PersonalSchedule::create([
            'title' => 'Nongkrong',
            'description' => 'Nongkrong di cafe dengan teman',
            'schedule_date' => Carbon::now()->addDays(4),
            'start_time' => Carbon::now()->addDays(4)->setTime(20, 0),
            'end_time' => Carbon::now()->addDays(4)->setTime(23, 0),
            'location' => 'Cafe dekat kampus',
            'activity_type' => 'nongkrong',
            'is_all_day' => false,
            'reminder_before' => 60,
            'status' => 'scheduled',
            'notes' => 'Meet up dengan teman kuliah',
        ]);

        PersonalSchedule::create([
            'title' => 'Belanja Bulanan',
            'description' => 'Belanja kebutuhan bulanan',
            'schedule_date' => Carbon::now()->addDays(7),
            'start_time' => Carbon::now()->addDays(7)->setTime(10, 0),
            'end_time' => Carbon::now()->addDays(7)->setTime(12, 0),
            'location' => 'Supermarket',
            'activity_type' => 'belanja',
            'is_all_day' => false,
            'reminder_before' => 120,
            'status' => 'scheduled',
            'notes' => 'Beli bahan makanan dan kebutuhan lainnya',
        ]);

        PersonalSchedule::create([
            'title' => 'Futsal',
            'description' => 'Futsal rutin mingguan',
            'schedule_date' => Carbon::now()->addDays(9),
            'start_time' => Carbon::now()->addDays(9)->setTime(18, 0),
            'end_time' => Carbon::now()->addDays(9)->setTime(20, 0),
            'location' => 'Lapangan Futsal',
            'activity_type' => 'futsal',
            'is_all_day' => false,
            'reminder_before' => 30,
            'status' => 'scheduled',
            'notes' => 'Futsal dengan tim',
        ]);
    }
}
