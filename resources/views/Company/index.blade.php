<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies." />
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard" />
    <meta name="author" content="Phoenixcoded" />

    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/style.css" />
    <link id="logo_favicon" rel="icon" href="{{ asset('assets') }}/images/logoapp.png" type="image/x-icon"  />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link" />
    <script src="{{ asset('assets') }}/js/tech-stack.js"></script>
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/uikit.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.7.1.min.js"></script>

    <style>
        select#limitPage {
            width: 35%;
        }
    </style>

    @yield('asset_css')

</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr"
    data-pc-theme_contrast="" data-pc-theme="light">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    @include('Company.layouts.sidebar')
    @include('Company.layouts.header')


    <div class="pc-container">
        <div class="pc-content">

            @yield('content')

        </div>
    </div>


    @include('Company.layouts.footer')

    <div id="preloaderLoadingPage-network" style="display: none">
        <div class="sk-three-bounce">
            <div class="centerpreloader-network">
                <center>
                    <div class="ui-loading-network"></div>
                    <h6 style="color: white;">DEVICE OFFLINE</h6>
                    <p style="color: white;">Pastikan koneksi internet Anda aktif dan stabil untuk pengalaman terbaik.
                    </p>
                </center>
            </div>
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

    <div style="position: fixed; bottom: 20px; right: 40px; z-index: 999;">
        <a href="https://wa.me/6281287980134?text=Halo saya ingin bertanya tentang layanan Anda"
            style="background:linear-gradient(45deg, #28a745, #28a74594); color: white; padding: 12px; border-radius: 50%; height: 50px;
                  width: 50px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
                  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <i class="ph-duotone ph-headset fa-solid text-white fa-2x"></i>
        </a>
    </div>

    {{-- <div class="floting-button">
        <a href="https://wa.me/6281287980134?text=Halo"
            class="btn btn btn-success buynowlinks d-inline-flex align-items-center gap-2" data-bs-toggle="tooltip"
            data-bs-original-title="Buy Now"><i class="ph-duotone ph-headset"></i> <span>Call Center</span>
        </a>
    </div> --}}




    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.3/js.cookie.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simple-datatables.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/sweetalert2.all.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{ asset('assets') }}/js/axios.js"></script>
    <script src="{{ asset('assets') }}/js/restAPI.js"></script>
    <script src="{{ asset('assets') }}/js/offline.js"></script>

    <script>
        layout_change('light');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>

    <script>
        main_layout_change('vertical');
    </script>
    <script>
        document.onreadystatechange = function() {
            var state = document.readyState;
            if (state == 'complete') {
                document.getElementById('preloaderLoadingPage').style.display = 'none';
                if (window.initPageLoad) {
                    initPageLoad();
                    setInterval(() => {
                        if (Offline.state == "up") {
                            document.getElementById('preloaderLoadingPage-network').style.display = 'none';
                        } else {
                            document.getElementById('preloaderLoadingPage-network').style.display = '';
                        }
                    }, 3000);

                }
            }
        }
    </script>
    @yield('scripts')
    <script type="text/javascript">
        let deskripsi_aplikasi;

        async function getDataApps() {
            loadingPage(true); // Menampilkan indikator loading

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/company/setting/find`, {
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
                document.getElementById('nama_instansi').innerText = appData.nama_instansi;
                document.getElementById('kredit_by').innerText = `${appData.nama_instansi}`;
                $('#email_app').html(`<i class="fa fa-envelope me-2"></i>${appData.email}`);
                $('#no_telepon_app').html(`<i class="fa fa-phone me-2"></i>${appData.whatsapp}`);
                $('#alamat_app').html(`<i class="fa-solid fa-location-dot me-2"></i> ${appData.alamat}`);
                $('.logo_aplikasi').html(
                    `<img src="${appData.logo_aplikasi}" alt="img" style="width: 45px; height: 45px; border-radius: 50%;">`
                );

                if (appData.logo_favicon) {
                    const favicon = document.getElementById('logo_favicon');
                    favicon.href = appData.logo_favicon;
                }
                let deskripsi_dashboard = document.getElementById('deskripsi_aplikasi');
                if (deskripsi_dashboard) {
                    deskripsi_dashboard.innerText = appData.deskripsi;
                }
                let logoFooter = document.getElementById('logo_footer');
                if (logoFooter) {
                    logoFooter.innerHTML = `<img src="${appData.logo_aplikasi}" alt="Logo" style="width: 45px; height: 45px; border-radius: 50%;">`;
                }
            }
        }
        window.onload = getDataApps;

        function notificationAlert(tipe, title, message) {
            Swal.fire({
                icon: tipe,
                title: title,
                text: message
            });
        }

        function loadingPage(show) {
            if (show == true) {
                document.getElementById('preloaderLoadingPage').style.display = '';
            } else {
                document.getElementById('preloaderLoadingPage').style.display = 'none';
            }
            return;
        }

        async function logout() {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'POST',
                '{{ url('') }}/api/logout', {}
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });
            if (getDataRest.status == 200) {
                Cookies.remove('auth_token');
                setTimeout(function() {
                    window.location.href = "{{ route('auth.login') }}"
                }, 500);
            }
        }

        $(document).on('click', '.logout', async function() {
            await logout();
        });
    </script>
    @include('Company.partial-js')
    @yield('page_js')
</body>
<!-- [Body] end -->

</html>
