@extends('...Administrator.index', ['title' => 'Satuan Kerja | Master Data Satuan Kerja'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/style.css" />
    <link rel="icon" href="{{ asset('assets') }}/images/favicon.svg" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link" />
    <script src="{{ asset('assets') }}/js/tech-stack.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css" />
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data</a></li>
                        <li class="breadcrumb-item" aria-current="page">Satuan Kerja</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Data Satuan Kerja</h2>
                    </div>
                    <button data-pc-animate="fade-in-scale" type="button" class="btn btn-md btn-primary px-3 p-2 mt-3 mt-md-0"
                        data-bs-toggle="modal" data-bs-target="#animateModal">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                            aria-labelledby="analytics-tab-1" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="pc-dt-simple-1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Instansi</th>
                                            <th>Provinsi</th>
                                            <th>Kota</th>
                                            <th>Tipe Instansi</th>
                                            <th>Kewenangan Layanan</th>
                                            <th>Status</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Instansi Baru</td>
                                            <td>Banten</td>
                                            <td>Tangerang</td>
                                            <td>Dishub Provinsi</td>
                                            <td>Pariwisata</td>
                                            <td><span class="badge bg-light-success">Aktif</span></td>
                                            <td class="text-end">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><a data-bs-toggle="modal"
                                                            data-pc-animate="fade-in-scale" data-bs-target="#animateModal"
                                                            class="avtar avtar-s btn-link-danger btn-pc-default">
                                                            <i class="fas fa-user-times"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a data-bs-toggle="modal"
                                                            data-pc-animate="fade-in-scale" data-bs-target="#animateModal"
                                                            class="avtar avtar-s btn-link-warning btn-pc-default"><i
                                                                class="ti ti-edit f-20"></i></a></li>
                                                    <li class="list-inline-item"><a data-bs-toggle="modal"
                                                            data-pc-animate="fade-in-scale" data-bs-target="#animateModal"
                                                            class="avtar avtar-s btn-link-danger btn-pc-default"><i
                                                                class="ti ti-trash f-20"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Instansi Baru</td>
                                            <td>Banten</td>
                                            <td>Tangerang</td>
                                            <td>Dishub Provinsi</td>
                                            <td>Pariwisata</td>
                                            <td><span class="badge bg-light-success">Aktif</span></td>
                                            <td class="text-end">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item"><a data-bs-toggle="modal"
                                                            data-pc-animate="fade-in-scale" data-bs-target="#animateModal"
                                                            class="avtar avtar-s btn-link-danger btn-pc-default">
                                                            <i class="fas fa-user-times"></i></a>
                                                    </li>
                                                    <li class="list-inline-item"><a data-bs-toggle="modal"
                                                            data-pc-animate="fade-in-scale" data-bs-target="#animateModal"
                                                            class="avtar avtar-s btn-link-warning btn-pc-default"><i
                                                                class="ti ti-edit f-20"></i></a></li>
                                                    <li class="list-inline-item"><a data-bs-toggle="modal"
                                                            data-pc-animate="fade-in-scale" data-bs-target="#animateModal"
                                                            class="avtar avtar-s btn-link-danger btn-pc-default"><i
                                                                class="ti ti-trash f-20"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-animate modal-lg modal-animate-scrollable" data-bs-keyboard="false" tabindex="-1"
        id="animateModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Satuan Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <form class="p-3">
                        <div class="row">
                            <!-- Peta -->
                            <div class="col-md-6 col-12  mb-3 mb-md-0">
                                <div id="data-map" style="height: 400px;"></div>
                            </div>
                            <div class="col-md-6 col-12 ">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="namaInstansi"
                                                placeholder="Nama Instansi" />
                                            <label for="namaInstansi">Nama Instansi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="instansi">
                                                <option selected>Pilih Instansi</option>
                                                <option value="1">Instansi 1</option>
                                                <option value="2">Instansi 2</option>
                                            </select>
                                            <label for="instansi">Instansi</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Baris kedua: No Telepon, Email -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="noTelepon"
                                                placeholder="No Telepon" />
                                            <label for="noTelepon">No Telepon</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Email" />
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kewenangan Layanan -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="kewenanganLayanan"
                                                placeholder="Kewenangan Layanan" />
                                            <label for="kewenanganLayanan">Kewenangan Layanan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="alamat" placeholder="Alamat" style="height: 100px;"></textarea>
                                            <label for="alamat">Alamat</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Baris ketiga: Latitude, Longitude, Provinsi, Kota -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="latitude" placeholder="Latitude" disabled />
                                    <label for="latitude">Latitude</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="longitude" placeholder="Longitude" disabled/>
                                    <label for="longitude">Longitude</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="provinsi" disabled>
                                        <option selected>Jawa Barat</option>
                                        <option value="1">Jawa Barat</option>
                                        <option value="2">Jawa Timur</option>
                                    </select>
                                    <label for="provinsi">Provinsi</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="kota">
                                        <option selected>Bandung</option>
                                        <option value="1">Bandung</option>
                                        <option value="2">Surabaya</option>
                                    </select>
                                    <label for="kota">Kota</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-primary shadow-2">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- [Page Specific JS] start -->
    <script src="https://ableproadmin.com/assets/js/plugins/apexcharts.min.js"></script>
    <script src="https://ableproadmin.com/assets/js/plugins/simple-datatables.js"></script>
    <script src="https://ableproadmin.com/assets/js/pages/invoice-list.js"></script>
@endsection
