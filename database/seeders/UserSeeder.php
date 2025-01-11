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

        $data = [
            [
                'id' => uuid_create(),
                'username' => 'testadmin',
                'name' => 'Test Admin',
                'last_name' => null,
                'nip' => '1234567890',
                'email' => 'testadmin@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_company' => false,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ], [
                'id' => uuid_create(),
                'username' => 'testcompany',
                'name' => 'Test Company',
                'last_name' => null,
                'nip' => null,
                'email' => 'testcompany@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_company' => true,
                'info_company' => null,
                'is_active' => true,
                'remember_token' => null
            ]
        ];

        DB::table('users')->insert($data);

    }
}
