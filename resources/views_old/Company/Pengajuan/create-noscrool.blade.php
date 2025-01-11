@extends('...Company.index', ['title' => 'Form Pengajuan Sertifikat | SMK-TD'])
@section('asset_css')
    
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/company/dashboard-company">Home</a></li>
                        <li class="breadcrumb-item"><a href="/company/pengajuan-sertifikat/list">Pengajuan Sertifikat</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Form Pengajuan Sertifikat</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Form Pengajuan Sertifikat</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="basicwizard" class="form-wizard row justify-content-center">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body p-3">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item" data-target-form="#formDocuments">
                            <a href="#formDocuments" data-bs-toggle="tab" data-toggle="tab" class="nav-link active">
                                <span class="d-none d-sm-inline fw-bold f-18"><i
                                        class="fa-solid fa-file-lines me-2"></i></span>
                            </a>
                        </li>
                        <li class="nav-item" data-target-form="#1detail">
                            <a href="#1.1Detail" data-bs-toggle="tab" data-toggle="tab" class="nav-link icon-btn">
                                <span class="d-none d-sm-inline fw-bold f-18"><i class="fa-solid fa-shield me-2">
                                    </i>1.1</span>
                            </a>
                        </li>
                        <li class="nav-item" data-target-form="#2detail">
                            <a href="#2.1Detail" data-bs-toggle="tab" data-toggle="tab" class="nav-link icon-btn">
                                <span class="d-none d-sm-inline fw-bold f-18"><i class="fa-solid fa-shield me-2">
                                    </i>2.1</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="formDocuments">
                            <form id="formDocuments" method="get">
                                <div class="text-center">
                                    <h3 class="mb-4">Dokumen/Form Yang Harus Dilengkapi</h3>
                                </div>
                                <div class="row mt-5">
                                    <!-- Jenis Pelayanan -->
                                    <div class="col-12 mb-4">
                                        <div class="form-floating">
                                            <select class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" disabled>
                                                <option selected>AJAP</option>
                                                <option value="1">AJAP</option>
                                            </select>
                                            <label for="floatingSelect">Jenis Pelayanan</label>
                                        </div>
                                    </div>
                                    <!-- Nomor Surat -->
                                    <div class="col-lg-6 col-12 mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="nomorSurat" placeholder="" />
                                            <label for="nomorSurat">Nomor Surat</label>
                                        </div>
                                    </div>
                                    <!-- Tanggal Surat -->
                                    <div class="col-lg-6 col-12 mb-4">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="tanggalSurat" />
                                            <label for="tanggalSurat">Tanggal Surat</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-4">
                                        <label class="mb-2">Upload Surat Permohonan Penilaian</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" />
                                            <small class="text-muted">Maksimal ukuran file 5 MB.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-4 d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avtar avtar-xs btn-light-primary">
                                                    <a href="path/to/template-surat.pdf"
                                                        download="Template_Surat_Permohonan_Penilaian.pdf"
                                                        title="Download Template">
                                                        <i class="f-16 fa-solid fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">Unduh Template Surat Permohonan Penilaian</h6>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="1.1Detail">
                            <form id="1detail" method="post" action="#">
                                <div class="text-center">
                                    <h3 class="mb-2">Komitmen dan Kebijakan Keselamatan</h3>
                                    <small style="color: blue">Maksimal ukuran file yang diunggah 5 MB.</small>
                                </div>
                                <div class="table-responsive py-5">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Uraian</th>
                                                <th>Dokumen / Bukti Dukungan Jawaban</th>
                                                <th>Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.1</td>
                                                <td>Deskripsi Komitmen dan Kebijakan Keselamatan (Persyaratan, Ekspektasi, Implementasi, Prosedur Terkait)</td>
                                                <td>Deskripsi Komitmen dan Kebijakan Keselamatan</td>
                                                <td>File Deskripsi Komitmen dan Kebijakan Keselamatan Persyaratan, Ekspektasi, Implementasi, Prosedur Terkait
                                                    <div class="col-lg-6 col-12 mb-4">
                                                        <label class="mb-2">Upload Surat Permohonan Penilaian</label>
                                                        <div class="mb-3">
                                                            <input class="form-control" type="file" />
                                                            <small class="text-muted">Maksimal ukuran file 5 MB.</small>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1.2</td>
                                                <td>Perusahaan mempunyai komitmen yang kuat dari Manajemen yang terdokumentasikan, tertulis dan ditandatangani oleh Pimpinan Perusahaan tertinggi sebagai lamngkah nyata terhadap aspek keselamatan yang ditunjukkan dalam sikap sehari-hari</td>
                                                <td>Bukti Pernyataan Dokumen (foto pernyataan komitmen)</td>
                                                <td>File Dokumen Komitmen
                                                    <div class="col-lg-6 col-12 mb-4">
                                                        <label class="mb-2">Upload Surat Permohonan Penilaian</label>
                                                        <div class="mb-3">
                                                            <input class="form-control" type="file" />
                                                            <small class="text-muted">Maksimal ukuran file 5 MB.</small>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="2.1Detail">
                            <form id="2detail" method="post" action="#">
                                <div class="text-center">
                                    <h3 class="mb-2">Pengorganisasian</h3>
                                    <small style="color: blue">Maksimal ukuran file yang diunggah 5 MB.</small>
                                </div>
                                <div class="table-responsive py-5">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Uraian</th>
                                                <th>Dokumen / Bukti Dukungan Jawaban</th>
                                                <th>Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2.1</td>
                                                <td>Deskripsi Pengorganisasian</td>
                                                <td>Deskripsi Pengorganisasian (Persyaratan, Ekspektasi, Implementasi, Prosedur Terkait)</td>
                                                <td>File Deskripsi Komitmen dan Kebijakan Keselamatan Persyaratan, Ekspektasi, Implementasi, Prosedur Terkait
                                                    <div class="col-lg-6 col-12 mb-4">
                                                        <label class="mb-2">Upload Surat Permohonan Penilaian</label>
                                                        <div class="mb-3">
                                                            <input class="form-control" type="file" />
                                                            <small class="text-muted">Maksimal ukuran file 5 MB.</small>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2.2</td>
                                                <td>Perusahaan mempunyai struktur organisasi pengelolaan di bidang keselamatan, seperti Unit Manajemen Keselamatan atau Petugas Keselamatan</td>
                                                <td>Dokumen struktur organisasi Unit Manajemen Keselamatan Petugas Keselamatan</td>
                                                <td>File Struktur Organisasi
                                                    <div class="col-lg-6 col-12 mb-4">
                                                        <label class="mb-2">Upload Surat Permohonan Penilaian</label>
                                                        <div class="mb-3">
                                                            <input class="form-control" type="file" />
                                                            <small class="text-muted">Maksimal ukuran file 5 MB.</small>
                                                        </div>
                                                    </div>
                                                </td>
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
                                                <input type="checkbox" class="form-check-input" id="customCheck1" />
                                                <label class="form-check-label" for="customCheck1">I agree with
                                                    the Terms
                                                    and Conditions</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-3">
                            <div class="first">
                                <a href="javascript:void(0);" class="btn btn-light"> Simpan Sebagai Draft </a>
                            </div>
                            <div class="d-flex">
                                <div class="previous me-2">
                                    <button type="button" class="btn btn-secondary kembali"> Kembali </button>
                                </div>
                                <div class="next">
                                    <button type="button" class="btn btn-primary selanjutnya"> Selanjutnya </button>
                                </div>
                            </div>
                            <div class="last">
                                <a href="javascript:void(0);" class="btn btn-success"> Kirim Pengajuan </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets') }}/js/plugins/wizard.min.js"></script>

    <script>
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
    </script>
@endsection
