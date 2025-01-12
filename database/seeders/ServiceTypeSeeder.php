<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceTypes = [
            [
                'id' => 1,
                'name' => 'AKAP'
            ],
            [
                'id' => 2,
                'name' => 'AKDP'
            ],
            [
                'id' => 3,
                'name' => 'AJAP'
            ],
            [
                'id' => 4,
                'name' => 'Pariwisata'
            ],
            [
                'id' => 5,
                'name' => 'Angkot/Angdes'
            ],
            [
                'id' => 6,
                'name' => 'Angkutan barang umum'
            ],
            [
                'id' => 7,
                'name' => 'Angkutan B3'
            ],
            [
                'id' => 8,
                'name' => 'Alat berat'
            ],
            [
                'id' => 9,
                'name' => 'Angkutan lintas batas negara'
            ]
        ];

        foreach ($serviceTypes as $serviceType) {
            ServiceType::updateOrCreate(
                ['id' => $serviceType['id']],
                ['name' => $serviceType['name']]
            );
        }
    }
}
