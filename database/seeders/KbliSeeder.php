<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KbliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if (DB::table('standard_industrial_classifications')->count() > 0) {
            return;
        }

        $json = file_get_contents(base_path('database/seeders/json/kbli.json'));
        $array = json_decode($json, true);

        DB::table('standard_industrial_classifications')->insert($array);
    }
}
