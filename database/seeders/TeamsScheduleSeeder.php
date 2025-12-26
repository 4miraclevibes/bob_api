<?php

namespace Database\Seeders;

use App\Models\TeamsSchedule;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TeamsScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeamsSchedule::create([
            'teams_event_id' => 'teams-001',
            'title' => 'Daily Standup',
            'description' => 'Daily standup meeting dengan tim',
            'start_time' => Carbon::tomorrow()->setTime(9, 0),
            'end_time' => Carbon::tomorrow()->setTime(9, 30),
            'location' => 'Microsoft Teams',
            'attendees' => [
                ['name' => 'John Doe', 'email' => 'john@example.com'],
                ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ],
            'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/123',
            'is_all_day' => false,
            'status' => 'confirmed',
            'last_synced_at' => Carbon::now(),
        ]);

        TeamsSchedule::create([
            'teams_event_id' => 'teams-002',
            'title' => 'Sprint Planning',
            'description' => 'Planning untuk sprint berikutnya',
            'start_time' => Carbon::now()->addDays(3)->setTime(14, 0),
            'end_time' => Carbon::now()->addDays(3)->setTime(16, 0),
            'location' => 'Microsoft Teams',
            'attendees' => [
                ['name' => 'John Doe', 'email' => 'john@example.com'],
                ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
                ['name' => 'Bob Wilson', 'email' => 'bob@example.com'],
            ],
            'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/456',
            'is_all_day' => false,
            'status' => 'confirmed',
            'last_synced_at' => Carbon::now(),
        ]);

        TeamsSchedule::create([
            'teams_event_id' => 'teams-003',
            'title' => 'Code Review Session',
            'description' => 'Review code untuk feature baru',
            'start_time' => Carbon::now()->addDays(5)->setTime(10, 0),
            'end_time' => Carbon::now()->addDays(5)->setTime(11, 30),
            'location' => 'Microsoft Teams',
            'attendees' => [
                ['name' => 'John Doe', 'email' => 'john@example.com'],
            ],
            'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/789',
            'is_all_day' => false,
            'status' => 'tentative',
            'last_synced_at' => Carbon::now(),
        ]);
    }
}
