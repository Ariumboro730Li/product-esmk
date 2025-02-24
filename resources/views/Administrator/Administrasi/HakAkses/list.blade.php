@extends('...Administrator.index', ['title' => 'Hak Akses'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/select2.min.css" />
    <style>
        .datatable-top {
            display: none;
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
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Hak Akses</a></li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex flex-column flex-md-row justify-content-between align-items-start">
                    <div class="page-header-title">
                        <h2 class="mb-0">Manajemen Peran</h2>
                    </div>
                    <button data-pc-animate="fade-in-scale" type="button"
                        class="btn btn-md btn-primary px-3 p-2 mt-3 mt-md-0" data-bs-toggle="modal"
                        data-bs-target="#animateModal">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Peran Baru
                    </button>
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
                    <div class="col-lg-4 mt-2">
                        <div class="mb-3">
                            <label class="fw-bold mb-2" for="input-role">Pencarian Peran</label>
                            <select class="form-control select2" name="input_role" id="input-role"></select>

                        </div>
                    </div>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                            aria-labelledby="analytics-tab-1" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Peran</th>
                                            <th>Izin</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-animate modal-animate-scrollable" data-bs-keyboard="false" tabindex="-1" id="animateModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Tambah Peran Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <form id="addRoleForm" class="p-3">
                        <div class="mb-3">
                            <div class="form-floating mb-0">
                                <input type="text" class="form-control" id="namaPeran"
                                    placeholder="Masukkan Nama Peran" />
                                <label for="namaPeran">Nama Peran</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label mt-2" for="customCheckinl1" style="font-weight: 500;">Peran
                                Status</label><br>
                            <div class="form-check form-switch custom-switch-v1 form-check-inline mt-2">
                                <input type="checkbox" class="form-check-input input-primary me-2" id="customCheckinl1" />
                                <label class="form-check-label" style="color: rgba(0, 0, 0, 0.625)"
                                    for="customCheckinl1">Centang jika peran ini aktif.</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-primary shadow-2" onclick="addRole()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- [Page Specific JS] start -->
    <script src="https://ableproadmin.com/assets/js/plugins/apexcharts.min.js"></script>
    <script src="https://ableproadmin.com/assets/js/plugins/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.full.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.min.js"></script>
@endsection

@section('page_js')
    <script>
        let selectedRole;
        async function getPermissions() {
            loadingPage(true);

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/group-permission`,
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
                let data = getDataRest.data.data
                let $rowTable = '';
                for (let idxData in data) {
                    let $tdPermissions = ``
                    for (let idxPermission in data[idxData]) {
                        let permission = data[idxData][idxPermission]
                        $tdPermissions += `
                            <div class="form-check form-switch form-switch-lg">
                                <input type="checkbox" name="status" class="form-check-input checkbox-permission" id="checkbox-permission-${permission.id}" value="${permission.id}" style="left: 0;">
                                <label class="form-check-label" for="checkbox-status" style="margin-left: 10px;">${permission.name}</label>
                            </div>
                        `
                    }

                    $rowTable += `
                        <tr>
                            <td style="text-align: center">
                                ${Object.keys(data).indexOf(idxData) + 1}
                            </td>
                            <td>
                                ${idxData}
                            </td>
                            <td>
                                ${$tdPermissions}
                            </td>
                        </tr>
                    `
                }
                $('#datatable').find('tbody').append($rowTable)
            }
        }

        async function getPermissionsByRoleID(id) {
            loadingPage(true);

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/permission`, {
                        id: id
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
                let data = getDataRest.data.data.permissions


                for (let i in data) {
                    $(`#checkbox-permission-${data[i].id}`).prop('checked', true)
                }
            }
        }


        $(document).on('change', '.checkbox-permission', async function() {
            loadingPage(true)
            let permissionID = $(this).val()
            let isAssign = $(this).prop('checked')

            let getDataRest = await CallAPI(
                    'PUT',
                    `{{ url('') }}/api/internal/admin-panel/sync-permission`, {
                        isAssign: isAssign,
                        permission: parseInt(permissionID),
                        id: selectedRole

                    }
                )
                .then(response => response)
                .catch(error => {
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert("info", "Pemberitahuan", resp.data.message);
                    return resp;
                });

            if (getDataRest.status === 200) {
                loadingPage(false)
                notificationAlert("success", "Berhasil", "Berhasil mengubah hak akses")
                setTimeout(() => window.location.reload(), 1500);

            }
        })

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
                placeholder: 'Pilih peran',
                allowClear: false, // Tidak mengizinkan opsi clear
                minimumResultsForSearch: Infinity, // Menyembunyikan kotak pencarian jika tidak dibutuhkan
            });

            // Fetch data pertama dan set sebagai default
            try {
                const response = await $.ajax({
                    url: `{{ url('') }}/api/internal/admin-panel/role-options`,
                    headers: {
                        Authorization: `Bearer ${Cookies.get('auth_token')}`
                    },
                });

                if (response.data && response.data.length > 0) {
                    const firstItem = response.data[0];

                    // Set opsi pertama sebagai default dan aktif
                    const option = new Option(firstItem.name, firstItem.id, true, true);
                    $('#input-role').append(option).trigger('change');
                }
            } catch (error) {
                console.error('Error fetching roles:', error);
            }
        }


        async function addRole() {
            loadingPage(true);
            const nameRole = document.getElementById('namaPeran').value.trim();
            const isActive = document.getElementById('customCheckinl1').checked ? 1 : 0;

            if (!nameRole) {
                loadingPage(false);
                notificationAlert('warning', 'Pemberitahuan', 'Nama peran tidak boleh kosong.');
                return;
            }
            const payload = {
                name: nameRole,
                is_active: isActive
            };

            let getDataRest = await CallAPI('POST',
                    '{{ url('') }}/api/internal/admin-panel/role/create', payload)
                .then((response) => response)
                .catch((error) => {
                    $('#animateModal').modal('hide');
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('warning', 'Pemberitahuan', 'Error')
                    return resp;
                });

            if (getDataRest.status === 201) {
                $('#animateModal').modal('hide');
                loadingPage(false);
                notificationAlert('success', 'Pemberitahuan', getDataRest.data.message)
                setTimeout(() => {
                    window.location.reload();
                }, 2000); // 2000 ms = 2 detik
            }
        }

        $('#input-role').on('change', function() {
            $('.checkbox-permission').each(function() {
                $(this).prop('checked', false)
            })

            selectedRole = $(this).val()
            getPermissionsByRoleID(selectedRole)
        })

        async function initPageLoad() {

            await Promise.all([
                selectFilter('#input-role'),
                getPermissions(),
            ]);

        }
    </script>
    @include('Administrator.partial-js')
@endsection
