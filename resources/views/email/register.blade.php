<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title>Pendaftaran Perusahaan {{ $name }}</title>
    <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");

        body {
            width: 100% !important;
            height: 100%;
            margin: 0;
            -webkit-text-size-adjust: none;
        }

        a {
            color: #3869D4;
        }

        a img {
            border: none;
        }

        td {
            word-break: break-word;
        }

        .preheader {
            display: none !important;
            visibility: hidden;
            mso-hide: all;
            font-size: 1px;
            line-height: 1px;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
        }

        /* Type ------------------------------ */

        body,
        td,
        th {
            font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
        }

        h1 {
            margin-top: 0;
            color: #333333;
            font-size: 22px;
            font-weight: bold;
            text-align: left;
        }

        h2 {
            margin-top: 0;
            color: #333333;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
        }

        h3 {
            margin-top: 0;
            color: #333333;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
        }

        td,
        th {
            font-size: 16px;
        }

        p,
        ul,
        ol,
        blockquote {
            margin: .4em 0 1.1875em;
            font-size: 16px;
            line-height: 1.625;
        }

        p.sub {
            font-size: 13px;
        }

        .align-center {
            text-align: center;
        }

        /* Buttons ------------------------------ */

        .button {
            background-color: #3869D4;
            border-top: 10px solid #3869D4;
            border-right: 18px solid #3869D4;
            border-bottom: 10px solid #3869D4;
            border-left: 18px solid #3869D4;
            display: inline-block;
            color: #FFF;
            text-decoration: none;
            border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
            -webkit-text-size-adjust: none;
            box-sizing: border-box;
        }

        .button--green {
            background-color: #22BC66;
            border-top: 10px solid #22BC66;
            border-right: 18px solid #22BC66;
            border-bottom: 10px solid #22BC66;
            border-left: 18px solid #22BC66;
        }

        .button--red {
            background-color: #FF6136;
            border-top: 10px solid #FF6136;
            border-right: 18px solid #FF6136;
            border-bottom: 10px solid #FF6136;
            border-left: 18px solid #FF6136;
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
                text-align: center !important;
            }
        }

        body {
            background-color: #F4F4F7;
            color: #51545E;
        }

        p {
            color: #51545E;
        }

        p.sub {
            color: #6B6E76;
        }

        .email-wrapper {
            width: 100%;
            margin: 0;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            background-color: #F4F4F7;
        }

        .email-content {
            width: 100%;
            margin: 0;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
        }

        /* Masthead ----------------------- */

        .email-masthead {
            text-align: center;
        }

        .email-masthead_logo {
            /* width: 150px; */
            width: 280px;
            height: auto;
        }

        /* Body ------------------------------ */

        .email-body {
            width: 100%;
            margin: 0;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            background-color: #FFFFFF;
        }

        .email-body_inner {
            /* width: 570px; */
            width: 700px;
            margin: 0 auto;
            padding: 0;
            -premailer-width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            background-color: #FFFFFF;
        }

        .email-footer {
            width: 570px;
            margin: 0 auto;
            padding: 0;
            -premailer-width: 570px;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            text-align: center;
        }

        .email-footer p {
            color: #6B6E76;
        }

        .body-action {
            width: 100%;
            margin: 30px auto;
            padding: 0;
            -premailer-width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            text-align: center;
        }

        .content-cell {
            padding: 20px 35px;
        }

        /*Media Queries ------------------------------ */

        @media only screen and (max-width: 600px) {

            .email-body_inner,
            .email-footer {
                width: 100% !important;
            }
        }

        @media (prefers-color-scheme: dark) {

            body,
            .email-wrapper,
            .email-masthead,
            .body,
            .email-wrapper,
            .email-masthead,
            .email-footer {
                /* background-color: #29292C !important;*/
                /* background-color: #d5d5dd !important; */
                background-color: #FFFFFF !important;
                /* color: #F4F4F7 !important; */
                color: black !important;
            }

            .email-body,
            .email-body_inner,
            .email-content {
                /* background-color: #333338 !important; */
                background-color: #FFFFFF !important;
                /* color: #F4F4F7 !important; */
                color: black !important;
            }

            p,
            ul,
            ol,
            blockquote,
            h1,
            h2,
            h3,
            span {
                /* color: #F4F4F7 !important; */
                color: black !important;
            }
        }

        :root {
            color-scheme: light dark;
            supported-color-schemes: light dark;
        }
    </style>
</head>

<body>
    <span class="preheader">Pendaftaran Perusahaan {{ $name }}.</span>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <!-- Email Header -->
        <tr>
            <td align="center">
                <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="email-masthead content-cell" style="background-color: #26296e !important;">
                            {{-- <img src="https://storage.hubdat.dephub.go.id/smk-pau/assets/logo_kemenhub_hubdat.png" class="email-masthead_logo" alt="E-SMK" /> --}}
                            <img src="{{ $logo }}" class="email-masthead_logo" alt="E-SMK" />
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        <div class="f-fallback">
                                            <h1>Yth. {{ ucfirst($pic_name) }}</h1>
                                            <p>Terima kasih perusahaan Anda telah terdaftar dalam elektronik Sistem Manajemen Keselamatan (e-SMK).<br>
                                                <div class="mt-5"><b style="font-size: 14px;">INFORMASI PERUSAHAAN</b></div>
                                            <table>
                                                <tr>
                                                    <td>Nama Perusahaan</td>
                                                    <td width="30">:</td>
                                                    <td><b>{{ $name }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>NIB</td>
                                                    <td width="30">:</td>
                                                    <td>{{ $nib }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td width="30">:</td>
                                                    <td>{{ $address }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Telepon</td>
                                                    <td width="30">:</td>
                                                    <td>{{ $company_phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 50px; vertical-align:bottom; text-align:left;"><b style="font-size: 14px;">INFORMASI AKUN</b></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>Username</td>
                                                    <td width="30">:</td>
                                                    <td>{{ $username }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Nomor Telepon</td>
                                                    <td width="30">:</td>
                                                    <td>{{ $phone_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kata Sandi</td>
                                                    <td width="30">:</td>
                                                    <td><b>{{ $default_password }}</b></td>
                                                </tr>
                                            </table>
                                            <!-- Action -->
                                            <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td align="center">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                            <tr>
                                                                <td align="center">
                                                                    <a href="{{env('APP_FROTNEND_URL_LOGIN')}}" target="_blank">
                                                                        <div class="f-fallback button button--blue">Masuk Aplikasi</div>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            </p>
                                            <p>Hormat kami,
                                                <br />
                                                {{$nama_instansi}}
                                            </p>
                                            <i><b style="font-size: 14px;">PENTING:</b></i>
                                            <ul>
                                                <li style="font-size: 14px;">Jika Anda tidak mendaftar perusahaan, abaikan email ini.</li>
                                                <li style="font-size: 14px;">Email dikirimkan secara otomatis oleh sistem, mohon untuk tidak membalas email ini.</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Email Footer -->
                    <tr>
                        <td>
                            <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="content-cell" align="center">
                                        <p class="f-fallback sub align-center" style="margin-top: -15px">{{$nama_instansi}}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
