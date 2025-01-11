@extends('...Company.index', ['title' => 'Sertifikat SMK'])
@section('asset_css')
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/company/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Permohonan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Sertifikat SMK</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Sertifikat SMK</h2>
                    </div>

                    <div id="for-create-button">
                        <a href="javascript:void(0);" data-pc-animate="fade-in-scale" onClick="goToSubmissionCreatePage()"
                            class="btn btn-md btn-primary px-3 p-2">
                            <i class="fas fa-plus-circle me-2"></i> Buat Permohonan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><!-- [ sample-page ] start -->
        <div class="col-12">
            <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns datatable-empty">
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
                        <input id="searchInput" class="datatable-input" placeholder="Cari..." type="search" name="search"
                            title="Search within table" aria-controls="pc-dt-simple-1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12 help-main large-view">
                    <div id="tableList"></div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="datatable-bottom">
                <div class="datatable-info">Menampilkan <span id="countPage">0</span>
                    dari <span id="totalPage">0</span> data</div>
                <nav class="datatable-pagination">
                    <ul class="datatable-pagination-list" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    <div id="notesModalCenter" class="modal fade" tabindex="-1" aria-labelledby="notesModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notesModalCenterTitle">Catatan Pengajuan</h5>
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
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>
@endsection

@section('page_js')
    <script>
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = "";
        let paramsTable = {};
        let statusLabels = {
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

        async function buttonAddSubmission() {

            const checkActive = await getActiveCertificateRequest();

            if (checkActive.data.data?.length == 0) {
                $('#for-create-button').empty();
                $('#for-create-button').append(`
                    <a href="javascript:void(0);" data-pc-animate="fade-in-scale" onClick="goToSubmissionCreatePage()"
                        class="btn btn-md btn-primary px-3 p-2">
                        <i class="fas fa-plus-circle me-2"></i> Buat Permohonan
                    </a>
                `);
            } else {
                $('#for-create-button').empty();
            }
        }


        async function getActiveCertificateRequest() {
            try {
                const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/company/documents/submission/active-submmision`
                );
                return getDataRest;
            } catch (error) {
                loadingPage(false);
                return resp;
            }
        }


        async function goToSubmissionCreatePage() {

            const checkActiveCertificateRequest = await getActiveCertificateRequest();

            if (checkActiveCertificateRequest.data.data?.length > 0) {
                notificationAlert('info', 'Pemberitahuan', 'Anda Memiliki Pengajuan Aktif');
                return false;
            }
            window.location.href = `{{ route('company.certificate.create') }}`;
        }

        async function getListData(paramsTable) {
            loadingPage(true);
            let countPaging = $('#countPage');
            let totalPaging = $('#totalPage');
            let tablePaging = $('#tableList');

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/company/documents/submission/index`, {
                        page: paramsTable.currentPage,
                        limit: paramsTable.defaultLimitPage,
                        ascending: paramsTable.defaultAscending,
                        search: paramsTable.defaultSearch,
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
                let dataTable = data.data;
                let totalPage = data.pagination.total;
                paramsTable.totalPage = totalPage;

                if (dataTable.length === 0) {
                    tablePaging.html(`
                        <div class="card">
                            <div class="card-body text-center"><strong>Tidak ada data.</strong></div>
                        </div>
                    `);
                    countPaging.text("0 - 0");
                    totalPaging.text("0");
                } else {
                    let display_from = ((paramsTable.defaultLimitPage * getDataRest.data.pagination.current_page) + 1) -
                        paramsTable.defaultLimitPage;
                    let display_to = paramsTable.currentPage < getDataRest.data.pagination.total_pages ?
                        dataTable.length < paramsTable.defaultLimitPage ?
                        dataTable.length :
                        (paramsTable.defaultLimitPage * getDataRest.data.pagination.current_page) :
                        totalPage;
                    let index_loop = display_from;
                    let domTableHtml = "";
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

                        let statusBadge = element.is_active ?
                            '<span class="badge bg-light-success">Aktif</span>' :
                            '<span class="badge bg-light-danger">Tidak Aktif</span>';

                        let statusLabelColor = 'primary';
                        if (element.status === 'draft') {
                            statusLabelColor = 'secondary';
                        }
                        if (element.status === 'certificate_validation') {
                            statusLabelColor = 'success';
                        }
                        if (element.status === 'rejected' ||
                            element.status === 'cancelled' |
                            element.status === 'expired') {
                            statusLabelColor = 'danger';
                        }
                        let statusLabel =
                            `<span class="badge bg-light-${statusLabelColor}">${statusLabels[element.status]}</span>`;

                        let lastUpdate = new Date(element.updated_at).toLocaleDateString();
                        let createdDate = new Date(element.created_at).toLocaleDateString();

                        let cardClass = element.status === 'certificate_validation' ? 'ticket-card close-ticket' :
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
                                                    <i class="fa-solid fa-file-alt text-white fa-2x"></i>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="popup-trigger">
                                                <div class="h5 font-weight-bold">No. Surat Permohonan: ${element.number_of_application_letter}</div>
                                                <div class="help-sm-hidden">
                                                    <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="ti ti-file-certificate text-center fa-lg"></i>
                                                            ${statusLabel}
                                                        </li>
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="wid-20 material-icons-two-tone text-center f-14">calendar_today</i>Diajukan ${createdDate}
                                                        </li>
                                                        <li class="d-sm-inline-block d-block mt-1 me-3">
                                                            <i class="wid-20 material-icons-two-tone text-center f-14">calendar_today</i>Terakhir diubah ${lastUpdate}
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
                                                                        <img src="{{ asset('assets') }}/images/user/avatar-5.jpg"
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
                                                                data-bs-toggle="modal" data-bs-target="#notesModalCenter" onclick="showModalNotes('${element.rejection_notes}')" style="border-radius: 5px;">
                                                                <i class="ti ti-eye me-1"></i> Lihat Catatan
                                                            </button>` : ''}
                                                <a href="/company/pengajuan-sertifikat/detail?id=${element.id}"
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

                    countPaging.html(`${display_from} - ${display_to}`);
                    totalPaging.html(getDataRest.data.pagination.total);
                    tablePaging.empty();
                    tablePaging.html(domTableHtml);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
        }

        function showModalNotes(notes) {
            $('#notesModalCenter .modal-body').html(`<p>${notes}</p>`);
            $('#notesModalCenter').modal('show');
        }


        async function initPageLoad() {
            paramsTable = {
                "defaultLimitPage": 10,
                "currentPage": 1,
                "totalPage": 0,
                "defaultAscending": 1,
                "defaultSearch": '',
            };

            await manipulationDataTable(paramsTable, '#pagination', '#limitPage',
                '#searchInput', getListData);
            await buttonAddSubmission();
        }
    </script>
    @include('Company.partial-js')
@endsection
