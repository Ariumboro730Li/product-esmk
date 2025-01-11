@extends('...Internal.index', ['title' => 'Detail | Data Perusahaan'])
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
                        <li class="breadcrumb-item"><a href="/internal/dashboard-internal">Home</a></li>
                        <li class="breadcrumb-item"><a href="/internal/perusahaan-internal/list">Perusahaan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail Perusahaan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Detail Perusahaan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="profile-tab-1"
                                data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true"><i
                                    class="ph-duotone ph-buildings me-2"></i>Profil Perusahaan</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="profile-tab-2" data-bs-toggle="tab"
                                href="#profile-2" role="tab" aria-selected="false" tabindex="-1"><i
                                    class="ti ti-file-text me-2"></i>KBLI Perusahaan</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="profile-tab-3" data-bs-toggle="tab"
                                href="#profile-3" role="tab" aria-selected="false" tabindex="-1"><i
                                    class="ti ti-file-analytics me-2"></i>Pengajuan Sertifikat</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="profile-tab-4" data-bs-toggle="tab"
                                href="#profile-4" role="tab" aria-selected="false" tabindex="-1"><i
                                    class="ph-duotone ph-chart-bar me-2"></i>Laporan Tahunan</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                    <div class="row">
                        <div class="col-lg-4 col-xxl-3">
                            <div class="card">
                                <div class="card-body position-relative">
                                    {{-- <div class="position-absolute end-0 top-0 p-3"><span class="badge bg-primary">Wawancara Terjadwal</span>
                                    </div> --}}
                                    <div class="text-center mt-3">
                                        <div class="chat-avtar d-inline-flex mx-auto"><img
                                                class="rounded-circle img-fluid wid-70"
                                                src="{{ asset('assets') }}/images/user/avatar-5.jpg" alt="User image">
                                        </div>
                                        <h5 class="mb-0 company-name">PT. NUSANTARA TECH INOVATOR</h5>
                                        <p class="text-muted text-sm company-role">Perusahaan</p>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="row g-3">
                                            <div class="col-4">
                                                <h5 class="mb-0 total_aodt">86</h5><small class="text-muted">AODT</small>
                                            </div>
                                            <div class="col-4 border border-top-0 border-bottom-0">
                                                <h5 class="mb-0 total_aotdt">40</h5><small
                                                    class="text-muted">AOTDT</small>
                                            </div>
                                            <div class="col-4">
                                                <h5 class="mb-0 total_ab">4.5K</h5><small class="text-muted">AB</small>
                                            </div>
                                        </div>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-mail me-2"></i>
                                            <p class="mb-0 company-email">anshan@gmail.com</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-phone me-2"></i>
                                            <p class="mb-0 company-phone">(+1-876) 8654 239 581</p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-map-pin me-2"></i>
                                            <p class="mb-0 company-address">New York</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xxl-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Informasi Perusahaan</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 pt-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Nama Perusahaan</p>
                                                    <p class="mb-0 company-name">PT WIRASWASTA GEMILANG INDONESIA</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">NIB</p>
                                                    <p class="mb-0 company-nib">8120004962755</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Telepon</p>
                                                    <p class="mb-0 company-phone">(+1-876) 8654 239 581</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Email</p>
                                                    <p class="mb-0 company-email">info@ptwgi.com</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Tanggal Terbit NIB</p>
                                                    <p class="mb-0 company-established">12 Desember 2023</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Jenis Layanan</p>
                                                    <ol class="company-service-types">
                                                        <li>AJAP</li>
                                                        <li>AKDP</li>
                                                        <li>Angkutan B3</li>
                                                        <li>Angkutan lintas batas negara</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <p class="mb-1 text-muted">Alamat</p>
                                            <p class="mb-0 company-address">GEDUNG THE CITY TOWER LT.5 UNIT 1S JL.MH
                                                THAMRIN NO.81</p>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <p class="mb-1 text-muted">Tanggal Bergabung</p>
                                            <p class="mb-0 company-joined-date">12 Desember 2023</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Informasi Penanggung Jawab</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 pt-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Nama</p>
                                                    <p class="mb-0 company-pic-name">Uidn</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Telepon</p>
                                                    <p class="mb-0 company-pic-phone">-</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Informasi Pengguna</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 pt-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Username</p>
                                                    <p class="mb-0 company-user-name">blalabla</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Telepon</p>
                                                    <p class="mb-0 company-user-phone">-</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div
                                            class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                            <!-- Top Controls: and Search -->
                                            <div class="datatable-top">
                                                <div class="datatable-dropdown">
                                                    <label>
                                                        <select class="datatable-selector" style="width: auto;min-width: unset;" name="limitPageKbli"
                                                            id="limitPageKbli">
                                                            <option value="5">5</option>
                                                            <option value="10" selected="">10</option>
                                                            <option value="15">15</option>
                                                            <option value="20">20</option>
                                                            <option value="25">25</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="datatable-search">
                                                    <input class="datatable-input search-input-kbli"
                                                        placeholder="Search..." type="search" name="search"
                                                        title="Search within table" aria-controls="pc-dt-simple">
                                                </div>
                                            </div>
                                            <div class="datatable-container">
                                                <table class="table table-hover datatable-table" id="pc-dt-simple">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-start">Klasifikasi Baku Lapangan Usaha
                                                                Indonesia (KBLI)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listDataKbli">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="datatable-bottom">
                                                <div class="datatable-info">Menampilkan <span id="countPageKbli">0</span>
                                                    dari <span id="totalPageKbli">0</span> data</div>
                                                <nav class="datatable-pagination">
                                                    <ul id="pagination-js-kbli" class="datatable-pagination-list">
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pt-3">
                                    <div class="table-responsive p-2">
                                        <div
                                            class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                            <div class="datatable-top">
                                                <div class="datatable-dropdown">
                                                    <label>
                                                        <select class="datatable-selector" style="width: auto;min-width: unset;" name="limitPage1"
                                                            id="limitPage1">
                                                            <option value="5">5</option>
                                                            <option value="10" selected="">10</option>
                                                            <option value="15">15</option>
                                                            <option value="20">20</option>
                                                            <option value="25">25</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="datatable-search">
                                                    <input class="datatable-input search-input" placeholder="Search..."
                                                        type="search" name="search" title="Search within table"
                                                        aria-controls="pc-dt-simple">
                                                </div>
                                            </div>
                                            <div class="datatable-container">
                                                <table class="table table-hover datatable-table" id="pc-dt-simple">
                                                    <thead>
                                                        <tr>
                                                            <th data-sortable="true" style="width: 24%;"><button
                                                                    class="datatable-sorter">Nomor Pendaftaran</button>
                                                            </th>
                                                            <th data-sortable="true" style="width: 13.777777777777779%;">
                                                                <button class="datatable-sorter">Tanggal Pengajuan</button>
                                                            </th>
                                                            <th data-sortable="true" style="width: 16.666666666666664%;">
                                                                <button class="datatable-sorter">Penilai</button>
                                                            </th>
                                                            <th data-sortable="true" style="width: 13%;"><button
                                                                    class="datatable-sorter">Jadwal Interview</button></th>
                                                            <th data-sortable="true" style="width: 17.77777777777778%;">
                                                                <button class="datatable-sorter">Posisi</button>
                                                            </th>
                                                            <th data-sortable="true" style="width: 14.777777777777779%;">
                                                                <button class="datatable-sorter">Aksi</button>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listData1">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="datatable-bottom">
                                                <div class="datatable-info">Menampilkan <span id="countPage1">0</span>
                                                    dari <span id="totalPage1">0</span> data</div>
                                                <nav class="datatable-pagination">
                                                    <ul id="pagination-js1" class="datatable-pagination-list">
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pt-3">
                                    <div class="table-responsive">
                                        <div
                                            class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                            <div class="datatable-top">
                                                <div class="datatable-dropdown">
                                                    <label>
                                                        <select class="datatable-selector" style="width: auto;min-width: unset;" name="limitPage2"
                                                            id="limitPage2">
                                                            <option value="5">5</option>
                                                            <option value="10" selected="">10</option>
                                                            <option value="15">15</option>
                                                            <option value="20">20</option>
                                                            <option value="25">25</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="datatable-search">
                                                    <input class="datatable-input search-input-laporan"
                                                        placeholder="Search..." type="search" name="search"
                                                        title="Search within table" aria-controls="pc-dt-simple">
                                                </div>
                                            </div>
                                            <div class="datatable-container">
                                                <table class="table table-hover datatable-table" id="pc-dt-simple">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">No.</th>
                                                            <th rowspan="2">Tahun Laporan</th>
                                                            <th rowspan="2">Tanggal Pelaporan</th>
                                                            <th rowspan="2">Status</th>
                                                            <th colspan="2" class="text-center" style="border-bottom:none;">Verifikasi</th>
                                                            <th rowspan="2" class="text-end">Aksi</th>
                                                        </tr>
                                                        <tr >
                                                            <th style="border-top:none;">Tanggal</th>
                                                            <th style="border-top:none;">Oleh</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="listData2">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="datatable-bottom">
                                                <div class="datatable-info">Menampilkan <span id="countPage2">0</span>
                                                    dari <span id="totalPage2">0</span> data</div>
                                                <nav class="datatable-pagination">
                                                    <ul id="pagination-js2" class="datatable-pagination-list">
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>
@endsection

