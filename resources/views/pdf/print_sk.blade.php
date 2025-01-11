<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Dirjen Keputusan </title>
    <style>
        @font-face {
            font-family: 'Bookman';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: storage_path("fonts/Bookman.ttf") format("truetype");
        }
        @page { margin: 0; }

        body {
            font-family: "Bookman";
            font-size: 16px;
        }
        .table-border table {
            border-collapse: collapse;
            font-family: "Bookman", Georgia, serif;
            width: 100%;
        }
        .table-border td, th {
            border: 1px solid #000;
            /* padding: 3px 4px; */
        }

    </style>
</head>

<body>
    <table cellspacing="0" class="table" style=" margin-top: 5rem; margin-left: 5rem;">
        <tr>
        <td style="width: 350px !important; font-size:14px;"><u>Terlebih Dahulu:</u></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 350px !important;">1. Kasubdit Manajamen Keselamatan</td>
            <td style="width: 350px !important;">:</td>
            <td></td>
        </tr>
        <tr>
            <td style="width: 350px !important;">2. Direktur Sarana Transportasi Jalan</td>
            <td style="width: 350px !important;">:</td>
            <td></td>
        </tr>
    </table>

    <div style="margin-left: 5rem; margin-right: 2.75rem; font-size: 17px;">
        <div style="text-align: center; font-weight: bold; margin-top: 5rem;">
            <p style="padding: 0; margin: 0">KEPUTUSAN DIREKTUR JENDERAL PERHUBUNGAN DARAT</p>
        </div>
        <div style="text-align: center;">
            <p style="padding: 0; margin: 0; line-height: 1.55; letter-spacing: 0.05rem;">NOMOR: {{$data['sk_number']}}</p>
            <p style="padding: 0; margin: 0; line-height: 1.75">TENTANG</p>
            <p style="padding: 0; margin-top: 2rem; line-height: 1.55;">PENETAPAN PEMENUHAN SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN</p>
            <p style="padding: 0; margin-top: -12px; line-height: 1;">ANGKUTAN UMUM {{ Str::upper($data['companies_name']) }}</p>
            <p style="padding: 0; margin-top: 2rem; line-height: 1.55;">DENGAN RAHMAT TUHAN YANG MAHA ESA</p>
            <p style="padding: 0; margin-top: 2rem; line-height: 1.55; margin-bottom: 5px; font-weight: bold">DIREKTUR JENDERAL PERHUBUNGAN DARAT,</p>
        </div>
    </div>

    <div style="font-size: 18px; margin-left: 5rem; margin-right: 4rem;">
        <table cellspacing="0" class="table" style="width: 100%;">
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">Menimbang</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">a.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">bahwa berdasarkan Peraturan Menteri Perhubungan Nomor 85 Tahun 2018 tentang Sistem Manajemen Keselamatan Perusahaan Angkutan Umum telah diatur mengenai Perusahaan Angkutan Umum wajib memenuhi Sistem Manajemen Keselamatan Perusahaan Angkutan Umum dan diberikan Sertifikat Sistem Manajemen Keselamatan Perusahaan Angkutan Umum oleh Direktur Jenderal, Kepala Badan, Gubernur, dan Bupati/Walikota sesuai dengan kewenangannya;<br>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">b.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                     bahwa berdasarkan hasil penilaian oleh Tim Penilai Sistem Manajemen Keselamatan Perusahaan Angkutan Umum, dinyatakan bahwa <b>{{ Str::upper($data['companies_name']) }}</b> telah menyusun dan melaksanakan {{ $data['count_element'] }} ({{ trim($data['penyebut']($data['count_element'])) }}) elemen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum;
                </td>
            </tr>
        </table>
    </div>

    <div style="page-break-before: always;"></div>

    <div style="">
        <img src="{{ $data['letterhead'] }}" alt="Cover" style="width: 100%; margin: 0; padding 0;" />
    </div>

    <div style="margin-left: 5rem; margin-right: 2.75rem; font-size: 17px;">

        <div style="text-align: center; font-weight: bold; margin-top: 0.5rem;">
            <p style="padding: 0; margin: 0">KEPUTUSAN DIREKTUR JENDERAL PERHUBUNGAN DARAT</p>
        </div>
        <div style="text-align: center;">
            <p style="padding: 0; margin: 0; line-height: 1.55; letter-spacing: 0.05rem;">NOMOR: {{$data['sk_number']}}</p>
            <p style="padding: 0; margin: 0; line-height: 1.55">TENTANG</p>
            <p style="padding: 0; margin-top: 2rem; line-height: 1.55;">PENETAPAN PEMENUHAN SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN</p>
            <p style="padding: 0; margin-top: -12px; line-height: 1;">ANGKUTAN UMUM {{ Str::upper($data['companies_name']) }}</p>
            <p style="padding: 0; margin-top: 2rem; line-height: 1.55;">DENGAN RAHMAT TUHAN YANG MAHA ESA</p>
            <p style="padding: 0; margin-top: 2rem; line-height: 1.55; margin-bottom: 5px; font-weight: bold">DIREKTUR JENDERAL PERHUBUNGAN DARAT,</p>
        </div>
    </div>

    <div style="font-size: 18px; margin-left: 5rem; margin-right: 4rem;">
        <table cellspacing="0" class="table" style=" width: 100%; page-break-after: always;">
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">Menimbang</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">a.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    bahwa berdasarkan Peraturan Menteri Perhubungan Nomor 85 Tahun 2018 tentang Sistem Manajemen Keselamatan Perusahaan Angkutan Umum telah diatur mengenai Perusahaan Angkutan Umum wajib memenuhi Sistem Manajemen Keselamatan Perusahaan Angkutan Umum dan diberikan Sertifikat Sistem Manajemen Keselamatan Perusahaan Angkutan Umum oleh Direktur Jenderal, Kepala Badan, Gubernur, dan Bupati/Walikota sesuai dengan kewenangannya;<br>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; ">b.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    bahwa berdasarkan hasil penilaian oleh Tim Penilai Sistem Manajemen Keselamatan Perusahaan Angkutan Umum, dinyatakan bahwa
                    <b>{{ Str::upper($data['companies_name']) }}</b> telah menyusun dan melaksanakan
                    {{ $data['count_element'] }} ({{ trim($data['penyebut']($data['count_element'])) }}) elemen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum;
                </td>

            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">c.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a dan huruf b, perlu menetapkan Keputusan Direktur Jenderal Perhubungan Darat tentang Penetapan Pemenuhan Sistem Manajemen Keselamatan Perusahaan Angkutan Umum <b>{{ Str::upper($data['companies_name']) }}; </b></td>
            </tr>
        </table>
    </div>
    <div style="font-size: 18px; margin-top: 5rem; margin-left: 5rem; margin-right: 4rem; page-break-after: always; ">
        <table cellspacing="0" class="table" style=" width: 100%;">
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 120px;">Mengingat</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">1.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Undang-Undang Nomor 22 Tahun 2009 tentang Lalu Lintas dan Angkutan Jalan (Lembaran Negara Republik Indonesia Tahun 2009 Nomor 96, Tambahan Lembaran Negara Republik Indonesia Nomor 5025);
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">2.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Peraturan Pemerintah Nomor 74 Tahun 2014 tentang Angkutan Jalan (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 260, Tambahan Lembaran Negara Republik Indonesia Nomor 5594);
                </td>
            </tr>
            <tr>
            <td style="vertical-align: text-top; padding: 0 5px;"></td>
            <td style="vertical-align: text-top; padding: 0 5px;"></td>
            <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">3.</td>
            <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                Peraturan Pemerintah Nomor 37 Tahun 2017 tentang Keselamatan Lalu Lintas dan Angkutan Jalan (Lembaran Negara Republik Indonesia Tahun 2017 Nomor 205, Tambahan Lembaran Negara Republik Indonesia Nomor 6122);
            </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">4.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Peraturan Menteri Perhubungan Nomor 85 Tahun 2018 tentang Sistem Manajemen Keselamatan Perusahaan Angkutan Umum (Berita Negara Republik Indonesia Tahun 2018 Nomor 1280);
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">5.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Peraturan Menteri Perhubungan Nomor 17 Tahun 2022 tentang Organisasi dan Tata Kerja Kementerian Perhubungan (Berita Negara Republik Indonesia Tahun 2022 Nomor 815);
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">6.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Peraturan Direktur Jenderal Perhubungan Darat Nomor KP.1990/AJ.503/DRJD/2019 tentang Tata Cara Penilaian Sistem Manajemen Keselamatan Perusahaan Angkutan Umum;
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 120px;">Memperhatikan</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">a.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Surat Direktur Utama {{ $data['companies_name'] }} Nomor: {{$data['number_of_application_letter']}} tanggal {{$data['date_of_application_letter']}} perihal Permohonan Penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum;
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">b.</td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                    Berita Acara Hasil Penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum Nomor : {{ $data['rov_number'] }} tanggal {{$data['interview_schedule']}};
                </td>
            </tr>
        </table>
    </div>

    <div style="font-size: 18px; margin-left: 5rem; margin-top: 5rem; margin-right: 4rem;">
        <table  style="page-break-after: always;">
            <tr>
                <td colspan="4" style="text-align: center; vertical-align: text-top; padding: 0 7px; line-height: 2.5; width: 120px; font-weight: bold;">MEMUTUSKAN :</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">Menetapkan</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; text-align: justify; text-justify: auto; font-weight: bold;">KEPUTUSAN DIREKTUR JENDERAL PERHUBUNGAN DARAT TENTANG PENETAPAN PEMENUHAN SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN ANGKUTAN UMUM {{ Str::upper($data['companies_name']) }}</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 2; width: 130px; font-weight: bold;">PERTAMA</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 2; ">:</td>
                <td style="vertical-align: text-top; padding: 0"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 2; text-align: justify; text-justify: auto;">Menetapkan bahwa&nbsp;:</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;"></td>
                <td style="vertical-align: text-top; padding: 0;"></td>
                <td style="vertical-align: text-top; padding: 0;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;text-justify: auto;">
                    <table cellspacing="0" class="table" style="border-spacing: 0 5px;" page-break-inside: always;>
                        <tr>
                            <td style="vertical-align: text-top; width: 150px !important;">Nama Perusahaan</td>
                            <td style="vertical-align: text-top; ">:</td>
                            <td style="vertical-align: text-top; padding: 0 5px;">{{ Str::upper($data['companies_name']) }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: text-top; width: 170px !important;">Alamat Perusahaan</td>
                            <td style="vertical-align: text-top;">:</td>
                            <td style="vertical-align: text-top; width: 250px !important; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">{{ ($data['address']) }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: text-top; width: 150px !important;">Penanggung Jawab</td>
                            <td style="vertical-align: text-top;">:</td>
                            <td style="vertical-align: text-top; padding: 0 5px;">{{ $data['pic_name'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; width: 130px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Telah memenuhi 10 (sepuluh) elemen Sistem Manajemen Keselamatan dan diberikan Sertifikat Sistem Manajemen Keselamatan Perusahaan Angkutan Umum sebagaimana tercantum dalam Lampiran yang merupakan bagian tidak terpisahkan dari Keputusan Direktur Jenderal ini.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KEDUA</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Sertifikat Sistem Manajemen Keselamatan Perusahaan Angkutan Umum sebagaimana dimaksud dalam DIKTUM PERTAMA berlaku selama 5 (lima) tahun sepanjang Perusahaan Angkutan Umum masih menjalankan usaha di bidang angkutan umum sesuai izin penyelenggaraan angkutan umum yang diberikan.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KETIGA</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Perusahaan Angkutan Umum yang telah mendapatkan Sertifikat Sistem Manajemen Keselamatan Perusahaan Angkutan Umum sebagaimana dimaksud dalam DIKTUM PERTAMA wajib:
                    <table cellspacing="0" style="width: 100%">
                        <tr>
                            <td style="vertical-align: text-top; padding: 0 5px;">a.</td>
                            <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Melaksanakan dan menyempurnakan Sistem Manajemen Keselamatan Perusahaan Angkutan Umum; dan</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: text-top; padding: 0 5px;">b.</td>
                            <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">melaporkan hasil pelaksanaan Sistem Manajemen Keselamatan Perusahaan Angkutan Umum kepada Direktur Jenderal Perhubungan Darat sekurang-kurangnya 1 (satu) tahun sekali.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div style="font-size: 18px; margin-left: 5rem; margin-top: 5rem; margin-right: 4rem;">
        <table>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KEEMPAT</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Dalam hal terjadi pelanggaran terhadap kewajiban sebagaimana dimaksud dalam DIKTUM KETIGA maka akan dikenai sanksi sesuai dengan ketentuan peraturan perundang-undangan.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KELIMA</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Direktur yang membidangi sarana transportasi jalan melakukan pembinaan dan pengawasan terhadap pelaksanaan Keputusan Direktur Jenderal Perhubungan Darat ini.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KEENAM</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Keputusan Direktur Jenderal Perhubungan Darat ini mulai berlaku pada tanggal ditetapkan.
                    <table cellspacing="0" align="right" class="table" style="margin-top: 5rem; margin-bottom: 0.5rem;">
                        <tr>
                            <td>Ditetapkan di</td>
                            <td>:</td>
                            <td>Jakarta</td>
                        </tr>
                        <tr>
                            <td>pada tanggal</td>
                            <td>:</td>
                            <td><?php
                                $date = new DateTime('now');
                                echo $date->format('d F Y');
                            ?></td>
                        </tr>
                            <tr>
                            <td style="vertical-align: top; text-align: center; line-height: 2.5;" colspan="3">DIREKTUR JENDERAL PERHUBUNGAN DARAT,</td>
                        </tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <p style="margin: 0">{{ $data['name_dirjen'] }}</p>
                            </td>
                        </tr>
                        </table>
                </td>
            </tr>
        </table>
        <br>
        <br>
    </div>
   <br>

    <div class="row" style="page-break-after: always;">
        <table cellspacing="0" class="table" style="margin-top: 1.5rem; margin-left: 3rem; margin-right: auto" page-break-inside: always;>
            <tr>
                <td><u>SALINAN Keputusan Direktur Jenderal ini disampaikan kepada:</u></td>
            </tr>
            <tr>
                <td tyle="width: 20px;">1. Sekretaris Direktorat Jenderal Perhubungan Darat;</td>
            </tr>
            <tr>
                <td>2. Direktur Sarana Transportasi Jalan;</td>
            </tr>
            <tr>
                <td>3. Direktur Angkutan Jalan;</td>
            </tr>
            <tr>
                <td>4. Kepala Dinas Perhubungan Provinsi Jawa Barat;</td>
            </tr>
            <tr>
                <td>5. {{ Str::upper($data['companies_name']) }}</td>
            </tr>
        </table>
    </div>

    <div style="font-size: 18px; margin-left: 5rem; margin-top: 5rem; margin-right: 4rem;">
        <table>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KEEMPAT</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Dalam hal terjadi pelanggaran terhadap kewajiban sebagaimana dimaksud dalam DIKTUM KETIGA maka akan dikenai sanksi sesuai dengan ketentuan peraturan perundang-undangan.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KELIMA</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Direktur yang membidangi sarana transportasi jalan melakukan pembinaan dan pengawasan terhadap pelaksanaan Keputusan Direktur Jenderal Perhubungan Darat ini.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">KEENAM</td>
                <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:</td>
                <td style="vertical-align: text-top; padding: 0 5px;"></td>
                <td style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">Keputusan Direktur Jenderal Perhubungan Darat ini mulai berlaku pada tanggal ditetapkan.
                    <table cellspacing="0" align="right" class="table" style="margin-top: 5rem; margin-bottom: 0.5rem;">
                        <tr>
                            <td>Ditetapkan di</td>
                            <td>:</td>
                            <td>Jakarta</td>
                        </tr>
                        <tr>
                            <td>pada tanggal</td>
                            <td>:</td>
                            <td><?php
                                $date = new DateTime('now');
                                echo $date->format('d F Y');
                            ?></td>
                        </tr>
                            <tr>
                            <td style="vertical-align: top; text-align: center; line-height: 2.5;" colspan="3">DIREKTUR JENDERAL PERHUBUNGAN DARAT,</td>
                        </tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr><td>&nbsp;</td><td></td></tr>
                        <tr>
                            <td colspan="3" style="text-align: center">
                                <p style="margin: 0">{{ $data['name_dirjen'] }}</p>
                            </td>
                        </tr>
                        </table>
                </td>
            </tr>
        </table>
        <br>
        <br>
    </div>
   <br>

    <div class="row">
        <table cellspacing="0" class="table" style="margin-top: 1.5rem; margin-left: 3rem; margin-right: auto" page-break-inside: always;>
            <tr>
                <td><u>SALINAN Keputusan Direktur Jenderal ini disampaikan kepada:</u></td>
            </tr>
            <tr>
                <td tyle="width: 20px;">1. Sekretaris Direktorat Jenderal Perhubungan Darat;</td>
            </tr>
            <tr>
                <td>2. Direktur Sarana Transportasi Jalan;</td>
            </tr>
            <tr>
                <td>3. Direktur Angkutan Jalan;</td>
            </tr>
            <tr>
                <td>4. Kepala Dinas Perhubungan Provinsi Jawa Barat;</td>
            </tr>
            <tr>
                <td>5. {{ Str::upper($data['companies_name']) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
