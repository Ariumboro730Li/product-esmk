@extends('...Administrator.index', ['title' => 'Data No. Berita Acara'])
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
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data No. Berita Acara</a></li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Data Nomor Berita Acara</h2>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-md btn-primary px-3 p-2 mt-3 mt-md-0 add-data"
                        id="add-data">
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
                                                    <th>No</th>
                                                    <th>No. Berita Acara</th>
                                                    <th>Provinsi</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                    <th class="text-end">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listData">
                                            </tbody>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                        <div class="p-3">
                            <div class="mb-3">
                                <div class="form-floating mb-0">
                                    <input type="text" class="form-control" name="input_sk_number" id="input_sk_number"
                                        placeholder="" required />
                                    <label for="input_sk_number">No. Berita Acara</label>
                                </div>
                            </div>
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
        let menu = 'Nomor SK';
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let getDataTable = '';
        let errorMessage = "Terjadi Kesalahan.";
        let isActionForm = "store";

        async function addData() {
            $(document).on("click", ".add-data", function() {
                $("#modal-title").html(`Form Tambah ${menu}`);
                isActionForm = "store";
                $("#modal-form").modal("show");
                $("form").find("input, textarea").val("").prop("checked", false).trigger("change");
                $("form").find("input, select, textarea").val("").prop("checked", false).trigger("change");

                $("#form-create").data("action-url", `${env}/internal/admin-panel/sk-number/store`);
            });
        }

        async function editData() {
            $(document).on("click", ".edit-data", async function() {
                loadingPage(false);
                let name = $(this).attr("data-name");
                let modalTitle = `Form Perbarui ${menu}`;
                let data = $(this).attr("data");
                isActionForm = "update";
                data = JSON.parse(data);
                let id = $(this).attr("data-id");

                $("#modal-title").html(modalTitle);
                $("#modal-form").modal("show");
                $("form").find("input, select, textarea").val("").prop("checked", false).trigger("change");

                $("#input_sk_number").val(data.decree_number);

                let provinceId = data.province?.id || '';
                let provinceName = data.province?.name ||
                'Pilih Provinsi'; 

                $("#input_province_id").val(null).trigger('change');
                $('#input_province_id').append(new Option(provinceName, provinceId, true, true));
                $("#input_province_id").trigger('change');


                $("#form-create").data("action-url",
                    `${env}/internal/admin-panel/sk-number/update`);

                $("#form-create").data("id_user", id);
            });
        }

        async function submitForm() {
            $(document).on("submit", "#form-create", async function(e) {
                e.preventDefault();
                loadingPage(true);

                let actionUrl = $("#form-create").data("action-url");
                let formData = {
                    sk_number: $('#input_sk_number').val(),
                    satker_id: $('#input_satuan_kerja_id').val(),
                    province_id: $('#input_province_id').val()
                };

                let id_user = $("#form-create").data("id_user");
                if (id_user) {
                    formData.id = id_user;
                }
                let postDataRest = await CallAPI('POST', actionUrl, formData)
                    .then(function(response) {
                        $("#modal-form").modal("hide");
                        return response;
                    }).catch(function(error) {
                        $("#modal-form").modal("hide");
                        loadingPage(false);
                        let resp = error.response || {};
                        notificationAlert('warning', 'Pemberitahuan', resp.data?.message || resp.data
                            ?.errors || 'Terjadi kesalahan');
                        return resp;
                    });

                loadingPage(false);
                if (postDataRest.status == 200 || postDataRest.status == 201) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pemberitahuan',
                        text: 'Data berhasil disimpan!',
                        confirmButtonText: 'OK'
                    }).then(async () => {
                        setTimeout(async () => {
                            await initDataOnTable(defaultLimitPage, currentPage,
                                defaultAscending, defaultSearch);
                            $(this).trigger("reset");
                        }, 500);
                    });
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
                            `{{ url('') }}/api/internal/admin-panel/sk-number/${method}`, {
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

        async function getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch) {
            loadingPage(true);
            let getDataRest;
            try {
                getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/sk-number/list`, {
                        page: currentPage,
                        limit: defaultLimitPage,
                        ascending: defaultAscending,
                        search: defaultSearch
                    }
                );
            } catch (error) {
                loadingPage(false);
                let resp = error.response;
                errorMessage = resp.data.message || errorMessage;
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                getDataRest = resp;
            }
            if (getDataRest.status == 200) {
                loadingPage(false);
                let data = getDataRest.data;
                appendHtml = '';
                totalPage = data.pagination.total;
                let dataList = data.data;

                let display_from = ((defaultLimitPage * data.pagination.current_page) + 1) - defaultLimitPage;
                let index_loop = display_from;
                let display_to = display_from + dataList.length - 1;

                for (let index = 0; index < dataList.length; index++) {
                    let element = dataList[index];
                    const elementData = JSON.stringify(element);

                    const isActive = element.is_active === true;
                    const statusBadge = isActive ?
                        `<span class="badge bg-success d-flex align-items-center justify-content-center text-white" style="max-width: 100px; white-space: nowrap;"><i class="fa fa-check-circle me-2"></i> Aktif</span>` :
                        `<span class="badge bg-danger d-flex align-items-center justify-content-center text-white" style="max-width: 100px; white-space: nowrap;"><i class="fa fa-times-circle me-2"></i> Tidak Aktif</span>`;

                    const actionButton = isActive ?
                        `<a class="avtar avtar-s btn-link-danger change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Nonaktifkan Status ${element.decree_number}" data-id="${element.id}" data-status="nonaktifkan">
                            <i class="fa-solid fa-square-xmark fa-lg"></i>
                        </a>` :
                        `<a class="avtar avtar-s btn-link-success change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Aktifkan Status ${element.decree_number}" data-id="${element.id}" data-status="aktifkan">
                            <i class="fa-solid fa-square-check fa-lg"></i>
                        </a>`;


                    appendHtml += `
                    <tr>
                        <td>${index_loop}.</td>
                        <td>
                            <div class="row align-items-center">
                                <div class="col-auto pe-0">
                                    <div class="wid-40 hei-40 rounded-circle bg-light d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-book-open-reader text-black"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1"><span class="text-truncate w-100">${element.decree_number || '-'}</span></h6>
                                </div>
                            </div>
                        </td>
                        <td>${element.province?.name || '-'}</td>
                        <td>${element.created_at ? new Date(element.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'}</td>
                        <td>
                            ${statusBadge}
                        </td>
                        <td class="text-end">
                            <li class="list-inline-item">
                                ${actionButton}
                            </li>
                            <li class="list-inline-item">
                                    ${getEditButton(elementData, element)}
                            </li>
                            <li class="list-inline-item">
                                ${getDeleteButton(elementData, element)}
                            </li>
                        </td>
                    </tr>`;
                    index_loop++;
                }
                $('#listData tr').remove();
                if (totalPage === 0) {
                    appendHtml = `
                        <tr>
                            <th class="text-center" colspan="5"> Tidak ada data. </th>
                        </tr>`;
                    $('#countPage').text("0 - 0");
                    $('#pagination-js').hide();
                } else {
                    $('#pagination-js').show();
                    $('#countPage').text(`${display_from} - ${display_to}`);
                }

                $('#listData').html(appendHtml);
                $('#totalPage').text(totalPage);
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        }


        function getEditButton(elementData, element) {
            return `
                <a class="avtar avtar-s btn-link-warning btn-pc-default edit-data"
                data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Edit Data ${element.decree_number}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.name}">
                    <i class="ti ti-edit f-20"></i>
                </a>`;
        }

        function getDeleteButton(elementData, element) {
            return `
                <a class="avtar avtar-s btn-link-danger btn-pc-default delete-data"
                    data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Hapus Data ${element.decree_number}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.name}">
                    <i class="ti ti-trash f-20"></i>
                </a>`;
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
                    const postDataRest = await CallAPI(
                        'GET',
                        `{{ url('') }}/api/internal/admin-panel/sk-number/status`,
                        formData
                    ).then(function(response) {
                        return response;
                    }).catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('info', 'Pemberitahuan', resp.data.message);
                        return resp;
                    });

                    if (postDataRest) {
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

        function formatTanggalIndo(dateString) {
            const date = new Date(dateString);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Intl.DateTimeFormat('id-ID', options).format(date);
        }

        async function initPageLoad() {
            await Promise.all([
                selectList('#input_satuan_kerja_id',
                    '{{ url('') }}/api/internal/admin-panel/satuan-kerja/list',
                    'Pilih Satuan Kerja', true),
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch),
                manipulationDataOnTable(),
                setStatus(),
                addData(),
                editData(),
                submitForm(),
                deleteData(),
                selectList('#input_province_id',
                    '{{ url('') }}/api/internal/admin-panel/provinsi/list',
                    'Pilih Provinsi', true),
            ])
        }
    </script>
@endsection
