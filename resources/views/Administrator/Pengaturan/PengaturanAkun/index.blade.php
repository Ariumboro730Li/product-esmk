@extends('...Administrator.index', ['title' => 'Pengaturan Akun | Pengaturan'])
<style>
    .passcode-switch {
        color: #6c757d;
        font-size: 1rem;
        cursor: pointer;
        z-index: 10;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="">Pengaturan Akun</a></li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pengaturan Akun</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body py-0">
                    <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="profile-tab-1"
                                data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true"><i
                                    class="ti ti-lock me-2"></i>Ubah Kata Sandi</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                    <div class="row">
                        <div class="col-lg-4 col-xxl-3">
                            <div class="card">
                                <div class="card-body position-relative">
                                    <div class="position-absolute end-0 top-0 p-3" id="is_active">
                                        <span class="badge bg-success">Aktif</span>
                                    </div>
                                    <div class="text-center mt-3">
                                        <div class="chat-avtar d-inline-flex mx-auto"><img
                                                class="rounded-circle img-fluid wid-70"
                                                src="{{ asset('assets') }}/images/user/user-profil2.jpg" alt="User image">
                                        </div>
                                        <h5 class="mb-0" id="username"></h5>
                                        <p class="text-muted text-sm" id="name"></p>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <h5 class="mb-0">NIP</h5><small class="text-muted"
                                                    id="nip"></small>
                                            </div>
                                            <div class="col-6 border border-top-0 border-bottom-0"
                                                style="border-right: 0 !important;">
                                                <h5 class="mb-0">Peran</h5><small class="text-muted"
                                                    id="role_name"></small>
                                            </div>
                                        </div>
                                        <hr class="my-3 border border-secondary-subtle">
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3"><i
                                                class="ti ti-mail me-2"></i>
                                            <p class="mb-0" id="email"></p>
                                        </div>
                                        <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                            <i class="fa-regular fa-calendar-days me-2"></i>
                                            <p class="mb-0" id="createdAt"> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xxl-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Ubah Kata Sandi</h5>
                                </div>
                                <form id="form-update-password">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3 position-relative">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control" id="password-old" name="password-old"
                                                            placeholder="Kata Sandi" required autocomplete="off" />
                                                        <label for="password-old">Kata Sandi Lama<sup
                                                                class="required-pass text-danger ms-1">*</sup></label>
                                                    </div>
                                                    <!-- Ikon mata -->
                                                    <a href="javascript:void(0);" class="passcode-switch position-absolute"
                                                        onclick="togglePasswordVisibility('password-old', this)"
                                                        style="right: 10px; top: 50%; transform: translateY(-50%); text-decoration: none;"
                                                        id="togglePassword">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="mb-3 position-relative">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control" id="password" name="password"
                                                            placeholder="Kata Sandi" required autocomplete="off" />
                                                        <label for="password">Kata Sandi Baru<sup
                                                                class="required-pass text-danger ms-1">*</sup></label>
                                                    </div>
                                                    <a href="javascript:void(0);" class="passcode-switch position-absolute"
                                                        onclick="togglePasswordVisibility('password', this)"
                                                        style="right: 10px; top: 50%; transform: translateY(-50%); text-decoration: none;"
                                                        id="togglePassword">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                                <div class="mb-3 position-relative">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                                            placeholder="Kata Sandi" required autocomplete="off" />
                                                        <label for="confirmPassword">Konfirmasi Kata Sandi <sup
                                                                class="required-pass text-danger ms-1">*</sup></label>
                                                    </div>
                                                    <!-- Ikon mata -->
                                                    <a href="javascript:void(0);" class="passcode-switch position-absolute"
                                                        onclick="togglePasswordVisibility('confirmPassword', this)"
                                                        style="right: 10px; top: 50%; transform: translateY(-50%); text-decoration: none;"
                                                        id="togglePassword">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mt-5 mt-md-0">
                                                <h5>Kata sandi yang baik mengandung:</h5>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item" id="minLength">
                                                        <i class="ti ti-circle-check f-16 me-2 d-none"
                                                            id="checkLength"></i> Minimal 8 karakter
                                                    </li>
                                                    <li class="list-group-item" id="hasUpperCase">
                                                        <i class="ti ti-circle-check f-16 me-2 d-none"
                                                            id="checkUpperCase"></i> Huruf Besar & Huruf Kecil (Aa)
                                                    </li>
                                                    <li class="list-group-item" id="hasNumber">
                                                        <i class="ti ti-circle-check f-16 me-2 d-none"
                                                            id="checkNumber"></i> Angka (1234567890)
                                                    </li>
                                                    <li class="list-group-item" id="hasSymbol">
                                                        <i class="ti ti-circle-check f-16 me-2 d-none"
                                                            id="checkSymbol"></i> Symbol (?!@#$%^&*)
                                                    </li>
                                                </ul>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <a href="" class="btn btn-outline-secondary">Batal</a>
                                        <button type="submit" class="btn btn-primary shadow-2">Perbarui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- [ sample-page ] end -->
    </div>
    {{-- @dd(request()) --}}
@endsection
@section('scripts')
    <script>
        let email = '';
        let nip = @json(request()->user['nip']);
        let username = @json(request()->user['username']);
        let createdAt = @json(request()->user['created_at']);
        let is_active = @json(request()->user['is_active']);
        let role = @json(request()->payload['internal_role']);

        async function getData() {
            loadingPage(true);
            let getDataRest = await CallAPI(
                'GET', `{{ url('') }}/api/internal/admin-panel/dashboard/userDetail`
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status === 200) {
                let data = getDataRest.data.data.user;
                email = data.email;
                let isActiveElement = document.getElementById('is_active');
                if (is_active === true || is_active === 1) {
                    isActiveElement.innerHTML = '<span class="badge bg-success">Aktif</span>';
                } else {
                    isActiveElement.innerHTML = '<span class="badge bg-danger">Tidak Aktif</span>';
                }

                // Populate other data
                document.getElementById('username').innerText = username ? username : '-';
                document.getElementById('name').innerText = data.name || '-';
                document.getElementById('nip').innerText = nip ? nip : '-';
                document.getElementById('role_name').innerText = role || '-';
                document.getElementById('email').innerText = data.email || '-';

                // Menampilkan tanggal terdaftar
                document.getElementById('createdAt').innerText =
                    `Terdaftar: ${createdAt ? new Date(createdAt ).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'}`;
            }

            loadingPage(false);
        }

        function validatePasswordStrength(password) {
            const minLength = 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSymbol = /[?!@#$%^&*]/.test(password);

            return password.length >= minLength && hasUppercase && hasLowercase && hasNumber && hasSymbol;
        }

        function handlePasswordInput() {
            $('#password').on('input', function() {
                const password = $(this).val();

                // Memanggil setiap validasi
                validateMinLength(password);
                validateUpperCaseLowerCase(password);
                validateNumber(password);
                validateSymbol(password);
            });
        }

        function validateMinLength(password) {
            if (password.length >= 8) {
                $('#checkLength').removeClass('d-none text-danger').addClass('text-success');
            } else {
                $('#checkLength').removeClass('d-none text-success').addClass('text-danger');
            }
        }

        function validateUpperCaseLowerCase(password) {
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            if (hasUppercase && hasLowercase) {
                $('#checkUpperCase').removeClass('d-none text-danger').addClass('text-success');
            } else {
                $('#checkUpperCase').removeClass('d-none text-success').addClass('text-danger');
            }
        }

        function validateNumber(password) {
            const hasNumber = /\d/.test(password);
            if (hasNumber) {
                $('#checkNumber').removeClass('d-none text-danger').addClass('text-success');
            } else {
                $('#checkNumber').removeClass('d-none text-success').addClass('text-danger');
            }
        }

        function validateSymbol(password) {
            const hasSymbol = /[?!@#$%^&*]/.test(password);
            if (hasSymbol) {
                $('#checkSymbol').removeClass('d-none text-danger').addClass('text-success');
            } else {
                $('#checkSymbol').removeClass('d-none text-success').addClass('text-danger');
            }
        }

        function submitPasswordForm() {
            $('#form-update-password').on('submit', function(e) {
                e.preventDefault();

                const data = {
                    oldPassword: $("#password-old").val(),
                    newPassword: $("#password").val(),
                    confirmPassword: $("#confirmPassword").val(),
                };

                // Validasi jika ada field yang kosong
                if (!data.oldPassword || !data.newPassword || !data.confirmPassword) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Harap isi semua kolom.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validasi kecocokan password baru dan konfirmasi password
                if (data.newPassword !== data.confirmPassword) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Kata sandi baru dan konfirmasi tidak cocok. Pastikan kedua kata sandi sama.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validasi kekuatan password
                if (!validatePasswordStrength(data.newPassword)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Kata sandi baru tidak memenuhi persyaratan:\n- Minimal 8 karakter\n- Mengandung huruf besar dan kecil (Aa)\n- Mengandung angka (1234567890)\n- Mengandung simbol (?@#$%^&*)',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                let formData = {
                    password: data.newPassword,
                    email: email,
                    old_password: data.oldPassword,
                }
                // Proses pengiriman data
                Swal.fire({
                    icon: "question",
                    title: `Apakah Anda yakin ingin mengubah kata sandi?`,
                    text: "Pastikan Anda tidak melupakannya.",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Saya Yakin!",
                    cancelButtonText: "Tidak, Batal!",
                    reverseButtons: true
                }).then(async (result) => {
                    loadingPage(false);
                    if (result.isConfirmed == true) {
                        let postDataRest = await CallAPI('PUT',
                                '{{ url('') }}/api/internal/pengaturan-akun/update',
                                formData)
                            .then(function(response) {
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
                                    text: 'Kata sandi berhasil diperbarui!',
                                    confirmButtonText: 'OK'
                                }).then(async () => {
                                    $("#form-update-password").trigger("reset");
                                });
                            }, 100);
                        }

                    }
                }).catch(swal.noop);
            });
        }

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

        async function initPageLoad() {
            await getData();
            await handlePasswordInput(); // Menangani input password dinamis
            await submitPasswordForm();
            await togglePasswordVisibility();
        }
    </script>
@endsection
