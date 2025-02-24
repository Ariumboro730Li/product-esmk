@extends('...Administrator.index', ['title' => 'Data Element Pemantauan'])


@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data Element Pemantauan</a></li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Data Element Pemantauan</h2>
                    </div>
                    <a href="/admin/element-pemantauan/create" class="btn btn-md btn-primary px-3 p-2 mt-3 mt-md-0">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Data
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->


    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                            aria-labelledby="analytics-tab-1" tabindex="0">
                            <div class="table-responsive">
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
                                    <div class="datatable-container">
                                        <table class="table table-hover datatable-table" id="pc-dt-simple-1">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10.24%;">NO</th>
                                                    <th style="width: 30.4%;">NAMA ELEMENT</th>
                                                    <th style="width: 13.919999999999998%;">STATUS</th>
                                                    <th style="width: 32.64%;">TANGGAL DIBUAT</th>
                                                    <th class="text-end" style="width: 12.8%;">AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableList">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="datatable-bottom">
                                        <div class="datatable-info">Menampilkan <span id="countPage">0</span>
                                            dari <span id="totalPage">0</span> data</div>
                                        <nav class="datatable-pagination">
                                            <ul class="datatable-pagination-list" id="pagination"></ul>
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
@endsection
@section('scripts')
    <script src="https://ableproadmin.com/assets/js/plugins/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paginationjs/2.1.5/pagination.min.js"></script>
@endsection

