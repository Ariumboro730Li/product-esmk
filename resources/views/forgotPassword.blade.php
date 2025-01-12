<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- [Head] start -->

<head>
    <title>Login | {{ env('APP_NAME') }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="Phoenixcoded" />

    <!-- [Favicon] icon -->
    <link rel="icon" id="logo_favicon" href="{{ asset('assets') }}/images/logoapp.png" type="image/x-icon" />
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />
    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/phosphor/duotone/style.css" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link" />
    <script src="{{ asset('assets') }}/js/tech-stack.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <link href="{{ asset('assets/css/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
</head>
<style>
    .welcome-banner::after {
        opacity: 0.1;
        background-position: bottom;
        background-size: 600%;

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
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center logo_aplikasi">
                        </div>
                        <h4 class="text-center mt-4 nama_aplikasi">PERIZINAN SMK-TD</h4>
                        <div class="saprator mb-5">
                            <span class="nama_instansi">Dinas Perhubungan</span>
                        </div>
                        <a href="#"></a>
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <h4 class="mb-0"><b>Lupa Kata Sandi</b></h4>
                            <a href="/" class="link-primary">Kembali ke Halaman Masuk</a>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-0">
                                <input type="email" class="form-control" id="email" placeholder="Email address" />
                                <label for="floatingInput">Email</label>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-muted">*** Jangan lupa cek kotak SPAM.</p>
                        <div class="d-grid mt-5">
                            <button href="javascript:void(0);" onclick="submitLogin()" type="button"
                                class="btn btn-primary"
                                style="background: linear-gradient(90deg, rgb(4 60 132) 0%, rgb(69 114 184) 100%); color: white;">Kirim
                                Email Reset Kata Sandi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.3/js.cookie.js"></script>
    <script src="{{ asset('assets/js/plugins/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>
    <script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/restAPI.js') }}"></script>

    <script>
        loadingPage(false);
        document.getElementById('email').addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                submitLogin();
            }
        });

        function loadingPage(show) {
            if (show == true) {
                document.getElementById('preloaderLoadingPage').style.display = '';
            } else {
                document.getElementById('preloaderLoadingPage').style.display = 'none';
            }
            return;
        }

        function notificationAlert(tipe, title, message) {
            swal(
                title,
                message,
                tipe
            );
        }

        async function getDataApps() {
            loadingPage(true); // Menampilkan indikator loading

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
                loadingPage(false);

                const appData = getDataRest.data.data;

                document.querySelectorAll('.nama_aplikasi').forEach(function(element) {
                    element.innerText = appData.nama;
                });
                document.querySelector('.nama_instansi').innerText = appData.nama_instansi || '';
                document.querySelector('.logo_aplikasi').innerHTML = 
                `<a href="#">
                    <img src="${appData.logo_aplikasi || `{{ asset('assets') }}/images/logoapp.png`}" alt="img"
                        style="width: 60px;border-radius:50%;" />
                </a>`;
                
                // Mengupdate logo aplikasi di welcome banner (gunakan gambar default jika kosong)
                let sideLogo = document.getElementById('side-content-logo');
                if (sideLogo) {
                    sideLogo.innerHTML = `
                   <div class="auth-sidecontent" style="position: relative;">
                        <!-- Gambar latar belakang -->
                        <img src="{{ asset('assets') }}/images/authentication/3.jpg" alt="images" class="img-fluid img-auth-side" />
                    
                        <!-- Logo, diposisikan di tengah gambar -->
                        <img src="${appData.logo_aplikasi || '{{ asset('assets') }}/images/logoapp.png'}" alt="images" 
                            class="img-fluid img-auth-side" 
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 8rem; height: 8rem;border-radius:50%;" />
                    </div>
                `;
                }

                if (appData.logo_favicon) {
                    const favicon = document.getElementById('logo_favicon');
                    favicon.href = appData.logo_favicon;
                } else {
                    const favicon = document.getElementById('logo_favicon');
                    favicon.href = '{{ asset('assets') }}/images/logoapp.png';
                }
            }
        }
        window.onload = getDataApps;


        async function submitLogin() {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'POST',
                '{{ url('') }}/api/auth/forgot-password', {
                    email: $('#email').val(),
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
                loadingPage(false)
                let rest_data = getDataRest.data;
                notificationAlert('success', 'Berhasil', rest_data.message);
                $('#email').val('');
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            }
        }
    </script>
</body>

</html>
