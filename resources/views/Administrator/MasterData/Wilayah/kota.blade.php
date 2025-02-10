@extends('...Administrator.index', ['title' => 'Kota | Master Data Wilayah'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data Wilayah</a></li>
                        <li class="breadcrumb-item" aria-current="page">Kota</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Data Kota</h2>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-md btn-primary px-3 p-2 mt-3 mt-md-0 add-data"
                        id="add-data">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Data
                    </a>
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
                                <div
                                    class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                    <div class="datatable-top">
                                        <div class="datatable-dropdown">
                                            <label>
                                                <select class="datatable-selector" id="limitPage" name="per-page"
                                                    style="width: auto;min-width: unset;">
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
                                                name="search" title="Search within table" aria-controls="pc-dt-simple">
                                        </div>
                                    </div>
                                    <div class="datatable-container">
                                        <table class="table table-hover datatable-table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Kota</th>
                                                    <th>Provinsi</th>
                                                    <th>Kode Wilayah</th>
                                                    <th>Status</th>
                                                    <th class="text-end">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listData"></tbody>
                                        </table>

                                    </div>
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
                </div>
            </div>
        </div>
    </div>
    <form id="form-create">
        <div class="modal fade modal-animate" id="modal-form" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <div class="form">
                                        <label for="floatingSelect">Provinsi</label>
                                        <select class="form-control" id="input_province_id" name="input_province_id"
                                            style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="kota" class="form-control" name="input_name" id="input_name"
                                                placeholder="kota" required />
                                            <label for="input_name">Nama Kota</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control form-control-lg"
                                                name="input_administrative_code" id="input_administrative_code"
                                                placeholder="Masukkan kode wilayah" autocomplete="off" required
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                            <label for="input_administrative_code">Kode Wilayah</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary reset-all"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary shadow-2">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        let env = '{{ url('') }}/api';
        let menu = 'Kota';
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let getDataTable = '';
        let errorMessage = "Terjadi Kesalahan.";
        let isActionForm = "store";
        let permission = @json(request()->permission).map(p => p.name);

        async function addData() {
            if (permission.includes('Tambah kota')) {
                $(document).on("click", ".add-data", function() {
                    $("#modal-title").html(`Form Tambah ${menu}`);
                    isActionForm = "store";
                    $("#modal-form").modal("show");
                    $("form").find("input, textarea").val("").prop("checked", false).trigger("change");
                    $("#form-create").data("action-url", ``);
                });
            } else {
                $('#add-data').hide();
            }

        }


        async function editData() {
            $(document).on("click", ".edit-data", async function() {
                loadingPage(false);
                let name = $(this).attr("data-name");
                let province = $(this).attr("data-province");
                let modalTitle = `Form Perbaharui ${menu}`;
                isActionForm = "update";
                let data = $(this).attr("data");
                data = JSON.parse(data);
                let id = $(this).attr("data-id");

                $("#modal-title").html(modalTitle);
                $("#modal-form").modal("show");
                $("form").find("input, textarea").val("").prop("checked", false).trigger("change");

                const getDataRest = await CallAPI(
                    'POST',
                    '{{ url('') }}/api/internal/admin-panel/kota/edit', {
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

                if (getDataRest.status == 200) {
                    $("#input_name").val(data.name);
                    let administrativeCode = data.administrative_code.split('.')[
                        1];
                    $("#input_administrative_code").val(
                        administrativeCode);

                    let provinceId = data.province.id;
                    $("#input_province_id").val(null).trigger('change');
                    $('#input_province_id').append(new Option(data.province.name, provinceId, true, true));
                    $("#input_province_id").trigger('change');

                }

            });
        }


        async function submitForm() {
            $(document).on("submit", "#form-create", async function(e) {
                e.preventDefault();
                loadingPage(true);

                let formData = {
                    name: $('#input_name').val(),
                    administrative_code: $('#input_administrative_code').val(),
                    province_id: $('#input_province_id').val()
                };

                if (isActionForm === 'update') {
                    let id = $('.edit-data').attr("data-id");
                    formData.id = id;
                }

                const postDataRest = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/internal/admin-panel/kota/${isActionForm}`,
                    formData
                ).then(function(response) {
                    return response;
                }).catch(function(error) {
                    $("#modal-form").modal("hide");
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('warning', 'Pemberitahuan', resp.data.message);
                    return resp;
                });

                if (postDataRest.status == 200 || postDataRest.status == 201) {
                    loadingPage(false);
                    $("form").find("input, select, textarea").val("").prop("checked", false)
                        .trigger("change");
                    $("#modal-form").modal("hide");
                    setTimeout(async () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pemberitahuan',
                            text: 'Data berhasil disimpan!',
                            confirmButtonText: 'OK'
                        }).then(async () => {
                            await initDataOnTable(defaultLimitPage, currentPage,
                                defaultAscending,
                                defaultSearch);
                            $(this).trigger("reset");
                            $("#modal-form").modal("hide");
                        });
                    }, 100);
                }
            });
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
                            `{{ url('') }}/api/internal/admin-panel/kota/${method}`, {
                                id: id
                            }
                        ).then(function(response) {
                            return response;
                        }).catch(function(error) {
                            loadingPage(false);
                            let resp = error.response;
                            notificationAlert('warning', 'Pemberitahuan', resp.data
                                .message);
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
                                    await initDataOnTable(
                                        defaultLimitPage,
                                        currentPage,
                                        defaultAscending,
                                        defaultSearch);
                                });
                            }, 100);
                        }
                    }
                }).catch(swal.noop);
            })
        }


        async function getListData(limit = 10, page = 1, ascending = 0, search = '') {
            loadingPage(true);
            let getDataRest;
            try {
                getDataRest = await CallAPI(
                    'GET',
                    '{{ url('') }}/api/internal/admin-panel/kota/list', {
                        page: page,
                        limit: limit,
                        ascending: ascending,
                        keyword: search
                    }
                );
            } catch (error) {
                loadingPage(false);
                let resp = error.response;
                errorMessage = resp.data.message || errorMessage;
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                getDataRest = resp;
            }

            loadingPage(false);
            if (getDataRest.status == 200) {
                await setListData(getDataRest.data);
            } else {
                getDataTable = `
                <tr class="nk-tb-item">
                    <th class="nk-tb-col text-center" colspan="${$('.nk-tb-head th').length}"> ${errorMessage} </th>
                </tr>`;
                $('#listData tr').remove();
                $('#listData').append(getDataTable);
            }
        }

        async function setListData(data) {
            getDataTable = '';
            totalPage = data.pagination.total;
            let dataList = data.data;

            let display_from = ((defaultLimitPage * data.pagination.current_page) + 1) - defaultLimitPage;
            let index_loop = display_from;
            let display_to = display_from + dataList.length - 1;

            for (let index = 0; index < dataList.length; index++) {
                let element = dataList[index];
                const elementData = JSON.stringify(element);
                const isActive = element.is_active === true || element.is_active === 1;
                console.log("🚀 ~ setListData ~ element.is_active:", element.is_active)
                const statusBadge = isActive ?
                    `<span class="badge bg-success d-flex align-items-center justify-content-center text-white" style="max-width: 100px; white-space: nowrap;"><i class="fa fa-check-circle me-2"></i> Aktif</span>` :
                    `<span class="badge bg-danger d-flex align-items-center justify-content-center text-white" style="max-width: 100px; white-space: nowrap;"><i class="fa fa-times-circle me-2"></i> Tidak Aktif</span>`;
                const actionButton = isActive ?
                        `<a class="avtar avtar-s btn-link-danger change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Nonaktifkan Kota ${element.name}" data-id="${element.id}" data-status="nonaktifkan">
                            <i class="fa-solid fa-square-xmark fa-lg"></i>
                        </a>` :
                        `<a class="avtar avtar-s btn-link-success change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Aktifkan Kota ${element.name}" data-id="${element.id}" data-status="aktifkan">
                            <i class="fa-solid fa-square-check fa-lg"></i>
                        </a>`;
                getDataTable += `
                <tr>
                    <td>${index_loop}.</td>
                    <td>
                        <div class="row align-items-center">
                            <div class="col-auto pe-0">
                                <div class="wid-40 hei-40 rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-city text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1"><span class="text-truncate w-100">${element.name ? element.name : '-'}</span></h6>
                            </div>
                        </div>
                    </td>
                    <td>${element.province.name ? element.province.name : '-'}</td>
                    <td>
                        ${element.administrative_code ? +  element.administrative_code : '-'}
                    </td>
                    <td>
                        ${statusBadge}
                    </td>
                    <td class="text-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                ${actionButton}
                            </li>
                            <li class="list-inline-item">
                                    ${getEditButton(elementData, element)}
                            </li>
                            <li class="list-inline-item">
                                ${getDeleteButton(elementData, element)}
                            </li>
                        </ul>
                    </td>
                </tr>`;
                index_loop++;
            }

            if (totalPage == 0 || dataList.length === 0) {
                getDataTable = `
                <tr>
                    <th class="text-center" colspan="5"> Tidak ada data. </th>
                </tr>`;
                $('#countPage').text("0 - 0");
            }

            $('#listData tr').remove();
            $('#listData').append(getDataTable);
            $('#totalPage').text(data.pagination.total);
            $('#countPage').text("" + display_from + " - " + display_to + "");

            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        function getEditButton(elementData, element) {
            if (permission.includes('Ubah kota')) {
                return `
                <a class="avtar avtar-s btn-link-warning btn-pc-default edit-data"
                data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Edit Data ${element.name}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.name}">
                    <i class="ti ti-edit f-20"></i>
                </a>`;
            }
            return ``;

        }

        function getDeleteButton(elementData, element) {
            if (permission.includes('Hapus kota')) {
                return `
                <a class="avtar avtar-s btn-link-danger btn-pc-default delete-data"
                    data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Hapus Data ${element.name}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.name}">
                    <i class="ti ti-trash f-20"></i>
                </a>`;
            }
            return ``;

        }

        async function performSearch() {
            defaultSearch = $('.search-input').val();
            defaultLimitPage = $("#limitPage").val();
            currentPage = 1;
            await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
        }

        async function initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch) {
            await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
            await paginationDataOnTable(defaultLimitPage);
        }

        async function manipulationDataOnTable() {
            $(document).on("change", "#limitPage", async function() {
                defaultLimitPage = $(this).val();
                currentPage = 1;
                await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                await paginationDataOnTable(defaultLimitPage);
            });

            $(document).on("input", ".search-input", debounce(performSearch, 500));
            await paginationDataOnTable(defaultLimitPage);
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


        async function selectList(id, isUrl, placeholder, isModal = false) {
            let select2Options = {
                ajax: {
                    url: isUrl,
                    dataType: 'json',
                    delay: 500,
                    headers: {
                        Authorization: `Bearer ${Cookies.get('auth_token')}`
                    },
                    data: function(params) {
                        let query = {
                            keyword: params.term,
                            page: 1,
                            limit: 30,
                            ascending: 1,
                        };
                        return query;
                    },
                    processResults: function(res) {
                        let data = res.data;
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                },
                allowClear: true,
                placeholder: placeholder
            };

            if (isModal === true) {
                select2Options.dropdownParent = $('#modal-form');
            }

            await $(id).select2(select2Options);
        }

        async function setStatus() {
            $(document).on("click", ".change-status", async function() {
                let id = $(this).attr("data-id");
                let status = $(this).attr("data-status");
                await setStatusAction(id, status);
            });
        }

        async function setStatusAction(id, isStatus) {
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
                    let is_status = isStatus == 'aktifkan' ? 'active' : 'inactive';
                    const postDataRest = await CallAPI(
                        'GET',
                        `{{ url('') }}/api/internal/admin-panel/direktur-jendral/${is_status}`,
                        formData
                    ).then(function(response) {
                        return response;
                    }).catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('warning', 'Pemberitahuan', resp.data.message);
                        return resp;
                    });

                    if (postDataRest.status == 200 || postDataRest.status == 201) {
                        loadingPage(false);
                        setTimeout(async () => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pemberitahuan',
                                text: 'Status berhasil dirubah!',
                                confirmButtonText: 'OK'
                            }).then(async () => {
                                await initDataOnTable(defaultLimitPage,
                                    currentPage,
                                    defaultAscending, defaultSearch);
                            });
                        }, 100);
                    }
                }
            }).catch(swal.noop);
        }

        async function initPageLoad() {
            await Promise.all([

                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch),
                manipulationDataOnTable(),
                addData(),
                editData(),
                setStatus(),
                submitForm(),
                deleteData(),
                selectList('#input_province_id',
                    '{{ url('') }}/api/internal/admin-panel/provinsi/list',
                    'Pilih Provinsi', true),
            ])
        }
    </script>
@endsection
