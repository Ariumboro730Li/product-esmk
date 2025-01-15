<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('users')->count() > 0) {
            return;
        }

        $uuidAdmin = uuid_create();
        $uuidKetuaTim = uuid_create();
        $uuidPenilai = uuid_create();

        $data = [
            [
                'id' => $uuidAdmin,
                'username' => 'administrator',
                'name' => 'Administrator',
                'last_name' => null,
                'nip' => '1234567890',
                'email' => 'administrator@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_company' => false,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ], [

                'id' => $uuidKetuaTim,
                'username' => 'ketuatim',
                'name' => 'Ketua Tim',
                'last_name' => null,
                'nip' => '1234567891',
                'email' => 'ketuatim@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_company' => false,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ], [

                'id' => $uuidPenilai,
                'username' => 'penilai',
                'name' => 'Penilai',
                'last_name' => null,
                'nip' => '1234567892',
                'email' => 'penilai@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
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
                'model_id' => $uuidKetuaTim
            ], [
                'id' => 3,
                'role_id' => 3,
                'model_type' => 'App\Models\User',
                'model_id' => $uuidPenilai
            ]
        ];

        DB::table('model_has_roles')->insert($modelHAsRole);

        $json = file_get_contents(base_path('database/seeders/json/role_has_permission.json'));
        $array = json_decode($json, true);

        DB::table('role_has_permissions')->insert($array);

    }
}
