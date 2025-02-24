<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--Title-->
    <title>{{ $title }} | {{ request()->app_setting->value->nama }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FAVICONS ICON -->
    <link rel="icon" href="{{ request()->app_setting->value->logo_favicon }}" type="image/x-icon" />
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/loading.css') }}" rel="stylesheet">
    <link class="main-css" href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <script>
        document.onreadystatechange = function() {
            var state = document.readyState;
            if (state == 'complete') {
                setTimeout(function() {
                    document.getElementById('preloaderLoadingPage').style.display = 'none';
                }, 100);
            }
        }
    </script>

</head>

<body
    style="
    background-image:url('{{ asset('bg_login.jpg') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: 100vh;
    ">
    <div id="preloaderLoadingPage">
        <div class="sk-three-bounce">
            <div class="centerpreloader">
                <div class="ui-loading"></div>
                <center>
                    <h6 style="color: white;">Loading...</h6>
                </center>
            </div>
        </div>
    </div>
    <div class="fix-wrapper"
        style="backdrop-filter: blur(4px); background-image: linear-gradient(180deg, rgba(85, 85, 85, .08), rgba(0, 0, 0, .73) 78%);}">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-8">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-2">
                                    <a href="javascript:void(0)"><img
                                            src="{{ request()->app_setting->value->logo_aplikasi }}" style="width: 22%"
                                            alt="{{ request()->app_setting->value->nama }}"></a>
                                </div>
                                <h4 class="text-center" style="line-height:1; color:white;">
                                    <b>{{ request()->app_setting->value->nama }}</b>
                                </h4>
                                <h6 class="text-center mb-4" style="color: white;">
                                    {{ request()->app_setting->value->nama_instansi }}</h6>
                                <form id="wizard-form">
                                    <div class="wizard-step step-1" data-step="1">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-white" for="nib">Cek Nomor Induk
                                                Berusaha (NIB)<sup class="text-danger ms-1">*</sup></label>
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="fa-solid fa-magnifying-glass text-dark"></i>
                                                </div>
                                                <input type="text" class="form-control" id="nib"
                                                    placeholder="Masukkan nomor induk berusaha" />
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" onclick="submitLogin()"
                                                class="btn btn-app btn-block">Cek NIB</button>
                                        </div>
                                        <div class="new-account mt-3">
                                            <p style="color: white;">Sudah punya akun? <a class="text-info"
                                                    href="/">Masuk sekarang</a></p>
                                        </div>
                                    </div>
                                    <div class="card mt-5 mb-2">
                                        <div class="card-body">
                                            <div class="wizard-step step-2" data-step="2">
                                                <h5 class="text-left mb-4" style="color:#214f96;"><i
                                                        class="fa-solid fa-circle-info fa-lg me-2"></i>Data
                                                    Perusahaan<sup class="text-danger ms-1">*</sup></h5>
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-0">
                                                            <input type="text" class="form-control"
                                                                id="data-perusahaan-nib" placeholder="" required />
                                                            <label for="nib">NIB<sup
                                                                    class="text-danger ms-1">*</sup></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <div class="form-floating mb-0">
                                                            <input type="text" class="form-control"
                                                                id="data-perusahaan-nama-perusahaan" required
                                                                placeholder="" />
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
                                                                    id="data-perusahaan-no-telepon-perusahaan" required
                                                                    placeholder="" />
                                                                <label for="noTelp">No. Telepon Perusahaan<sup
                                                                        class="text-danger ms-1">*</sup></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <div class="form-floating mb-0">
                                                                <input type="email" class="form-control"
                                                                    id="data-perusahaan-email"
                                                                    placeholder="Email address" required />
                                                                <label for="email">Email<sup
                                                                        class="text-danger ms-1">*</sup></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="mb-0">
                                                            <label class="fw-normal"
                                                                for="data-perusahaan-provinsi">Provinsi<sup
                                                                    class="text-danger ms-1">*</sup></label>
                                                            <select class="form-control form-control-sm"
                                                                name="data-perusahaan-provinsi"
                                                                id="data-perusahaan-provinsi" required></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label class="fw-normal"
                                                                for="data-perusahaan-kota">Kota<sup
                                                                    class="text-danger ms-1">*</sup></label>
                                                            <select class="form-control form-control-sm"
                                                                name="data-perusahaan-kota" id="data-perusahaan-kota"
                                                                required></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-0">
                                                            <textarea class="form-control" id="data-perusahaan-alamat" required rows="3"></textarea>
                                                            <label for="floatingdeskripsi">Alamat<sup
                                                                    class="text-danger ms-1">*</sup></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="col-md-12 mb-3">
                                                        <label class="fw-normal" for="data-jenis-pelayanan">Jenis
                                                            Pelayanan<sup class="text-danger ms-1">*</sup></label>
                                                        <select class="form-control form-control-sm"
                                                            name="data-jenis-pelayanan" id="data-jenis-pelayanan"
                                                            multiple required></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="wizard-step step- mb-3 " data-step="3" style="display: none;">
                                                <h5 class="text-left mb-4" style="color:#214f96;"><i
                                                        class="fa-solid fa-circle-info fa-lg me-2"></i>Penanggung Jawab
                                                    (PIC)</h5>
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="mb-0">
                                                            <div class="form-floating mb-0">
                                                                <input type="text" class="form-control" required
                                                                    id="data-pic-nama" placeholder="" />
                                                                <label for="namaPic">Nama PIC<sup
                                                                        class="text-danger ms-1">*</sup></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <div class="form-floating mb-0">
                                                                <input type="text" class="form-control"
                                                                    id="data-pic-no-telepon" placeholder=""required />
                                                                <label for="noTelpPic">No. Telepon PIC<sup
                                                                        class="text-danger ms-1">*</sup></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="wizard-step step-4" data-step="4" style="display: none;">
                                                <h5 class="text-left mb-4" style="color:#214f96;"><i
                                                        class="fa-solid fa-circle-info fa-lg me-2"></i>Informasi Akun
                                                </h5>
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="mb-0">
                                                            <div class="form-floating mb-0">
                                                                <input type="text" class="form-control"
                                                                    id="data-informasi-akun-username" placeholder=""
                                                                    required />
                                                                <label for="data-informasi-akun-username">Username<sup
                                                                        class="text-danger ms-1">*</sup></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <div class="form-floating mb-0">
                                                                <input type="number" class="form-control"
                                                                    id="data-informasi-akun-no-telepon" placeholder=""
                                                                    required />
                                                                <label for="data-informasi-akun-no-telepon">No.
                                                                    Telepon<sup
                                                                        class="text-danger ms-1">*</sup></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 position-relative">
                                                    <div class="form-floating">
                                                        <input type="password" class="form-control"
                                                            id="data-informasi-akun-password" placeholder="Kata Sandi"
                                                            required />
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
                                                <div class="d-flex mt-1 justify-content-between align-items-start">
                                                    <small id="passwordHelp" class="mt-2">
                                                        <b>Kata sandi yang baik mengandung:</b>
                                                        <ul>
                                                            <li id="is8">
                                                                <span>Minimal 8 karakter <i style="display: none"
                                                                        class="ti ti-check" id="is8Check"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                            <li id="isCapLow">
                                                                <span>Huruf Besar & Huruf Kecil (Aa) <i
                                                                        style="display: none" class="ti ti-check"
                                                                        id="isCapLowCheck"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                            <li id="isAngka">
                                                                <span>Angka (1234567890) <i style="display: none"
                                                                        class="ti ti-check" id="isAngkaCheck"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                            <li id="isSymbol">
                                                                <span>Symbol (?!@#$%^&*.) <i style="display: none"
                                                                        class="ti ti-check" id="isSymbolCheck"
                                                                        aria-hidden="true"></i></span>
                                                            </li>
                                                        </ul>
                                                    </small>
                                                    <div class="form-check ms-4 ms-md-0 mt-2">
                                                        <input class="form-check-input input-primary" type="checkbox"
                                                            name="cp1-save-register" id="cp1-save-register"
                                                            value="1" required />
                                                        <label class="form-check-label text-muted"
                                                            for="cp1-save-register">Saya
                                                            menyetujui
                                                            syarat dan ketentuan yang berlaku.</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div
                                        class="text-center mt-4 d-flex justify-content-center gap-2 flex-column flex-sm-row">
                                        <button type="button" onclick="submitLogin()"
                                            class="btn btn-dark flex-grow-1">Kembali</button>
                                        <button type="button" onclick="submitLogin()"
                                            class="btn btn-app flex-grow-1">Selanjutnya</button>
                                        <button type="button" onclick="submitLogin()"
                                            class="btn btn-success flex-grow-1" style="display: none;">Simpan</button>
                                    </div>
                                    <div class="new-account mt-3 text-center">
                                        <p style="color: white;">Sudah punya akun? <a class="text-info"
                                                href="/">Masuk sekarang</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/HttpStatusCodes.js') }}"></script>
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script src="{{ asset('js/restAPI.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
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
            '20': 'Badan Usaha Lainnya', // Badan Usaha Lainnya (Khusus STPW Luar Negeri)
            '21': 'Perum', // Perusahaan Umum (PERUM)
            '22': 'Perumda', // Perusahaan Umum Daerah (PERUMDA)
            '23': 'Perusda', // Perusahaan Daerah (PERUSDA)
            '24': 'BOB', // Badan Operasi Bersama (BOB)
            '25': 'Badan Usaha Perwakilan',
            '26': 'PT Peorangan', // PT Perorangan
            '27': 'PBA', // Pedagang Berjangka Asing (PBA)
            '28': 'BUM Desa', // Badan Usaha Milik Desa (BUM Desa)
            '29': 'BUM Desa Bersama'
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
            } else {
                adjustWizardSteps();
            }
        }

        // async function getDataApps() {

        //     const getDataRest = await CallAPI(
        //             'GET',
        //             `{{ url('') }}/api/setting/find`, {
        //                 name: "aplikasi"
        //             }
        //         )
        //         .then(response => response)
        //         .catch(error => {
        //             loadingPage(false);
        //             let resp = error.response;
        //             notificationAlert('info', 'Pemberitahuan', 'Error');
        //             return resp;
        //         });

        //     if (getDataRest.status === 200) {


        //         const appData = getDataRest.data.data;

        //         const currentPort = window.location.port || '80';
        //         let logoPort;
        //         let logoFavicon;
        //         try {
        //             logoPort = new URL(appData.logo_aplikasi).port || '80';
        //             logoFavicon = new URL(appData.logo_favicon).port || '80';
        //         } catch {
        //             logoFavicon = null;
        //             logoPort = null;
        //         }

        //         const defaultLogo = '{{ asset('assets/images/logoapp.png') }}';
        //         const finalLogo = (logoPort && logoPort !== currentPort) ?
        //             defaultLogo :
        //             (appData.logo_aplikasi || defaultLogo);
        //         const finalLogoFav = (logoFavicon && logoFavicon !== currentPort) ?
        //             defaultLogo :
        //             (appData.logo_favicon || defaultLogo);

        //         const isDefaultLogo = finalLogo === defaultLogo;
        //         loadingPage(false);
        //         document.querySelectorAll('.nama_aplikasi').forEach(function(element) {
        //             element.innerText = 'Daftar ' + appData.nama;
        //         });

        //         document.querySelector('.nama_instansi').innerText = appData.nama_instansi || '';

        //         document.querySelector('.logo_aplikasi').innerHTML = `
        //             <a href="#">
        //                 <img src="${finalLogo}" alt="img"
        //                     style="width: 60px; border-radius:50%;" />
        //             </a>`;

        //         let sideLogo = document.getElementById('side-content-logo');
        //         if (sideLogo) {
        //             sideLogo.innerHTML = `
        //         <div class="auth-sidecontent" style="position: relative;">
        //                 <!-- Gambar latar belakang -->
        //                 <img src="{{ asset('assets') }}/images/authentication/3.jpg" alt="images" class="img-fluid img-auth-side" />

        //                 <!-- Logo, diposisikan di tengah gambar -->
        //                 <img src="${finalLogo}" alt="images"
        //                     class="img-fluid img-auth-side"
        //                     style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 8rem; height: ${isDefaultLogo ? '9rem' : '8rem'}; border-radius:50%;" />
        //             </div>
        //         `;
        //         }

        //         const favicon = document.getElementById('logo_favicon');
        //         favicon.href = finalLogoFav;
        //     }
        // }

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
                button.addEventListener("click", () => {
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
            // getDataApps();

        });
    </script>

</body>

</html>
