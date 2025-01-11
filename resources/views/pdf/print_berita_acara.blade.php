<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table-border table {
            border-collapse: collapse;
            font-family: Calibri, Helvetica, sans-serif;
            width: 100%;
        }

        .table-border td,
        th {
            border: 1px solid #000;
            padding: 3px 4px;
        }

        .center-text {
            text-align: center;
        }

        .table-border th {
            font-weight: bold;
        }

        /* Specific padding adjustments for signatures */
        .signature-cell {
            padding: 20px 5px;
        }
    </style>
</head>

<body>
    <div>
        <img src="{{ $logo }}" alt="Cover" style="width: 100%;" />
    </div>

    <div style="margin-top: 1.5rem; margin-left: 3rem; margin-right: 3rem; font-size: 16px">
        <div style="text-align: center; font-weight: bold">
            <p style="padding: 0; margin: 0">BERITA ACARA HASIL PENILAIAN DOKUMEN</p>
            <p style="padding: 0; margin: 0">SISTEM MANAJEMEN KESELAMATAN PERUSAHAAN ANGKUTAN UMUM</p>
            <p style="padding: 0; margin: 0">Nomor : {{ $number_of_letter }}</p>
        </div>

        <p style="margin-top: 1.5rem; text-align: justify">Pada Hari ini, {{ $schedule_day }} tanggal
            <b>{{ $schedule_day_text }}</b> bulan <b>{{ $schedule_month }}</b> tahun <b>{{ $schedule_year }}</b>,
            bertempat di Kantor {{ $company_name }} telah dilaksanakan Penilaian Dokumen Sistem Manajemen Keselamatan
            Perusahaan Angkutan Umum oleh :
        </p>

        <table cellspacing="0" style="margin-top: 1.5rem; margin-left: auto; margin-right: auto">
            <tr>
                <td style="padding: 0;">Tim Penilai Dokumen</td>
                <td style="padding: 0; text-align: center">:</td>
                <td style="padding: 0;">1. {{ $assessor_head }}</td>
            </tr>
            @foreach ($assessors as $assessor)
                <tr>
                    <td style="padding: 0;"></td>
                    <td style="padding: 0;"></td>
                    <td style="padding: 0;">{{ $loop->iteration + 1 }}. {{ $assessor->name }}</td>
                </tr>
            @endforeach
        </table>

        <div style="margin-top: 1.5rem;">
            <p>Kepada <b>{{ $company_name }}</b> yang beralamat di
                <b>{{ $company_address }}</b>.
            </p>

            <p>Adapun hasil Penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan
                Angkutan Umum adalah sebagai berikut :
            </p>
        </div>

        <table cellspacing="0" class="table-border"
            style="margin-top: 1.5rem; width: 100%; page-break-inside: always; font-size: 12px;">
            <tr>
                <th class="center-text">NO.</th>
                <th class="center-text">ELEMEN</th>
                <th class="center-text">TOTAL NILAI</th>
                <th class="center-text">MEMENUHI</th>
                <th class="center-text">TIDAK MEMENUHI</th>
                <th class="center-text">KETERANGAN</th>
            </tr>

            @foreach ($elementTitles as $key => $title)
                <tr>
                    <td class="center-text">{{ $loop->iteration }}.</td>
                    <td>{{ $title }}</td>
                    <td class="center-text">{{ isset($nilai[$key]) ? $nilai[$key] : '-' }}</td>
                    <td class="center-text">
                        @if (isset($nilai[$key]) && $nilai[$key] > 5)
                            v
                        @endif
                    </td>
                    <td class="center-text">
                        @if (isset($nilai[$key]) && $nilai[$key] <= 5)
                            v
                        @endif
                    </td>
                    <td class="center-text"></td>
                </tr>
            @endforeach


            <tr>
                <th colspan="2">Total Penilaian Seluruh Dokumen</th>
                <th colspan="4" class="center-text">
                    @if ($nilai->count() > 0)
                        {{-- Hitung rata-rata nilai dan kalibrasi ke skala 100% --}}
                        {{ round(($nilai->sum() / ($nilai->count() * 10)) * 100, 2) }}%
                    @else
                        0%
                    @endif
                </th>
            </tr>

        </table>



        <br /><br /><br /><br />

        <p style="font-size: 15px">Hasil penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum
            <b>{{ $company_name }}</b>, sebagaimana Lampiran Berita Acara ini.
        </p>

        <div style="margin-top: 1.5rem">
            <span>Kesimpulan :</span>
            <ol style="margin: 0">
                <li>Dokumen Sistem Manajemen Keselamatan Perusahaan Angkutan Umum ini agar
                    selalu diterapkan dalam kegiatan operasional perusahaan.
                </li>
                <li>Setiap 1 (satu) tahun sekali perusahaan wajib melaporkan dokumen terkini
                    ke Direktorat Sarana Transportasi Darat, Ditjen Hubdat.
                </li>
            </ol>
        </div>

        <p style="margin-top: 1.5rem">Demikian Berita Acara Penilaian Dokumen Sistem Manajemen Keselamatan Perusahaan
            Angkutan Umum ini dibuat untuk digunakan sebagaimana mestinya.
        </p>
        <div style="page-break-after: always;"></div>
        <div style="text-align: center; font-weight: bold">
            <p style="padding: 0; margin: 0; margin-bottom: 10px">Tim Penilai Dokumen</p>
            <p style="padding: 0; margin: 0">Sistem Manajemen Keselamatan Perusahaan Angkutan Umum</p>
        </div>

        <table cellspacing="0" class="table-border" style="width: 100%">
            <tr>
                <th>NO.</th>
                <th>NAMA</th>
                <th>TANDA TANGAN</th>
            </tr>

            <tr>
                <td>1.</td>
                <td>{{ $assessor_head }}</td>
                <td style="padding: 20px 5px;">1.</td>
            </tr>

            @foreach ($assessors as $assessor)
                $style
                <tr>
                    <td>{{ $loop->iteration + 1 }}.</td>
                    <td>{{ $assessor->name }}</td>
                    <td
                        style="{{ $loop->iteration % 2 == 0 ? 'padding: 20px 5px;' : 'padding: 20px 5px; text-align: center' }}">
                        {{ $loop->iteration + 1 }}.</td>
                </tr>
            @endforeach
        </table>

        <br /><br /><br />

        <table cellspacing="0" style="width: 100%">
            <tr>
                <td style="text-align: center">Mengetahui,</td>
                <td style="text-align: center">Mengetahui,</td>
            </tr>

            <tr>
                <td style="text-align: center">
                    <p style="margin: 0">{{ $company_name }}</p>
                    <p style="margin: 0">a.n. Presiden Direktur</p>
                </td>
                <td style="text-align: center; vertical-align: top">KETUA TIM PENILAI</td>
            </tr>

            <tr>
                <td colspan="2" style="height: 100px;"></td>
            </tr>

            <tr>
                <td style="text-align: center; vertical-align: top">{{ $company_pic }}</td>
                <td style="text-align: center">
                    <p style="margin: 0">{{ $assessor_head }}</p>
                    <p style="margin: 0">NIP. {{ $assessor_head_nip }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
