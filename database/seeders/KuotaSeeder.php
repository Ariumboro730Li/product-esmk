<?php

namespace Database\Seeders;

use App\Models\Kuota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KuotaSeeder extends Seeder
{

    public function run(): void
    {
        Kuota::insert([
            [
                'province_id' => 11,
                'city_id' => json_encode([1101, 1105]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'province_id' => 12,
                'city_id' => json_encode([1201, 1202, 1203]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'province_id' => 13,
                'city_id' => json_encode([1301]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
