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
    <link rel="icon" href="{{ asset('assets') }}/images/logoapp.png" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css" />
    <script src="{{ asset('assets') }}/js/tech-stack.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <script src="{{ asset('assets') }}/js/plugins/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/creativetimofficial/nucleo-icons/css/nucleo-icons.css" rel="stylesheet">


    {{-- <link rel="stylesheet" href="{{ asset('assets') }}/css/uikit.css" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/style.css" /> --}}

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

    @include('Internal.layouts.sidebar')
    @include('Internal.layouts.header')

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    @include('Internal.layouts.footer')
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.3/js.cookie.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simple-datatables.js"></script>
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
    <script type="text/javascript">
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
    @yield('scripts')


    @yield('page_js')
    @include('Administrator.partial-js')


</body>
<!-- [Body] end -->

</html>
