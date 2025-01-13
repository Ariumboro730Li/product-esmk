@extends('...Administrator.index', ['title' => 'Data Laporan Tahunan'])

@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/datepicker-bs5.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/daterange.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/daterange-picker.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
@endsection


@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/internal/dashboard-internal">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">Laporan Tahunan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Laporan Tahunan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <p class="mb-1 fw-medium text-muted">Total Laporan Tahunan</p>
                            <h5 class="mb-1 submission-total"></h5>
                            {{-- <p class="mb-0 text-sm">May 23 - June 01 (2018)</p> --}}
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-primary rounded-circle">
                                <i class="ph-duotone ph-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <p class="mb-1 fw-medium text-muted">Total Laporan Terverifikasi</p>
                            <h5 class="mb-1 submission-verified"></h5>
                            {{-- <p class="mb-0 text-sm">May 23 - June 01 (2018)</p> --}}
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-success rounded-circle">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <p class="mb-1 fw-medium text-muted">Total Laporan Direvisi</p>
                            <h5 class="mb-1 submission-revision"></h5>
                            {{-- <p class="mb-0 text-sm">May 23 - June 01 (2018)</p> --}}
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-warning rounded-circle">
                                <i class="fa-solid fa-file-circle-exclamation"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="collapseFilter" class="">
        <div class="card card-body mb-3">
            <h5 class="card-title mt-1 mb-2"><i class="fa-solid fa-filter fa-20"></i> Filter Download</h5>
            <form id="custom-filter">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <!-- Rentang Tanggal -->
                            <div class="col-md-12 mb-3">
                                <label class="fw-normal" for="daterange">Rentang Tanggal <sup
                                        class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" id="daterange" class="form-control"
                                        placeholder="Pilih rentang tanggal" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>

                            <!-- Perusahaan -->
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-perusahaan">Perusahaan</label>
                                <select class="form-control " name="input_perusahaan" id="input-perusahaan">
                                    <option value="">Pilih perusahaan</option>
                                    <!-- Tambahkan opsi perusahaan secara dinamis -->
                                </select>
                            </div>

                            <!-- Status Sertifikat -->
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-status">Status Sertifikat</label>
                                <select class="form-control " name="input_status" id="input-status">
                                    <option value="">Pilih status sertifikat</option>
                                    <!-- Tambahkan opsi status sertifikat secara dinamis -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mt-4">
                        <div class="row mt-md-0">
                            <div class="col-6 mb-2">
                                <button type="submit" id="btn-find" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i>Cari
                                </button>
                            </div>
                            <div class="col-6 mb-3">
                                <button type="button" id="resetCustomFilter" class="btn btn-light-secondary w-100">
                                    <i class="fa-solid fa-eraser me-2"></i>Reset
                                </button>
                            </div>
                            <div class="col-12 mb-2 mt-4">
                                <div id="download-container">
                                    <!-- Tombol utama download sebagai dropdown -->
                                    <div class="dropdown w-100">
                                        <button class="btn w-100 btn-success dropdown-toggle" type="button"
                                            id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-download me-2"></i>Download
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="downloadDropdown">
                                            <li>
                                                <a class="dropdown-item" id="download-excel" href="#">
                                                    <i class="fas fa-file-excel me-1"></i>Download Excel
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="download-csv" href="#">
                                                    <i class="fas fa-file-csv me-1"></i>Download CSV
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="download-pdf" href="#">
                                                    <i class="fas fa-file-pdf me-1"></i>Download PDF
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-12 mt-3">
            <div class="table-responsive">
                <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                    <div class="datatable-top">
                        <div class="datatable-dropdown">
                            <label>
                                <select id="limitPage"class="datatable-selector" name="per-page">
                                    <option value="10" selected="">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                </select>
                            </label>
                        </div>
                        <div class="datatable-search">
                            <input class="datatable-input search-input" placeholder="Cari..." type="search"
                                title="Search within table" aria-controls="pc-dt-simple-1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 help-main large-view">
                    <div id="submission-card"></div>
                </div>
            </div>

            <div class="table-responsive">
                <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                    <div class="datatable-bottom">
                        <div class="datatable-info">Menampilkan <span id="countPage">0</span>
                            dari <span id="totalPage">0</span> data</div>
                        <nav class="datatable-pagination">
                            <ul id="pagination-js" class="datatable-pagination-list">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="exampleModalCenter" class="modal fade" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Catatan Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script src="{{ asset('assets/js/date/moment.js') }}"></script>
    <script src="{{ asset('assets/js/date/daterange-picker.js') }}"></script>
    <script src="{{ asset('assets/js/date/daterange-custom.js') }}"></script>
    <script src="{{ asset('assets/js/date/date-language-format.js') }}"></script>
    <script src="{{ asset('assets/js/date/date-DMY-format.js') }}"></script>
    <script src="{{ asset('assets/js/excel/xlsx-populate.min.js') }}"></script>
    <script src="{{ asset('assets/js/excel/file-saver.min.js') }}"></script>

    {{-- <script src="{{ asset('assets') }}/js//select2.full.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.min.js"></script> --}}
    <script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
