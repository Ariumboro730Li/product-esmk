@extends('...Administrator.index', ['title' => 'Detail Sertifikat SMK | SMK-TD'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/datepicker-bs5.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/daterange.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/daterange-picker.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/laporan/index.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        .table th.sticky-end,
        .table td.sticky-end {
            position: sticky;
            right: 0;
            background-color: #fff;
            z-index: 1;
            border-left: 1px solid #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">Sertifikat SMK</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Permohonan Penilaian E-SMK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-primary">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Total Permohonan Sertifikat</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2" id="total_permohonan">3</h4>
                                <span class="fw-bold f-16" id="ket_total">Permohonan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-info">
                                <i class="fa-solid fa-bars-progress"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Permohonan Berlangsung</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2" id="total_proses">1</h4>
                                <span class="fw-bold f-16 ket_proses">Berlangsung</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-dark">
                                <i class="fa-solid fa-file-circle-exclamation"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Permohonan Kadaluwarsa</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2" id="total_kadaluwarsa">1</h4>
                                <span class="fw-bold f-16 ket_kadaluwarsa">Kadaluwarsa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-success">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Permohonan Selesai</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2" id="total_verified">1</h4>
                                <span class="fw-bold f-16 ket_verified">Selesai</span>
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
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="daterange">Rentang Tanggal <sup
                                        class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" id="daterange" class="form-control"
                                        placeholder="Pilih rentang tanggal" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-penilai">Penilai</label>
                                <select class="form-control select" name="input_penilai" id="input-penilai"></select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-perusahaan">Perusahaan</label>
                                <select class="form-control select" name="input_perusahaan"
                                    id="input-perusahaan"></select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-status">Status Sertifikat</label>
                                <select class="form-control select" name="input_status" id="input-status"></select>
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
        <div class="col-12">
            <div class="table-responsive">
                <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                    <div class="datatable-top">
                        <div class="datatable-dropdown">
                            <label>
                                <select class="datatable-selector" style="width: auto;min-width: unset;" id="limitPage">
                                    <option value="5">5</option>
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
            <div class="table-responsive mb-5">
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
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('assets/js/excel/xlsx-populate.min.js') }}"></script>
    <script src="{{ asset('assets/js/excel/file-saver.min.js') }}"></script>
    <script src="{{ asset('assets/js/date/moment.js') }}"></script>
    <script src="{{ asset('assets/js/date/date-language-format.js') }}"></script>
    <script src="{{ asset('assets/js/date/daterange-picker.js') }}"></script>
    <script src="{{ asset('assets/js/date/daterange-custom.js') }}"></script>
    <script src="{{ asset('assets/js/date/date-DMY-format.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
@endsection
@section('page_js')
    <script>
        let env = '{{ url('') }}/api';
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let customFilter = {};

        function calculateBusinessDays(startDate, endDate) {
            let count = 0;
            let curDate = moment(startDate).startOf('day');
            let lastDate = moment(endDate).startOf('day');
            while (curDate.isSameOrBefore(lastDate)) {
                if (curDate.isoWeekday() !== 6 && curDate.isoWeekday() !== 7) {
                    count++;
                }
                curDate.add(1, 'days');
            }

            return count;
        }

        async function getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            loadingPage(true);
            let card = $('#submission-card');
            // let countPaging = $('#countPage');
            // let totalPaging = $('#totalPage');
            // let tablePaging = $('#tableList');

            const getDataRest = await CallAPI(
                    'GET',
                    `${env}/internal/admin-panel/pengajuan-sertifikat/list`, {
                        page: currentPage,
                        limit: defaultLimitPage,
                        ascending: defaultAscending,
                        search: defaultSearch,
                        searchByPerusahaan: Object.keys(customFilter).length !== 0 ? customFilter['company'] : '',
                        searchByStatus: Object.keys(customFilter).length !== 0 ? customFilter['status'] : '',
                        searchByPenilai: Object.keys(customFilter).length !== 0 ? customFilter['assesor'] : '',
                        date_from: customFilter?.['start_date'] || '',
                        date_to: customFilter?.['end_date'] || '',
                    }
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
                document.getElementById('total_permohonan').innerText = data.pagination.total || '-';
                document.getElementById('ket_total').innerText = data.pagination.total ? 'Permohonan' : '';

                let dataTable = data.data;
                if (dataTable.length === 0) {
                    card.html(`
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="text-center">Tidak Ada Permohonan Penilaian Sertifikat.</h5>
                                </div>
                            </div>
                        </div>
                    `);
                    $('#totalPage').text('0');
                    $('#countPage').text('0 - 0');
                } else {
                    totalPage = getDataRest.data.pagination.total;
                    let data = getDataRest.data.data;
                    let display_from = ((defaultLimitPage * getDataRest.data.pagination.current_page) + 1) -
                        defaultLimitPage;
                    let display_to = currentPage < getDataRest.data.pagination.total_pages ? data.length <
                        defaultLimitPage ? data.length : (defaultLimitPage * getDataRest.data.pagination.current_page) :
                        totalPage;
                    $('#totalPage').text(getDataRest.data.pagination.total);
                    $('#countPage').text("" + display_from + " - " + display_to + "");
                    let domTableHtml = "";
                    let index_loop = display_from;
                    const processStatuses = [
                        'request',
                        'disposition',
                        'not_passed_assessment',
                        'submission_revision',
                        'passed_assessment',
                        'not_passed_assessment_verification',
                        'assessment_revision',
                        'passed_assessment_verification',
                        'scheduling_interview',
                        'scheduled_interview',
                        'not_passed_interview',
                        'completed_interview',
                        'verification_director'
                    ];
                    let totalInProcess = dataTable.filter(item => processStatuses.includes(item.status)).length;

                    const expStatuses = [
                        'expired'
                    ];
                    let totalExpired = dataTable.filter(item => expStatuses.includes(item.status)).length;

                    const verifiedStatuses = [
                        'certificate_validation'
                    ];
                    let totalVerified = dataTable.filter(item => verifiedStatuses.includes(item.status)).length;

                    document.getElementById('total_proses').innerText = totalInProcess || '-';
                    document.querySelector('.ket_proses').innerText = totalInProcess ? 'Berlangsung' : '';
                    document.getElementById('total_kadaluwarsa').innerText = totalExpired || '-';
                    document.querySelector('.ket_kadaluwarsa').innerText = totalExpired ? 'Kadaluwarsa' : '';
                    document.getElementById('total_verified').innerText = totalVerified || '-';
                    document.querySelector('.ket_verified').innerText = totalVerified ? 'Selesai' : '';

                    const statusLabels = {
                        'draft': 'Draft',
                        'request': 'Pengajuan',
                        'disposition': 'Disposisi',
                        'not_passed_assessment': 'Tidak lulus penilaian',
                        'submission_revision': 'Revisi pengajuan',
                        'passed_assessment': 'Lulus penilaian',
                        'not_passed_assessment_verification': 'Penilaian tidak lulus verifikasi',
                        'assessment_revision': 'Revisi penilaian',
                        'passed_assessment_verification': 'Penilaian terverifikasi',
                        'scheduling_interview': 'Penjadwalan wawancara',
                        'scheduled_interview': 'Wawancara Terjadwal',
                        'not_passed_interview': 'Tidak lulus wawancara',
                        'completed_interview': 'Wawancara selesai',
                        'verification_director': 'Validasi direktur',
                        'certificate_validation': 'Pengesahan sertifikat',
                        'rejected': 'Pengajuan ditolak',
                        'cancelled': 'Pengajuan dibatalkan',
                        'expired': 'Pengajuan kedaluwarsa'
                    };
                    for (let index = 0; index < dataTable.length; index++) {
                        let element = dataTable[index];
                        let colorBage = 'primary';
                        if (element.status.includes('draft')) {
                            colorBage = 'secondary';
                        }
                        if (element.status.includes('not')) {
                            colorBage = 'warning';
                        }
                        if (element.status.includes('expired')) {
                            colorBage = 'dark';
                        }
                        if (element.status.includes('complete') || element.status.includes('passed_assessment_') ||
                            element.status == 'certificate_validation') {
                            colorBage = 'success';
                        }
                        if (element.status.includes('expired') ||
                            element.status.includes('cancelled') ||
                            element.status.includes('rejected') || (element.rejection_notes && element.rejection_notes
                                .length > 0)
                        ) {
                            colorBage = 'danger';
                        }
                        let badgeStatus =
                            `<small class="badge bg-light-${colorBage} ms-2 f-14">${statusLabels[element.status]}</small>`;

                        let created_at = moment(element.created_at, 'YYYY-MM-DD');
                        let current = moment();
                        let lastUpdated = element.updated_at ? moment(element.updated_at, 'YYYY-MM-DD') : current;

                        let weekDays = calculateBusinessDays(created_at, current);

                        // Jika status 'certificate_validation', hitung dari updated_at hingga sekarang
                        if (element.status === 'certificate_validation') {
                            weekDays = calculateBusinessDays(lastUpdated, created_at);
                        }
                        let progressLabel = `${weekDays} hari`;
                        let statusBadge = element.is_active ?
                            '<span class="badge bg-light-success">Aktif</span>' :
                            '<span class="badge bg-light-danger">Tidak Aktif</span>';

                        let statusLabel = element.status === "disposition" ?
                            '<span class="badge bg-light-primary">Pengajuan Baru</span>' :
                            '<span class="badge bg-light-success">Draft</span>';

                        let lastUpdate = new Date(element.updated_at).toLocaleDateString();
                        let createdDate = new Date(element.created_at).toLocaleDateString();

                        let cardClass = element.status === 'certificate_validation' ? 'ticket-card close-ticket' :
                            (element.rejection_notes && element.rejection_notes.length > 0 ? 'ticket-card open-ticket' :
                                'ticket-card');

                        let profileClass = element.status === 'certificate_validation' ? 'bg-success' :
                            (element.rejection_notes && element.rejection_notes.length > 0 ? 'bg-danger' :
                                'bg-primary');

                        let truncatedNotes = element.rejection_notes && element.rejection_notes.length !== null ?
                            element.rejection_notes.substring(0, 100) + '...' : element.rejection_notes || '';

                        domTableHtml += `
                            <div class="card ${cardClass}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-auto mb-3 mb-sm-0">
                                            <div class="d-sm-inline-block d-flex align-items-center">
                                                <div
                                                    class="wid-60 hei-60 rounded-circle bg-${colorBage} d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-file-lines text-white fa-2x"></i>
                                                </div>
                                                <div class="ms-3 ms-sm-0">
                                                    <ul class="text-sm-center list-unstyled mt-2 mb-0 d-inline-block">
                                                        <li class="list-unstyled-item"><a href="#" class="link-secondary">${element.notes_count ? element.notes_count + ' Catatan' : ''}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col">
                                            <div class="popup-trigger">
                                                <div
                                                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                                    <div class="h4 font-weight-bold mb-2 mb-md-0">
                                                        No. Pendaftaran: ${element.regnumber || '-'}
                                                        ${badgeStatus}
                                                    </div>
                                                    <div>
                                                        <span class="badge bg-light-dark px-3 py-2 mb-3 mb-md-0">Lama Proses:
                                                            ${progressLabel}</span>
                                                    </div>
                                                </div>

                                                <div class="help-sm-hidden">
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="ph-duotone ph-buildings me-1"></i>
                                                            <b>${element.company_name || '-'}</b>
                                                        </li>
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                           <i class="fa-solid fa-user-tie me-1"></i>
                                                            Penilai : <b>${element.disposition_to ? element.disposition_to.name : '-'}</b>
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-regular fa-calendar-days me-1"></i>Diajukan
                                                            <b>${element.created_at? formatTanggalIndo(element.created_at) : ''}</b>
                                                        </li>
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-solid fa-calendar-day me-1"></i><b>Jadwal
                                                                Interview : </b>${element.schedule_interview ? formatTanggalIndo(element.schedule_interview) : 'Tidak ada wawancara'}</li>
                                                    </ul>
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-solid fa-clipboard-list me-1"></i><b>Jenis Pelayanan :
                                                            </b>
                                                            ${element.company?.service_types?.map(service => service.name).join(', ') || '-'}
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                           <i class="fa-solid fa-user-tie me-1"></i>
                                                            Posisi : <b>${element.disposition_by ? element.disposition_by.name : '-'}</b>
                                                        </li>
                                                    </ul>
                                                </div>
                                                ${element.rejection_notes ? `
                                                                                                                        <div class="h5 mt-4"><i class="fa-solid fa-note-sticky me-1"></i>
                                                                                                                            Catatan Permohonan</div>
                                                                                                                        <div class="help-md-hidden">
                                                                                                                            <div class="bg-body mb-3 p-3">
                                                                                                                                <h6><img src="{{ asset('assets') }}/images/user/"
                                                                                                                                        alt="" class="wid-20 avatar me-2 rounded">Catatan terakhir dari <a href="#" class="link-secondary">${element.updated_by}</a></h6>
                                                                                                                                <p class="mb-0">
                                                                                                                                    ${truncatedNotes}
                                                                                                                                </p>
                                                                                                                            </div>
                                                                                                                        </div>`
                                                    :
                                                ''}
                                            </div>
                                            <div class="mt-4">
                                                ${element.rejection_notes ? `
                                                                                                                    <button type="button" class="me-2 btn btn-sm btn-light-danger"
                                                                                                                        data-bs-toggle="modal" data-bs-target="#exampleModalCenter" onclick="showModalNotes('${element.rejection_notes}')" style="border-radius: 5px;">
                                                                                                                        <i class="ti ti-eye me-1"></i> Lihat Catatan
                                                                                                                    </button>` : ''}
                                                <a href="/admin/sertifikat/detail?r=${element.id}" class="me-2 btn btn-sm btn-light-secondary"
                                                    style="border-radius:5px;"><i class="feather icon-eye mx-1 me-2"></i>Lihat
                                                    Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                    }
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

        async function selectFilterStatus(id, placeholder) {
            const data = {
                request: 'Pengajuan',
                disposition: 'Disposisi',
                not_passed_assessment: 'Tidak lulus penilaian',
                submission_revision: 'Perbaikan dokumen',
                passed_assessment: 'Lulus penilaian',
                not_passed_assessment_verification: 'Tidak lulus verifikasi penilaian',
                assessment_revision: 'Perbaikan penilaian',
                passed_assessment_verification: 'Lulus verifikasi penilaian',
                scheduling_interview: 'Penjadwalan wawancara',
                scheduled_interview: 'Wawancara terjadwal',
                completed_interview: 'Wawancara selesai',
                verification_director: 'Verifikasi direktur',
                certificate_validation: 'Pengesahan Sertifikat',
                rejected: 'Ditolak',
                cancelled: 'Dibatalkan',
                expired: 'Kedaluarsa',
                draft: 'Draft'
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

        async function performSearch() {
            defaultSearch = $('.search-input').val();
            defaultLimitPage = $("#limitPage").val();
            currentPage = 1;
            await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
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

        async function fetchFilteredData(filter = {}) {
            loadingPage(true);

            const formatDate = (date) => {
                if (!date || isNaN(new Date(date).getTime())) {
                    console.warn('Invalid date value:', date);
                    return ''; // Return an empty string for invalid dates
                }
                const d = new Date(date);
                return d.toISOString().split('T')[0]; // Format YYYY-MM-DD
            };

            let formattedStartDate = formatDate(filter['start_date']);
            let formattedEndDate = formatDate(filter['end_date']);

            if (!formattedStartDate || !formattedEndDate) {
                notificationAlert('warning', 'Error', 'Tanggal mulai atau tanggal akhir tidak valid.');
                loadingPage(false);
                return [];
            }

            let params = {
                searchByStatus: filter['status'] || '',
                searchByPerusahaan: filter['company'] || '',
                searchByPenilai: filter['assesor'] || '',
                date_from: formattedStartDate,
                date_to: formattedEndDate,
                limit: filter['limit'] || 10,
                ascending: true
            };

            try {
                let getDataRest = await CallAPI('GET',
                    `{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/list`, params);


                if (getDataRest.data.status_code === 200) {
                    let data = getDataRest.data.data;

                    let filteredData = data.filter(item => {
                        let createdAt = moment(item.created_at).startOf('day').format('YYYY-MM-DD');

                        return ((!params.searchByStatus || item.status === params.searchByStatus) &&
                            (!params.searchByPerusahaan || String(item.company.id) === params
                                .searchByPerusahaan) &&
                            (!params.searchByPenilai || String(item.disposition_to.id) === params
                                .searchByPenilai) &&
                            (!params.date_from || createdAt >= params.date_from) &&
                            (!params.date_to || createdAt <= params.date_to));
                    });


                    if (filteredData.length > 0) {
                        notificationAlert('success', 'Berhasil', 'Silahkan periksa file anda.');
                        loadingPage(false);
                        return filteredData;
                    } else {
                        notificationAlert('info', 'Pemberitahuan',
                            'Data tidak ditemukan dengan filter yang diberikan.');
                        loadingPage(false);
                        return [];
                    }
                } else {
                    notificationAlert('error', 'Error', 'Gagal mendapatkan data.');
                    loadingPage(false);
                    return [];
                }
            } catch (error) {
                notificationAlert('warning', 'Error', 'Terjadi kesalahan saat memuat data.');
                console.error('Fetch error:', error);
                loadingPage(false);
                return [];
            }
        }


        async function customFilterTable() {
            // Inisialisasi flatpickr
            let dateRangePicker = initializeDateRangePicker();

            function getStartEndDate() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                return {
                    startDate,
                    endDate
                };
            }

            document.getElementById('custom-filter').addEventListener('submit', async function(e) {
                e.preventDefault();

                let {
                    startDate,
                    endDate
                } = getStartEndDate();
                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');
                } else {
                    startDate = '';
                    endDate = '';
                }


                // Ambil nilai lain untuk filter
                let assesor = document.getElementById('input-penilai').value;
                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'assesor': assesor,
                    'company': company,
                    'status': status,
                    'start_date': startDate,
                    'end_date': endDate
                };

                currentPage = 1;
                await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
            });

            // Download actions for Excel, CSV, and PDF
            document.getElementById('download-excel').addEventListener('click', async function() {
                let {
                    startDate,
                    endDate
                } = getStartEndDate();

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');

                } else {
                    startDate = '';
                    endDate = '';
                }
                let assesor = document.getElementById('input-penilai').value;
                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'status': status,
                    'company': company,
                    'assesor': assesor,
                    'start_date': startDate,
                    'end_date': endDate
                };

                let timeDiff = new Date(endDate) - new Date(startDate);
                let dayDiff = timeDiff / (1000 * 3600 * 24);

                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                await getFilterDownload(customFilter, startDate, endDate);
            });

            document.getElementById('download-csv').addEventListener('click', async function() {
                let {
                    startDate,
                    endDate
                } = getStartEndDate();

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');

                } else {
                    startDate = '';
                    endDate = '';
                }
                let assesor = document.getElementById('input-penilai').value;
                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'status': status,
                    'company': company,
                    'assesor': assesor,
                    'start_date': startDate,
                    'end_date': endDate
                };

                let timeDiff = new Date(endDate) - new Date(startDate);
                let dayDiff = timeDiff / (1000 * 3600 * 24);

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
                let {
                    startDate,
                    endDate
                } = getStartEndDate();

                if ($("#daterange").val() !== '') {
                    startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                    endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');

                } else {
                    startDate = '';
                    endDate = '';
                }
                let assesor = document.getElementById('input-penilai').value;
                let company = document.getElementById('input-perusahaan').value;
                let status = document.getElementById('input-status').value;

                customFilter = {
                    'status': status,
                    'company': company,
                    'assesor': assesor,
                    'start_date': startDate,
                    'end_date': endDate
                };

                let timeDiff = new Date(endDate) - new Date(startDate);
                let dayDiff = timeDiff / (1000 * 3600 * 24);

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

            document.getElementById('resetCustomFilter').addEventListener('click', async function() {
                window.location.reload();
            });
        }

        async function getFilterDownload(filter = {}, startDate, endDate) {

            loadingPage(true);

            const formatDate = (date) => {
                const d = new Date(date);
                return d.toISOString().split('T')[0]; // Formats to 'YYYY-MM-DD'
            };

            // Format startDate and endDate
            let formattedStartDate = formatDate(startDate);
            let formattedEndDate = formatDate(endDate);

            let params = {
                status: filter['status'] || '',
                company: filter['company'] || '',
                assesor: filter['assesor'] || '',
                date_from: formatDate(filter['start_date'] || formattedStartDate),
                date_to: formatDate(filter['end_date'] || formattedEndDate),
                limit: filter['limit'],
                ascending: true
            };

            try {
                // Fetch data from the JSON file
                let getDataRest = await CallAPI('GET',
                        `{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/list`, params)
                    .then(function(response) {
                        return response;
                    })
                    .catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('warning', 'Error', 'Tidak dapat memuat data');
                        return resp;
                    });


                // Check if the request was successful
                if (getDataRest.data.status_code == 200) {
                    let data = getDataRest.data.data;


                    // Filter data based on parameters
                    let filteredData = data.filter(item => {
                        return (!params.status || item.status === params.status) &&
                            (!params.company || item.nama_perusahaan === params.company) &&
                            (!params.assesor || item.penilai === params.assesor) &&
                            (!params.start_date || new Date(item.tanggal_pengajuan) >= new Date(params
                                .start_date)) &&
                            (!params.end_date || new Date(item.tanggal_pengajuan) <= new Date(params.end_date));
                    });


                    if (filteredData.length > 0) {
                        await downloadToExcel(filteredData, formattedStartDate,
                            formattedEndDate);
                        notificationAlert('success', 'Berhasil', 'Silahkan periksa file anda');
                    } else {
                        notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                    }
                } else {
                    notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                }
            } catch (error) {
                notificationAlert('warning', 'Error', 'Tidak dapat memuat data');
            } finally {
                loadingPage(false);
            }
        }

        function mapData(data) {
            return data.map((item, index) => {
                let created_at = moment(item.created_at, 'YYYY-MM-DD');
                let current = moment();
                let lastUpdated = item.updated_at ? moment(item.updated_at, 'YYYY-MM-DD') : current;
                let weekDays = calculateBusinessDays(created_at, current);
                if (item.status === 'certificate_validation') {
                    weekDays = calculateBusinessDays(lastUpdated, current);
                }
                let progressLabel = `${weekDays} hari`;

                const statusLabels = {
                    'draft': 'Draft',
                    'request': 'Pengajuan',
                    'disposition': 'Disposisi',
                    'not_passed_assessment': 'Tidak lulus penilaian',
                    'submission_revision': 'Revisi pengajuan',
                    'passed_assessment': 'Lulus penilaian',
                    'not_passed_assessment_verification': 'Penilaian tidak lulus verifikasi',
                    'assessment_revision': 'Revisi penilaian',
                    'passed_assessment_verification': 'Penilaian terverifikasi',
                    'scheduling_interview': 'Penjadwalan wawancara',
                    'scheduled_interview': 'Wawancara Terjadwal',
                    'not_passed_interview': 'Tidak lulus wawancara',
                    'completed_interview': 'Wawancara selesai',
                    'verification_director': 'Validasi direktur',
                    'certificate_validation': 'Pengesahan sertifikat',
                    'rejected': 'Pengajuan ditolak',
                    'cancelled': 'Pengajuan dibatalkan',
                    'expired': 'Pengajuan kedaluwarsa'
                };

                // Mengambil nama service types dari company
                let serviceTypes = '-';
                if (item.company && Array.isArray(item.company.service_types)) {
                    serviceTypes = item.company.service_types.map(service => service.name).join(', ');
                }

                return {
                    No: index + 1,
                    Header1: item.regnumber || '-',
                    Header2: item.company_name || '-',
                    Header3: serviceTypes, // Menambahkan serviceTypes setelah company_name
                    Header4: statusLabels[item.status] || '-',
                    Header5: progressLabel,
                    Header6: item.disposition_to && item.disposition_to.name ? item.disposition_to.name : '-',
                    Header7: item.schedule_interview ? dateDMYFormat(item.schedule_interview) : '-',
                    Header8: item.disposition_by ? item.disposition_by.name : '-',
                    Header9: item.created_at ? dateDMYFormat(item.created_at) : '-'
                };
            });
        }

        async function downloadToExcel(data, fromDate, toDate) {
            let selectedData = mapData(data);

            let header = [
                'No.',
                'No. Pendaftaran',
                'Nama Perusahaan',
                'Jenis Pelayanan',
                'Status',
                'Lama Proses',
                'Penilai',
                'Jadwal Interview',
                'Posisi',
                'Tanggal Pengajuan'
            ];

            let formattedFromDate = dateLanguageFormat(fromDate);
            let formattedToDate = dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            let fileName;
            if (sameDate) {
                title = `Daftar Pengajuan Sertifikan E-SMK ${formattedFromDate}`.toUpperCase();
                fileName = `Daftar Pengajuan Sertifikan E-SMK (${formattedFromDate}).xlsx`;
            } else {
                title = `Daftar Pengajuan Sertifikan E-SMK ${formattedFromDate} - ${formattedToDate}`.toUpperCase();
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
                            horizontalAlignment: "left"
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

            let headers = [
                'No.',
                'No. Pendaftaran',
                'Nama Perusahaan',
                'Jenis Pelayanan',
                'Status',
                'Lama Proses',
                'Penilai',
                'Jadwal Interview',
                'Posisi',
                'Tanggal Pengajuan'
            ];

            let csvContent = headers.join(',') + '\n';
            let selectedData = mapData(data);

            selectedData.forEach(row => {
                csvContent += Object.values(row).join(',') + '\n';
            });

            let blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            let link = document.createElement('a');
            let fileName = `Perusahaan e-SMK (${formattedFromDate} - ${formattedToDate}).csv`;

            if (navigator.msSaveBlob) {
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
            let selectedData = mapData(data);

            let header = [
                'No.',
                'No. Pendaftaran',
                'Nama Perusahaan',
                'Jenis Pelayanan',
                'Status',
                'Lama Proses',
                'Penilai',
                'Jadwal Interview',
                'Posisi',
                'Tanggal Pengajuan'
            ];

            let formattedFromDate = dateLanguageFormat(fromDate);
            let formattedToDate = dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            if (sameDate) {
                title = `Daftar Pengajuan Penilaian e-SMK ${formattedFromDate}`.toUpperCase();
            } else {
                title = `Daftar Pengajuan Penilaian e-SMK ${formattedFromDate} - ${formattedToDate}`.toUpperCase();
            }

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
                    cellPadding: 4
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
                        halign: 'center',
                        cellWidth: 30
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
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                },
                afterPageOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                },
                afterNextOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                },
            });
        }

        async function initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
            customFilter) {
            await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
            await paginationDataOnTable(defaultLimitPage);
        }


        async function initPageLoad() {
            await Promise.all([
                customFilterTable(),
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter),
                manipulationDataOnTable(),
                selectFilterStatus('#input-status', 'Pilih status sertifikat'),
                selectFilter('#input-penilai',
                    '{{ url('') }}/api/internal/admin-panel/assessor-list',
                    'Pilih penilai'),
                selectFilter('#input-perusahaan',
                    '{{ url('') }}/api/internal/admin-panel/perusahaan/list',
                    'Pilih perusahaan'),
            ]);
        }
    </script>
@endsection
