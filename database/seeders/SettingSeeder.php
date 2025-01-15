<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('settings')->count() > 0) {
            return;
        }

        $array = [
            [
                "id" => 1,
                "name" => "aplikasi",
                "value" => json_encode([
                    "kota" => "Kab. Cirebon",
                    "nama" => "SMK - KOTA CIREBON",
                    "email" => "dishubKotacirebon@mail.com",
                    "alamat" => "Jl. R.Dewi Sartika No.118, Sumber, Kec. Sumber, Kabupaten Cirebon, Jawa Barat 45611",
                    "provinsi" => "Jawa Barat",
                    "whatsapp" => "62812879801",
                    "deskripsi" => "Aplikasi ini dirancang untuk mendukung perusahaan angkutan umum dalam menerapkan dan memantau standar keselamatan operasional. Sistem ini memantau kinerja keselamatan secara berkelanjutan.",
                    "logo_favicon" => "",
                    "logo_aplikasi" => "",
                    "nama_instansi" => "Dinas Perhubungan Kota Cirebon"
                ]),
            ],
            [
                "id" => 3,
                "name" => "oss",
                "value" => json_encode([
                    "url" => "https://gw-oss.dephub.go.id/api/v431",
                    "password" => "demodemo",
                    "username" => "spionam",
                    "is_active" => 0
                ]),
            ]
        ];

        DB::table('settings')->insert($array);
    }
}
