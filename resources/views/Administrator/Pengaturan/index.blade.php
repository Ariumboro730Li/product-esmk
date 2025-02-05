@extends('...Administrator.index', ['title' => 'Pengaturan Aplikasi | Pengaturan'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/js/libs/filepond/filepond.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-pdf-preview/filepond-plugin-pdf-preview.min.css">
@endsection


@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Pengaturan Aplikasi</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Pengaturan Aplikasi</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-sm-row align-items-center">
                        <div class="d-flex justify-content-center mb-3 mb-sm-0">
                            <img src="{{ asset(request()->app_setting->value->logo_aplikasi) }}" alt="Logo Aplikasi"
                                style="width: 4rem;  border-radius: 50%; height: 4rem; object-fit: cover;">
                        </div>

                        <div class="flex-grow-1 mx-4 text-center text-sm-start">
                            <h4 class="mb-0">{{ request()->app_setting->value->nama }}</h4>
                            <h6 class="mb-0">{{ request()->app_setting->value->nama_instansi }}</h6>
                            <p class="mb-0">
                                <i class="fa-solid fa-location-dot me-2"></i> {{ request()->app_setting->value->alamat }}
                            </p>
                            <div
                                class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-start">
                                <p class="mb-0 me-2">
                                    <span class="contact-icon">
                                        <i class="fa fa-phone  me-2"></i>{{ request()->app_setting->value->whatsapp }}
                                    </span>
                                </p>
                                <span class="mx-2">|</span>
                                <p class="mb-0 ms-2">
                                    <span class="contact-icon">
                                        <i class="fa fa-envelope  me-2"></i>{{ request()->app_setting->value->email }}
                                    </span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="card shadow-none border mb-0 h-100">
                                <div class="card-body">
                                    <form enctype="multipart/form-data">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-3">
                                                <h6 class="mb-0">Logo Favicon</h6>
                                            </div>
                                        </div>
                                        <div class="mb-5 mt-3">
                                            <input type="file" id="faviconFileUrl" name="favicon_file_url"
                                                accept="image/*" required />
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-3">
                                                <h6 class="mb-0">Logo Aplikasi</h6>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <input type="file" id="logoFileUrl" name="logo_file_url" accept="image/*"
                                                required />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card shadow-none border mb-0 h-100">
                                <div class="card-body">
                                    <h6 class="mb-2">Informasi Aplikasi</h6>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="">
                                                <div class="form-floating mb-0">
                                                    <input type="text" class="form-control" id="input_nama"
                                                        placeholder="Masukkan Nama Aplikasi" />
                                                    <label for="input_nama">Nama Aplikasi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-0">
                                                    <input type="text" class="form-control" id="input_nama_instansi"
                                                        placeholder="Masukkan Nama Aplikasi" />
                                                    <label for="input_nama_instansi">Nama Instansi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="mb-5">
                                                <div class="form-floating mb-0">
                                                    <textarea class="form-control" id="deskripsiAplikasi" rows="5"></textarea>
                                                    <label for="deskripsiAplikasi">Deskripsi Aplikasi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="">
                                                <div class="form-floating mb-0">
                                                    <input type="email" class="form-control" id="input_email"
                                                        placeholder="Masukkan Email Helpdesk" />
                                                    <label for="email">Email Helpdesk</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-0">
                                                    <input type="text" class="form-control" id="input_wa"
                                                        placeholder="No WhatsApp Helpdesk" />
                                                    <label for="noWaHelpdesk">No. WhatsApp Helpdesk</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form mb-0">
                                                    <label for="floatingSelect">Provinsi</label>
                                                    <select class="form-select select2" id="select_provinsi"
                                                        aria-label="Floating label select example" disabled>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form mb-0">
                                                    <label for="floatingSelect">Kota/Kabupaten</label>
                                                    <select class="form-select select2" id="select_kota"
                                                        aria-label="Floating label select example" disabled>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <div class="mb-">
                                                <div class="form-floating mb-0">
                                                    <textarea class="form-control" id="input_alamat" rows="3"></textarea>
                                                    <label for="alamat">Alamat</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end m-t-15">
                                        <button class="btn btn-sm btn-outline-primary p-2" style="border-radius:5px;"
                                            onclick="updateDataApps()">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card mt-4 shadow-none border mb-0 h-100">
                            <div class="card-body">
                                <h6 class="mb-3">Integrasi Akun OSS</h6>
                                <div class="form-check form-switch custom-switch-v1 switch-lg mb-4">
                                    <input type="checkbox" class="form-check-input input-primary f-16"
                                        id="akunOssActive" />
                                    <label class="form-check-label" for="akunOssActive">Aktifkan Akun OSS</label>
                                </div>
                                <div id="form-akun-oss" style="display: none;">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-0">
                                                    <input type="text" class="form-control" id="username"
                                                        placeholder="Masukkan Nama Aplikasi" />
                                                    <label for="username">Username OSS</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="form-floating mb-0">
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="Masukkan Nama Aplikasi" />
                                                    <label for="password">Password OSS</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control" id="urlOss"
                                                placeholder="Masukkan url" />
                                            <label for="urlOss">URL OSS</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" hidden>
                        <div class="card mt-4 shadow-none border mb-0 h-100">
                            <div class="card-body">
                                <h6 class="mb-3">Berbagi Data</h6>
                                <div class="form-check form-switch custom-switch-v1 switch-lg mb-4">
                                    <input type="checkbox" class="form-check-input input-primary f-16"
                                        id="shareActive" />
                                    <label class="form-check-label" for="shareActive">Aktifkan Berbagi
                                        Data</label>
                                </div>
                                <div id="form-berbagi-data" style="display: none;">
                                    <!-- Informasi Dasar -->
                                    <div class="mb-3">
                                        <div class="form-floating mb-0">
                                            <input type="text" class="form-control" id="judulData"
                                                placeholder="Masukkan Judul Data" />
                                            <label for="judulData">Judul Data</label>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-0">
                                                <input type="date" class="form-control" id="tanggalBerbagi" />
                                                <label for="tanggalBerbagi">Tanggal Dibagikan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-0">
                                                <select class="form-select" id="penerimaData">
                                                    <option value="" selected>Pilih Penerima</option>
                                                    <option value="dishub-provinsi">Dishub Provinsi</option>
                                                    <option value="dishub-pusat">Dishub Pusat</option>
                                                </select>
                                                <label for="penerimaData">Penerima</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Jenis dan Format Data -->
                                    <div class="mb-3 mt-5">
                                        <div class="form-floating mb-0">
                                            <select class="form-select" id="jenisData">
                                                <option value="" selected>Pilih Jenis Data</option>
                                                <option value="laporan">Laporan Keselamatan</option>
                                                <option value="insiden">Data Insiden</option>
                                            </select>
                                            <label for="jenisData">Jenis Data</label>
                                        </div>
                                    </div>

                                    <!-- File Upload -->
                                    <div class="mb-3 mt-3">
                                        <div class="form-floating mb-0">
                                            <div class="mb-5 mt-3">
                                                <form action="{{ asset('assets') }}/json/file-upload.php">
                                                    <input type="file" id="file" multiple accept=".pdf" />
                                                    <input type="hidden" id="fileUrl" name="fileUrl" />
                                                </form>
                                            </div>
                                            <label for="fileLampiran">Unggah File Lampiran</label>
                                        </div>
                                    </div>

                                    <!-- Hak Akses dan Keamanan -->
                                    <div class="row g-4 mt-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-0">
                                                <select class="form-select" id="levelAkses">
                                                    <option value="" selected>Pilih Level Akses</option>
                                                    <option value="read-only">Hanya Baca</option>
                                                    <option value="read-download">Baca dan Unduh</option>
                                                </select>
                                                <label for="levelAkses">Level Akses</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-0">
                                                <input type="date" class="form-control" id="masaBerlaku" />
                                                <label for="masaBerlaku">Masa Berlaku</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Catatan Tambahan -->
                                    <div class="mb-3 mt-3">
                                        <div class="form-floating mb-0">
                                            <textarea class="form-control" id="catatanTambahan" style="height: 100px;"></textarea>
                                            <label for="catatanTambahan">Catatan Tambahan</label>
                                        </div>
                                    </div>

                                    <!-- Tombol Simpan -->
                                    <div class="text-end mt-4">
                                        <button class="btn btn-sm btn-outline-primary p-2"
                                            style="border-radius:5px;">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/dropzone-amd-module.min.js"></script>
    <script src="{{ asset('assets') }}/js/libs/filepond/filepond.min.js"></script>
    <script src="{{ asset('assets') }}/js/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js">
    </script>
    <script src="{{ asset('assets') }}/js/libs/filepond-plugin-pdf-preview/filepond-plugin-pdf-preview.min.js"></script>
    <script
        src="{{ asset('assets') }}/js/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js">
    </script>
    <script
        src="{{ asset('assets') }}/js/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js">
    </script>
    <script src="{{ asset('assets') }}/js/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
    <script
        src="{{ asset('assets') }}/js/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js">
    </script>
@endsection

@section('page_js')
    <script>
        let faviconFileUrl;
        let logoFileUrl;

        async function getDataApps() {
            loadingPage(true);

            let getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/setting/find`, {
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

                let appData = getDataRest.data.data;
                document.getElementById('input_nama').value = appData.nama;
                document.getElementById('input_nama_instansi').value = appData.nama_instansi;
                document.getElementById('deskripsiAplikasi').value = appData.deskripsi;
                document.getElementById('input_email').value = appData.email;
                document.getElementById('input_wa').value = appData.whatsapp;
                document.getElementById('input_alamat').value = appData.alamat;

                faviconFileUrl = appData.logo_favicon;
                logoFileUrl = appData.logo_aplikasi;
                setTimeout(() => {
                    filePondCreate("#faviconFileUrl", appData.logo_favicon);
                }, 500);
                setTimeout(() => {
                    filePondCreate("#logoFileUrl", appData.logo_aplikasi);
                }, 500);

                let provinsiSelect = document.querySelector('#select_provinsi');
                let citySelect = document.querySelector('#select_kota');
                let provinsiId = '';

                // Inisialisasi Select2 untuk Provinsi
                if (provinsiSelect) {
                    provinsiSelect.innerHTML = `<option selected>${appData.provinsi}</option>`;
                    // await selectList('#select_provinsi', `{{ url('') }}/api/internal/admin-panel/provinsi/list`,
                    //     'Pilih Provinsi');

                    // $('#select_provinsi').on('change', async function() {
                    //     provinsiId = $(this).val();
                    //     await selectList('#select_kota',
                    //         '{{ url('') }}/api/internal/admin-panel/kota/list', 'Pilih Kota',
                    //         provinsiId);
                    //     // Menampilkan teks yang terpilih untuk provinsi
                    //     let selectedTextProvinsi = $('#select_provinsi').select2('data')[0]?.text;
                    //     $('#provinsiNama').text(selectedTextProvinsi); // Menampilkan provinsi yang terpilih
                    // });
                }

                // Inisialisasi Select2 untuk Kota
                if (citySelect) {
                    citySelect.innerHTML = `<option selected>${appData.kota}</option>`;
                    // Menampilkan teks yang terpilih untuk kota
                    // let selectedTextKota = $('#select_kota').select2('data')[0]?.text;
                    // $('#kotaNama').text(selectedTextKota); // Menampilkan kota yang terpilih
                }
            }
        }

        async function selectList(id, isUrl, placeholder, idProv = '') {
            let select2Options = {
                ajax: {
                    url: isUrl,
                    dataType: 'json',
                    delay: 500,
                    headers: {
                        Authorization: `Bearer ${Cookies.get('auth_token')}`
                    },
                    data: function(params) {
                        let query = {
                            keyword: params.term,
                            page: 1,
                            limit: 30,
                            ascending: 1,
                        };
                        if (idProv != '') {
                            query.province_id = idProv;
                        }
                        return query;
                    },
                    processResults: function(res) {
                        let data = res.data;
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                },
                allowClear: true,
                placeholder: placeholder
            };

            if ($(id).length > 0) {
                await $(id).select2(select2Options);
            }

            $(id).on('change', function() {
                let selectedText = $(this).select2('data')[0]?.text;
                let displayElementId = id === '#select_provinsi' ? '#provinsiNama' :
                    '#kotaNama';
                $(displayElementId).text(selectedText);
            });
        }

        async function updateDataApps() {
            loadingPage(true);

            // Memeriksa apakah Select2 sudah diinisialisasi sebelum mengakses datanya
            let provinsi = $('#select_provinsi').data('select2') ?
                $('#select_provinsi').select2('data')[0]?.text :
                document.getElementById('select_provinsi').value;

            let kota = $('#select_kota').data('select2') ?
                $('#select_kota').select2('data')[0]?.text :
                document.getElementById('select_kota').value;

            // Ambil data lainnya
            let namaAplikasi = document.getElementById('input_nama').value;
            let namaInstansi = document.getElementById('input_nama_instansi').value;
            let deskripsiAplikasi = document.getElementById('deskripsiAplikasi').value;
            let email = document.getElementById('input_email').value;
            let noWaHelpdesk = document.getElementById('input_wa').value;
            let alamat = document.getElementById('input_alamat').value;
            let faviconUrl = faviconFileUrl; // Misalnya Anda sudah mendefinisikan faviconFileUrl
            let logoUrl = logoFileUrl; // Begitu juga dengan logoFileUrl

            // Payload untuk dikirim ke API
            let payload = {
                nama_instansi: namaInstansi,
                nama: namaAplikasi,
                deskripsi: deskripsiAplikasi,
                email: email,
                whatsapp: noWaHelpdesk,
                alamat: alamat,
                provinsi: provinsi,
                kota: kota,
                logo_favicon: faviconUrl,
                logo_aplikasi: logoUrl
            };

            console.log("🚀 ~ updateDataApps ~ payload:", payload);

            // Kirim data ke API
            let getDataRest = await CallAPI('POST',
                    '{{ url('') }}/api/internal/admin-panel/setting/aplikasi', payload)
                .then((response) => response)
                .catch((error) => {
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('warning', 'Pemberitahuan', resp.data.message || "Terjadi kesalahan");
                    return resp;
                });

            if (getDataRest && getDataRest.status === 200) {
                loadingPage(false);
                notificationAlert('success', 'Pemberitahuan', 'Data berhasil diubah');
                window.location.reload();
            }
        }


        async function getDataOSS() {
            loadingPage(true);

            let getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/setting/find`, {
                        name: "oss"
                    }
                )
                .then(response => response)
                .catch(error => {
                    loadingPage(false);
                    let resp = error.response;
                    return resp;
                });

            if (getDataRest.status === 200) {
                loadingPage(false);

                let appData = getDataRest.data.data;
                let active = appData.is_active;

                let akunOssCheckbox = document.getElementById('akunOssActive');
                let formAkunOss = document.getElementById('form-akun-oss');

                akunOssCheckbox.checked = active === 1;
                formAkunOss.style.display = active === 1 ? 'block' : 'none';

                document.getElementById('username').value = appData.username;
                document.getElementById('password').value = appData.password;
                document.getElementById('urlOss').value = appData.url;
            }
        }

        async function updateDataOSS(isActive = null) {
            loadingPage(true);

            let ossUsername = document.getElementById('username').value;
            let ossPassword = document.getElementById('password').value;
            let ossUrl = document.getElementById('urlOss').value;

            let akunOssCheckbox = document.getElementById('akunOssActive');

            let payload = {
                username: ossUsername,
                password: ossPassword,
                url: ossUrl,
                is_active: isActive !== null ? (isActive ? 1 : 0) : (akunOssCheckbox.checked ? 1 :
                    0),
            };

            let getDataRest = await CallAPI('POST',
                    '{{ url('') }}/api/internal/admin-panel/setting/oss', payload)
                .then((response) => response)
                .catch((error) => {
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('info', 'Pemberitahuan', 'Error')
                    return resp;
                });

            if (getDataRest && getDataRest.status === 200) {
                loadingPage(false);
                notificationAlert('success', 'Pemberitahuan', getDataRest.data.message || "Data berhasil diubah")
            } else {
                loadingPage(false);
                notificationAlert('warning', 'Pemberitahuan', getDataRest.data.message || "Error")
            }
        }

        async function filePondCreate(isSelector = "#faviconFileUrl", urlFile = "") {
            let serverOption = {
                process: async (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    let data = await uploadFileData(file);
                    if (data) {
                        data = JSON.parse(data);
                        if (isSelector == "#faviconFileUrl") {
                            faviconFileUrl = data.file_url;
                        } else if (isSelector == "#logoFileUrl") {
                            logoFileUrl = data.file_url;
                        }
                        load(data);
                    }
                },
                revert: (uniqueFileId, load, error) => {
                    $(`${isSelector}`).val('')
                    load();
                }
            };

            let options = {
                labelIdle: 'Seret & Jatuhkan file Anda atau <span class="filepond--label-action">Jelajahi File</span>',
                labelMaxFileSizeExceeded: 'File terlalu besar',
                labelMaxFileSize: 'Ukuran file maksimum adalah {filesize}',
                acceptedFileTypes: ['image/png'],
                allowMultiple: false,
                maxFileSize: '2MB',
                required: 0,
                checkValidity: true,
            };

            if (urlFile == "") {
                options["server"] = serverOption;
            } else {
                options["instantUpload"] = false;
            }

            let filepond = FilePond.create(document.querySelector(`${isSelector}`), options);

            let pondDom = document.querySelector(`${isSelector}`);

            if (urlFile != "") {
                pondDom.addEventListener('FilePond:init', (e) => {
                    filepond.addFile(urlFile);
                });
                pondDom.addEventListener('click', () => {
                    FilePond.destroy();
                    filePondCreate(isSelector, "");
                })
            }
        }

        async function uploadFileData(file) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            loadingPage(true);
            let auth_token = Cookies.get('auth_token') ?? null;
            let form = new FormData();
            form.append("file", file, file.name);

            let settings = {
                "url": "{{ url('api/internal/admin-panel/upload-file') }}",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "X-CSRF-TOKEN": csrfToken,
                    "Authorization": `Bearer ${auth_token}`,
                },
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form
            };

            let data = await $.ajax(settings);
            if (data) {
                loadingPage(false);
                return data;
            } else {
                return false;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let akunOssCheckbox = document.getElementById('shareActive');
            let formAkunOss = document.getElementById('form-berbagi-data');

            akunOssCheckbox.addEventListener('change', function() {
                if (akunOssCheckbox.checked) {
                    formAkunOss.style.display = 'block';
                } else {
                    formAkunOss.style.display = 'none';
                }
            });

            if (akunOssCheckbox.checked) {
                formAkunOss.style.display = 'block';
            }
        });


        async function initPageLoad() {
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginImagePreview,
                FilePondPluginPdfPreview,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType
            );
            filePondCreate("#faviconFileUrl");
            filePondCreate("#logoFileUrl");

            const akunOssCheckbox = document.getElementById('akunOssActive');
            const formAkunOss = document.getElementById('form-akun-oss');
            const simpanButton = document.createElement('button');

            // Tambahkan tombol simpan perubahan
            simpanButton.textContent = "Simpan Perubahan";
            simpanButton.className = "btn btn-sm btn-outline-primary p-2";
            simpanButton.style.borderRadius = "5px";
            simpanButton.addEventListener('click', () => updateDataOSS());
            formAkunOss.appendChild(simpanButton);

            akunOssCheckbox.addEventListener('change', async function() {
                let isActive = akunOssCheckbox.checked;

                if (isActive) {
                    formAkunOss.style.display = 'block';
                } else {
                    // Jika false, langsung update tanpa tombol
                    formAkunOss.style.display = 'none';
                    await updateDataOSS(isActive);
                }
            });

            async function syncCheckboxStatus() {
                let getDataRest = await getDataOSS();
                if (getDataRest.status === 200) {
                    let appData = getDataRest.data.data;
                    let isActive = appData.is_active === 1;


                    akunOssCheckbox.checked = isActive;
                    formAkunOss.style.display = isActive ? 'block' : 'none';
                }
            }

            await Promise.all([
                getDataApps(),
                getDataOSS()
            ]);
        }
        $('.filepond--credits').remove();
    </script>
@endsection
