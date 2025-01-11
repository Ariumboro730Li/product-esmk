@extends('...Internal.index', ['title' => 'Detail | Data Perusahaan'])
@section('asset_css')
    <link rel="icon" href="{{ asset('assets') }}/images/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/datepicker-bs5.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link" />
    <script src="{{ asset('assets') }}/js/tech-stack.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <style>
        .custom-icon {
            font-size: 30px !important;
        }

        .custom-text {
            text-align: -webkit-left;
        }

        .number-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 40px;
            background-color: #6c757d;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }

        .nav-link .fw-bold {
            font-size: 16px;
            font-weight: bold;
        }

        .nav-link.active .number-box {
            background: none;
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/internal/dashboard-internal">Home</a></li>
                        <li class="breadcrumb-item"><a href="/internal/laporan-tahunan/list">Laporan Tahunan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail Laporan Tahunan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Detail Laporan Tahunan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row align-items-center g-3">
                                <div class="col-lg-8 col-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="col-sm-auto mb-3 mb-sm-0 me-3">
                                            <div class="d-sm-inline-block d-flex align-items-center">
                                                <div
                                                    class="wid-60 hei-60 rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-building text-white fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex flex-column flex-sm-row align-items-center">
                                                <h4 class="d-inline-block mb-0 me-2">PT TRISTAR JAVA TRANSINDO |</h4>
                                                <p class="mb-0"><b>NIB : 9120109831421</b></p>
                                            </div>



                                            <!-- Nomor telepon dan informasi lainnya di bawah h4 dan p -->
                                            <div class="help-sm-hidden">
                                                <ul class="list-unstyled mt-0 mb-0 text-muted">
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fa-solid fa-phone me-1"></i>
                                                        +6289 4562 8963
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fa-regular fa-envelope me-1"></i>
                                                        tristarjava@mail.com
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fa-solid fa-location-dot me-1"></i>
                                                        Street 110-B Kalians Bag, Dewan, M.P. New York
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Jenis Pelayanan</h5>
                                <ol>
                                    <li>AJAP</li>
                                    <li>Angkutan barang umum</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Penanggung Jawab</h5>
                                <p class="mb-0"><i class="fa-solid fa-user me-2"></i>Ang Hoey Tiong</p>
                                <p class="mb-0"><i class="fa-solid fa-phone me-2"></i>(970) 982-3353</p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Informasi Pengguna</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="mb-0"><i class="fa-solid fa-circle-user me-2"></i>Anghoey</p>
                                        <p class="mb-0"><i class="fa-solid fa-phone me-2"></i>(970) 982-3353</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i>anghoey.conn@borer.com
                                        </p>
                                        <p class="mb-0"><i class="fa-solid fa-calendar-day me-2"></i>25 Maret 2023</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div id="basicwizard" class="form-wizard row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-3">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item mb-lg-0 mb-3" data-target-form="#contactDetailForm">
                                    <a href="#1.1Detail" data-bs-toggle="tab" data-toggle="tab" class="nav-link active">
                                        <div class="d-flex align-items-center">
                                            <span class="number-box me-2">1</span>
                                            <span class="fw-bold f-16 ms-2 custom-text">Komitmen dan Kebijakan
                                                Keselamatan</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item mb-lg-0 mb-3" data-target-form="#jobDetailForm">
                                    <a href="#2.1Detail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <div class="d-flex align-items-center">
                                            <span class="number-box me-2">2</span>
                                            <span class="fw-bold f-16 ms-2 custom-text">Pengorganisasian</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item mb-lg-0 mb-3" data-target-form="#educationForm">
                                    <a href="#3.1Detail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <div class="d-flex align-items-center">
                                            <span class="number-box me-2">3</span>
                                            <span class="fw-bold f-16 ms-2 custom-text">Manajemen Bahaya Dan
                                                Risiko</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item mb-lg-0 mb-3" data-target-form="#jobDetailForm">
                                    <a href="#4.1Detail" data-bs-toggle="tab" data-toggle="tab"
                                        class="nav-link icon-btn">
                                        <div class="d-flex align-items-center">
                                            <span class="number-box me-2">4</span>
                                            <span class="fw-bold f-16 ms-2 custom-text">Fasilitas Pemeliharaan Dan
                                                Perbaikan</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="1.1Detail">
                                    <form id="contactForm" method="get">
                                        <div class="text-center">
                                            <h3 class="mb-2">Komitmen dan Kebijakan Keselamatan</h3>
                                        </div>
                                        <div class="table-responsive py-5">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Uraian</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawab</th>
                                                        <th>Kesesuaian</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1.1</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Deskripsi Komitmen dan Kebijakan Keselamatan (Persyaratan,
                                                            Ekspektasi, Implementasi, Prosedur Terkait)</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1.2</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Perusahaan mempunyai komitmen yang kuat dari Manajemen yang
                                                            terdokumentasikan, tertulis dan ditandatangani oleh Pimpinan
                                                            Perusahaan tertinggi sebagai langkah nyata terhadap aspek
                                                            keselamatan yang ditunjukkan dalam sikap sehari-hari</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Apakah terdapat perubahan pada dokumen Komitmen</td>
                                                        <td>Tidak ada perubahan</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>1.2</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Perusahaan mempunyai komitmen yang kuat dari Manajemen yang
                                                            terdokumentasikan, tertulis dan ditandatangani oleh Pimpinan
                                                            Perusahaan tertinggi sebagai langkah nyata terhadap aspek
                                                            keselamatan yang ditunjukkan dalam sikap sehari-hari</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Apakah terdapat perubahan pada dokumen Komitmen</td>
                                                        <td>
                                                            <a href="">
                                                                <p class="mb-0"><i
                                                                        class="fa-regular fa-file-pdf me-1"></i><label
                                                                        class="mb-0">Lihat Dokumen</label></p>
                                                            </a>
                                                        </td>
                                                        <td><span class="badge bg-light-success">Sesuai</span></td>
                                                        <td>-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="2.1Detail">
                                    <form id="jobForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Pengorganisasian</h3>
                                        </div>
                                        <div class="table-responsive py-5">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Uraian</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawab</th>
                                                        <th>Kesesuaian</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>2.1</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Deskripsi Pengorganisasian</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2.2</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Perusahaan mempunyai struktur organisasi pengelolaan di bidang
                                                            keselamatan, seperti Unit Manajemen Keselamatan atau Petugas
                                                            Keselamatan</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Apakah terdapat perubahan pada dokumen Komitmen</td>
                                                        <td>Tidak ada perubahan</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2.3</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Perusahaan dapat menjabarkan uraian tugas dan fungsi di
                                                            masing-masing jabatan pada struktur organisasi hubungan antar
                                                            struktur organisasi tersebut</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Apakah terdapat perubahan pada dokumen Komitmen</td>
                                                        <td>
                                                            <a href="">
                                                                <p class="mb-0"><i
                                                                        class="fa-regular fa-file-pdf me-1"></i><label
                                                                        class="mb-0">Lihat Dokumen</label></p>
                                                            </a>
                                                        </td>
                                                        <td><span class="badge bg-light-success">Sesuai</span></td>
                                                        <td>-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="3.1Detail">
                                    <form id="educationForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Manajemen Bahaya Dan Risiko</h3>
                                        </div>
                                        <div class="table-responsive py-5">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Uraian</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawab</th>
                                                        <th>Kesesuaian</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>3.1</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Deskripsi Manajemen Bahaya dan Risiko (Persyaratan, Ekspektasi,
                                                            Implementasi, Prosedur Terkait)</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.2</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Perusahaan telah memiliki prosedur identifikasi bahaya,
                                                            penilaian dan pengendalian risiko secara komprehensif baik
                                                            terhadap personel, sarana angkutan, penumpang maupun lingkungan
                                                            untuk setiap tahapan operasi pengangkutan</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Apakah terdapat perubahan pada dokumen Struktur Organisasi</td>
                                                        <td>Tidak ada perubahan</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3.3</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Perusahaan telah melakukan identifikasi bahaya, penilaian dan
                                                            pengendaliannya dengan metode yang sesuai dengan karakteristik
                                                            bahaya yang ada, memiliki matrik penilaian bahaya dan risiko,
                                                            matrik identifikasi bahaya, penilaian dan pengendalian risiko di
                                                            kantor, bengkel dan operasional serta matrik identifikasi bahaya
                                                            lalu lintas</td>
                                                        <td
                                                            style="word-wrap: break-word; white-space: normal; max-width: 300px;">
                                                            Apakah terdapat perubahan pada dokumen Komitmen</td>
                                                        <td>
                                                            <a href="">
                                                                <p class="mb-0"><i
                                                                        class="fa-regular fa-file-pdf me-1"></i><label
                                                                        class="mb-0">Lihat Dokumen</label></p>
                                                            </a>
                                                        </td>
                                                        <td><span class="badge bg-light-success">Sesuai</span></td>
                                                        <td>-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="4.1Detail">
                                    <form id="jobForm" method="post" action="#">
                                        <div class="text-center">
                                            <h3 class="mb-2">Fasilitas Pemeliharaan Dan Perbaikan</h3>
                                        </div>
                                        <div class="table-responsive py-5">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Uraian</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawab</th>
                                                        <th>Kesesuaian</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>4.1</td>
                                                        <td>Deskripsi Fasilitas Pemeliharaan dan Perbaikan (Persyaratan,
                                                            Ekspektasi, Implementasi, Prosedur Terkait</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4.2</td>
                                                        <td>Perusahaan melengkapi kegiatan operasional angkutan dengan
                                                            menyediakan fasilitas pemeliharaan dan perbaikan kendaraan
                                                            bermotor sebagai syarat utama keselamatan dan perbaikan
                                                            kendaraan bermotor yang digunakan untuk mendukung kegiatan
                                                            perusahaan</td>
                                                        <td>Apakah terdapat perubahan dokumen prosedur pengoperasian
                                                            kendaraan</td>
                                                        <td>-</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4.3</td>
                                                        <td>Pemeliharaan dan perbaikan kendaraan dengan penyediaan sarana
                                                            dan prasarana pendukung yang memadai untuk mendukung keselamatan
                                                            seperti bengkel, klinik, ruang istirahat pengemudi, ruang
                                                            parkir, fasilitas penyimpanan suku cadang dan lain-lain</td>
                                                        <td>Apakah terdapat perubahan pada dokumen Komitmen</td>
                                                        <td>
                                                            <a href="">
                                                                <p class="mb-0"><i
                                                                        class="fa-regular fa-file-pdf me-1"></i><label
                                                                        class="mb-0">Lihat Dokumen</label></p>
                                                            </a>
                                                        </td>
                                                        <td><span class="badge bg-light-success">Sesuai</span></td>
                                                        <td>-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="finish">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-lg-6">
                                            <div class="text-center">
                                                <i class="ph-duotone ph-gift f-50 text-danger"></i>
                                                <h3 class="mt-4 mb-3">Thank you !</h3>
                                                <div class="mb-3">
                                                    <div class="form-check d-inline-block">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="customCheck1" />
                                                        <label class="form-check-label" for="customCheck1">I agree with
                                                            the Terms
                                                            and Conditions</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex wizard justify-content-center flex-wrap gap-2 mt-3">
                                    <div class="d-flex">
                                        <div class="previous me-2">
                                            <button type="button" class="btn btn-secondary kembali"> Kembali </button>
                                        </div>
                                        <div class="next me-2">
                                            <button type="button" class="btn btn-primary selanjutnya"> Selanjutnya
                                            </button>
                                        </div>
                                        <div class="save">
                                            <button type="button" class="btn btn-success simpan"> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Define your controller buttons here-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets') }}/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/js/pages/invoice-list.js"></script>
    <script src="../assets/js/plugins/datepicker-full.min.js"></script>
    <script src="../assets/js/pages/ac-datepicker.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var options17 = {
            series: [30],
            chart: {
                height: 150,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '60%',
                        background: 'transparent',
                        imageOffsetX: 0,
                        imageOffsetY: 0,
                        position: 'front'
                    },
                    track: {
                        background: '#4680FF50',
                        strokeWidth: '50%'
                    },

                    dataLabels: {
                        show: true,
                        name: {
                            show: false
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val);
                            },
                            offsetY: 7,
                            color: '#4680FF',
                            fontSize: '20px',
                            fontWeight: '700',
                            show: true
                        }
                    }
                }
            },
            colors: ['#4680FF'],
            fill: {
                type: 'solid'
            },
            stroke: {
                lineCap: 'round'
            }
        };
        var chart = new ApexCharts(document.querySelector('#total-earning-graph-1'), options17);
        chart.render();

        var options18 = {
            series: [30], // Persentase atau nilai yang ingin ditampilkan
            chart: {
                height: 150,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '60%',
                        background: 'transparent',
                        imageOffsetX: 0,
                        imageOffsetY: 0,
                        position: 'front'
                    },
                    track: {
                        background: '#28A74550', // Ganti dengan warna hijau transparan (hijau 50% opacity)
                        strokeWidth: '50%' // Lebar track
                    },
                    dataLabels: {
                        show: true,
                        name: {
                            show: false
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val); // Format nilai menjadi integer
                            },
                            offsetY: 7,
                            color: '#28A745', // Ganti dengan warna hijau
                            fontSize: '20px',
                            fontWeight: '700',
                            show: true
                        }
                    }
                }
            },
            colors: ['#28A745'], // Ganti warna grafik menjadi hijau
            fill: {
                type: 'solid' // Isi grafik menggunakan warna solid
            },
            stroke: {
                lineCap: 'round' // Stroke dengan ujung membulat
            }
        };

        // Render chart
        var chart = new ApexCharts(document.querySelector('#total-earning-graph-2'), options18);
        chart.render();


        var options19 = {
            series: [30],
            chart: {
                height: 150,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '60%',
                        background: 'transparent',
                        imageOffsetX: 0,
                        imageOffsetY: 0,
                        position: 'front'
                    },
                    track: {
                        background: '#DC262650',
                        strokeWidth: '50%'
                    },

                    dataLabels: {
                        show: true,
                        name: {
                            show: false
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val);
                            },
                            offsetY: 7,
                            color: '#DC2626',
                            fontSize: '20px',
                            fontWeight: '700',
                            show: true
                        }
                    }
                }
            },
            colors: ['#DC2626'],
            fill: {
                type: 'solid'
            },
            stroke: {
                lineCap: 'round'
            }
        };
        var chart = new ApexCharts(document.querySelector('#total-earning-graph-3'), options19);
        chart.render();

        var options20 = {
            series: [30],
            chart: {
                height: 150,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 0,
                        size: '60%',
                        background: 'transparent',
                        imageOffsetX: 0,
                        imageOffsetY: 0,
                        position: 'front'
                    },
                    track: {
                        background: '#28A74550', // Warna latar belakang track tetap merah muda
                        strokeWidth: '50%'
                    },

                    dataLabels: {
                        show: true,
                        name: {
                            show: false
                        },
                        value: {
                            formatter: function(val) {
                                return parseInt(val);
                            },
                            offsetY: 7,
                            color: '#006400', // Ubah warna teks menjadi hijau tua
                            fontSize: '20px',
                            fontWeight: '700',
                            show: true
                        }
                    }
                }
            },
            colors: ['#006400'], // Ubah warna grafik menjadi hijau tua
            fill: {
                type: 'solid'
            },
            stroke: {
                lineCap: 'round'
            }
        };
        var chart = new ApexCharts(document.querySelector('#total-earning-graph-4'), options20);
        chart.render();

        document.addEventListener("click", (e) => {
            if (e.target.classList.contains('selanjutnya')) {
                let currentTab = document.querySelector('.tab-pane.active');
                let nextTab = currentTab.nextElementSibling;

                if (nextTab) {
                    currentTab.classList.remove('show', 'active');
                    nextTab.classList.add('show', 'active');
                }
            }

            if (e.target.classList.contains('kembali')) {
                let currentTab = document.querySelector('.tab-pane.active');
                let prevTab = currentTab.previousElementSibling;

                if (prevTab) {
                    currentTab.classList.remove('show', 'active');
                    prevTab.classList.add('show', 'active');
                }
            }
        });

        $(document).on("click", ".collapse-filter", function() {
            $("#collapseFilter").toggle(500);
        });
    </script>
@endsection