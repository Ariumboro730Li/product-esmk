<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CitySeeder::class,
            ProvinceSeeder::class,
            CertificateTemplateSeeder::class,
            ServiceTypeSeeder::class,
            MonitoringElementSeeder::class,
            SmkElementSeeder::class,
            SettingSeeder::class,
            SignerSeeder::class,
            DecreeSeeder::class,
            KbliSeeder::class,
        ]);
    }
}
