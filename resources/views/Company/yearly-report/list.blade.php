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
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Laporan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Laporan Tahunan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Laporan Tahunan</h2>
                    </div>
                    <a href="/company/yearly-report/create" data-pc-animate="fade-in-scale"
                        class="btn btn-md btn-primary px-3 p-2">
                        <i class="fas fa-plus-circle me-2"></i> Buat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><!-- [ sample-page ] start -->
        <div class="col-12">
            <div
                class="datatable-wrapper datatable-loading no-footer searchable fixed-columns datatable-empty">
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
                        <input id="searchInput" class="datatable-input" placeholder="Cari..."
                            type="search" name="search" title="Search within table"
                            aria-controls="pc-dt-simple-1">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>
@endsection

@section('page_js')
    <script>
        let defaultLimitPage = 10;
        let currentPage      = 1;
        let totalPage        = 1;
        let defaultAscending = 0;
        let defaultSearch    = "";
        let paramsTable      = {};


        async function getListData(paramsTable) {
            loadingPage(true);
            let countPaging = $('#countPage');
            let totalPaging = $('#totalPage');
            let tablePaging = $('#tableList');

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ env("SERVICE_BASE_URL") }}/company/laporan-tahunan/monitoring-element`,
                    {
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

                        let statusBadge = element.is_active ?
                            '<span class="badge bg-light-success">Aktif</span>' :
                            '<span class="badge bg-light-danger">Tidak Aktif</span>';

                        // let statusLabel = element.status === "disposition" ?
                        //     '<span class="badge bg-light-primary">Pengajuan Baru</span>' :
                        //     '<span class="badge bg-light-success">Terverifikasi</span>';

                        let lastUpdate = new Date(element.approved_at).toLocaleDateString();
                        let createdDate = new Date(element.created_at).toLocaleDateString();

                        let statusLabel = '';
                        let colorBage = 'primary';
                        switch (element.status) {
                            case "request":
                                statusLabel = '<span class="badge bg-light-secondary">Pengajuan Baru</span>';
                                colorBage = 'primary';
                                break;
                            case "revision":
                                statusLabel = '<span class="badge bg-light-danger">Revisi</span>';
                                colorBage = 'danger';
                                break;
                            case "verified":
                                statusLabel = '<span class="badge bg-light-success">Terverifikasi</span>';
                                colorBage = 'success';
                                break;
                            default:
                                statusLabel = '<span class="badge bg-light-warning">Status Tidak Diketahui</span>';
                                colorBage = 'warning';
                                break;
                        }

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
                                                    <i class="fa-solid fa-calendar text-white fa-2x"></i>
                                                </div>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="popup-trigger">
                                            <div class="h5 font-weight-bold">Tahun Laporan: ${element.year}</div>
                                            <div class="help-sm-hidden">
                                                <ul class="list-unstyled mt-2 mb-0 text-muted">
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="ti ti-file-certificate me-1 fa-lg"></i>
                                                        ${statusLabel}
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fas fa-user me-1 "></i>
                                                            Diproses Oleh: <b>${element?.assessor?.name || '-'}</b>
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="material-icons-two-tone text-center f-14 me-1">calendar_today</i>Diajukan ${createdDate}
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="material-icons-two-tone text-center f-14 me-1">calendar_today</i>Disetujui ${lastUpdate}
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
                                                    </div>` :
                                                    ''}
                                        </div>
                                        <div class="mt-4">
                                            ${element.rejection_notes ? `
                                                    <button type="button" class="me-2 btn btn-sm btn-light-danger"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModalCenter" onclick="showModalNotes('${element.rejection_notes}')" style="border-radius: 5px;">
                                                        <i class="ti ti-eye me-1"></i> Lihat Catatan
                                                    </button>` : ''}
                                            <a href="/company/yearly-report/detail?id=${element.id}&company_id=${element.company_id}"
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
            $('#exampleModalCenter .modal-body').html(`<p>${notes}</p>`);
            $('#exampleModalCenter').modal('show');
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
        }
    </script>
    @include('Company.partial-js')
@endsection