@endsection

@section('page_js')
    <script>
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let customFilter = {};

        async function getCount() {
            loadingPage(true)
            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/laporan-tahunan/countData`,
                )
                .then(response => response)
                .catch(error => {
                    loadingPage(false);
                    let resp = error.response;
                    Swal.fire({
                        icon: 'info',
                        title: 'Pemberitahuan',
                        text: resp.data.message,
                        confirmButtonColor: '#28a745',
                    });
                    return resp;
                });

            if (getDataRest.status === 200) {
                let data = getDataRest.data.data
                $(".submission-total").text(`${data.total_pengajuan || 0} Pengajuan`);
                $(".submission-verified").text(`${data.total_terverifikasi || 0} Terverifikasi`);
                $(".submission-revision").text(`${data.total_revisi || 0} Revisi`);

            }
        }
        async function getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            loadingPage(true);
            let card = $('#submission-card');
            let countPaging = $('#countPage');
            let totalPaging = $('#totalPage');
            let tablePaging = $('#tableList');


            let data = [];
            customFilter = customFilter || {};
            const queryParams = new URLSearchParams({
                page: currentPage,
                limit: defaultLimitPage,
                ascending: defaultAscending,
                search: defaultSearch,
                company: Object.keys(customFilter).length !== 0 ? customFilter['company'] : '',
                status: Object.keys(customFilter).length !== 0 ? customFilter['status'] : '',
                fromdate: customFilter?.['start_date'] || '',
                duedate: customFilter?.['end_date'] || '',
            }).toString();

            // Memanggil API untuk mendapatkan data bidang
            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/laporan-tahunan/list?${queryParams}`
                )
                .then(response => response)
                .catch(error => {
                    loadingPage(false);
                    let resp = error.response;
                    Swal.fire({
                        icon: 'info',
                        title: 'Pemberitahuan',
                        text: resp.data.message,
                        confirmButtonColor: '#28a745',
                    });
                    return resp;
                });

            if (getDataRest.status === 200) {
                loadingPage(false);
                let data = getDataRest.data;
                let dataTable = data.data;
                if (dataTable.length === 0) {
                    card.html(`
                        <div class="card ticket-card">
                            <div class="card-body d-flex justify-content-center align-items-center" style="height: 100px;">
                                <p class="fw-bold text-muted m-0">Data tidak ditemukan</p>
                            </div>
                        </div>
                    `);

                    countPaging.text(`0 - 0`);
                    totalPaging.text(`0`);
                } else {
                    totalData = getDataRest.data.pagination.total || 0;
                    totalPage = Math.ceil(totalData / defaultLimitPage);
                    let display_from = (currentPage - 1) * defaultLimitPage + 1;
                    let display_to = Math.min(currentPage * defaultLimitPage, totalData);
                    let index_loop = display_from;
                    let domTableHtml = "";

                    for (let index = 0; index < dataTable.length; index++) {
                        let element = dataTable[index];

                        let statusBadge = element.is_active ?
                            '<span class="badge bg-light-success">Aktif</span>' :
                            '<span class="badge bg-light-danger">Tidak Aktif</span>';

                        let statusLabel = '';
                        let colorBage = 'primary';
                        switch (element.status) {
                            case "request":
                                statusLabel = '<span class="badge bg-light-secondary ms-2">Pengajuan Baru</span>';
                                colorBage = 'primary';
                                break;
                            case "revision":
                                statusLabel = '<span class="badge bg-light-danger ms-2">Revisi</span>';
                                colorBage = 'danger';
                                break;
                            case "verified":
                                statusLabel = '<span class="badge bg-light-success ms-2">Terverifikasi</span>';
                                colorBage = 'success';
                                break;
                            case "not_passed":
                                statusLabel = '<span class="badge bg-light-danger ms-2">Tidak lulus verifikasi</span>';
                                colorBage = 'danger';
                                break;
                            default:
                                statusLabel = '<span class="badge bg-light-warning ms-2">Status Tidak Diketahui</span>';
                                colorBage = 'warning';
                                break;
                        }

                        
                        let lastUpdate = new Date(element.updated_at).toLocaleDateString();
                        let createdDate = new Date(element.created_at).toLocaleDateString();

                        let cardClass = element.status === 'verified' ? 'ticket-card close-ticket' :
                            (element.rejection_notes && element.rejection_notes.length > 0 ? 'ticket-card open-ticket' :
                                'ticket-card');

                        let truncatedNotes = element.rejection_notes && element.rejection_notes.length !== null ?
                            element.rejection_notes.substring(0, 100) + '...' : element.rejection_notes || '';

                        domTableHtml += `
                            <div class="card ${cardClass}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-auto mb-3 mb-sm-0">
                                            <div class="d-sm-inline-block d-flex align-items-center">
                                                <div class="wid-60 hei-60 rounded-circle bg-${colorBage} d-flex align-items-center justify-content-center">
                                                    <i class="ph-duotone ph-buildings text-white fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="popup-trigger">
                                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                                    <div class="h4 font-weight-bold mb-2 mb-md-0">
                                                       ${element.nama_perusahaan}
                                                       ${statusLabel}
                                                    </div>
                                                </div>
                                                <div class="help-sm-hidden">
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li
                                                            class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i
                                                                class="fa-solid fa-calendar-day me-1"></i>
                                                            Tahun Laporan : <b>${element.tahun_laporan}</b>
                                                        </li>
                                                        <li
                                                            class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-solid fa-user-tie me-1"></i>
                                                            Diverifikasi Oleh <b>${(element?.diverifikasi_oleh?.assessor?.name ?? "-")}</b>

                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li
                                                            class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-solid fa-calendar-day me-1"></i>
                                                            Tanggal Dibuat : <b>${element.created_at}</b>
                                                        </li>
                                                        <li
                                                            class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-solid fa-calendar-day me-1"></i>
                                                            Tanggal Terverifikasi : <b>${element.tanggal_verifikasi}</b>
                                                        </li>
                                                    </ul>
                                                </div>
                                                ${element.rejection_notes ? `
                                                                            <div class="h5 mt-3">
                                                                                <i class="material-icons-two-tone f-16 me-1">notification_important</i>Catatan Permohonan
                                                                            </div>
                                                                            <div class="help-md-hidden">
                                                                                <div class="bg-body mb-3 p-3">
                                                                                    <h6>
                                                                                        <img src="{{ asset('assets') }}/images/user/user-profil2.jpg"
                                                                                            alt="" class="wid-20 avatar me-2 rounded">
                                                                                        Last comment from <a href="#" class="link-secondary">${element.updated_by}:</a>
                                                                                    </h6>
                                                                                    <p class="mb-0">
                                                                                        ${truncatedNotes}
                                                                                    </p>
                                                                                </div>
                                                                            </div>` : ''}
                                            </div>
                                            <div class="mt-4">
                                                ${element.rejection_notes ? `
                                                                            <button type="button" class="me-2 btn btn-sm btn-light-danger"
                                                                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter" onclick="showModalNotes('${element.rejection_notes}')" style="border-radius: 5px;">
                                                                                <i class="ti ti-eye me-1"></i> Lihat Catatan
                                                                            </button>` : ''}
                                                <a href="/admin/laporan-tahunan/detail?id=${element.id}&companyID=${element.company_id}"
                                                    class="me-2 btn btn-sm btn-light-secondary" style="border-radius: 5px;">
                                                    <i class="feather icon-eye mx-1"></i>Lihat Pengajuan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                    }

                    countPaging.text(`${display_from} - ${display_to}`);
                    totalPaging.text(totalData);
                    card.empty();
                    card.html(domTableHtml);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
        }

        function showModalNotes(notes) {
            $('#exampleModalCenter .modal-body').html(`<p>${notes}</p>`);
            $('#exampleModalCenter').modal('show');
        }

        async function selectFilter(id, route, placeholder) {
            var multipleFetch = new Choices(id, {
                placeholder: placeholder,
                placeholderValue: placeholder,
                maxItemCount: 5,
                removeItemButton: true,
            });

            multipleFetch.setChoices(async function() {
                const params = {
                    term: ""
                };

                const query = {
                    keyword: params.term,
                    page: 1,
                    limit: 30,
                    ascending: 1
                };

                const url = new URL(route);
                url.search = new URLSearchParams(query).toString();

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${Cookies.get('auth_token')}`,
                    }
                });

                const data = await response.json();

                return data.data.map(function(item) {
                    return {
                        value: item.id,
                        label: item.name
                    };
                });

            });

            document.querySelector(id).addEventListener('change', function(event) {
                const selectedValue = event.target.value;

                if (selectedValue === '') {
                    $(id).val('');
                } else {
                    $(id).val(selectedValue);
                }

                const selectedValues = multipleFetch.getValue(true);
            });

            function clearSelection() {
                multipleFetch.clearChoices();
            }
        }

        async function getFilterDownload(filter = {}, startDate, endDate) {
            loadingPage(true);
            const formatDate = (date) => {
                const d = new Date(date);
                return d.toISOString().split('T')[0];
            };

            let params = {
                status: filter['status'] || '',
                company: filter['company'] || '',
                fromdate: formatDate(filter['start_date'] || startDate),
                duedate: formatDate(filter['end_date'] || endDate),
                limit: filter['limit'] || 10,
                ascending: true
            };


            let getDataRest = await CallAPI('GET', `${url}/internal/admin-panel/laporan-tahunan/list`, params)
                .then(function(response) {
                    return response;
                })
                .catch(function(error) {
                    loadingPage(false);
                    notificationAlert('warning', 'Error', 'Tidak dapat memuat data');
                    return null;
                });

            if (getDataRest && getDataRest.data.status_code === 200) {
                let data = getDataRest.data.data;


                let filteredData = data.filter(item => {
                    return (!params.status || item.status === params.status) &&
                        (!params.company || item.nama_perusahaan === params.company) &&
                        (!params.start_date || new Date(item.tanggal_pengajuan) >= new Date(params
                            .start_date)) &&
                        (!params.end_date || new Date(item.tanggal_pengajuan) <= new Date(params.end_date));
                });

                if (filteredData.length > 0) {
                    // Fungsi ini harus dipanggil untuk mengunduh data
                    await downloadToExcel(filteredData, startDate, endDate);
                    notificationAlert('success', 'Berhasil', 'Silahkan periksa file anda');
                } else {
                    notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                }
            } else {
                notificationAlert('error', 'Pemberitahuan', 'Gagal mendapatkan data atau data tidak ada.');
            }
        }


        async function downloadToExcel(data, fromDate, toDate) {
            let selectedData = data.map((item, index) => ({
                No: index + 1,
                Header2: item.nama_perusahaan || '-',
                Header3: item.status || '-',
                Header5: item.diverifikasi_oleh.assessor && item.diverifikasi_oleh.assessor.name ? item
                    .diverifikasi_oleh.assessor.name : '-',
                Header7: item.tahun_laporan || '-',
                Header8: item.tanggal_verifikasi ? dateDMYFormat(item.tanggal_verifikasi) : '-',
                Header9: item.created_at ? dateDMYFormat(item.created_at) : '-'
            }));


            let header = [
                'No.',
                'Nama Perusahaan',
                'Status',
                'Diverifikasi Oleh',
                'Tahun Laporan',
                'Tanggal Verivikasi',
                'Tanggal Dibuat',
            ];

            let formattedFromDate = await dateLanguageFormat(fromDate);
            let formattedToDate = await dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            let fileName;
            if (sameDate) {
                title = `Daftar Pengajuan Sertifikan E-SMK ${formattedFromDate}`.toUpperCase();
                fileName = `Daftar Pengajuan Sertifikan E-SMK (${formattedFromDate}).xlsx`;
            } else {
                title = `Daftar Pengajuan Sertifikan E-SMK ${formattedFromDate} - ${formattedToDate}`
                    .toUpperCase();
                fileName = `Daftar Pengajuan Sertifikan E-SMK (${formattedFromDate} - ${formattedToDate}).xlsx`;
            }

            try {
                let workbook = await XlsxPopulate.fromBlankAsync();
                let sheet = workbook.sheet(0);
                sheet.name("Data");

                let lastColumn = String.fromCharCode(64 + header.length);
                let titleRange = `A1:${lastColumn}1`;
                sheet.range(titleRange).merged(true).value(title).style({
                    horizontalAlignment: "center",
                    bold: true,
                    fontSize: 12
                });

                header.forEach((title, index) => {
                    let cell = sheet.cell(3, index + 1);
                    cell.value(title);
                    cell.style({
                        bold: true,
                        fill: "CCCCCC",
                        border: true,
                        horizontalAlignment: "center"
                    });
                });

                selectedData.forEach((row, rowIndex) => {
                    Object.values(row).forEach((value, colIndex) => {
                        let cell = sheet.cell(rowIndex + 4, colIndex + 1);
                        cell.value(value);
                        cell.style({
                            border: true,
                            horizontalAlignment: "left" // Rata kiri untuk semua data
                        });
                    });
                });

                header.forEach((title, index) => {
                    sheet.column(index + 1).width(Math.max(...[title, ...selectedData.map(row => row[Object
                        .keys(row)[index]])].map(text => text.toString().length)) * 1.2);
                });

                let blob = await workbook.outputAsync();

                saveAs(blob, fileName);
            } catch (error) {
                notificationAlert('warning', 'Error', 'Periksa Jaringan Anda.');
            }
        }


        async function downloadToCSV(data, fromDate, toDate) {
            let formattedFromDate = dateLanguageFormat(fromDate);
            let formattedToDate = dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            if (sameDate) {
                title = `Perusahaan e-SMK TANGGAL ${formattedFromDate}`.toUpperCase();
            } else {
                title = `Perusahaan e-SMK DARI TANGGAL ${formattedFromDate} - ${formattedToDate}`.toUpperCase();
            }

            // Prepare the headers
            let headers = [
                'No.',
                'Nama Perusahaan',
                'Status',
                'Diverifikasi Oleh',
                'Tahun Laporan',
                'Tanggal Verifikasi',
                'Tanggal Dibuat',
            ];

            // Convert the data to CSV format
            let csvContent = headers.join(',') + '\n'; // Add headers

            data.forEach((item, index) => {
                let row = [
                    index + 1,
                    item.nama_perusahaan || '-',
                    item.status || '-',
                    item.diverifikasi_oleh.assessor && item.diverifikasi_oleh.assessor.name ? item
                    .diverifikasi_oleh.assessor.name : '-',
                    item.tahun_laporan || '-', // Changed from item.year to item.tahun_laporan
                    item.tanggal_verifikasi ? dateDMYFormat(item.tanggal_verifikasi) :
                    '-', // Changed from item.tanggal_verivikasi to item.tanggal_verifikasi
                    item.created_at ? dateDMYFormat(item.created_at) :
                    '-'
                ];
                csvContent += row.join(',') + '\n';
            });

            let blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            let link = document.createElement('a');
            let fileName = `Perusahaan e-SMK (${formattedFromDate} - ${formattedToDate}).csv`;

            if (navigator.msSaveBlob) { // For IE 10+
                navigator.msSaveBlob(blob, fileName);
            } else {
                let url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', fileName);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        async function downloadToPDF(data, fromDate, toDate) {
            const {
                jsPDF
            } = window.jspdf;

            let selectedData = data.map((item, index) => ({
                No: index + 1,
                Header2: item.nama_perusahaan || '-',
                Header3: item.status || '-',
                Header5: item.diverifikasi_oleh.assessor && item.diverifikasi_oleh.assessor.name ? item
                    .diverifikasi_oleh.assessor.name : '-',
                Header7: item.tahun_laporan || '-',
                Header8: item.tanggal_verifikasi ? dateDMYFormat(item.tanggal_verifikasi) : '-',
                Header9: item.created_at ? dateDMYFormat(item.created_at) : '-'
            }));

            let header = [
                'No.',
                'Nama Perusahaan',
                'Status',
                'Diverifikasi Oleh',
                'Tahun Laporan',
                'Tanggal Verifikasi',
                'Tanggal Dibuat',
            ];

            let formattedFromDate = await dateLanguageFormat(fromDate);
            let formattedToDate = await dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title = sameDate ?
                `Daftar Pengajuan Penilaian e-SMK ${formattedFromDate}`.toUpperCase() :
                `Daftar Pengajuan Penilaian e-SMK ${formattedFromDate} - ${formattedToDate}`.toUpperCase();

            let doc = new jsPDF({
                orientation: 'landscape',
                unit: 'pt',
                format: 'a4'
            });

            doc.setFontSize(12);
            doc.text(title, doc.internal.pageSize.getWidth() / 2, 30, {
                align: 'center'
            });

            doc.autoTable({
                head: [header],
                body: selectedData.map(Object.values),
                startY: 50,
                styles: {
                    fontSize: 9,
                    cellPadding: 4,
                    halign: 'center' // Rata tengah untuk seluruh isi
                },
                headStyles: {
                    fillColor: [204, 204, 204],
                    textColor: 0,
                    halign: 'center'
                },
                bodyStyles: {
                    valign: 'middle'
                },
                columnStyles: {
                    0: {
                        cellWidth: 30 // Lebar kolom pertama
                    },
                    // Atur semua kolom lain agar rata tengah
                    1: {
                        halign: 'center'
                    },
                    2: {
                        halign: 'center'
                    },
                    3: {
                        halign: 'center'
                    },
                    4: {
                        halign: 'center'
                    },
                    5: {
                        halign: 'center'
                    }
                }
            });

            doc.save(`Daftar Pengajuan Penilaian e-SMK (${formattedFromDate} - ${formattedToDate}).pdf`);
        }

        async function customFilterTable() {

            let dateRangePicker = initializeDateRangePicker();
            let startDate = dateRangePicker.data('daterangepicker').startDate;
            let endDate = dateRangePicker.data('daterangepicker').endDate;
            let startDateObj = new Date(startDate);
            let endDateObj = new Date(endDate);
            let timeDiff = endDateObj - startDateObj;
            let dayDiff = timeDiff / (1000 * 3600 * 24);

            // Submit filter
            document.getElementById('custom-filter').addEventListener('submit', async function(e) {
                e.preventDefault();

                // Ambil nilai startDate dan endDate dari datepicker
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');
                } else {
                    startDate = '';
                    endDate = '';
                }

                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                // Buat objek custom filter
                customFilter = {

                    'company': company,
                    'status': status,
                    'start_date': $("#daterange").val() != '' ? startDate : '',
                    'end_date': $("#daterange").val() != '' ? endDate : ''
                };


                // Set currentPage ke 1 dan muat data baru
                currentPage = 1;
                await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
            });

            // Fungsi download
            document.getElementById('download-excel').addEventListener('click', async function() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');
                } else {
                    startDate = '';
                    endDate = '';
                }

                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'status': status,
                    'company': company,
                    'start_date': $("#daterange").val() !== '' ? startDate : '',
                    'end_date': $("#daterange").val() !== '' ? endDate : ''
                };

                // Validation for date range length
                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                loadingPage(true);

                await getFilterDownload(customFilter, startDate, endDate);

            });

            document.getElementById('download-csv').addEventListener('click', async function() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');
                } else {
                    startDate = '';
                    endDate = '';
                }


                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'status': status,
                    'company': company,
                    'start_date': $("#daterange").val() !== '' ? startDate : '',
                    'end_date': $("#daterange").val() !== '' ? endDate : ''
                };

                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                let filteredData = await fetchFilteredData(customFilter);


                if (filteredData.length > 0) {

                    await downloadToCSV(filteredData, startDate, endDate);
                } else {
                    notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                }
            });

            document.getElementById('download-pdf').addEventListener('click', async function() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');
                } else {
                    startDate = '';
                    endDate = '';
                }


                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'status': status,
                    'company': company,

                    'start_date': $("#daterange").val() !== '' ? startDate : '',
                    'end_date': $("#daterange").val() !== '' ? endDate : ''
                };

                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                let filteredData = await fetchFilteredData(customFilter);

                if (filteredData.length > 0) {
                    await downloadToPDF(filteredData, startDate, endDate);
                } else {
                    notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                }
            });

            // Reset filter
            document.getElementById('resetCustomFilter').addEventListener('click', async function() {
                window.location.reload();
            });
        }

        async function fetchFilteredData(filter = {}) {
            const formatDate = (date) => {
                const d = new Date(date);
                return d.toISOString().split('T')[0];
            };
            let formattedStartDate = formatDate(filter['start_date']);
            let formattedEndDate = formatDate(filter['end_date']);

            if (!formattedStartDate || !formattedEndDate) {
                notificationAlert('warning', 'Error', 'Tanggal mulai atau tanggal akhir tidak valid.');
                loadingPage(false);
                return [];
            }
            let params = {
                status: filter['status'] || '',
                company: filter['company'] || '',
                fromdate: formattedStartDate,
                duedate: formattedEndDate,
                limit: filter['limit'] || 10,
                ascending: true
            };

            try {

                let getDataRest = await CallAPI('GET',
                        `{{ url('') }}/api/internal/admin-panel/laporan-tahunan/list?${params}`
                    )
                    // `{{ url('') }}/api/internal/admin-panel/laporan-tahunan/list`, params)
                    .then(function(response) {
                        return response;
                    })
                    .catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('warning', 'Error', 'Tidak dapat memuat data');
                        return resp;
                    });

                console.log("🚀 ~ fetchFilteredData ~ getDataRest:", getDataRest)

                // Check if the request was successful
                if (getDataRest.data.status_code == 200) {
                    let data = getDataRest.data.data;

                    // Filter data based on parameters
                    let filteredData = data.filter(item => {
                        let createdAt = moment(item.created_at).startOf('day').format('YYYY-MM-DD');
                        console.log("🚀 ~ fetchFilteredData ~ createdAt:", createdAt)
                        console.log("🚀 ~ fetchFilteredData ~ createdAt:", item.company_id)
                        console.log()
                        return (!params.status || item.status === params.status) &&
                            (!params.company || String(item.company_id) === params.company) &&
                            (!params.fromdate || createdAt >= params.fromdate) &&
                            (!params.duedate || createdAt <= params.duedate);
                    });

                    // Check the result of the filtered data
                    if (filteredData.length > 0) {
                        notificationAlert('success', 'Berhasil', 'Silahkan periksa file anda.');
                        return filteredData;
                    } else {
                        notificationAlert('info', 'Pemberitahuan',
                            'Data tidak ditemukan dengan filter yang diberikan.');
                        return [];
                    }
                } else {
                    notificationAlert('error', 'Error', 'Gagal mendapatkan data, status code bukan 200.');
                    return [];
                }
            } catch (error) {
                notificationAlert('warning', 'Error', 'Terjadi kesalahan saat memuat data.');

                return [];
            }
        }


        async function selectFilterStatus(id, placeholder) {
            const data = {
                request: 'Pengajuan',
                submission_revision: 'Perbaikan dokumen',
                rejected: 'Ditolak',
                verified: 'Terverifikasi',
            };

            var multipleFetch = new Choices(id, {
                placeholder: placeholder,
                placeholderValue: placeholder,
                maxItemCount: 5,
                allowClear: true,
                removeItemButton: true,
            }).setChoices(function() {
                // Mengonversi objek menjadi array untuk diolah oleh Choices.js
                const choicesArray = Object.entries(data).map(([key, value]) => ({
                    value: key,
                    label: value
                }));

                return Promise.resolve(choicesArray);
            });
            document.querySelector(id).addEventListener('change', function(event) {
                const selectedValue = event.target.value;

                document.querySelector(id).value = selectedValue;
            });

            function clearSelection() {
                multipleFetch.clearChoices();
            }
        }

        async function getFilterDownload(filter = {}, startDate, endDate) {
            loadingPage(true);
            const formatDate = (date) => {
                const d = new Date(date);
                return d.toISOString().split('T')[0];
            };

            let params = {
                status: filter['status'] || '',
                company: filter['company'] || '',
                fromdate: formatDate(filter['start_date'] || startDate),
                duedate: formatDate(filter['end_date'] || endDate),
                limit: filter['limit'] || 10,
                ascending: true
            };


            let getDataRest = await CallAPI('GET',
                    `{{ url('') }}/api/internal/admin-panel/laporan-tahunan/list`, params)
                .then(function(response) {
                    return response;
                })
                .catch(function(error) {
                    loadingPage(false);
                    notificationAlert('warning', 'Error', 'Tidak dapat memuat data');
                    return null;
                });

            if (getDataRest && getDataRest.data.status_code === 200) {
                loadingPage(false)
                let data = getDataRest.data.data;


                let filteredData = data.filter(item => {
                    return (!params.status || item.status === params.status) &&
                        (!params.company || item.nama_perusahaan === params.company) &&
                        (!params.start_date || new Date(item.tanggal_pengajuan) >= new Date(params
                            .start_date)) &&
                        (!params.end_date || new Date(item.tanggal_pengajuan) <= new Date(params.end_date));
                });

                if (filteredData.length > 0) {
                    // Fungsi ini harus dipanggil untuk mengunduh data
                    await downloadToExcel(filteredData, startDate, endDate);
                    notificationAlert('success', 'Berhasil', 'Silahkan periksa file anda');
                } else {
                    notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                }
            } else {
                notificationAlert('error', 'Pemberitahuan', 'Gagal mendapatkan data atau data tidak ada.');
            }
        }

        async function downloadToExcel(data, fromDate, toDate) {
            let selectedData = data.map((item, index) => ({
                No: index + 1,
                Header2: item.nama_perusahaan || '-',
                Header3: item.status || '-',
                Header5: item.diverifikasi_oleh.assessor && item.diverifikasi_oleh.assessor !== null ? item
                    .diverifikasi_oleh.assessor.name : '-',
                Header7: item.tahun_laporan || '-',
                Header8: item.tanggal_verifikasi ? dateDMYFormat(item.tanggal_verifikasi) : '-',
                Header9: item.created_at ? dateDMYFormat(item.created_at) : '-'
            }));


            let header = [
                'No.',
                'Nama Perusahaan',
                'Status',
                'Diverifikasi Oleh',
                'Tahun Laporan',
                'Tanggal Verivikasi',
                'Tanggal Dibuat',
            ];

            let formattedFromDate = await dateLanguageFormat(fromDate);
            let formattedToDate = await dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            let fileName;
            if (sameDate) {
                title = `Daftar Pengajuan Sertifikan E-SMK ${formattedFromDate}`.toUpperCase();
                fileName = `Daftar Pengajuan Sertifikan E-SMK (${formattedFromDate}).xlsx`;
            } else {
                title = `Daftar Pengajuan Sertifikan E-SMK ${formattedFromDate} - ${formattedToDate}`
                    .toUpperCase();
                fileName = `Daftar Pengajuan Sertifikan E-SMK (${formattedFromDate} - ${formattedToDate}).xlsx`;
            }

            try {
                let workbook = await XlsxPopulate.fromBlankAsync();
                let sheet = workbook.sheet(0);
                sheet.name("Data");

                let lastColumn = String.fromCharCode(64 + header.length);
                let titleRange = `A1:${lastColumn}1`;
                sheet.range(titleRange).merged(true).value(title).style({
                    horizontalAlignment: "center",
                    bold: true,
                    fontSize: 12
                });

                header.forEach((title, index) => {
                    let cell = sheet.cell(3, index + 1);
                    cell.value(title);
                    cell.style({
                        bold: true,
                        fill: "CCCCCC",
                        border: true,
                        horizontalAlignment: "center"
                    });
                });

                selectedData.forEach((row, rowIndex) => {
                    Object.values(row).forEach((value, colIndex) => {
                        let cell = sheet.cell(rowIndex + 4, colIndex + 1);
                        cell.value(value);
                        cell.style({
                            border: true,
                            horizontalAlignment: "left" // Rata kiri untuk semua data
                        });
                    });
                });

                header.forEach((title, index) => {
                    sheet.column(index + 1).width(Math.max(...[title, ...selectedData.map(row => row[Object
                        .keys(row)[index]])].map(text => text.toString().length)) * 1.2);
                });

                let blob = await workbook.outputAsync();

                saveAs(blob, fileName);
            } catch (error) {
                notificationAlert('warning', 'Error', 'Periksa Jaringan Anda.');
            }
        }

        async function downloadToCSV(data, fromDate, toDate) {
            let formattedFromDate = dateLanguageFormat(fromDate);
            let formattedToDate = dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            if (sameDate) {
                title = `Perusahaan e-SMK TANGGAL ${formattedFromDate}`.toUpperCase();
            } else {
                title = `Perusahaan e-SMK DARI TANGGAL ${formattedFromDate} - ${formattedToDate}`.toUpperCase();
            }

            // Prepare the headers
            let headers = [
                'No.',
                'Nama Perusahaan',
                'Status',
                'Diverifikasi Oleh',
                'Tahun Laporan',
                'Tanggal Verifikasi',
                'Tanggal Dibuat',
            ];

            // Convert the data to CSV format
            let csvContent = headers.join(',') + '\n'; // Add headers

            data.forEach((item, index) => {
                let row = [
                    index + 1,
                    item.nama_perusahaan || '-',
                    item.status || '-',
                    item.diverifikasi_oleh.assessor && item.diverifikasi_oleh.assessor.name ? item
                    .diverifikasi_oleh.assessor.name : '-',
                    item.tahun_laporan || '-', // Changed from item.year to item.tahun_laporan
                    item.tanggal_verifikasi ? dateDMYFormat(item.tanggal_verifikasi) :
                    '-', // Changed from item.tanggal_verivikasi to item.tanggal_verifikasi
                    item.created_at ? dateDMYFormat(item.created_at) :
                    '-'
                ];
                csvContent += row.join(',') + '\n';
            });

            let blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            let link = document.createElement('a');
            let fileName = `Perusahaan e-SMK (${formattedFromDate} - ${formattedToDate}).csv`;

            if (navigator.msSaveBlob) { // For IE 10+
                navigator.msSaveBlob(blob, fileName);
            } else {
                let url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', fileName);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        async function downloadToPDF(data, fromDate, toDate) {
            const {
                jsPDF
            } = window.jspdf;

            let selectedData = data.map((item, index) => ({
                No: index + 1,
                Header2: item.nama_perusahaan || '-',
                Header3: item.status || '-',
                Header5: item.diverifikasi_oleh.assessor && item.diverifikasi_oleh.assessor.name ? item
                    .diverifikasi_oleh.assessor.name : '-',
                Header7: item.tahun_laporan || '-',
                Header8: item.tanggal_verifikasi ? dateDMYFormat(item.tanggal_verifikasi) : '-',
                Header9: item.created_at ? dateDMYFormat(item.created_at) : '-'
            }));

            let header = [
                'No.',
                'Nama Perusahaan',
                'Status',
                'Diverifikasi Oleh',
                'Tahun Laporan',
                'Tanggal Verifikasi',
                'Tanggal Dibuat',
            ];

            let formattedFromDate = await dateLanguageFormat(fromDate);
            let formattedToDate = await dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title = sameDate ?
                `Daftar Pengajuan Penilaian e-SMK ${formattedFromDate}`.toUpperCase() :
                `Daftar Pengajuan Penilaian e-SMK ${formattedFromDate} - ${formattedToDate}`.toUpperCase();

            let doc = new jsPDF({
                orientation: 'landscape',
                unit: 'pt',
                format: 'a4'
            });

            doc.setFontSize(12);
            doc.text(title, doc.internal.pageSize.getWidth() / 2, 30, {
                align: 'center'
            });

            doc.autoTable({
                head: [header],
                body: selectedData.map(Object.values),
                startY: 50,
                styles: {
                    fontSize: 9,
                    cellPadding: 4,
                    halign: 'center' // Rata tengah untuk seluruh isi
                },
                headStyles: {
                    fillColor: [204, 204, 204],
                    textColor: 0,
                    halign: 'center'
                },
                bodyStyles: {
                    valign: 'middle'
                },
                columnStyles: {
                    0: {
                        cellWidth: 30 // Lebar kolom pertama
                    },
                    // Atur semua kolom lain agar rata tengah
                    1: {
                        halign: 'center'
                    },
                    2: {
                        halign: 'center'
                    },
                    3: {
                        halign: 'center'
                    },
                    4: {
                        halign: 'center'
                    },
                    5: {
                        halign: 'center'
                    }
                }
            });

            doc.save(`Daftar Pengajuan Penilaian e-SMK (${formattedFromDate} - ${formattedToDate}).pdf`);
        }


        function paginationDataOnTable(isPageSize) {
            $('#pagination-js').pagination({
                dataSource: Array.from({
                    length: totalPage
                }, (_, i) => i + 1),
                pageSize: isPageSize,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
                afterPageOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
                afterNextOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
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

        async function performSearch() {
            defaultSearch = $('.search-input').val();
            defaultLimitPage = $("#limitPage").val();
            currentPage = 1;
            await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
        }


        async function manipulationDataOnTable() {
            $(document).on("change", "#limitPage", async function() {
                defaultLimitPage = $(this).val();
                currentPage = 1;
                await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
                await paginationDataOnTable(defaultLimitPage);
            });

            $(document).on("input", ".search-input", debounce(performSearch, 500));
            await paginationDataOnTable(defaultLimitPage);
        }

        async function initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
            await paginationDataOnTable(defaultLimitPage);
        }

        async function initPageLoad() {
            await Promise.all([
                customFilterTable(),
                getCount(),
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter),
                manipulationDataOnTable(),
                selectFilterStatus('#input-status', 'Pilih status sertifikat'),
                selectFilter('#input-perusahaan',
                    '{{ url('') }}/api/internal/admin-panel/perusahaan/list',
                    'Pilih perusahaan'),
            ]);
        }
    </script>
    @include('Administrator.partial-js')
@endsection
