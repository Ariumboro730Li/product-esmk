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
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}" />
    <link class="main-css" href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
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
    background-image:url('{{ asset("bg_login.jpg") }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: 100vh;
    ">
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
    <div class="fix-wrapper"
        style="backdrop-filter: blur(4px); background-image: linear-gradient(180deg, rgba(85, 85, 85, .08), rgba(0, 0, 0, .73) 78%);}">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
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
                                <h6 class="text-center mb-4" style="color: white;">{{ request()->app_setting->value->nama_instansi }}</h6>
                                <div class="mb-3">
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Email atau Username" autocomplete="off">
                                </div>

                                <div class="mb-2 position-relative">
                                    <input type="password" id="dz-password" class="form-control" placeholder="Kata sandi"
                                        autocomplete="off">
                                    <span class="show-pass eye">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <div class="form-row d-flex flex-wrap justify-content-between">
                                    <div class="form-group mb-sm-4 mb-1">
                                        <div class="form-check custom-checkbox ms-1">
                                            <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                            <label class="form-check-label" for="basic_checkbox_1"
                                                style="color: white;">Ingat saya</label>
                                        </div>
                                    </div>
                                    <div class="form-group ms-2">
                                        <a class="text-hover" href="/forgot-password"
                                            style="color: white;">Lupa kata sandi?</a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" onclick="submitLogin()" class="btn btn-app btn-block">Masuk sekarang</button>
                                </div>
                                <div class="new-account mt-3">
                                    <p style="color: white;">Belum punya akun? <a class="text-info" href="/register">Daftar sekarang</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
 Scripts
***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('js/HttpStatusCodes.js') }}"></script>
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script src="{{ asset('js/restAPI.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script>
        document.querySelectorAll('#email, #dz-password').forEach(input => {
            input.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    submitLogin();
                }
            });
        });

        function loadingPage(show) {
            if (show) {
                document.getElementById('preloaderLoadingPage').style.display = '';
            } else {
                document.getElementById('preloaderLoadingPage').style.display = 'none';
            }
        }

        function notificationAlert(type, title, message) {
            Swal.fire({
                title: title,
                text: message,
                icon: type,
                showCancelButton: false,
                showConfirmButton: false
            });
        }

        async function submitLogin() {
            loadingPage(true);
            const getDataRest = await CallAPI(
            'POST',
            '{{url("/api/auth/login")}}',
            {
                email : $('#email').val(),
                password : $('#dz-password').val()
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
                setTimeout(function(){
                    window.location.href = "{{ route('admin.dashboard') }}"
                },500);
            }
        }
    </script>


</body>

</html>
