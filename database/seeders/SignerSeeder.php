<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SignerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('signers')->count() > 0) {
            return;
        }
        $json = file_get_contents(base_path('database/seeders/json/signer.json'));
        $array = json_decode($json, true);

        DB::table('signers')->insert($array);
    }
}
