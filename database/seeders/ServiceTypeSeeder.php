<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('service_types')->count() > 0) {
            return;
        }
        $serviceTypes = [
            [
                'id' => 1,
                'name' => 'AKDP'
            ],
            [
                'id' => 2,
                'name' => 'Angkot/Angdes'
            ],
            [
                'id' => 3,
                'name' => 'Angkutan barang umum'
            ],
        ];

        DB::table('service_types')->insert($serviceTypes);
    }
}