@section('page_js')
    <script>
    let paramsTable         = {};
        async function getListData(paramsTable) {
            loadingPage(true);
            let countPaging = $('#countPage');
            let totalPaging = $('#totalPage');
            let tablePaging = $('#tableList');

            // Memanggil API untuk mendapatkan data bidang
            const getDataRest = await CallAPI(
                    'GET',
                    '{{ url('') }}/api/internal/admin-panel/monitoring-element/list',
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
                let totalPage = data.paginate.total;
                paramsTable.totalPage = totalPage;

                if (dataTable.length === 0) {
                    tablePaging.html(`
                <tr>
                    <th class="text-center" colspan="5">Tidak ada data.</th>
                </tr>
            `);
                    countPaging.text("0 - 0");
                    totalPaging.text("0");
                } else {
                    let display_from = ((paramsTable.defaultLimitPage * getDataRest.data.paginate.current_page) + 1) -
                        paramsTable.defaultLimitPage;
                    let display_to = paramsTable.currentPage < getDataRest.data.paginate.total_pages ?
                        dataTable.length < paramsTable.defaultLimitPage ?
                        dataTable.length :
                        (paramsTable.defaultLimitPage * getDataRest.data.paginate.current_page) :
                        totalPage;
                    let index_loop = display_from;
                    let domTableHtml = "";

                    for (let index = 0; index < dataTable.length; index++) {
                        let element = dataTable[index];
                        const elementData = JSON.stringify(element);
                        const isActive = element.is_active === true;
                        const statusBadge = isActive ?
                            `<span class="badge bg-success d-flex align-items-center justify-content-center text-white" style="max-width: 100px; white-space: nowrap;"><i class="fa fa-check-circle me-2"></i> Aktif</span>` :
                            `<span class="badge bg-danger d-flex align-items-center justify-content-center text-white" style="max-width: 100px; white-space: nowrap;"><i class="fa fa-times-circle me-2"></i> Tidak Aktif</span>`;

                        const actionButton = isActive ?
                            `<a class="avtar avtar-s btn-link-danger change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Nonaktifkan Status ${element.title}" data-id="${element.id}" data-status="nonaktifkan">
                                        <i class="fa-solid fa-square-xmark fa-lg"></i>
                            </a>` :
                            `<a class="avtar avtar-s btn-link-success change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Aktifkan Status ${element.title}" data-id="${element.id}" data-status="aktifkan">
                                    <i class="fa-solid fa-square-check fa-lg"></i>
                                </a>`;


                        domTableHtml += `
                            <tr>
                              <td class="text-start">${index_loop}.</td>
                                <td class="fw-bold text-start">${element.title}</td>
                                <td class="text-start">${statusBadge}</td>
                                <td class="text-start">${new Date(element.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</td>
                                 <td class="text-end">
                                    <li class="list-inline-item">
                                        ${actionButton}
                                    </li>
                                    <li class="list-inline-item"><a href="/admin/element-pemantauan/detail?id=${element.id}"
                                            class="avtar avtar-s btn-link-info btn-pc-default"><i
                                                class="ti ti-eye f-20"></i></a></li>
                                    <li class="list-inline-item">
                                        ${getDeleteButton(elementData, element)}
                                    </li>
                                </td>
                            </tr>
                        `;
                        index_loop++;
                    }

                    countPaging.html(`${display_from} - ${display_to}`);
                    totalPaging.html(getDataRest.data.paginate.total);
                    tablePaging.empty();
                    tablePaging.html(domTableHtml);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
        }

        function getDeleteButton(elementData, element) {
            return `
                <a class="avtar avtar-s btn-link-danger btn-pc-default delete-data"
                    data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Hapus Data ${element.title}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.title}">
                    <i class="ti ti-trash f-20"></i>
                </a>`;
        }

        async function deleteData() {
            $(document).on("click", ".delete-data", async function() {
                isActionForm = "destroy";
                let id = $(this).attr("data-id");
                Swal.fire({
                    icon: "question",
                    title: `Hapus Data ${name}`,
                    text: "Anda tidak akan dapat mengembalikannya!",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Tidak, Batal!",
                    reverseButtons: false
                }).then(async (result) => {
                    if (result.isConfirmed == true) {
                        loadingPage(true);
                        let method = 'destroy';
                        const postDataRest = await CallAPI(
                            'POST',
                            `{{url('')}}/api/internal/admin-panel/monitoring-element/${method}`,
                            {
                                id: id
                            }
                        ).then(function(response) {
                            return response;
                        }).catch(function(error) {
                            loadingPage(false);
                            let resp = error.response;
                            notificationAlert('info', 'Pemberitahuan', resp.data.message);
                            return resp;
                        });

                        if (postDataRest.status == 200) {
                            loadingPage(false);
                            setTimeout(async () => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pemberitahuan',
                                    text: 'Data berhasil dihapus!',
                                    confirmButtonText: 'OK'
                                }).then(async () => {
                                    await manipulationDataTable(paramsTable, '#pagination', '#limitPage', '#searchInput', getListData, true);
                                });
                            }, 100);
                        }
                    }
                }).catch(swal.noop);
            })
        }

        async function setStatus() {
            $(document).on("click", ".change-status", async function() {
                let id = $(this).attr("data-id");
                let status = $(this).attr("data-status");
                await setStatusAction(id, status);
            });
        }

        async function setStatusAction(id, status) {
            Swal.fire({
                icon: "info",
                title: "Pemberitahuan",
                text: "Apakah anda yakin mengganti status data ini?",
                showCancelButton: true,
                confirmButtonText: "Ya, Saya Yakin!",
                cancelButtonText: "Batal",
                reverseButtons: false
            }).then(async (result) => {
                if (result.isConfirmed == true) {
                    loadingPage(true)
                    let formData = {};
                    formData.id = id;
                    const getDataRest = await CallAPI(
                        'GET',
                        `{{url('')}}/api/internal/admin-panel/monitoring-element/status`,
                        formData
                    ).then(function(response) {
                        return response;
                    }).catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('info', 'Pemberitahuan', resp.data.message);
                        return resp;
                    });

                    if (getDataRest.status == 200 || getDataRest.status == 201) {
                        loadingPage(false);
                        setTimeout(async () => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pemberitahuan',
                                text: 'Status berhasil dirubah!',
                                confirmButtonText: 'OK'
                            }).then(async () => {
                                await manipulationDataTable(paramsTable, '#paginationJs', '#limitPage', '#searchInput', getListData, true);
                            });
                        }, 100);
                    }
                }
            }).catch(swal.noop);
        }


        async function initPageLoad() {

            paramsTable = {
                "defaultLimitPage": 10, // Set limit page default
                "currentPage": 1,
                "totalPage": 0,
                "defaultAscending": 1,
                "defaultSearch": '',
            };

            await manipulationDataTable(paramsTable, '#pagination', '#limitPage',
                '#searchInput', getListData); // Memanggil getListDataBidang

            await Promise.all([
                // selectList('#input_satuan_kerja_id',
                //     '{{ env('ESMK_SERVICE_BASE_URL') }}/internal/admin-panel/satuan-kerja/list',
                //     'Pilih Satuan Kerja', true),
                setStatus(),
                deleteData(),
            ])
        }
    </script>
    @include('Administrator.partial-js')
@endsection
