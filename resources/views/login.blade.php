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
    <link rel="icon" href="{{ asset('assets') }}/images/logoapp.png" type="image/x-icon" />
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
    /* .welcome-banner::after {
        opacity: 0.1;
        background-position: bottom;
        background-size: 600%;

    } */
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
                <div class="auth-sidecontent">
                    <img src="{{ asset('assets') }}/images/authentication/2.jpg" alt="images" class="img-fluid img-auth-side"/>
                </div>

            <div class="auth-form">
                <div class="card my-5" style="max-width:70%">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#"><img src="{{ asset('assets') }}/images/logoapp.png" alt="img"
                                    style="width: 60px;" /></a>
                        </div>
                        <h4 class="text-center mt-4">PERIZINAN SMK-TD</h4>
                        <div class="saprator mb-5">
                            <span>Dinas Perhubungan</span>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating mb-0">
                                <input type="email" class="form-control" id="email"
                                    placeholder="Email address" required />
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password"
                                    placeholder="Password" required />
                                <label for="password">Kata Sandi</label>
                            </div>
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" />
                                <label class="form-check-label text-muted" for="customCheckc1">Ingatkan saya?</label>
                            </div>
                            <h6 class="text-secondary f-w-400 mb-0">
                                <a href="/forgot-password"> Lupa Kata Sandi? </a>
                            </h6>
                        </div>
                        <div class="d-grid mt-5">
                            <a href="javascript:void(0);" onclick="submitLogin()" type="button" class="btn btn-primary" style="background: linear-gradient(90deg, rgb(4 60 132) 0%, rgb(69 114 184) 100%); color: white;">Masuk</a>
                        </div>
                        <div class="d-flex justify-content-center align-items-end mt-3">
                            <h6 class="f-w-500 mb-0 me-2">Belum punya akun?</h6>
                            <a href="/register" class="link-primary">Daftar Sekarang!</a>
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

        document.getElementById('password').addEventListener('keydown', (event) => {
          if (event.key === 'Enter') {
            submitLogin();
          }
        });

        function loadingPage(show) {
            if(show == true) {
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

        async function submitLogin() {
            loadingPage(true);
            const getDataRest = await CallAPI(
            'POST',
            '{{ env("SERVICE_BASE_URL") }}/auth/login',
            {
                email : $('#email').val(),
                password : $('#password').val()
            }
            ).then(function (response) {
                return response;
            }).catch(function (error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info','Pemberitahuan',resp.data.message);
                return resp;
            });
            if(getDataRest.status == 200) {
                let rest_data = getDataRest.data;
                let token = rest_data.token;
                let tokenParse = parseJwt(token);
                console.log("🚀 ~ submitLogin ~ getDataRest.data:", getDataRest.data)
                Cookies.remove('auth_token')
                Cookies.set('auth_token', token, {
                  expires: tokenParse.exp,
                  user: rest_data.user
                })
                setTimeout(function(){
                    window.location.href = "{{ route('admin.dashboard') }}"
                },500);
            }
        }

        function parseJwt (token) {
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        }
    </script>
</body>

</html>
