<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DecreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('decree_numbers')->count() > 0) {
            return;
        }
        $json = file_get_contents(base_path('database/seeders/json/decree.json'));
        $array = json_decode($json, true);

        DB::table('decree_numbers')->insert($array);

    }
}