@section('page_js')
    <script>
        let defaultLimitPageKbli = 10;
        let currentPageKbli = 1;
        let totalPageKbli = 1;
        let defaultAscendingKbli = 0;
        let defaultSearchKbli = '';
        let getDataTableKbli = '';
        let errorMessageKbli = "Terjadi Kesalahan.";

        let defaultLimitPage1 = 10;
        let currentPage1 = 1;
        let totalPage1 = 1;
        let defaultAscending1 = 0;
        let defaultSearch1 = '';
        let getDataTable1 = '';
        let errorMessage1 = "Terjadi Kesalahan.";

        let defaultLimitPage2 = 10;
        let currentPage2 = 1;
        let totalPage2 = 1;
        let defaultAscending2 = 0;
        let defaultSearch2 = '';
        let getDataTable2 = '';
        let errorMessage2 = "Terjadi Kesalahan.";

        let pathArray = window.location.pathname.split('/');
        let referenceId = pathArray[pathArray.length - 1];

        async function getPerusahaanData(id) {
            loadingPage(true);
            const getDataRest = await CallAPI(
                    'GET',
                    `{{ asset('dummy/company/detail_perusahaan.json') }}`, {
                        id: id,
                    }
                )
                .then(response => response)
                .catch(function(error) {
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('info', 'Pemberitahuan', resp.data.message);
                    return resp;
                });

            loadingPage(false);
            if (getDataRest.status == 200) {
                let handleDataResult = await handlePerusahaanData(getDataRest.data.data);
                await setUserData(handleDataResult);
            }
        }

        async function handlePerusahaanData(data) {
            const isActive = (data['is_active'] === true) || (data['is_active'] === 1);

            let handleData = {
                id: data['id'] ?? '-',
                name: data['name'] ?? '-',
                username: data['username'] ?? '-',
                phone_number: data['phone_number'] ?? '-',
                email: data['email'] ?? '-',
                email_verified_at: data['email_verified_at'] ?? '-',
                nib: data['nib'] ?? '-',
                address: data['address'] ?? '-',
                company_phone_number: data['company_phone_number'] ?? '-',
                pic_name: data['pic_name'] ?? '-',
                pic_phone: data['pic_phone'] ?? '-',
                request_date: data['request_date'] ?? '-',
                approved_at: data['approved_at'] ?? '-',
                approved_by: data['approved_by'] ?? '-',
                created_at: dateLanguageFormat(data['created_at']) ?? '-',
                updated_at: data['updated_at'] ?? '-',
                established: data['established'] ?? '-',
                exist_spionam: data['exist_spionam'] ?? '-',
                province_name: (data['province'] && data['province']['name']) ? data['province']['name'] : '-',
                city_name: (data['city'] && data['city']['name']) ? data['city']['name'] : '-',
                is_active: {
                    init: data['is_active'] ?? '-',
                    color: isActive ? "text-success" : "text-danger",
                    text_status: isActive ? "Aktif" : "Tidak Aktif",
                    icon_status: isActive ? "fas fa-circle-check" : "fas fa-circle-xmark",
                },
                service_types: (data['service_types']?.map(service => service['name']).join(', ')) ?? '-'
            };

            return handleData;
        }

        async function setUserData(data) {
            $('.company-name').html(data.name);
            $('.company-nib').html(data.nib);
            $('.company-province').html(data.province_name);
            $('.company-city').html(data.city_name);
            $('.company-phone').html(data.company_phone_number);
            $('.company-email').html(data.email);
            $('.company-address').html(data.address);
            $('.company-service-types').html(`<li class="list-item">${data.service_types}</li>`);
            $('.company-established').html(data.established);
            $('.company-joined-date').html(data.created_at);
            $('.company-pic-name').html(data.pic_name);
            $('.company-pic-phone').html(data.pic_phone);
            $('.company-user-name').html(data.username);
            $('.company-user-phone').html(data.phone_number);
            $('.company-is-active').addClass(`${data.is_active.icon_status} ${data.is_active.color}`);
        }

        async function getListPengajuanSmk(limit = 10, page = 1, ascending = 0, search = '', id = referenceId) {
            loadingPage(true);
            let getDataRest;
            try {
                getDataRest = await CallAPI(
                    'GET',
                    `{{ asset('dummy/company/list_pengajuan_perusahaan.json') }}`, {
                        id: id,
                        page: page,
                        limit: limit,
                        ascending: ascending,
                        search: search
                    }
                );
            } catch (error) {
                loadingPage(false);
                let resp = error.response;
                errorMessage1 = resp.data.message || errorMessage1;
                notificationAlert('info', 'Pemberitahuan', errorMessage1);
                getDataRest = resp;
            }

            loadingPage(false);
            if (getDataRest.status == 200) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handlePengajuanSmk(item))
                );
                await setListPengajuanSmk(handleDataArray, getDataRest.data.paginate);
            } else {
                getDataTable1 = `
                <tr class="nk-tb-item">
                    <th class="nk-tb-col text-center" colspan="${$('.nk-tb-head th').length}"> ${errorMessage1} </th>
                </tr>`;
                $('#listData1 tr').remove();
                $('#listData1').append(getDataTable1);
            }
        }

        async function handlePengajuanSmk(data) {
            // Enum status yang diharapkan
            const enumStatus = [
                'Permohonan',
                'Disposisi',
                'Tidak Lulus Penilaian',
                'Lulus Penilaian',
                'Revisi Pengajuan',
                'Tidak Lulus Verifikasi Penilaian',
                'Revisi Penilaian',
                'Lulus Verifikasi Penilaian',
                'Penjadwalan Wawancara',
                'Wawancara Terjadwal',
                'Tidak Lulus Wawancara',
                'Wawancara Selesai',
                'Verifikasi Direktur',
                'Validasi Sertifikat',
                'Ditolak',
                'Dibatalkan',
                'Kedaluwarsa',
                'Draf'
            ];

            // Tentukan status berdasarkan nilai yang valid dari data['status']
            const currentStatus = enumStatus.includes(data['status']) ? data['status'] : '-';

            // Tentukan warna background dan teks berdasarkan status
            const statusConfig = {
                'Permohonan': {
                    background: "bg-info text-white",
                    text_status: "Permohonan",
                    icon_status: "fa fa-circle-info"
                },
                'Disposisi': {
                    background: "bg-primary text-white",
                    text_status: "Disposisi",
                    icon_status: "fa fa-circle-arrow-right"
                },
                'Tidak Lulus Penilaian': {
                    background: "bg-warning text-white",
                    text_status: "Tidak Lulus Penilaian",
                    icon_status: "fa fa-circle-xmark"
                },
                'Lulus Penilaian': {
                    background: "bg-success text-white",
                    text_status: "Lulus Penilaian",
                    icon_status: "fa fa-circle-check"
                },
                'Revisi Pengajuan': {
                    background: "bg-secondary text-white",
                    text_status: "Revisi Pengajuan",
                    icon_status: "fa fa-pencil-alt"
                },
                'Tidak Lulus Verifikasi Penilaian': {
                    background: "bg-warning text-white",
                    text_status: "Tidak Lulus Verifikasi Penilaian",
                    icon_status: "fa fa-circle-xmark"
                },
                'Revisi Penilaian': {
                    background: "bg-secondary text-white",
                    text_status: "Revisi Penilaian",
                    icon_status: "fa fa-pencil-alt"
                },
                'Lulus Verifikasi Penilaian': {
                    background: "bg-success text-white",
                    text_status: "Lulus Verifikasi Penilaian",
                    icon_status: "fa fa-circle-check"
                },
                'Penjadwalan Wawancara': {
                    background: "bg-info text-white",
                    text_status: "Penjadwalan Wawancara",
                    icon_status: "fa fa-calendar"
                },
                'Wawancara Terjadwal': {
                    background: "bg-primary text-white",
                    text_status: "Wawancara Terjadwal",
                    icon_status: "fa fa-calendar-check"
                },
                'Tidak Lulus Wawancara': {
                    background: "bg-warning text-white",
                    text_status: "Tidak Lulus Wawancara",
                    icon_status: "fa fa-circle-xmark"
                },
                'Wawancara Selesai': {
                    background: "bg-success text-white",
                    text_status: "Wawancara Selesai",
                    icon_status: "fa fa-circle-check"
                },
                'Verifikasi Direktur': {
                    background: "bg-info text-white",
                    text_status: "Verifikasi Direktur",
                    icon_status: "fa fa-user-check"
                },
                'Validasi Sertifikat': {
                    background: "bg-success text-white",
                    text_status: "Validasi Sertifikat",
                    icon_status: "fa fa-certificate"
                },
                'Ditolak': {
                    background: "bg-danger text-white",
                    text_status: "Ditolak",
                    icon_status: "fa fa-ban"
                },
                'Dibatalkan': {
                    background: "bg-dark text-white",
                    text_status: "Dibatalkan",
                    icon_status: "fa fa-circle-xmark"
                },
                'Kedaluwarsa': {
                    background: "bg-secondary text-white",
                    text_status: "Kedaluwarsa",
                    icon_status: "fa fa-clock"
                },
                'Draf': {
                    background: "bg-light text-dark",
                    text_status: "Draf",
                    icon_status: "fa fa-file"
                },
                '-': {
                    background: "bg-light text-dark",
                    text_status: "Status Tidak Diketahui",
                    icon_status: "fa fa-question-circle"
                }
            };




            // Ambil konfigurasi status dari objek statusConfig
            const status = statusConfig[currentStatus];

            let handleData = {
                id: data['id'] ?? '-',
                regnumber: data['regnumber'] ?? '-',
                created_at: dateLanguageFormat(data['created_at']) ?? '-',
                status: {
                    init: data['status'] ?? '-',
                    background: status.background,
                    text_status: status.text_status,
                    icon_status: status.icon_status,
                },
                disposition_to: {
                    name: data['disposition_to']['name'] ?? '-',
                },
                disposition_by: {
                    name: data['disposition_by']['name'] ?? '-',
                },
                schedule_interview: data['schedule_interview'] && dateLanguageFormat(data['schedule_interview']) ?
                    dateLanguageFormat(data['schedule_interview']) : '-',
            };

            return handleData;
        }

        async function setListPengajuanSmk(dataList, pagination) {
            totalPage1 = pagination.total;
            let display_from = ((defaultLimitPage1 * pagination.current_page) + 1) - defaultLimitPage1;
            let index_loop = display_from;
            let display_to = currentPage1 < pagination.total_pages ? dataList.length < defaultLimitPage1 ?
                dataList.length : (defaultLimitPage1 * pagination.current_page) : totalPage1;

            let getDataTable1 = '';
            for (let index = 0; index < dataList.length; index++) {
                let element = dataList[index];
                const elementData = JSON.stringify(element);
                const route = ``;
                getDataTable1 += `
                <tr class="nk-tb-item">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="wid-40 hei-40 rounded-circle bg-primary d-flex align-items-center justify-content-center">
                                    <i class="ti ti-file-analytics fa-lg text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">${element.regnumber}</h6>
                                <p class="f-12 mb-0">
                                    <a href="#!" class="text-muted">
                                        <span class="badge ${element.status.background} d-inline-flex align-items-center">
                                            <i class="${element.status.icon_status} me-1"></i>
                                            ${element.status.text_status}
                                        </span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>${element.created_at}</td>
                    <td>${element.disposition_to.name}</td>
                    <td>${element.schedule_interview}</td>
                    <td>${element.disposition_by.name}</td>
                    <td>
                        <li class="list-inline-item">
                            ${getDetailPage(route)}
                        </li>
                    </td>
                </tr>`;
                index_loop++;
            }
            $('#listData1 tr').remove();

            if (totalPage1 == 0) {
                getDataTable1 = `
                <tr class="nk-tb-item">
                    <th class="text-center" colspan="${$('th').length}"> Tidak ada data. </th>
                </tr>`;
                $('#countPage1').text("0 - 0");
            }
            $('#listData1').append(getDataTable1);
            $('#totalPage1').text(totalPage1);
            $('#countPage1').text(`${display_from} - ${display_to}`);

            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        function getDetailPage(route) {
            return `
            <a href="${route}"
                class="avtar avtar-s btn-link-info detail-data"
                data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Detail Data">
                <i class="fa fa-eye"></i>
            </a>`;
        }

        async function performSearchPengajuanSmk() {
            defaultSearch1 = $('.search-input').val();
            defaultLimitPage1 = $("#limitPage1").val();
            currentPage1 = 1;
            await initDataOnTablePengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1);
        }

        async function initDataOnTablePengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1) {
            await getListPengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1);
            await paginationDataOnTablePengajuanSmk(defaultLimitPage1);
        }

        async function manipulationDataOnTablePengajuanSmk() {
            $(document).on("change", "#limitPage1", async function() {
                defaultLimitPage1 = $(this).val();
                currentPage1 = 1;
                await getListPengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1,
                    defaultSearch1);
                await paginationDataOnTablePengajuanSmk(defaultLimitPage1);
            });

            $(document).on("input", ".search-input", debounce(performSearchPengajuanSmk, 500));
            await paginationDataOnTablePengajuanSmk(defaultLimitPage1);
        }

        function paginationDataOnTablePengajuanSmk(isPageSize) {
            $('#pagination-js1').pagination({
                dataSource: Array.from({
                    length: totalPage1
                }, (_, i) => i + 1),
                pageSize: isPageSize,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: function(e) {
                    currentPage1 = parseInt(e.currentTarget.dataset.num);
                    getListPengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1);
                },
                afterPageOnClick: function(e) {
                    currentPage1 = parseInt(e.currentTarget.dataset.num);
                    getListPengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1);
                },
                afterNextOnClick: function(e) {
                    currentPage1 = parseInt(e.currentTarget.dataset.num);
                    getListPengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1);
                },
            });
        }

        async function getListLaporanTahunan(limit = 10, page = 1, ascending = 0, search = '', id = referenceId) {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'GET',
                `{{ asset('dummy/company/list_laporan_perusahaan.json') }}`, {
                    id: id,
                    page: page,
                    limit: limit,
                    ascending: ascending,
                    search: search
                }
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            loadingPage(false);
            if (getDataRest.status == 200) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleLaporanTahunan(item))
                );
                await setListLaporanTahunan(handleDataArray, getDataRest.data.paginate);
            } else {
                getDataTable2 = `
                <tr class="nk-tb-item">
                    <th class="text-center" colspan="${$('th').length}"> ${errorMessage1} </th>
                </tr>`;
                $('#listData2 tr').remove();
                $('#listData2').append(getDataTable2);
            }
        }

        async function handleLaporanTahunan(data) {
            // Map status ke bahasa Indonesia
            const statusMap = {
                'Permintaan': {
                    text: "Permintaan",
                    background: "bg-warning text-white",
                    icon: "fa fa-hourglass-start"
                },
                'Disposisi': {
                    text: "Disposisi",
                    background: "bg-info text-white",
                    icon: "fa fa-envelope"
                },
                'Tidak Lulus': {
                    text: "Tidak Lulus",
                    background: "bg-danger text-white",
                    icon: "fa fa-times-circle"
                },
                'Revisi': {
                    text: "Revisi",
                    background: "bg-warning text-white",
                    icon: "fa fa-edit"
                },
                'Terverifikasi': {
                    text: "Terverifikasi",
                    background: "bg-success text-white",
                    icon: "fa fa-check-circle"
                },
                'Ditolak': {
                    text: "Ditolak",
                    background: "bg-danger text-white",
                    icon: "fa fa-ban"
                },
                'Dibatalkan': {
                    text: "Dibatalkan",
                    background: "bg-secondary text-white",
                    icon: "fa fa-times"
                },
                'Pengesahan Sertifikat': {
                    text: "Pengesahan Sertifikat",
                    background: "bg-success text-white",
                    icon: "fa fa-check"
                }
            };

            // Tentukan status, fallback ke 'Tidak Aktif' jika tidak ada di mapping
            const statusKey = data['status'] ?? '-';
            const status = statusMap[statusKey] || {
                text: "Tidak Aktif",
                background: "bg-danger text-white",
                icon: "fa fa-circle-xmark"
            };

            let handleData = {
                id: data['id'] ?? '-',
                year: data['year'] ?? '-',
                created_at: data['created_at'] ?? '-',
                status: {
                    init: statusKey,
                    background: status.background,
                    text_status: status.text,
                    icon_status: status.icon,
                },
                disposition_to: {
                    name: data['disposition_to']['name'] ?? '-',
                    created_at: data['disposition_to']['approved_at'] ?
                        dateLanguageFormat(data['disposition_to']['approved_at']) : '-'
                }
            };

            return handleData;
        }

        function dateLanguageFormat(date) {
            if (date.includes('/') && /^\d{2}\/\d{2}\/\d{4}$/.test(date)) {
                const [day, month, year] = date.split('/');

                date = `${year}-${month}-${day}`;
            }

            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            return new Date(date).toLocaleDateString('id-ID', options);
        }

        async function setListLaporanTahunan(dataList, pagination) {
            totalPage2 = pagination.total;
            let display_from = ((defaultLimitPage2 * pagination.current_page) + 1) - defaultLimitPage2;
            let index_loop = display_from;
            let display_to = currentPage2 < pagination.total_pages ? dataList.length < defaultLimitPage2 ?
                dataList.length : (defaultLimitPage2 * pagination.current_page) : totalPage2;

            let getDataTable2 = '';
            for (let index = 0; index < dataList.length; index++) {
                let element = dataList[index];
                const elementData = JSON.stringify(element);
                const route = '';
                getDataTable2 += `
                <tr class="nk-tb-item">
                    <td>${index_loop}.</td>
                    <td>${element.year}</td>
                    <td>${element.created_at}</td>
                    <td>
                        <span class="badge ${element.status.background} d-inline-flex align-items-center">
                            <i class="${element.status.icon_status} me-1"></i>
                            ${element.status.text_status}
                        </span>
                    </td>
                    <td>${element.disposition_to.created_at}</td>
                    <td>${element.disposition_to.name}</td>
                    <td class="text-end">
                        <li class="list-inline-item">
                            ${getDetailPage(route)}
                        </li>
                    </td>
                </tr>`;
                

                index_loop++;
            }
            $('#listData2 tr').remove();

            if (totalPage2 == 0) {
                getDataTable2 = `
                <tr class="nk-tb-item">
                    <th class="text-center" colspan="${$('th').length}"> Tidak ada data. </th>
                </tr>`;
                $('#countPage2').text("0 - 0");
            }
            $('#listData2').append(getDataTable2);
            $('#totalPage2').text(totalPage2);
            $('#countPage2').text(`${display_from} - ${display_to}`);

            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        async function performSearchLaporanTahunan() {
            defaultSearch2 = $('.search-input-laporan').val();
            defaultLimitPage2 = $("#limitPage2").val();
            currentPage2 = 1;
            await initDataOnTableLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2);
        }

        async function initDataOnTableLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2) {
            await getListLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2);
            await paginationDataOnTableLaporanTahunan(defaultLimitPage2);
        }

        async function manipulationDataOnTableLaporanTahunan() {
            $(document).on("change", "#limitPage2", async function() {
                defaultLimitPage2 = $(this).val();
                currentPage2 = 1;
                await getListLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2,
                    defaultSearch2);
                await paginationDataOnTableLaporanTahunan(defaultLimitPage2);
            });

            $(document).on("input", ".search-input-laporan", debounce(performSearchLaporanTahunan, 500));
            await paginationDataOnTableLaporanTahunan(defaultLimitPage2);
        }

        function paginationDataOnTableLaporanTahunan(isPageSize) {
            $('#pagination-js2').pagination({
                dataSource: Array.from({
                    length: totalPage2
                }, (_, i) => i + 1),
                pageSize: isPageSize,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: function(e) {
                    currentPage2 = parseInt(e.currentTarget.dataset.num);
                    getListLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2);
                },
                afterPageOnClick: function(e) {
                    currentPage2 = parseInt(e.currentTarget.dataset.num);
                    getListLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2);
                },
                afterNextOnClick: function(e) {
                    currentPage2 = parseInt(e.currentTarget.dataset.num);
                    getListLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2, defaultSearch2);
                },
            });
        }

        async function getListKbli(limit = 10, page = 1, ascending = 0, search = '', id = referenceId) {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'GET',
                `{{ asset('dummy/internal/md-kbli/list_kbli.json') }}`, {
                    id: id,
                    page: page,
                    limit: limit,
                    ascending: ascending,
                    search: search
                }
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });
            loadingPage(false);
            if (getDataRest.status == 200) {
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleKbli(item))
                );
                await setListKbli(handleDataArray, getDataRest.data.pagination);
            } else {
                getDataTableKbli = `
                <tr class="nk-tb-item">
                    <th class="text-center" colspan="${$('th').length}"> ${errorMessage1} </th>
                </tr>`;
                $('#listDataKbli tr').remove();
                $('#listDataKbli').append(getDataTableKbli);
            }
        }

        async function handleKbli(data) {
            let handleData = {
                id: data['id'] ?? '-',
                name: data['name'] ?? '-',
                kbli: data['kbli'] ?? '-',
                description: data['description'] ?? '-',
                created_at: data['created_at'] ?? '-',
            };

            return handleData;
        }

        async function setListKbli(dataList, pagination) {
            const totalPageKbli = pagination.total;
            const display_from = ((defaultLimitPageKbli * pagination.current_page) + 1) - defaultLimitPageKbli;
            let index_loop = display_from;
            const display_to = currentPageKbli < pagination.total_pages ?
                dataList.length < defaultLimitPageKbli ?
                dataList.length :
                (defaultLimitPageKbli * pagination.current_page) :
                totalPageKbli;

            let getDataTableKbli = '';
            for (let index = 0; index < dataList.length; index++) {
                const element = dataList[index];
                getDataTableKbli += `
                <tr>
                    <td>
                        <div class="row align-items-center">
                            <div class="col-auto pe-0">
                                <div
                                    class="wid-40 hei-40 rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-file-lines text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="mb-1"><span class="text-truncate w-100">${element.kbli}</span> </h5>
                                <h6 class="mb-1 fw-normal"><span class="text-truncate w-100">${element.name}</span> </h6>
                            </div>
                        </div>
                    </td>
                </tr>
                `;
                index_loop++;
            }

            $('#listDataKbli tr').remove();

            if (totalPageKbli === 0) {
                // Hitung jumlah kolom tabel
                const colCount = $('#listDataKbli').closest('table').find('thead th').length;

                getDataTableKbli = `
                <tr>
                    <td class="text-center" colspan="${colCount}">Tidak ada data.</td>
                </tr>`;
                $('#countPageKbli').text("0 - 0");
            }

            $('#listDataKbli').append(getDataTableKbli);
            $('#totalPageKbli').text(totalPageKbli);
            $('#countPageKbli').text(`${display_from} - ${display_to}`);

            // Aktifkan tooltip jika ada
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        async function performSearchKbli() {
            defaultSearchKbli = $('.search-input-kbli').val();
            defaultLimitPageKbli = $("#limitPageKbli").val();
            currentPageKbli = 1;
            await initDataOnTableKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli, defaultSearchKbli);
        }

        async function initDataOnTableKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli, defaultSearchKbli) {
            await getListKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli, defaultSearchKbli);
            await paginationDataOnTableKbli(defaultLimitPageKbli);
        }

        async function manipulationDataOnTableKbli() {
            $(document).on("change", "#limitPageKbli", async function() {
                defaultLimitPageKbli = $(this).val();
                currentPageKbli = 1;
                await getListKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli,
                    defaultSearchKbli);
                await paginationDataOnTableKbli(defaultLimitPageKbli);
            });

            $(document).on("input", ".search-input-kbli", debounce(performSearchKbli, 500));
            await paginationDataOnTableKbli(defaultLimitPageKbli);
        }

        function paginationDataOnTableKbli(isPageSize) {
            $('#pagination-js-kbli').pagination({
                dataSource: Array.from({
                    length: totalPageKbli
                }, (_, i) => i + 1),
                pageSize: isPageSize,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: function(e) {
                    currentPageKbli = parseInt(e.currentTarget.dataset.num);
                    getListKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli, defaultSearchKbli);
                },
                afterPageOnClick: function(e) {
                    currentPageKbli = parseInt(e.currentTarget.dataset.num);
                    getListKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli, defaultSearchKbli);
                },
                afterNextOnClick: function(e) {
                    currentPageKbli = parseInt(e.currentTarget.dataset.num);
                    getListKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli, defaultSearchKbli);
                },
            });
        }

        function debounce(func, wait, immediate) {
            let timeout;
            return function() {
                let context = this,
                    args = arguments;
                let later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                let callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        async function initPageLoad() {
            await Promise.all([
                getPerusahaanData(referenceId),
                initDataOnTablePengajuanSmk(defaultLimitPage1, currentPage1, defaultAscending1, defaultSearch1),
                manipulationDataOnTablePengajuanSmk(),
                initDataOnTableLaporanTahunan(defaultLimitPage2, currentPage2, defaultAscending2,
                    defaultSearch2),
                manipulationDataOnTableLaporanTahunan(),
                initDataOnTableKbli(defaultLimitPageKbli, currentPageKbli, defaultAscendingKbli,
                    defaultSearchKbli),
                manipulationDataOnTableKbli(),
            ])
        }
    </script>
@endsection
