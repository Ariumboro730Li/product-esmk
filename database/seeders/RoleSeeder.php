<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ["id" => 1, "guard_name" => "employee", "name" => "Super Admin"],
            ["id" => 2, "guard_name" => "employee", "name" => "Admin"],
            ["id" => 3, "guard_name" => "employee", "name" => "Assessor"],
            ["id" => 4, "guard_name" => "employee", "name" => "Ketua Tim"],
            ["id" => 5, "guard_name" => "employee", "name" => "Kasubdit"],
            ["id" => 6, "guard_name" => "employee", "name" => "Direktur"],
            ["id" => 7, "guard_name" => "employee", "name" => "Ketua tim kota"],
            ["id" => 8, "guard_name" => "employee", "name" => "Ketua tim provinsi"],
            ["id" => 9, "guard_name" => "employee", "name" => "Assessor kota"]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']], // Cek berdasarkan name dan guard_name
                [
                    'is_active' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            );
        }
    }
}
