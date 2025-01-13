<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Register | SMK</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="Phoenixcoded" />

    <link rel="icon" id="logo_favicon" href="{{ asset('assets') }}/images/logoapp.png" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link" />
    <script src="{{ asset('assets') }}/js/tech-stack.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <link href="{{ asset('assets/css/sweetalert2.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets') }}/js/plugins/jquery-3.7.1.min.js"></script>
</head>
<style>
    /* .welcome-banner::after {
        opacity: 0.3;
        background-position: bottom;
        background-size: 600%;

    } */
    #passwordHelp ul {
        padding-left: 2;
    }

    #passwordHelp li {
        font-size: 12px;
        margin-bottom: 5px;
    }

    #passwordHelp li span {
        display: inline-flex;
        align-items: center;
        color: #6c757d;
    }

    #passwordHelp li span i {
        color: green;
        margin-left: 5px;
        display: none;
    }

    #passwordHelp li.valid span {
        color: green;
    }

    #passwordHelp li.invalid span {
        color: #dc3545;
    }


    .select2-container {
        width: 100% !important;
    }

    .passcode-switch {
        color: #6c757d;
        /* Warna ikon */
        font-size: 1rem;
        /* Ukuran ikon */
        cursor: pointer;
        z-index: 10;
        /* Pastikan di atas elemen lain */
    }
