<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('cities')->count() > 0) {
            return;
        }

        $json = file_get_contents(base_path('database/seeders/json/city.json'));
        $array = json_decode($json, true);

        DB::table('cities')->insert($array);
    }
}
