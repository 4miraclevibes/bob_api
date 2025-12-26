<?php

namespace Database\Seeders;

use App\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Isi bahan bakar
        Transport::create([
            'type' => 'fuel',
            'vehicle_type' => 'motor',
            'amount' => 50000,
            'description' => 'Isi bahan bakar 3 liter',
            'notes' => 'Isi bensin di SPBU dekat kost',
        ]);

        Transport::create([
            'type' => 'fuel',
            'vehicle_type' => 'motor',
            'amount' => 30000,
            'description' => 'Isi bahan bakar 2 liter',
            'notes' => 'Isi bensin untuk perjalanan',
        ]);

        // Service motor
        Transport::create([
            'type' => 'service',
            'vehicle_type' => 'motor',
            'amount' => 250000,
            'description' => 'Service motor rutin',
            'service_items' => [
                ['item' => 'Oli mesin', 'price' => 50000],
                ['item' => 'Oli gardan', 'price' => 30000],
                ['item' => 'Ban belakang', 'price' => 150000],
                ['item' => 'Jasa service', 'price' => 20000],
            ],
            'notes' => 'Service di bengkel langganan',
        ]);

        Transport::create([
            'type' => 'maintenance',
            'vehicle_type' => 'motor',
            'amount' => 75000,
            'description' => 'Ganti busi dan filter udara',
            'service_items' => [
                ['item' => 'Busi', 'price' => 25000],
                ['item' => 'Filter udara', 'price' => 30000],
                ['item' => 'Jasa pasang', 'price' => 20000],
            ],
            'notes' => 'Maintenance rutin',
        ]);
    }
}