</style>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div id="preloaderLoadingPage">
        <div class="sk-three-bounce">
            <div class="centerpreloader">
                <div class="ui-loading"></div>
                <center>
                    <h6 style="color: white;">Harap Tunggu....</h6>
                </center>
            </div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <div class="auth-main">
        <div class="auth-wrapper v2">
            <div id="side-content-logo">
            </div>

            <div class="auth-form">
                <div class="card my-5" style="max-width:70%">
                    <div class="card-body">
                        <div class="text-center logo_aplikasi">
                        </div>
                        <h4 class="text-center mt-4 nama_aplikasi"></h4>
                        <div class="saprator mb-5 text-center">
                            <span class=" nama_instansi">Dinas Perhubungan Kabupaten</span>
                        </div>

                        <form id="wizard-form">
                            <div class="wizard-step step-1" data-step="1">
                                <h5 class="text-left mb-4" style="color:#214f96;">
                                    <i class="fa-solid fa-circle-info fa-lg me-2"></i>Data Perusahaan
                                </h5>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" for="nib">Nomor Induk Berusaha (NIB)<sup
                                            class="text-danger ms-1">*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="fa-solid fa-magnifying-glass text-dark"></i>
                                        </div>
                                        <input type="text" class="form-control" id="nib"
                                            placeholder="Masukkan nomor induk berusaha" />
                                    </div>
                                </div>
                                <div class="d-grid mt-5">
                                    <button type="button" class="btn btn-primary mb-2" onclick="getAllowedNib()"
                                        style="border-radius:5px; background: linear-gradient(90deg, rgb(4 60 132) 0%, rgb(69 114 184) 100%); color: white;">
                                        <em class="icon ni ni-check-round-cut"></em> &nbsp; Cek NIB
                                    </button>
                                </div>
                            </div>

                            <div class="wizard-step step-2" data-step="2">
                                <h5 class="text-left mb-4" style="color:#214f96;"><i
                                        class="fa-solid fa-circle-info fa-lg me-2"></i>Data Perusahaan<sup
                                        class="text-danger ms-1">*</sup></h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control" id="data-perusahaan-nib"
                                                placeholder="" />
                                            <label for="nib">NIB<sup class="text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control"
                                                id="data-perusahaan-nama-perusahaan" placeholder="" />
                                            <label for="namaPerusahaan">Nama Perusahaan<sup
                                                    class="text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-0">
                                            <div class="form-floating mb-0">
                                                <input type="number" class="form-control"
                                                    id="data-perusahaan-no-telepon-perusahaan" placeholder="" />
                                                <label for="noTelp">No. Telepon Perusahaan<sup
                                                        class="text-danger ms-1">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-floating mb-0">
                                                <input type="email" class="form-control" id="data-perusahaan-email"
                                                    placeholder="Email address" />
                                                <label for="email">Email<sup
                                                        class="text-danger ms-1">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-0">
                                            <label class="fw-normal" for="data-perusahaan-provinsi">Provinsi<sup
                                                    class="text-danger ms-1">*</sup></label>
                                            <select class="form-control form-control-sm"
                                                name="data-perusahaan-provinsi" id="data-perusahaan-provinsi"
                                                required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="fw-normal" for="data-perusahaan-kota">Kota<sup
                                                    class="text-danger ms-1">*</sup></label>
                                            <select class="form-control form-control-sm" name="data-perusahaan-kota"
                                                id="data-perusahaan-kota" required></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-0">
                                            <textarea class="form-control" id="data-perusahaan-alamat" rows="3"></textarea>
                                            <label for="floatingdeskripsi">Alamat<sup
                                                    class="text-danger ms-1">*</sup></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <label class="fw-normal" for="data-jenis-pelayanan">Jenis Pelayanan<sup
                                                class="text-danger ms-1">*</sup></label>
                                        <select class="form-control form-control-sm" name="data-jenis-pelayanan"
                                            id="data-jenis-pelayanan" multiple required></select>
                                    </div>
                                </div>
                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary mb-2"
                                        style="border-radius:5px; background: linear-gradient(90deg, rgb(4 60 132) 0%, rgb(69 114 184) 100%); color: white;">Selanjutnya</button>
                                </div>
                                <div class="d-flex justify-content-center align-items-end mt-3">
                                    <h6 class="f-w-500 mb-0 me-2">Sudah punya akun?</h6>
                                    <a href="/" class="link-primary">Masuk Sekarang!</a>
                                </div>
                            </div>
                            <div class="wizard-step step-3" data-step="3" style="display: none;">
                                <h5 class="text-left mb-4" style="color:#214f96;"><i
                                        class="fa-solid fa-circle-info fa-lg me-2"></i>Penanggung Jawab (PIC)</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-0">
                                            <div class="form-floating mb-0">
                                                <input type="text" class="form-control" id="data-pic-nama"
                                                    placeholder="" />
                                                <label for="namaPic">Nama PIC<sup
                                                        class="text-danger ms-1">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <div class="form-floating mb-0">
                                                <input type="text" class="form-control" id="data-pic-no-telepon"
                                                    placeholder="" />
                                                <label for="noTelpPic">No. Telepon PIC<sup
                                                        class="text-danger ms-1">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-4">
                                    <button type="button" class="btn btn-outline-secondary prev-btn mb-2"
                                        style="border-radius:5px;">Kembali</button>
                                    <button type="submit" class="btn btn-primary"
                                        style="border-radius:5px; background: linear-gradient(90deg, rgb(4 60 132) 0%, rgb(69 114 184) 100%); color: white;">Selanjutnya</button>
                                </div>
                            </div>

                            <div class="wizard-step step-4" data-step="4" style="display: none;">
                                <h5 class="text-left mb-4" style="color:#214f96;"><i
                                        class="fa-solid fa-circle-info fa-lg me-2"></i>Informasi Akun</h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-0">
                                            <div class="form-floating mb-0">
                                                <input type="text" class="form-control"
                                                    id="data-informasi-akun-username" placeholder="" />
                                                <label for="data-informasi-akun-username">Username<sup
                                                        class="text-danger ms-1">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <div class="form-floating mb-0">
                                                <input type="number" class="form-control"
                                                    id="data-informasi-akun-no-telepon" placeholder="" />
                                                <label for="data-informasi-akun-no-telepon">No. Telepon<sup
                                                        class="text-danger ms-1">*</sup></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="data-informasi-akun-password"
                                            placeholder="Kata Sandi" required />
                                        <label for="data-informasi-akun-password">Kata Sandi<sup
                                                class="text-danger ms-1">*</sup></label>
                                    </div>
                                    <!-- Ikon mata -->
                                    <a href="#" class="passcode-switch position-absolute"
                                        style="right: 10px; top: 50%; transform: translateY(-50%); text-decoration: none;"
                                        id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </div>
                                {{-- <div class="mb-3">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-0">
                                            <input type="password" class="form-control"
                                                id="data-informasi-akun-password" placeholder="" />
                                            <label for="data-informasi-akun-password">Password</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="d-flex mt-1 justify-content-between align-items-start">
                                    <small id="passwordHelp" class="mt-2">
                                        <b>Kata sandi yang baik mengandung:</b>
                                        <ul>
                                            <li id="is8">
                                                <span>Minimal 8 karakter <i style="display: none" class="ti ti-check"
                                                        id="is8Check" aria-hidden="true"></i></span>
                                            </li>
                                            <li id="isCapLow">
                                                <span>Huruf Besar & Huruf Kecil (Aa) <i style="display: none"
                                                        class="ti ti-check" id="isCapLowCheck"
                                                        aria-hidden="true"></i></span>
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
                                    <div class="form-check ms-4 ms-md-0 mt-2">
                                        <input class="form-check-input input-primary" type="checkbox"
                                            name="cp1-save-register" id="cp1-save-register" value="1"
                                            required />
                                        <label class="form-check-label text-muted" for="cp1-save-register">Saya
                                            menyetujui
                                            syarat dan ketentuan yang berlaku.</label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-5 flex-column flex-sm-row">
                                    <button type="button"
                                        class="btn btn-outline-secondary prev-btn mb-2 mb-md-0 me-0 me-md-3 flex-grow-1"
                                        style="border-radius:5px;">
                                        Kembali
                                    </button>
                                    <button type="button" class="btn flex-grow-1" id="daftar-akun"
                                        style="border-radius:5px; background: linear-gradient(90deg, rgb(4 60 132) 0%, rgb(69 114 184) 100%); color: white;">
                                        Simpan
                                    </button>
                                </div>


                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/form/validate.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.3/js.cookie.js"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.min.js"></script>
    <script src="{{ asset('assets') }}/js/axios.js"></script>
    <script src="{{ asset('assets') }}/js/restAPI.js"></script>

    <script>
        let totalPasswordLine = 0
        let totalPasswordLine1 = 0
        let totalPasswordLine2 = 0
        let totalPasswordLine3 = 0
        let totalPasswordLine4 = 0
        let passwordConfirmStatus = 0
        document.addEventListener('DOMContentLoaded', function() {
            // Dapatkan elemen-elemen yang dibutuhkan
            const passwordInput = document.getElementById('data-informasi-akun-password'); // ID input password
            const passwordHelp = document.getElementById('passwordHelp');
            const is8Check = document.getElementById('is8Check');
            const isCapLowCheck = document.getElementById('isCapLowCheck');
            const isAngkaCheck = document.getElementById('isAngkaCheck');
            const isSymbolCheck = document.getElementById('isSymbolCheck');

            const cp1SaveRegister = document.getElementById('cp1-save-register');
            const daftarAkunBtn = document.getElementById('daftar-akun');

            // Fungsi untuk memvalidasi password
            function validatePassword() {
                const passwordValue = passwordInput.value;

                // Cek panjang password (minimal 8 karakter)
                const isLengthValid = passwordValue.length >= 8;
                toggleValidation(is8Check, isLengthValid, is8);

                // Cek huruf besar dan kecil
                const isCapLowValid = /[a-z]/.test(passwordValue) && /[A-Z]/.test(passwordValue);
                toggleValidation(isCapLowCheck, isCapLowValid, isCapLow);

                // Cek angka
                const isAngkaValid = /\d/.test(passwordValue);
                toggleValidation(isAngkaCheck, isAngkaValid, isAngka);

                // Cek simbol
                const isSymbolValid = /[!@#$%^&*()_+{}\[\]:;"'<>,.?\/\\|]/.test(passwordValue);
                toggleValidation(isSymbolCheck, isSymbolValid, isSymbol);

                if (isLengthValid && isCapLowValid && isAngkaValid && isSymbolValid && cp1SaveRegister.checked) {
                    daftarAkunBtn.disabled = false;
                } else {
                    daftarAkunBtn.disabled = true;
                }
            }

            // Fungsi untuk menampilkan atau menyembunyikan tanda centang dan mengubah warna teks
            function toggleValidation(iconElement, isValid, listItem) {
                if (isValid) {
                    // Menampilkan tanda centang dan memberi warna hijau pada teks
                    iconElement.style.display = 'inline'; // Menampilkan tanda centang
                    listItem.classList.remove('invalid');
                    listItem.classList.add('valid');
                } else {
                    // Menyembunyikan tanda centang dan memberi warna merah pada teks
                    iconElement.style.display = 'none'; // Menyembunyikan tanda centang
                    listItem.classList.remove('valid');
                    listItem.classList.add('invalid');
                }
            }

            // Event listener untuk validasi saat password diketik
            passwordInput.addEventListener('input', validatePassword);
            cp1SaveRegister.addEventListener('change', validatePassword);
        });



        let languageIndonesian = {
            inputTooShort: function(args) {
                var remainingChars = args.minimum - args.input.length;
                return `silakan masukkan ${remainingChars} karakter atau lebih`;
            },
            noResults: function() {
                return 'Tidak ada data yang sesuai';
            },
            searching: function() {
                return 'Mencari…';
            },
        };

        let isNibAllowed = 0;

        let companyType = {
            '01': 'PT',
            '02': 'CV',
            '04': 'Badan Usaha pemerintah',
            '05': 'Firma (Fa)',
            '06': 'Persekutuan Perdata',
            '07': 'Koperasi',
            '10': 'Yayasan',
            '16': 'Bentuk Usaha Tetap (BUT)',
            '17': 'Perseorangan',
            '18': 'Badan Layanan Umum (BLU)',
            '19': 'Badan Hukum',
        };

        async function togglePass() {
            document.getElementById('togglePassword').addEventListener('click', function(e) {
                e.preventDefault();
                const passwordField = document.getElementById('data-informasi-akun-password');
                const icon = this.querySelector('i');
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }

        async function checkOSS() {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'GET',
                '{{ url('') }}/api/setting/find', {
                    name: "oss"
                }
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                adjustWizardSteps();
                let resp = error.response;
                return resp;
            });
            if (getDataRest.status == 200) {
                loadingPage(false)
                const active = getDataRest.data.data.is_active;
                if (active === 0) {
                    adjustWizardSteps();
                }
            }else{
                adjustWizardSteps();
            }
        }

        async function getDataApps() {

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/setting/find`, {
                        name: "aplikasi"
                    }
                )
                .then(response => response)
                .catch(error => {
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('info', 'Pemberitahuan', 'Error');
                    return resp;
                });

            if (getDataRest.status === 200) {


                const appData = getDataRest.data.data;

                const currentPort = window.location.port || '80';
                let logoPort;
                let logoFavicon;
                try {
                    logoPort = new URL(appData.logo_aplikasi).port || '80';
                    logoFavicon = new URL(appData.logo_favicon).port || '80';
                } catch {
                    logoFavicon = null;
                    logoPort = null;
                }

                const defaultLogo = '{{ asset('assets/images/logoapp.png') }}';
                const finalLogo = (logoPort && logoPort !== currentPort) ?
                    defaultLogo :
                    (appData.logo_aplikasi || defaultLogo);
                const finalLogoFav = (logoFavicon && logoFavicon !== currentPort) ?
                    defaultLogo :
                    (appData.logo_favicon || defaultLogo);

                const isDefaultLogo = finalLogo === defaultLogo;
                loadingPage(false);
                document.querySelectorAll('.nama_aplikasi').forEach(function(element) {
                    element.innerText = 'Daftar ' + appData.nama;
                });

                document.querySelector('.nama_instansi').innerText = appData.nama_instansi || '';

                document.querySelector('.logo_aplikasi').innerHTML = `
                    <a href="#">
                        <img src="${finalLogo}" alt="img"
                            style="width: 60px; border-radius:50%;" />
                    </a>`;

                let sideLogo = document.getElementById('side-content-logo');
                if (sideLogo) {
                    sideLogo.innerHTML = `
                <div class="auth-sidecontent" style="position: relative;">
                        <!-- Gambar latar belakang -->
                        <img src="{{ asset('assets') }}/images/authentication/3.jpg" alt="images" class="img-fluid img-auth-side" />

                        <!-- Logo, diposisikan di tengah gambar -->
                        <img src="${finalLogo}" alt="images"
                            class="img-fluid img-auth-side"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 8rem; height: ${isDefaultLogo ? '9rem' : '8rem'}; border-radius:50%;" />
                    </div>
                `;
                }

                const favicon = document.getElementById('logo_favicon');
                favicon.href = finalLogoFav;
            }
        }

        function adjustWizardSteps() {
            // Menyembunyikan semua langkah
            const steps = document.querySelectorAll('.wizard-step');
            steps.forEach((step) => {
                step.style.display = 'none';
            });

            const step2 = document.querySelector('.wizard-step.step-2');
            if (step2) {
                step2.style.display = 'block';
            } else {
                console.error('Step 2 element not found in DOM.');
            }
        }

        document.getElementById('nib').addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                getAllowedNib();
            }
        });

        async function getAllowedNib() {
            loadingPage(true);
            const dataRest = await CallAPI(
                'GET',
                `{{ url('') }}/api/oss/inquery-nib`, {
                    nib: $('#nib').val()
                }
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                console.error("🚀 ~ message:", resp.data.message)
                notificationAlert('warning', 'Pemberitahuan', resp.data.message);
                $('.selanjutnya').attr('disabled', true);
                return resp;
            });
            let data = {};
            if (dataRest.status == 200) {
                loadingPage(false);
                notificationAlert('success', 'Pemberitahuan',
                    'Berhasil menemukan NIB untuk KBLI E-SMK dari data OSS Perusahaan!. Silahkan Klik Tombol Selanjutnya'
                );
                adjustWizardSteps();

                console.log(dataRest)
                $("#input-provinsi").val(' ').trigger("change");
                $("#input-kota").val(' ').trigger("change");
                $("#input-pelayanan").val(' ').trigger("change");

                data = dataRest.data.data;
                isNibAllowed = 1;
                $('#data-perusahaan-nib').val(data.nib);
                let companyTypeName = typeof companyType[data.jenis_perseroan] != 'undefined' ?
                    companyType[data.jenis_perseroan].toUpperCase() : ''
                $('#data-perusahaan-nama-perusahaan').val(companyTypeName + ' ' + data.nama_perseroan)
                $('#data-perusahaan-no-telepon-perusahaan').val(data.nomor_telpon_perseroan);
                $('#data-perusahaan-email').val(data.email_perusahaan);
                $('#data-perusahaan-alamat').val(
                    `${data.alamat_perseroan} Kelurahan ${data.kelurahan_perseroan || '-'} Kode pos ${data.kode_pos_perseroan || '-'}`
                );

                let namaPic = data.penanggung_jwb.length > 0 ? data.penanggung_jwb[0]
                    .nama_penanggung_jwb : '-';
                let teleponPic = data.penanggung_jwb.length > 0 ? data.penanggung_jwb[0]
                    .no_hp_penanggung_jwb : '-';
                $('#data-pic-nama').val(namaPic)
                $('#data-pic-no-telepon').val(teleponPic)

                $('.selanjutnya').attr('disabled', false);
            }
            return data;

        }

        async function submitCompany() {
            $(document).on('click', '#daftar-akun', async function() {
                loadingPage(true);
                const dataSubmission = {
                    "province_id": $('#data-perusahaan-provinsi').val(),
                    "city_id": $('#data-perusahaan-kota').val(),
                    "username": $('#data-informasi-akun-username').val(),
                    "phone_number": $('#data-informasi-akun-no-telepon').val(),
                    "service_types": $('#data-jenis-pelayanan').val(),
                    "nib": $('#data-perusahaan-nib').val(),
                    "password": $('#data-informasi-akun-password').val(),
                    "name": $('#data-perusahaan-nama-perusahaan').val(),
                    "address": $('#data-perusahaan-alamat').val(),
                    "pic_name": $('#data-pic-nama').val(),
                    "pic_phone": $('#data-pic-no-telepon').val(),
                    "email": $('#data-perusahaan-email').val(),
                    "company_phone_number": $('#data-perusahaan-no-telepon-perusahaan').val()
                };

                console.log(dataSubmission)
                const dataRest = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/auth/register`,
                    dataSubmission
                ).then(function(response) {
                    return response;
                }).catch(function(error) {
                    loadingPage(false);
                    let resp = error.response;
                    console.error("🚀 ~ message:", resp.data.message)
                    notificationAlert('warning', 'Pemberitahuan', resp.data.message);
                    return resp;
                });
                if (dataRest.status == 200) {
                    loadingPage(false);
                    notificationAlert('success', 'Pemberitahuan', dataRest.data.message);
                    setTimeout(() => {
                        window.location.href = '/'; // Arahkan ke halaman login
                    }, 1000);
                }
            });
        }

        function notificationAlert(tipe, title, message) {
            swal(
                title,
                message,
                tipe
            );
        }

        function loadingPage(show) {
            if (show == true) {
                document.getElementById('preloaderLoadingPage').style.display = '';
            } else {
                document.getElementById('preloaderLoadingPage').style.display = 'none';
            }
            return;
        }

        async function select2List(idElement = '#data-perusahaan-provinsi', type = 'provinsi', id = '') {
            let urlExtended = '';
            let isAllowMultiple = false;
            if (type == 'provinsi') {
                urlExtended = 'provinsi/list';
                isPlaceholder = 'Pilih Provinsi';
            }
            if (type == 'kota') {
                urlExtended = 'kota/list';
                isPlaceholder = 'Pilih Kota';
            }
            if (type == 'jenis_pelayanan') {
                urlExtended = 'service-type/list';
                isPlaceholder = 'Pilih Jenis Pelayanan';
                isAllowMultiple = true;
            }
            $(`${idElement}`).select2({
                language: languageIndonesian,
                ajax: {
                    url: `{{ url('') }}/api/${urlExtended}`,
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        let query = {
                            keyword: params.term,
                            page: 1,
                            limit: 30,
                            ascending: 1,
                        }
                        if (id != '') {
                            query.province_id = id;
                        }
                        return query;
                    },
                    processResults: function(res) {
                        let data = res.data
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                },
                enable: true,
                allowClear: true,
                placeholder: isPlaceholder,
                multiple: isAllowMultiple
            });
        }


        document.addEventListener("DOMContentLoaded", () => {
            const steps = document.querySelectorAll(".wizard-step");
            const wizardContainer = document.querySelector(".wizard-container");
            let currentStep = 0;

            const showStep = (index) => {
                steps.forEach((step, idx) => {
                    step.style.display = idx === index ? "block" : "none";
                });
            };

            const nextButtons = document.querySelectorAll("button[type='submit']");
            const prevButtons = document.querySelectorAll(".prev-btn");

            nextButtons.forEach((button, idx) => {
                button.addEventListener("click", (event) => {
                    event.preventDefault(); // Hentikan pengiriman form
                    if (idx < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            prevButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            $("#data-perusahaan-provinsi").select2({
                language: languageIndonesian,
                placeholder: 'Pilih Provinsi',
                enable: false,
            });
            $("#data-perusahaan-kota").select2({
                language: languageIndonesian,
                placeholder: 'Pilih Kota',
                enable: false,
            });
            $("#data-jenis-pelayanan").select2({
                language: languageIndonesian,
                placeholder: 'Pilih Jenis Pelayanan',
                enable: false,
            });

            $('#data-informasi-akun-username, #data-informasi-akun-no-telepon').on('input', function() {
                if ($('#data-informasi-akun-username').val() == '' || $('#data-informasi-akun-no-telepon')
                    .val() == '') {
                    $('#cp1-save-register').prop('checked', false);
                    $('#cp1-save-register').attr('disabled', true);
                } else {
                    $('#cp1-save-register').attr('disabled', false);
                }
            });


            select2List('#data-perusahaan-provinsi', 'provinsi');
            select2List('#data-jenis-pelayanan', 'jenis_pelayanan');
            $('#data-perusahaan-provinsi').on('change', async function() {
                $("#data-perusahaan-kota").val(' ').trigger("change");
                let id = $(this).val();
                select2List('#data-perusahaan-kota', 'kota', id);
            });

            showStep(currentStep);
            checkOSS();
            submitCompany();
            togglePass();
            getDataApps();

        });
    </script>

</body>

</html>
