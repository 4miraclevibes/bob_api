<?php

namespace Database\Seeders;

use App\Models\Biography;
use Illuminate\Database\Seeder;

class BiographySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Personal Info
        Biography::create([
            'category' => 'personal_info',
            'title' => 'Tempat Lahir',
            'content' => 'Jakarta, Indonesia',
            'tags' => ['lahir', 'jakarta', 'personal'],
            'is_public' => true,
            'priority' => 10,
        ]);

        Biography::create([
            'category' => 'personal_info',
            'title' => 'Tanggal Lahir',
            'content' => '1 Januari 2000',
            'tags' => ['lahir', 'tanggal', 'personal'],
            'is_public' => true,
            'priority' => 9,
        ]);

        // Education
        Biography::create([
            'category' => 'education',
            'title' => 'Kampus',
            'content' => 'Universitas Indonesia, Fakultas Teknik Informatika',
            'tags' => ['kampus', 'ui', 'pendidikan', 'informatika'],
            'is_public' => true,
            'priority' => 8,
        ]);

        Biography::create([
            'category' => 'education',
            'title' => 'Sekolah Menengah',
            'content' => 'SMA Negeri 1 Jakarta',
            'tags' => ['sekolah', 'sma', 'pendidikan'],
            'is_public' => true,
            'priority' => 7,
        ]);

        // Daily Story
        Biography::create([
            'category' => 'daily_story',
            'title' => 'Hobi',
            'content' => 'Futsal, nongkrong, dan coding',
            'tags' => ['hobi', 'futsal', 'coding', 'nongkrong'],
            'is_public' => true,
            'priority' => 6,
        ]);

        Biography::create([
            'category' => 'daily_story',
            'title' => 'Rutinitas Harian',
            'content' => 'Bangun pagi, olahraga, kerja/kuliah, nongkrong dengan teman, coding di malam hari',
            'tags' => ['rutinitas', 'harian', 'aktivitas'],
            'is_public' => true,
            'priority' => 5,
        ]);

        // Preference
        Biography::create([
            'category' => 'preference',
            'title' => 'Makanan Favorit',
            'content' => 'Nasi goreng, bakso, dan mie ayam',
            'tags' => ['makanan', 'favorit', 'preferensi'],
            'is_public' => true,
            'priority' => 4,
        ]);
    }
}
