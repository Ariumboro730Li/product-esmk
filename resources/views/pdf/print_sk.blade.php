```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Keputusan </title>
    <style>
        @font-face {
            font-family: 'Bookman';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: storage_path("fonts/Bookman.ttf") format("truetype");
        }

        @page {
            margin: 4rem 0 4rem 0;
        }

        body {
            font-family: "Bookman";
            font-size: 16px;
        }

        .table-border table {
            border-collapse: collapse;
            font-family: "Bookman";
            width: 100%;
        }

        .table-border td,
        th {
            border: 1px solid #000;
            /* padding: 3px 4px; */
        }
    </style>
</head>

<body>

    <div style="page-break-after: after;">

        <div style="text-align: center;">
            <img src="{{ $data['logo_garuda'] }}" alt="Cover" style="width: 5rem;" />
        </div>
        <p style="text-align: center; font-weight: bold;">BUPATI {{ Str::upper($data['kota']) }}</p>

        <div style="text-align: center;">
            <p style="padding: 0; margin: 0">KEPUTUSAN BUPATI {{ Str::upper($data['kota']) }}</p>
            <p style="padding: 0; margin: 0; letter-spacing: 0.05rem;">NOMOR: {{ $data['sk_number'] }}</p>
            <p style="padding: 0; margin: 1rem;letter-spacing: 0.5rem;">TENTANG</p>
            <p style="padding: 0; margin: 0;">PENETAPAN HASIL PENILAIAN DOKUMEN</p>
            <p style="padding: 0; margin: 0;">SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN ANGKUTAN UMUM</p>
            <p style="padding: 0; margin: 0;">{{ Str::upper($data['companies_name']) }}</p>
        </div>

        <p style="text-align: center; margin: 2rem 0 1rem 0">BUPATI {{ Str::upper($data['kota']) }},</p>

        <div style="font-size: 18px; margin-left: 5rem; margin-right: 4rem;">
            <table cellspacing="0" class="table" style=" width: 100%;">
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">
                        Menimbang
                    </td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        a.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        bahwa berdasarkan Peraturan Pemerintah Nomor 85 Tahun 2018 pasal 5 ayat (1) bahwa Sistem
                        Manajemen Keselamatan Perusahaan Angkutan Umum meliputi 10 (sepuluh) elemen serta pada pasal 9
                        ayat (2) bahwa berdasarkan hasil penilaian tim penilai Dokumen Sistem Manajemen Keselamatan
                        Perusahaan Angkutan Umum dinyatakan memenuhi atau tidak memenuhi;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        b.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        bahwa berdasarkan hasil penilaian oleh Tim Penilai Sistem Manajemen Keselamatan Perusahaan
                        Angkutan Umum, dinyatakan bahwa <b>{{ Str::upper($data['companies_name']) }}</b> telah menyusun
                        dan melaksanakan {{ $data['count_element'] }}
                        ({{ trim($data['penyebut']($data['count_element'])) }}) elemen Sistem Manajemen Keselamatan
                        Perusahaan Angkutan Umum;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        c.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 1.5rem 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a dan huruf b, perlu menetapkan
                        Keputusan Bupati {{ $data['kota'] }} tentang Penetapan Hasil Penilaian Dokumen Sistem Manajemen
                        Keselamatan Perusahaan Angkutan Umum <b>{{ Str::upper($data['companies_name']) }}; </b>
                    </td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">
                        Mengingat
                    </td>
                    <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">:
                    </td>
                    <td style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem;">1.
                    </td>
                    <td
                        style="vertical-align: text-top; padding: 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Undang-Undang Nomor 22 Tahun 2009 tentang Lalu Lintas dan Angkutan Jalan (Lembaran Negara
                        Republik Indonesia Tahun 2009 Nomor 96, Tambahan Lembaran Negara Republik Indonesia Nomor 5025);
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        2.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintah Daerah;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        3.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Peraturan Pemerintah Nomor 74 Tahun 2014 tentang Angkutan Jalan;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        4.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Peraturan Pemerintah Nomor 37 Tahun 2017 tentang Keselamatan Lalu Lintas dan Angkutan Jalan;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        5.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Peraturan Menteri Perhubungan Nomor 85 Tahun 2018 tentang Sistem Manajemen Keselamatan
                        Perusahaan Angkutan Umum;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        6.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Peraturan Bupati {{ $data['provinsi'] }} Nomor 13 Tahun 2020 tentang Kedudukan, Susunan
                        Organisasi, Uraian Tugas dan Fungsi serta Tata Kerja Dinas Perhubungan Provinsi
                        {{ $data['provinsi'] }};
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top; padding: 0 5px 1rem 0;"></td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        7.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 1rem 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Keputusan Direktur Jenderal Perhubungan Darat Nomor KP.1990/AJ.503/2019 tentang Tata Cara
                        Penilaian Sistem Manajemen Keselamatan Perusahaan Angkutan Umum.
                    </td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">
                        Memperhatikan</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        a.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Surat Direktur Utama {{ $data['companies_name'] }} Nomor:
                        {{ $data['number_of_application_letter'] }} tanggal {{ $data['date_of_application_letter'] }}
                        perihal Permohonan Penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum;
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top;"></td>
                    <td style="vertical-align: text-top;"></td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        b.</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 0 8rem 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                        Berita Acara Hasil Penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum Nomor
                        : {{ $data['rov_number'] }} tanggal {{ $data['interview_schedule'] }};
                    </td>
                </tr>
                <tr>
                    <td colspan="4"
                        style="text-align: center; vertical-align: text-top; line-height: 2.5; width: 130px; font-weight: bold;">
                        MEMUTUSKAN :</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">
                        Menetapkan</td>
                    <td
                        style="vertical-align: text-top; padding: 0 5px 0 0;; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; text-align: justify; text-justify: auto; font-weight: bold;">
                        KEPUTUSAN BUPATI {{ Str::upper($data['kota']) }} TENTANG PENETAPAN HASIL PENILAIAN DOKUMEN
                        SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN ANGKUTAN UMUM {{ Str::upper($data['companies_name']) }}
                    </td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0 5px 0 0; line-height: 2; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        PERTAMA</td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0; line-height: 2; ">:</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0; line-height: 2; text-align: justify; text-justify: auto;">
                        Menetapkan bahwa&nbsp;:</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px;">
                    </td>
                    <td style="vertical-align: text-top; padding: 0 5px 0 0;"></td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 0 0 0; line-height: 1.55; letter-spacing: 0.05rem;text-justify: auto;">
                        <table cellspacing="0" class="table" page-break-inside: always;>
                            <tr>
                                <td style="vertical-align: text-top; width: 150px !important;">Nama Perusahaan</td>
                                <td style="vertical-align: text-top; ">:</td>
                                <td style="vertical-align: text-top; padding: 0 5px;">
                                    {{ Str::upper($data['companies_name']) }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: text-top; width: 170px !important;">Alamat Perusahaan</td>
                                <td style="vertical-align: text-top;">:</td>
                                <td
                                    style="vertical-align: text-top; width: 250px !important; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                                    {{ $data['address'] }}</td>
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
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0; width: 130px;"></td>
                    <td style="vertical-align: text-top; padding: 0.25rem 5px 0 0"></td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Telah memenuhi {{ $data['count_element'] }}
                        ({{ trim($data['penyebut']($data['count_element'])) }}) elemen dan diberikan Sertifikat Sistem
                        Manajemen Keselamatan Perusahaan Angkutan Umum.</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        KEDUA</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Perusahaan Angkutan Umum sebagaimana dimaksud pada DIKTUM PERTAMA telah memenuhi
                        {{ $data['count_element'] }} ({{ trim($data['penyebut']($data['count_element'])) }}) elemen
                        meliputi:
                        <table cellspacing="0" style="width: 100%">
                            @php $alphabet = range('a', 'z'); @endphp
                            @foreach ($data['element_titles'] as $index => $title)
                                <tr>
                                    <td style="vertical-align: text-top; padding: 0 5px;">{{ $alphabet[$index] }}.
                                    </td>
                                    <td
                                        style="vertical-align: text-top; padding: 0 5px; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify;">
                                        {{ $title }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>

                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        KETIGA</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Perusahaan Angkutan Umum yang telah mendapatkan Sertifikat Sistem Manajemen Keselamatan
                        Perusahaan Angkutan Umum sebagaimana DIKTUM PERTAMA wajib melaksanakan dan menyempurnakan Sistem
                        Manajemen Keselamatan Perusahaan Angkutan Umum serta melaporkan hasil pelaksanaannya kepada
                        Bupati {{ $data['kota'] }}.</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        KEEMPAT</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Dalam hal terjadi pelanggaran terhadap kewajiban sebagaimana dimaksud dalam DIKTUM KETIGA, maka
                        Keputusan Penetapan Hasil Penilaian dan Sertifikat Sistem Manajemen Keselamatan Perusahaan
                        Angkutan Umum sebagaimana dimaksud dalam DIKTUM PERTAMA dicabut.</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        KELIMA</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Keputusan Penetapan Hasil Penilaian dan Sertifikat Sistem Manajemen Keselamatan Perusahaan
                        Angkutan Umum berlaku selama 5 (lima) tahun selama Perusahaan Angkutan Umum masih menjalankan
                        usaha di bidang angkutan umum sesuai izin penyelenggaraan angkutan umum yang diberikan.</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        KEENAM</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Kepala Dinas Perhubungan {{ $data['kota'] }} melakukan pembinaan dan pengawasan terhadap
                        pelaksanaan Keputusan Bupati ini.</td>
                </tr>
                <tr>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; width: 130px; font-weight: bold;">
                        KETUJUH</td>
                    <td
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem;">
                        :</td>
                    <td colspan="2"
                        style="vertical-align: text-top; padding: 0.25rem 5px 0 0; line-height: 1.55; letter-spacing: 0.05rem; text-align: justify; text-justify: auto;">
                        Keputusan Bupati ini mulai berlaku pada tanggal ditetapkan.</td>
                </tr>
            </table>
        </div>
        <div style="float:right;font-size: 18px; margin-left: 5rem; margin-right: 5rem;">
            <table cellspacing="0" class="table" style="width: 100%; margin-top: 5rem; margin-bottom: 0.5rem;">
                <tr>
                    <td>Ditetapkan di</td>
                    <td>:</td>
                    <td>{{ $data['kota'] }}</td>
                </tr>
                <tr>
                    <td>Pada tanggal</td>
                    <td>:</td>
                    <td>{{ $data['current_date'] }}</td>
                </tr>
            </table>
            <table cellspacing="0" class="table" style="margin-bottom: 0.5rem;">
                <tr>
                    <td style="vertical-align: top; text-align: center; line-height: 2.5;" colspan="3">Kepala
                        {{ $data['nama_instansi'] }},</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center">
                        <p style="margin: 0">{{ $data['name_dirjen'] }}</p>
                        <p style="margin: 0">{{ $data['identity_number'] }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>

```
