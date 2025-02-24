@extends('...Administrator.index', ['title' => 'Data KBLI'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Master Data KBLI</a></li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Data KBLI</h2>
                    </div>
                    <div id="tambahContainer">
                        <a href="javascript:void(0)" class="btn btn-md btn-primary px-3 p-2 mt-3 mt-md-0 add-data"
                            id="add-data">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-2 infoOss">
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <div>Aktifkan Integrasi Akun OSS pada menu <a href="/admin/pengaturan" class="fw-bold">Pengaturan Aplikasi</a>
                agar dapat mengelola Master Data KBLI.</div>
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
                                                    <th>No</th>
                                                    <th>Kode KBLI</th>
                                                    <th>Nama KBLI</th>
                                                    <th>Uraian KBLI</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th class="text-end aksiContainer">Aksi</th>
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
                                <div class="form-floating mb-0">
                                    <input type="text" class="form-control" name="input_kode_kbli" id="input_kode_kbli"
                                        placeholder="kode" required />
                                    <label for="input_kode_kbli">Kode KBLI</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-0">
                                    <input type="text" class="form-control" name="input_judul_kbli" id="input_judul_kbli"
                                        placeholder="nama" required />
                                    <label for="input_judul_kbli">Nama KBLI</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating mb-0">
                                    <textarea class="form-control" name="input_deskripsi_kbli" id="input_deskripsi_kbli" rows="3"></textarea>
                                    <label for="input_deskripsi_kbli">Deskripsi KBLI</label>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
@endsection
@section('page_js')
    <script>
        let env = '{{ url('') }}/api';
        let menu = 'KBLI';
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let getDataTable = '';
        let errorMessage = "Terjadi Kesalahan.";
        let isActionForm = "store";
        let is_active_oss = '';

        async function addData() {
            $(document).on("click", ".add-data", function() {
                $("#modal-title").html("Form Tambah KBLI");
                isActionForm = "store";
                $("#modal-form").modal("show");
                $("form").find("input, textarea").val("").trigger("change");

            });
        }

        async function editData() {
            $(document).on("click", ".edit-data", async function() {
                let data = $(this).attr("data");
                data = JSON.parse(data);
                let id = $(this).attr("data-id");
                $("#modal-title").html("Form Perbarui KBLI");
                $("#modal-form").modal("show");
                $("form").find("input, textarea").val("").trigger("change");
                isActionForm = "update";
                // Populate fields with existing data
                $("#input_kode_kbli").val(data.kbli);
                $("#input_judul_kbli").val(data.name);
                $("#input_deskripsi_kbli").val(data.description);

                // Set form action URL
                $("#form-create").data("id", id);
            });
        }

        async function submitForm() {
            $(document).on("submit", "#form-create", async function(e) {
                e.preventDefault();
                loadingPage(true);

                let actionUrl = $("#form-create").data("action-url");
                let formData = {
                    kbli: $("#input_kode_kbli").val(),
                    name: $("#input_judul_kbli").val(),
                    description: $("#input_deskripsi_kbli").val(),
                };

                let id = $("#form-create").data("id");
                if (id) {
                    formData.id = id;
                }
                let method = isActionForm;
                if (isActionForm == "update") {
                    method = "update";
                }

                const postDataRest = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/internal/admin-panel/master-kbli/${method}`,
                    formData
                ).then(function(response) {
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
                if (postDataRest.status == 200) {
                    $("#modal-form").modal("hide");
                    Swal.fire({
                        icon: 'success',
                        title: 'Pemberitahuan',
                        text: 'Data berhasil disimpan!',
                        confirmButtonText: 'OK'
                    }).then(async () => {
                        setTimeout(async () => {
                            $(this).trigger("reset");
                            await initDataOnTable(defaultLimitPage, currentPage,
                                defaultAscending,
                                defaultSearch);
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
                            `{{ url('') }}/api/internal/admin-panel/master-kbli/${method}`, {
                                id: id
                            }
                        ).then(function(response) {
                            return response;
                        }).catch(function(error) {
                            loadingPage(false);
                            let resp = error.response;
                            notificationAlert('info', 'Pemberitahuan', resp.data
                                .message);
                            return resp;
                        });

                        loadingPage(false);
                        if (postDataRest.status == 200) {
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
                            }, 500);
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
                    `{{ url('') }}/api/internal/admin-panel/master-kbli/list`, {
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

                let display_from = ((defaultLimitPage * data.pagination.current_page) + 1) -
                    defaultLimitPage;
                let index_loop = display_from;
                let display_to = display_from + dataList.length - 1;

                for (let index = 0; index < dataList.length; index++) {
                    let element = dataList[index];
                    const elementData = JSON.stringify(element);
                    const isActive = element.status_aktif === 1;
                    let buttonActions = '';

                    if (is_active_oss === 1) {
                        buttonActions = `
                        <td class="text-end">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    ${getEditButton(elementData, element)}
                                </li>
                                <li class="list-inline-item">
                                    ${getDeleteButton(elementData, element)}
                                </li>
                            </ul>
                        </td>`;
                    }
                    appendHtml += `
                        <tr class="">
                            <td>${index_loop}.</td>
                            <td>
                                <div class="row align-items-center">
                                    <div class="col-auto pe-0">
                                        <div class="wid-40 hei-40 rounded-circle bg-success d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-file-lines text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-1"><span class="text-truncate w-100">${element.kbli || '-'}</span> </h6>
                                    </div>
                                </div>
                            </td>
                            <td><b>${element.name || '-'}</b></td>
                            <td>${element.description || '-'}</td>
                            <td>${element.created_at ? new Date(element.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'}</td>
                            ${buttonActions}
                        </tr>`;
                    index_loop++;
                }

                $('#listData tr').remove();
                if (totalPage === 0) {
                    appendHtml = `
                        <tr class="">
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
                    title="Edit Data ${element.kbli}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.kbli}">
                    <i class="ti ti-edit f-20"></i>
                </a>`;
        }

        function getDeleteButton(elementData, element) {
            return `
                <a class="avtar avtar-s btn-link-danger btn-pc-default delete-data"
                    data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Hapus Data ${element.kbli}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.kbli}">
                    <i class="ti ti-trash f-20"></i>
                </a>`;
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
                await getListData(defaultLimitPage, currentPage, defaultAscending,
                    defaultSearch);
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

        async function checkOSS() {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'GET',
                '{{ url('') }}/api/internal/admin-panel/setting/find', {
                    name: "oss"
                }
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                // notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            loadingPage(false);

            if (getDataRest.status == 200) {
                let data = getDataRest.data.data;
                is_active_oss = data.is_active;

                if (data.is_active === 0 || data.is_active === false) {
                    const btnTambah = document.getElementById('tambahContainer');
                    const thAksi = document.querySelector('.aksiContainer');
                    if (btnTambah) {
                        btnTambah.style.display = 'none';
                        thAksi.style.display = 'none';
                    }
                } else {
                    const infoOss = document.querySelector('.infoOss');
                    infoOss.style.display = 'none';
                }
            } else {
                const btnTambah = document.getElementById('tambahContainer');
                    const thAksi = document.querySelector('.aksiContainer');
                    if (btnTambah) {
                        btnTambah.style.display = 'none';
                        thAksi.style.display = 'none';
                    }
            }
        }

        async function initPageLoad() {
            await Promise.all([
                checkOSS(),
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch),
                manipulationDataOnTable(),
                addData(),
                editData(),
                submitForm(),
                deleteData(),
            ])
        }
    </script>
@endsection
