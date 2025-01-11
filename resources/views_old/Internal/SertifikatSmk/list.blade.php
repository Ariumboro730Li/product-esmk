@extends('...Internal.index', ['title' => 'Detail | Data Perusahaan'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/flatpickr.min.css" />
    <style>
        .table th.sticky-end,
        .table td.sticky-end {
            position: sticky;
            right: 0;
            background-color: #fff;
            /* Warna background agar cocok */
            z-index: 1;
            /* Prioritaskan di atas elemen lain */
            border-left: 1px solid #dee2e6;
            /* Tambahkan garis batas */
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
                                    <input type="text" id="pc-date_range_picker-2" class="form-control"
                                        placeholder="Pilih rentang tanggal" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-penilai">Penilai</label>
                                <select class="form-control" name="input_penilai" id="input-penilai"></select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-perusahaan">Perusahaan</label>
                                <select class="form-control" name="input_perusahaan"
                                    id="input-perusahaan"></select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-normal" for="input-status">Status Sertifikat</label>
                                <select class="form-control" name="input_status" id="input-status"></select>
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
                            <input class="datatable-input searchInput" placeholder="Cari..." type="search"
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
    <script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>
    <script src="{{ asset('assets/js/date/moment.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>
    <script>
        function calculateBusinessDays(startDate, endDate) {
            let count = 0;
            let curDate = moment(startDate).startOf('day'); // Mulai dari hari pertama
            let lastDate = moment(endDate).startOf('day'); // Sampai dengan hari terakhir

            while (curDate.isSameOrBefore(lastDate)) {
                // Exclude weekend (Saturday = 6, Sunday = 7)
                if (curDate.isoWeekday() !== 6 && curDate.isoWeekday() !== 7) {
                    count++;
                }
                curDate.add(1, 'days');
            }

            return count;
        }

        async function getListData() {
            loadingPage(true);
            let card = $('#submission-card');

            // Memanggil API untuk mendapatkan data bidang
            const getDataRest = await CallAPI(
                    'GET',
                    `/dummy/internal/sertifikat/list_sertifikat.json`,
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
                        <tr>
                            <th class="text-center" colspan="5">Tidak ada data.</th>
                        </tr>
                    `);
                } else {
                    let domTableHtml = "";
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
                            element.status.includes('rejected') || (element.rejection_notes && element.rejection_notes.length > 0 )
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
                                                            <img src="{{ asset('assets') }}/images/user/avatar-5.jpg"
                                                                alt="" class="wid-20 rounded me-1 img-fluid">
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
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <img src="{{ asset('assets') }}/images/user/avatar-5.jpg"
                                                                alt="" class="wid-20 rounded me-1 img-fluid">
                                                            Posisi : <b>${element.disposition_by ? element.disposition_by.name : '-'}</b>
                                                        </li>
                                                    </ul>
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="fa-solid fa-clipboard-list me-1"></i><b>Jenis Pelayanan :
                                                            </b>
                                                            ${element.company?.service_types?.map(service => service.name).join(', ') || '-'}
                                                        </li>
                                                    </ul>
                                                </div>
                                                ${element.rejection_notes ? `
                                                                        <div class="h5 mt-4"><i class="fa-solid fa-note-sticky me-1"></i>
                                                                            Catatan Permohonan</div>
                                                                        <div class="help-md-hidden">
                                                                            <div class="bg-body mb-3 p-3">
                                                                                <h6><img src="{{ asset('assets') }}/images/user/avatar-5.jpg"
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
                                                <a href="/internal/sertifikat/detail" class="me-2 btn btn-sm btn-light-secondary"
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
                maxItemCount: 5
            }).setChoices(function() {
                return fetch(
                        route
                    )
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        return data.data.map(function(item) {
                            return {
                                value: item.id,
                                label: item.name
                            };
                        });
                    });
            });
        }

        async function selectFilterStatus(id, placeholder) {
            // Data didefinisikan langsung di dalam fungsi
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
                maxItemCount: 5
            }).setChoices(function() {
                // Mengonversi objek menjadi array untuk diolah oleh Choices.js
                const choicesArray = Object.entries(data).map(([key, value]) => ({
                    value: key,
                    label: value
                }));

                return Promise.resolve(choicesArray);
            });
        }

        async function initPageLoad() {
            flatpickr(document.querySelector('#pc-date_range_picker-2'), {
                mode: 'range'
            });
            await Promise.all([
                getListData(),
                selectFilterStatus('#input-status', 'Pilih status sertifikat'),
                selectFilter('#input-penilai',
                    '{{ asset('/dummy/internal/sertifikat/select_penilai.json') }}',
                    'Pilih penilai'),
                selectFilter('#input-perusahaan',
                    '{{ asset('/dummy/internal/sertifikat/select_perusahaan.json') }}',
                    'Pilih penilai'),
            ]);
        }
    </script>
    @include('Company.partial-js')
@endsection
