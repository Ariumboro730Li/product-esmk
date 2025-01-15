<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title }} | {{ request()->app_setting->value->nama }}</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="{{ request()->app_setting->value->logo_favicon }}" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <style>
        select#limitPage {
            width: 35%;
        }
        body > div.pc-container > div > div.page-header > div > div > div.col-md-12.d-flex.justify-content-between.align-items-center > div > h2 {
            font-size: 1.2rem;
        }
        body > div.pc-container > div > div.page-header > div > div > div.col-md-12.d-flex.d-flex.flex-column.flex-md-row.justify-content-between.align-items-start > div > h2 {
            font-size: 1.2rem;
        }
    </style>

    @yield('asset_css')
    <script src="{{ asset('assets/js/tech-stack.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-3.7.1.min.js') }}"></script>
    <script>
        function initPageSeeting() {
            let email       = "{{ request()->app_setting->value->email }}";
            let whatsapp    = "{{ request()->app_setting->value->whatsapp }}";
            let address     = "{{ request()->app_setting->value->alamat }}";

            document.querySelector('#nama_instansi').innerText  = "{{ request()->app_setting->value->nama_instansi }}";
            // document.getElementById('kredit_by').innerText      = "{{ request()->app_setting->value->nama_instansi }}";

            $('#email_app').html(`<i class="fa fa-envelope me-2"></i>${email}`);
            $('#no_telepon_app').html(`<i class="fa fa-phone me-2"></i>${whatsapp}`);
            $('#alamat_app').html(`<i class="fa-solid fa-location-dot me-2"></i> ${address}`);

            let imgLogoApp = document.querySelector('.img-logo-app');
            if (imgLogoApp) {
                    imgLogoApp.innerHTML = `
                    <div class="img-welcome-banner">
                        <img src="{{ request()->app_setting->value->logo_aplikasi }}" alt="img" class="img-fluid mt-2"
                            style="width: 5rem; height: 100%; border-radius: 50%;" />
                    </div>
                `;
            }

            let deskripsi_dashboard = document.getElementById('deskripsi_aplikasi');
            if (deskripsi_dashboard) {
                deskripsi_dashboard.innerText = "{{ request()->app_setting->value->deskripsi }}";
            }

            let logoFooter = document.getElementById('logo_footer');
            if (logoFooter) {
                logoFooter.innerHTML = `
                    <img src="{{ request()->app_setting->value->logo_aplikasi }}" alt="Logo" style="width: 45px; height: 50px; border-radius: 50%;">
                `;
            }
        }

        document.onreadystatechange = function() {
            var state = document.readyState;
            if (state == 'complete') {
                initPageSeeting();
                document.getElementById('preloaderLoadingPage').style.display = 'none';
                if (window.initPageLoad) {
                    initPageLoad();

                }
            }
        }
    </script>

</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">

    <div id="preloaderLoadingPage" style="background-image: linear-gradient(rgba(85, 85, 85, 0.08), rgba(0, 0, 0, 0.73) 95%);">
        <div class="sk-three-bounce">
            <div class="centerpreloader">
                <center>
                    <img class="ui-loading" src="{{ asset('images/loading_new.webp') }}" style="margin-bottom: 10px;">
                    <h6 style="color: white;">Please Wait...</h6>
                </center>
            </div>
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

    <div style="position: fixed; bottom: 20px; right: 40px; z-index: 999;">
        <a href="https://wa.me/{{ request()->app_setting->value->whatsapp }}" target="_blank"
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
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{ asset('assets/js/axios.js') }}"></script>
    <script src="{{ asset('assets/js/restAPI.js') }}"></script>

    <script>
        layout_change('light');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change('preset-1');
        main_layout_change('vertical');
    </script>
    @yield('scripts')
    <script type="text/javascript">
        let deskripsi_aplikasi;

        function notificationAlert(tipe, title, message) {
            Swal.fire({
                title: title,
                text: message,
                icon: tipe,
                showCancelButton: false,
                showConfirmButton: false
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
