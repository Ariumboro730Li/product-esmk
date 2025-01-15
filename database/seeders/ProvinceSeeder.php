<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('provinces')->count() > 0) {
            return;
        }

        $json = file_get_contents(base_path('database/seeders/json/provinces.json'));
        $array = json_decode($json, true);

        DB::table('provinces')->insert($array);

    }
}
