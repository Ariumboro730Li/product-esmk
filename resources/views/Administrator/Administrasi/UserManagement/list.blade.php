@extends('...Administrator.index', ['title' => 'User Manajemen | Master Data Administrasi'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <style>
        .passcode-switch {
            color: #6c757d;
            font-size: 1rem;
            cursor: pointer;
            z-index: 10;
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
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Administrasi</a></li>
                        <li class="breadcrumb-item" aria-current="page">User Manajemen</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Data Pengguna</h2>
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
                                                    <th>Nama</th>
                                                    <th>Nama Pengguna</th>
                                                    <th>NIP</th>
                                                    <th>Peran</th>
                                                    <th>Status</th>
                                                    <th>Tanggal Terdaftar</th>
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
    <form class="validates" id="form-create">
        <div class="modal fade modal-animate modal-lg modal-animate-scrollable" id="modal-form" data-bs-keyboard="false"
            tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                        <div class="p-3">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Masukkan email" required autocomplete="off"/>
                                            <label for="email">Email<sup
                                                    class=" text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control" name="fullname" id="fullname"
                                                placeholder="Masukkan nama lengkap"  autocomplete="off" required />
                                            <label for="fullname">Nama Lengkap<sup
                                                    class=" text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder="Masukkan nama pengguna" autocomplete="off" required />
                                            <label for="username">Nama Pengguna (username)<sup
                                                    class=" text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control" name="nip" id="nip"
                                                placeholder="Masukkan NIP" autocomplete="off" required />
                                            <label for="nip">NIP<sup
                                                    class=" text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <div class="form-label-group">
                                        <label class="form-label" for="input-role">Role<sup
                                                class="required text-danger ms-1">*</sup></label>
                                    </div>
                                    <div class="form-control-wrap">
                                        <select class="form-control select2" name="input_role" id="input-role"
                                            style="width: 100% !important;" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3 position-relative">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Kata Sandi" required autocomplete="off" />
                                            <label for="password">Kata Sandi <sup
                                                    class="required-pass text-danger ms-1">*</sup></label>
                                        </div>
                                        <!-- Ikon mata -->
                                        <a href="javascript:void(0);" class="passcode-switch position-absolute"
                                            onclick="togglePasswordVisibility('password', this)"
                                            style="right: 10px; top: 50%; transform: translateY(-50%); text-decoration: none;"
                                            id="togglePassword">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 position-relative">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="password-confirm" name="password-confirm"
                                                placeholder="Kata Sandi" required autocomplete="off" />
                                            <label for="password-confirm">Konfirmasi Kata Sandi <sup
                                                    class="required-pass text-danger ms-1">*</sup></label>
                                        </div>
                                        <!-- Ikon mata -->
                                        <a href="javascript:void(0);" class="passcode-switch position-absolute"
                                            onclick="togglePasswordVisibility('password-confirm', this)"
                                            style="right: 10px; top: 50%; transform: translateY(-50%); text-decoration: none;"
                                            id="togglePassword">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <small id="passwordHelp mt-2">
                                <b>Kata sandi yang baik mengandung:</b>
                                <ul>
                                    <li id="is8">
                                        <span>Minimal 8 karakter <i style="display: none" class="ti ti-check"
                                                id="is8Check" aria-hidden="true"></i></span>
                                    </li>
                                    <li id="isCapLow">
                                        <span>Huruf Besar & Huruf Kecil (Aa) <i style="display: none" class="ti ti-check"
                                                id="isCapLowCheck" aria-hidden="true"></i></span>
                                    </li>
                                    <li id="isAngka">
                                        <span>Angka (1234567890) <i style="display: none" class="ti ti-check"
                                                id="isAngkaCheck" aria-hidden="true"></i></span>
                                    </li>
                                    <li id="isSymbol">
                                        <span>Symbol (?!@#$%^&*.) <i style="display: none" class="ti ti-check"
                                                id="isSymbolCheck" aria-hidden="true"></i></span>
                                    </li>
                                </ul>
                            </small>
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
    <script src="{{ asset('assets') }}/js/select2/select2.full.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.min.js"></script>
    <script src="{{ asset('assets/js/form/validate.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script></script>

    <script>
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let menu = 'Pengguna';
        let getDataTable = '';
        let errorMessage = "Terjadi Kesalahan.";
        let isActionForm = "store";
        let env = `{{ url('') }}/api`
        let customFilter = '';
        let totalPasswordLine = 0
        let totalPasswordLine1 = 0
        let totalPasswordLine2 = 0
        let totalPasswordLine3 = 0
        let totalPasswordLine4 = 0
        let passwordConfirmStatus = 0

        jQuery.extend(jQuery.validator.messages, {
            required: "Bagian ini diperlukan.",
            email: "Silakan masukkan email yang valid."
        });

        async function togglePasswordVisibility(inputId, toggleElement) {
            const passwordField = document.getElementById(inputId);
            const icon = toggleElement.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        async function getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch) {
            loadingPage(true);
            let getDataRest;
            try {
                getDataRest = await CallAPI(
                    'GET',
                    '{{ url('') }}/api/internal/admin-panel/user-management/list', {
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
                            title="Nonaktifkan Status ${element.name}" data-id="${element.id}" data-status="nonaktifkan">
                            <i class="fa-solid fa-user-xmark"></i>
                        </a>` :
                        `<a class="avtar avtar-s btn-link-success change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Aktifkan Status ${element.name}" data-id="${element.id}" data-status="aktifkan">
                            <i class="fa-solid fa-user-check fa-lg"></i>
                        </a>`;

                    appendHtml += `
                        <tr>
                            <td>${index_loop}.</td>
                            <td>
                                <div class="row align-items-center">
                                     <div class="col-auto pe-0">
                                        <div class="wid-40 hei-40 rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-user text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-1"><span class="text-truncate w-100">${element.name || '-'}</span> </h6>
                                        <p class="f-12 mb-0"><a href="#!" class="text-muted"><span
                                                    class="text-truncate w-100">${element.email || '-'}</span></a>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>${element.username || '-'}</td>
                            <td>${element.nip || '-'}</td>
                            <td><span class="badge text-bg-light fw-bold p-2"><i class="fa-solid fa-user me-2 fa-lg"></i>${element.role_name || '-'}</span></td>
                            <td>
                                ${statusBadge}
                            </td>
                            <td>${element.created_at ? new Date(element.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'}</td>
                            <td class="text-end">
                                <li class="list-inline-item">
                                    ${actionButton}
                                </li>
                                <li class="list-inline-item ${(element.role_name).toLocaleLowerCase() !== 'perusahaan' ? '' : 'd-none'}">
                                        ${getEditButton(elementData, element)}
                                </li>
                            </td>
                        </tr>`;
                    index_loop++;
                }

                $('#listData tr').remove();
                if (totalPage === 0) {
                    appendHtml = `
                        <tr>
                            <th class="text-center" colspan="8> Tidak ada data. </th>
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
                    title="Edit Data ${element.name}"
                    data='${elementData}'
                    data-id="${element.id}"
                    data-name="${element.name}">
                    <i class="ti ti-edit f-20"></i>
                </a>`;
        }

        async function addData() {
            $(document).on("click", ".add-data", function() {
                $("#modal-title").html(`Form Pendaftaran ${menu}`);
                isActionForm = "store";
                $("#modal-form").modal("show");
                $("form").find("input, select, textarea").val("").prop("checked", false).trigger("change");

                $("#password").attr("required", "required");
                $("#password-confirm").attr("required", "required");
                $(".required-pass").text("*");
                $("#form-create").data("action-url",
                    `{{ url('') }}/api/internal/admin-panel/user-management/add`);
            });
        }

        async function submitForm() {
            $(document).on("submit", "#form-create", async function(e) {
                e.preventDefault();
                if ($('#password').val() != $('#password-confirm').val()) {
                    $("#modal-form").modal("hide");
                    notificationAlert('info', 'Pemberitahuan', 'Konfirmasi kata sandi tidak sama.');
                    return;
                }
                loadingPage(true);

                let actionUrl = $("#form-create").data("action-url");
                // work_unit_id: $('#input-instansi').val(),
                let formData = {
                    id_role: $('#input-role').val(),
                    name: $('#fullname').val(),
                    username: $('#username').val(),
                    email: $('#email').val(),
                    nip: $('#nip').val(),
                    password: $('#password').val()
                };

                let id_user = $("#form-create").data("id_user");
                console.log(id_user);
                if (id_user) {
                    formData.id_user = id_user;
                }
                let method = id_user ? 'POST' : 'POST';
                let postDataRest = await CallAPI(method, actionUrl, formData)
                    .then(function(response) {
                        return response;
                    }).catch(function(error) {
                        loadingPage(false);
                        $("form").find("input, select, textarea").val("").prop("checked", false)
                        .trigger("change");
                        $("#modal-form").modal("hide");
                        let resp = error.response;
                        notificationAlert('info', 'Pemberitahuan', resp.data.message);
                        return resp;
                        $(this).trigger("reset");
                    });

                if (postDataRest.status == 200 || postDataRest.status == 201) {
                    loadingPage(false);
                    $("form").find("input, select, textarea").val("").prop("checked", false)
                        .trigger("change");
                    $("#modal-form").modal("hide");
                    let textStatus = id_user ? 'Pengguna Berhasil Diperbarui!' :
                        'Perngguna Berhasil Didaftarkan!';
                    Swal.fire({
                        icon: 'success',
                        title: 'Pemberitahuan',
                        text: textStatus,
                        confirmButtonText: 'OK'
                    }).then(async () => {
                        await initDataOnTable(defaultLimitPage, currentPage,
                            defaultAscending, defaultSearch);
                        $(this).trigger("reset");
                    });
                }
            });
        }

        async function setStatus() {
            $(document).on("click", ".change-status", async function() {
                let id = $(this).attr("data-id");
                let status = $(this).attr("data-status");
                console.log(status);
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
                    formData.id_user = id;
                    let is_status = isStatus == 'aktifkan' ? 'active' : 'inactive';
                    let postDataRest = await CallAPI(
                        'GET',
                        `{{ url('') }}/api/internal/admin-panel/user-management/${is_status}`,
                        formData
                    ).then(function(response) {
                        return response;
                    }).catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('info', 'Pemberitahuan', resp.data.message);
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

        async function editData() {
            $(document).on("click", ".edit-data", async function() {
                loadingPage(false);

                let modalTitle = `Form Perbarui Data ${menu}`;
                let data = $(this).attr("data");
                data = JSON.parse(data);
                let id = $(this).attr("data-id");
                console.log("🚀 ~ $ ~ id:", id)

                $("#modal-title").html(modalTitle);
                $("#modal-form").modal("show");

                $("form").find("input, select, textarea").val("").prop("checked", false).trigger("change");

                $("#password").removeAttr("required");
                $("#password-confirm").removeAttr("required");

                let newOption = new Option(data.role_name, data.role_id, true, true);
                $('#input-role').append(newOption).trigger('change');

                $('#fullname').val(data.name)
                $('#username').val(data.username)
                $('#email').val(data.email)
                $('#nip').val(data.nip)

                $(".required-pass").text("");
                $("#form-create").data("action-url",
                    `{{ url('') }}/api/internal/admin-panel/user-management/update`);
                $("#form-create").data("id_user", id);
            });
        }


        async function selectFilter(id) {
            $('#input-role').select2({
                ajax: {
                    url: `{{ url('') }}/api/internal/admin-panel/role-options`,
                    dataType: 'json',
                    delay: 500,
                    headers: {
                        Authorization: `Bearer ${Cookies.get('auth_token')}`
                    },
                    data: function(params) {
                        let query = {
                            search: params.term,
                            page: 1,
                            limit: 30,
                            ascending: 1
                        };
                        return query;
                    },
                    processResults: function(res) {
                        let data = res.data;

                        console.log("🚀 ~ selectFilter ~ data:", data)
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                },
                allowClear: true,
                placeholder: 'Pilih peran',
                dropdownParent: $('#modal-form')
            });
        }

        async function performSearch() {
            defaultSearch = $('.search-input').val();
            defaultLimitPage = $("#limitPage").val();
            currentPage = 1;
            await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
        }

        async function initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
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
            $(document).ready(function() {

                $('.reset-all').on('click', function() {
                    $('#form-create')[0].reset();
                    $('#form-create').validate().resetForm();
                    resetPasswordValidation();
                    passwordEvent();
                });

                $(".validates").validate({
                    ignore: "input[type=hidden]",
                    errorClass: "text-danger",
                    successClass: "text-success",
                    highlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    unhighlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.parent());
                    }
                });

                passwordEvent();
            });
            await Promise.all([
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch),
                manipulationDataOnTable(),
                selectFilter('#input-role'),
                addData(),
                setStatus(),
                editData(),
                submitForm(),
                togglePasswordVisibility(),
                // selectList('#input_satuan_kerja_id',
                //     '{{ url('') }}/api/internal/admin-panel/satuan-kerja/list',
                //     'Pilih Satuan Kerja', true),
            ]);

        }
    </script>
@endsection
