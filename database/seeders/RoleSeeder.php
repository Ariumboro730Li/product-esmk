<?php

namespace Database\Seeders;

use App\Models\Auth\Role;
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
        $array =
        [
            [
                "id" => 1,
                "guard_name" => "employee",
                "name" => "Super Admin",
                "is_active" => 1,
                "created_at" => "2023-11-30 02:40:38",
                "updated_at" => "2023-11-30 02:40:38",
                "deleted_at" => null
            ],
            [
                "id" => 2,
                "guard_name" => "employee",
                "name" => "Admin",
                "is_active" => 1,
                "created_at" => "2023-11-30 02:40:38",
                "updated_at" => "2023-11-30 02:40:38",
                "deleted_at" => null
            ],
            [
                "id" => 3,
                "guard_name" => "employee",
                "name" => "Assessor",
                "is_active" => 1,
                "created_at" => "2023-11-30 02:40:38",
                "updated_at" => "2023-11-30 02:40:38",
                "deleted_at" => null
            ],
            [
                "id" => 4,
                "guard_name" => "employee",
                "name" => "Ketua Tim",
                "is_active" => 1,
                "created_at" => "2023-11-30 02:40:38",
                "updated_at" => "2023-11-30 02:40:38",
                "deleted_at" => null
            ],
            [
                "id" => 5,
                "guard_name" => "employee",
                "name" => "Kasubdit",
                "is_active" => 1,
                "created_at" => "2023-11-30 02:40:38",
                "updated_at" => "2023-11-30 02:40:38",
                "deleted_at" => null
            ],
            [
                "id" => 6,
                "guard_name" => "employee",
                "name" => "Direktur",
                "is_active" => 1,
                "created_at" => "2023-11-30 02:40:38",
                "updated_at" => "2023-11-30 02:40:38",
                "deleted_at" => null
            ]
        ];

        if (DB::table('roles')->count() > 0) {
            return;
        }

        DB::table('roles')->insert($array);

    }
}
