<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CertificateTemplate;
use Carbon\Carbon;

class CertificateTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $contentTemplate =  '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Sertifikat SMKPAU</title><style>body{font-family:Arial,Helvetica,sans-serif}</style></head><body><div style="display:flex"><div style="width:72%;text-align:right"><span style="font-size:12px;font-weight:700">No Sertifikat:&nbsp;</span></div><div style="width:26%;border-bottom:2px dotted"><span style="font-size:12px;font-weight:700">{{certificate_number}}</span></div></div><div style="margin-top:15rem;text-align:center"><div style="font-weight:700;font-size:14px"><p style="margin:0">SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN ANGKUTAN UMUM</p><p style="margin:0"><i>SAFETY MANAGEMENT SYSTEM OF PUBLIC TRANSPORTATION COMPANY</i></p></div><div style="margin-top:1rem;font-size:12px"><p style="margin:0">Berdasarkan</p><p style="margin:0">Based on</p></div><div style="margin-top:1rem;font-size:12px"><p style="margin:0">Keputusan Menteri Perhubungan Republik Indonesia</p><p style="margin:0"><i>Decree of the Minister of Transportation of the Republic of Indonesia</i></p><p style="margin:0">Nomor 85 Tahun 2018 Tentang Sistem Manajemen Keselamatan Perusahaan Angkutan Umum</p><p style="margin:0"><i>Number 85 Year 2018 Concerning the Safety Management System of Public Transportation Company</i></p></div><div style="font-weight:700;margin-top:4rem;font-size:12px"><p style="margin:0">MENYATAKAN BAHWA</p><p style="margin:0">THIS IS TO CERTIFY THAT</p></div><div style="font-weight:700;margin-top:3rem"><p>{{company_name}}</p><p style="font-size:12px">Alamat/Address</p><p style="font-size:12px">{{company_address}}</p></div><div style="margin-top:1rem;font-size:12px"><p style="margin:0">Telah Memenuhi 10 (Sepuluh) Elemen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum</p><p style="margin:0;margin-bottom:10px"><i>Has Fullfilled 10 (ten) Elements of the Public Transportation Company of Safety Management System</i></p><p style="margin:0">Sertifikat ini Berlaku Dalam Jangka Waktu 5(lima) Tahun Sejak Dikeluarkan</p><p style="margin:0"><i>This Certificate is Valid for 5 (Five) Years from the Date of Issued</i></p></div><table style="float:right;font-size:14px;border:0;margin-top:50px;align-item:center"><tr><td style="text-align:center">{{wu_city}},&nbsp;{{release_date}}<br>{{signer_position}}</td></tr><tr><td style="height:80px"></td></tr><tr style="margin-top:50px"><td style="text-align:center">{{signer_name}}<br><b>{{signer_identity_type}}&nbsp;{{signer_identity_number}}</b></td></tr></table></div><div style="position:absolute;top:70px;right:100px">{{qrCode}}</div></body></html>';

    public function run()
    {
        $template = new CertificateTemplate();
        $template->content = $this->contentTemplate;
        $template->is_active = true;
        $template->created_at = Carbon::now();
        $template->save();
    }
}
