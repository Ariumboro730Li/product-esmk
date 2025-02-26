<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserDaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $uuidAdmin = uuid_create();
        $uuidKetuaTimProv = uuid_create();
        $uuidKetuaTimKota = uuid_create();
        $uuidPenilai = uuid_create();

        $data = [
            [
                'id' => $uuidAdmin,
                'username' => 'admin-aceh',
                'name' => 'Administrator Aceh',
                'last_name' => null,
                'nip' => '12345998919',
                'email' => 'administrator-aceh@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_company' => false,
                'province_id' => 11,
                'city_id' => null,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ], [

                'id' => $uuidKetuaTimProv,
                'username' => 'ketuatimaceh',
                'name' => 'Ketua Tim Aceh',
                'last_name' => null,
                'nip' => '12345998917',
                'email' => 'ketuatim-aceh@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'province_id' => 11,
                'city_id' => null,
                'is_company' => false,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ],[

                'id' => $uuidKetuaTimKota,
                'username' => 'ketuatim-simeulue',
                'name' => 'Ketua Tim Simeulue',
                'last_name' => null,
                'nip' => '12345998915',
                'email' => 'ketuatim-simeulue@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'province_id' => 11,
                'city_id' => 1101,
                'is_company' => false,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ], [

                'id' => $uuidPenilai,
                'username' => 'penilai-aceh',
                'name' => 'Penilai Aceh',
                'last_name' => null,
                'nip' => '12345998912',
                'email' => 'penilai-aceh@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'province_id' => 11,
                'city_id' => 1101,
                'is_company' => false,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ]
        ];

        DB::table('users')->insert($data);

        $modelHAsRole = [
            [
                'id' => 1,
                'role_id' => 1,
                'model_type' => 'App\Models\User',
                'model_id' => $uuidAdmin
            ], [
                'id' => 2,
                'role_id' => 4,
                'model_type' => 'App\Models\User',
                'model_id' => $uuidKetuaTimProv
            ],
            [
                'id' => 2,
                'role_id' => 4,
                'model_type' => 'App\Models\User',
                'model_id' => $uuidKetuaTimKota
            ],

            [
                'id' => 3,
                'role_id' => 3,
                'model_type' => 'App\Models\User',
                'model_id' => $uuidPenilai
            ]
        ];

    }
}
