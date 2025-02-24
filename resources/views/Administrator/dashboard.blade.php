@extends('Administrator.index', ['title' => 'Dashboard'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/datepicker-bs5.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/daterange.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/daterange-picker.css" />
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
        }

        #proses-sertifikasi {
            width: 100%;
            height: 250px;
            /* Tinggi tetap, sesuaikan sesuai kebutuhan */
            position: relative;
        }

        #proses-sertifikasi img {
            width: 100%;
            /* Memastikan gambar mengambil 100% lebar kontainer */
            height: 80%;
            /* Memastikan gambar mengambil 100% tinggi kontainer */
            object-fit: cover;
            /* Menjaga gambar agar tidak terdistorsi dan memotong jika perlu */
            object-position: center;
            /* Posisi gambar di tengah jika ada pemotongan */
        }


        @media (max-width: 768px) {
            .chart-container {
                height: 200px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card welcome-banner bg-blue-800" style="background: #0f2a7d;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="p-4">
                                <h2 class="text-white internal-name"></h2>
                                <p class="text-white" id="deskripsi_aplikasi">Sistem yang dirancang untuk mendukung perusahaan angkutan umum dalam menerapkan dan memantau standar keselamatan operasional. Sistem ini memantau kinerja keselamatan secara berkelanjutan.
                            </div>
                        </div>
                        <div class="col-sm-6 text-center img-logo-app mt-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-1" id="custom-filter">
            <div class="card">
                <div class="row align-items-center py-4 px-2">
                    <div class="col-md-5 offset-md-7 d-flex justify-content-start">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="feather icon-calendar"></i>
                            </span>

                            <input type="text" id="daterange" class="form-control" placeholder="Pilih rentang tanggal" />

                            <button type="submit" id="btn-find" class="btn btn-outline-primary p-3"
                                style="border: 1px solid #ced4da;">
                                <i class="fa-solid fa-magnifying-glass me-2"></i> Cari
                            </button>
                            <button type="submit" id="resetCustomFilter" class="btn btn-outline-secondary p-3"
                                style="border: 1px solid #ced4da;">
                                <i class="fa-solid fa-arrows-rotate me-2"></i>Set Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1" id="totalperusahaan"></h3>
                            <p class="text-muted mb-0">Total Perusahaan</p>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fa-regular fa-building fa-lg text-primary f-36"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1" id="totaltidakterverifikasi"></h3>
                            <p class="text-muted mb-0">Tidak Tersertifikasi</p>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fa-regular fa-rectangle-xmark fa-lg text-danger f-36"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1" id="totalprosessertivikasi"></h3>
                            <p class="text-muted mb-0">Proses Sertifikasi</p>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fa-solid fa-chalkboard-teacher fa-lg text-warning f-36"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-1" id="totaltersertifikasi"></h3>
                            <p class="text-muted mb-0">Tersertifikasi</p>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fa-regular fa-square-check fa-lg text-success f-36"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-5">Proses Sertifikasi <p class="fw-normal rentangTanggal"></p>
                        </h5>
                    </div>

                    <div class="row g-3 mx-3">
                        <div id="proses" class="col-lg-4 col-12  d-flex align-items-center justify-content-center">
                            <div id="proses-sertifikasi" style="width: 100%; height: 350px;"></div>
                        </div>
                        <div class="col-lg-8 col-12 mb-4 " id="proses-ket">
                            <div class="row g-3 mt-3">
                                <!-- Kolom pertama: Pengajuan -->
                                <div class="col-sm-4 d-flex">
                                    <div class="bg-body p-3 rounded text-center w-100" style="border: 1px solid #4680FF;">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <span class="d-block bg-primary rounded-circle"
                                                style="width: 10px; height: 10px; background:#4680FF;"></span>
                                        </div>
                                        <p class="mb-1">Pengajuan</p>
                                        <h6 class="mb-0" id="pengajuan"></h6>
                                    </div>
                                </div>

                                <!-- Kolom kedua: Proses Pengajuan -->
                                <div class="col-sm-4 d-flex">
                                    <div class="bg-body p-3 rounded text-center w-100" style="border: 1px solid #E58A00;">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <span class="d-block rounded-circle"
                                                style="width: 10px; height: 10px; background:#E58A00;"></span>
                                        </div>
                                        <p class="mb-1">Proses Pengajuan</p>
                                        <h6 class="mb-0" id="prosesPengajuan"></h6>
                                    </div>
                                </div>

                                <!-- Kolom ketiga: Pengesahan Sertifikat -->
                                <div class="col-sm-4 d-flex">
                                    <div class="bg-body p-3 rounded text-center w-100" style="border: 1px solid #2CA87F;">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <span class="d-block rounded-circle"
                                                style="width: 10px; height: 10px; background:#2CA87F;"></span>
                                        </div>
                                        <p class="mb-1">Pengesahan Sertifikat</p>
                                        <h6 class="mb-0" id="pengesahanSertifikat"></h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <!-- Kolom keempat: Ditolak -->
                                <div class="col-sm-4 d-flex">
                                    <div class="bg-body p-3 rounded text-center w-100" style="border: 1px solid #DC2626;">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <span class="d-block rounded-circle"
                                                style="width: 10px; height: 10px;background:#DC2626"></span>
                                        </div>
                                        <p class="mb-1">Ditolak</p>
                                        <h6 class="mb-0" id="ditolak"></h6>
                                    </div>
                                </div>

                                <!-- Kolom kelima: Kedaluwarsa -->
                                <div class="col-sm-4 d-flex mt-3 mt-md-0">
                                    <div class="bg-body p-3 rounded text-center w-100" style="border: 1px solid #6e0000;">
                                        <div class="d-flex align-items-center justify-content-center mb-2">
                                            <span class="d-block rounded-circle"
                                                style="width: 10px; height: 10px; background:#6e0000;"></span>
                                        </div>
                                        <p class="mb-1">Kedaluwarsa</p>
                                        <h6 class="mb-0" id="kedaluwarsa"></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0" id="titleTotalPenilaian">Total Penilaian <p class="fw-normal rentangTanggal">
                            </p>
                        </h5>
                    </div>
                    <div class="my-2" id="totalPenilaian" class="chart-container"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="flex-grow-1">
                            <h5 class="mb-0">Tipe Perusahaan <p class="fw-normal rentangTanggal"></p>
                            </h5>
                        </div>
                    </div>
                    <div class="my-2" id="bar-chart-3" class="chart-container"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12" id="widget-table-1">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Penilai Dengan Disposisi Terbanyak <p class="fw-normal rentangTanggal"></p>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <div class="datatable-dropdown">
                                    <label>
                                        <select class="datatable-selector" id="limitPage" name="per-page"
                                            style="width: auto;min-width: unset;">
                                            <option value="5">5</option>
                                            <option value="10" selected="">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="datatable-search">
                                    <input class="datatable-input search-input" placeholder="Cari..." type="search"
                                        name="search" title="Search within table" aria-controls="pc-dt-simple">
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table table-hover datatable-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Proses</th>
                                            <th>Selesai</th>
                                            <th>Total Disposisi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listData">
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                <div class="datatable-info">Menampilkan <span id="countPage">0</span>
                                    dari <span id="totalPage">0</span> data</div>
                                <nav class="datatable-pagination">
                                    <ul id="pagination-js" class="datatable-pagination-list">
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12" id="tahunan">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0">Informasi Belum Laporan Tahunan</h5>
                    </div>
                    <div class="table-responsive">
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                <div class="datatable-dropdown">
                                    <label>
                                        <select class="datatable-selector" id="limitPageReport" name="per-page"
                                            style="width: auto;min-width: unset;">
                                            <option value="5">5</option>
                                            <option value="10" selected="">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="datatable-search">
                                    <input class="datatable-input search-input-report" placeholder="Cari..."
                                        type="search" name="search" title="Search within table"
                                        aria-controls="pc-dt-simple">
                                </div>
                            </div>
                            <div class="datatable-container">
                                <table class="table table-hover datatable-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tahun</th>
                                            <th>Tanggal Berakhir</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listData2">
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                <div class="datatable-info">Menampilkan <span id="countPageReport">0</span>
                                    dari <span id="totalPageReport">0</span> data</div>
                                <nav class="datatable-pagination">
                                    <ul id="pagination-js-report" class="datatable-pagination-list">
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('assets/js/excel/xlsx-populate.min.js') }}"></script>
    <script src="{{ asset('assets/js/excel/file-saver.min.js') }}"></script>
    <script src="{{ asset('assets/js/date/date-language-format.js') }}"></script>
    <script src="{{ asset('assets/js/date/daterange-picker.js') }}"></script>
    <script src="{{ asset('assets/js/date/daterange-custom.js') }}"></script>
    <script src="{{ asset('assets/js/date/date-DMY-format.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/locale/id.js"></script>
@endsection
@section('page_js')
    <script>
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let defaultLimitPageReport = 10;
        let currentPageReport = 1;
        let totalPageReport = 1;
        let defaultAscendingReport = 0;
        let defaultSearchReport = '';
        let customFilter = {};
        let customFilterReport = {};
        let getDataRestDashboard;
        let isAdmin;
        let chart;
        let role = @json(request()->payload['internal_role']);

        async function getUserData() {
            loadingPage(true);
            let getDataRest = await CallAPI(
                'GET', `{{ url('') }}/api/internal/admin-panel/dashboard/userDetail`
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });
            if (getDataRest.status == 200) {
                loadingPage(false);
                let handleDataResult = await handleUserData(getDataRest.data.data);
                await setUserData(handleDataResult);
                const userRole = handleDataResult.role || [];
                isAdmin = userRole.includes('Super Admin');

                if ((role !== 'Admin') && (role !== 'Super Admin')) {
                    document.getElementById('widget-table-1').style.display = 'none';
                    const infoTableCol = document.getElementById('tahunan');
                    if (infoTableCol) {
                        infoTableCol.classList.remove('col-lg-6', 'col-12');
                        infoTableCol.classList.add('col-12');
                    }
                }
            }
        }

        function handleUserData(data) {
            const userData = data['user'];
            const isActive = (userData['is_active'] === true) || (userData['is_active'] === 1);
            let handleData = {
                id: userData['id'] ?? '-',
                name: userData['name'] ?? '-',
                role: userData['role'] ?? []
            };
            return handleData;
        }

        function setUserData(data) {
            $('.internal-name').html(`Selamat Datang, ${data.name}`);
        }

        async function getDataAllCompany(customFilter) {
            loadingPage(true);
            let defaultStartDate = moment().subtract(30, 'days').format('YYYY-MM-DD');
            let defaultEndDate = moment().format('YYYY-MM-DD');

            let startDate = customFilter?.start_date || defaultStartDate;
            let endDate = customFilter?.end_date || defaultEndDate;

            let requestData = {
                date_from: startDate,
                date_to: endDate
            };

            let getDataRest = await CallAPI(
                'GET',
                '{{ url('') }}/api/internal/admin-panel/dashboard/dataDashboard',
                requestData
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status == 200) {
                loadingPage(false);
                let companies = getDataRest.data.data.companies || [];
                let certificateRequests = getDataRest.data.data.certificate_requests || [];
                let totalCompany = companies.length;
                let formattedStartDate = new Date(startDate).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });
                let formattedEndDate = new Date(endDate).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                });

                // Gunakan querySelectorAll untuk memilih semua elemen dengan kelas 'rentangTanggal' dan iterasi
                document.querySelectorAll('.rentangTanggal').forEach((element) => {
                    element.innerText =
                        `${formattedStartDate} - ${formattedEndDate}`; // Gunakan backticks untuk string template
                });


                document.getElementById('totalperusahaan').innerText = totalCompany;

                let totalWithoutCertification = companies.filter(company =>
                    !certificateRequests.some(request => request.company_id === company.id)
                ).length;
                document.getElementById('totaltidakterverifikasi').innerText = totalWithoutCertification;

                let validStatuses = [
                    'request', 'disposition', 'not_passed_assessment',
                    'revision', 'submission_revision', 'passed_assessment',
                    'not_passed_assessment_verification', 'passed_assessment_verification',
                    'scheduling_interview', 'scheduled_interview', 'completed_interview'
                ];
                let totalProcess = certificateRequests.filter(request => validStatuses.includes(request.status)).length;
                document.getElementById('totalprosessertivikasi').innerText = totalProcess;

                let validStatusesverif = ['certificate_validation'];
                let totalverif = certificateRequests.filter(request => validStatusesverif.includes(request.status))
                    .length;
                document.getElementById('totaltersertifikasi').innerText = totalverif;

                let serviceTypes = getDataRest.data.data.service_types || [];

                setChart(serviceTypes);

                let certificateRequestschart = getDataRest.data.data.certificate_requests || [];

                if (!Array.isArray(certificateRequestschart) || certificateRequestschart.length === 0) {
                    const prosesElement = document.getElementById('proses');
                    const prosesSert = document.getElementById('proses-sertifikasi');
                    if (prosesElement) {
                        prosesElement.style.display = 'none';
                        prosesSert.style.display = 'none';
                    }

                    const infoTableCol = document.getElementById('proses-ket');
                    if (infoTableCol) {
                        infoTableCol.classList.remove('col-lg-8');
                        infoTableCol.classList.add('col-12');
                    }
                } else {
                    setChartcertificateRequest(certificateRequestschart);
                }
                let statusMapping = {
                    request: 'Pengajuan',
                    disposition: 'Proses Pengajuan',
                    not_passed_assessment: 'Proses Pengajuan',
                    submission_revision: 'Proses Pengajuan',
                    passed_assessment: 'Proses Pengajuan',
                    not_passed_assessment_verification: 'Proses Pengajuan',
                    assessment_revision: 'Proses Pengajuan',
                    passed_assessment_verification: 'Proses Pengajuan',
                    scheduling_interview: 'Proses Pengajuan',
                    scheduled_interview: 'Proses Pengajuan',
                    completed_interview: 'Proses Pengajuan',
                    verification_director: 'Proses Pengajuan',
                    certificate_validation: 'Pengesahan Sertifikat',
                    rejected: 'Ditolak',
                    // cancelled: 'Dibatalkan',
                    expired: 'Kedaluwarsa'
                };

                let statusCounts = {
                    'Pengajuan': 0,
                    'Proses Pengajuan': 0,
                    'Pengesahan Sertifikat': 0,
                    'Ditolak': 0,
                    'Kedaluwarsa': 0
                };

                certificateRequestschart.forEach(request => {
                    if (request && request.status && statusMapping[request.status]) {
                        let statusLabel = statusMapping[request.status];
                        if (statusLabel === 'Proses Pengajuan') {
                            statusCounts['Proses Pengajuan']++;
                        } else {
                            statusCounts[statusLabel]++;
                        }
                    }
                });

                document.getElementById('pengajuan').innerText = statusCounts['Pengajuan'] || 0;
                document.getElementById('prosesPengajuan').innerText = statusCounts['Proses Pengajuan'] || 0;
                document.getElementById('pengesahanSertifikat').innerText = statusCounts['Pengesahan Sertifikat'] || 0;
                document.getElementById('ditolak').innerText = statusCounts['Ditolak'] || 0;
                document.getElementById('kedaluwarsa').innerText = statusCounts['Kedaluwarsa'] || 0;
            }

        }

        async function setChart(serviceTypes) {
            // Pastikan data tidak kosong
            if (!serviceTypes || serviceTypes.length === 0) {
                document.getElementById('bar-chart-3').innerHTML = '<p>No data available for the selected range</p>';
                return; // Stop the function if no data
            }

            let labels = serviceTypes.map(item => item.name);
            let dataPoints = serviceTypes.map(item => item.companies.length);

            let minValue = Math.min(...dataPoints);
            let maxValue = Math.max(...dataPoints);

            var options_bar_chart_3 = {
                chart: {
                    height: 350,
                    width: '90%',
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: ['#4680FF'],
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                series: [{
                    name: 'Perusahaan',
                    data: dataPoints
                }],
                xaxis: {
                    categories: labels,
                    min: minValue,
                    max: maxValue
                }
            };

            // Hancurkan chart lama jika ada
            if (window.jenisLayanan) {
                window.jenisLayanan.destroy(); // Hancurkan chart lama
            }

            // Buat chart baru dengan data yang sudah diperbarui
            window.jenisLayanan = new ApexCharts(document.querySelector('#bar-chart-3'), options_bar_chart_3);
            window.jenisLayanan.render(); // Render chart dengan data yang baru
        }


        async function setChartcertificateRequest(certificateRequestschart) {
            if (!certificateRequestschart || !Array.isArray(certificateRequestschart)) {
                console.error('Error: certificateRequestschart is not an array.');
                return;
            }

            // Menentukan label untuk chart
            let labels = [
                'Pengajuan',
                'Proses Pengajuan',
                'Pengesahan Sertifikat',
                'Ditolak',
                'Kedaluwarsa'
            ];

            // Pemetaan status ke kategori
            let statusMapping = {
                request: 'Pengajuan',
                disposition: 'Proses Pengajuan',
                not_passed_assessment: 'Proses Pengajuan',
                submission_revision: 'Proses Pengajuan',
                passed_assessment: 'Proses Pengajuan',
                not_passed_assessment_verification: 'Proses Pengajuan',
                assessment_revision: 'Proses Pengajuan',
                passed_assessment_verification: 'Proses Pengajuan',
                scheduling_interview: 'Proses Pengajuan',
                scheduled_interview: 'Proses Pengajuan',
                completed_interview: 'Proses Pengajuan',
                verification_director: 'Proses Pengajuan',
                certificate_validation: 'Pengesahan Sertifikat',
                rejected: 'Ditolak',
                cancelled: 'Dibatalkan',
                expired: 'Kedaluwarsa'
            };

            let dataPoints = Array(labels.length).fill(0);

            certificateRequestschart.forEach(item => {
                if (item && item.status) {
                    let mappedLabel = statusMapping[item.status];
                    if (mappedLabel) {
                        let index = labels.indexOf(mappedLabel);
                        if (index !== -1) {
                            dataPoints[index]++;
                        }
                    } else {
                        console.warn(`Status "${item.status}" tidak ditemukan di statusMapping.`);
                    }
                } else {
                    console.warn('Warning: item does not have a valid status.', item);
                }
            });

            if (window.chart_pie_chart_2) {
                window.chart_pie_chart_2.destroy();
            }

            let colors = [
                '#4680FF', // Pengajuan
                '#E58A00', // Proses Pengajuan
                '#2CA87F', // Pengesahan Sertifikat
                '#DC2626', // Ditolak
                '#6e0000', // Kedaluwarsa
            ];

            var options_pie_chart_2 = {
                chart: {
                    height: 320,
                    type: 'donut',
                    toolbar: {
                        show: false
                    }
                },
                series: dataPoints,
                colors: colors,
                labels: labels,
                legend: {
                    show: false,
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: false
                                },
                                value: {
                                    show: true
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    dropShadow: {
                        enabled: false
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            // Membuat chart baru
            window.chart_pie_chart_2 = new ApexCharts(document.querySelector('#proses-sertifikasi'),
                options_pie_chart_2);
            window.chart_pie_chart_2.render();
        }


        async function getDataPenilaian(customFilter) {
            loadingPage(true);
            let defaultStartDate = moment().subtract(30, 'days').format('YYYY-MM-DD');
            let defaultEndDate = moment().format('YYYY-MM-DD');

            let startDate = customFilter?.start_date || defaultStartDate;
            let endDate = customFilter?.end_date || defaultEndDate;

            let requestData = {
                dateFrom: startDate,
                dateTo: endDate
            };

            let getDataRest = await CallAPI(
                'GET',
                '{{ url('') }}/api/internal/admin-panel/dashboard/totalPenilaian', requestData
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status == 200) {
                loadingPage(false);
                let totalPenilaian = getDataRest.data.data || [];
                setChartTotalPenilaian(totalPenilaian);
            }
        }


        async function setChartTotalPenilaian(totalPenilaian) {
            // Check if data is available
            // if (!totalPenilaian || totalPenilaian.length === 0) {
            //     document.getElementById('totalPenilaian').innerHTML = '<p>No data available for the selected range</p>';
            //     return;
            // }

            // Extract days and the values for each series
            const daysArray = totalPenilaian.map(item => moment(item.date).format(
                'DD MMM YY')); // Format date to "12 Des 25"
            const pengajuanAwalData = totalPenilaian.map(item => item.pengajuan_awal);
            const prosesPengajuanData = totalPenilaian.map(item => item.proses_pengajuan);
            const prosesSelesaiData = totalPenilaian.map(item => item.proses_selesai);

            // Chart options using the actual data
            var options = {
                series: [{
                    name: 'Pengajuan awal',
                    data: pengajuanAwalData // Data for 'Pengajuan awal'
                }, {
                    name: 'Proses Pengajuan',
                    data: prosesPengajuanData // Data for 'Proses Pengajuan'
                }, {
                    name: 'Proses Selesai',
                    data: prosesSelesaiData // Data for 'Proses Selesai'
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: false,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 5,
                        borderRadiusApplication: 'end'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: daysArray, // Use the formatted dates as categories
                    title: {
                        text: 'Tanggal'
                    }
                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Permohonan";
                        }
                    }
                },
                colors: ['#007bff', '#ffc107', '#28a745'], // Define chart colors
            };

            // Hancurkan chart lama sebelum merender chart baru
            if (chart) {
                chart.destroy(); // Hancurkan chart lama jika ada
            }

            // Render the chart
            chart = new ApexCharts(document.querySelector("#totalPenilaian"), options);
            chart.render();
        }


        async function fetchData(url, params) {
            try {
                loadingPage(true);
                let response = await CallAPI('GET', url, params);
                loadingPage(false);
                return response;
            } catch (error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            }
        }

        async function getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            let defaultStartDate = moment().subtract(30, 'days').format('YYYY-MM-DD');
            let defaultEndDate = moment().format('YYYY-MM-DD');
            let startDate = customFilter?.['start_date'] || defaultStartDate;
            let endDate = customFilter?.['end_date'] || defaultEndDate;
            let params = {
                page: currentPage,
                limit: defaultLimitPage,
                ascending: defaultAscending,
                search: defaultSearch,
                date_from: startDate,
                date_to: endDate
            };

            let getDataRest = await fetchData(
                '{{ url('') }}/api/internal/admin-panel/dashboard/listAsesor', params);

            if (getDataRest.status === 200) {
                let data = getDataRest.data.data;
                let totalPage = getDataRest.data.pagination.total_pages;
                let totalItems = getDataRest.data.pagination.total;

                if (totalItems === 0) {
                    $('#pagination-js').hide();
                } else {
                    $('#pagination-js').show();
                }

                let display_from = (data.length > 0) ? ((defaultLimitPage * (currentPage - 1)) + 1) : 0;
                let display_to = (data.length > 0) ?
                    Math.min(display_from + data.length - 1, totalItems) :
                    0;

                $('#totalPage').text(totalItems);
                $('#countPage').text(`${display_from} - ${display_to}`);

                let appendHtml = "";
                let index_loop = display_from;
                if (data.length > 0) {
                    for (let index = 0; index < data.length; index++) {
                        let element = data[index];
                        appendHtml += `
                            <tr>
                            <td>${index_loop}.</td>
                            <td>
                                <div class="row align-items-center">
                                    <div class="row">
                                        <h6 class="mb-2"><span class="text-truncate w-100">${element.name || '-'}</span>
                                        </h6>
                                        <p class="text-muted f-12 mb-0"><span class="text-truncate w-100">
                                            NIP: ${element.nip || '-'}</span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>${element.certificate_request_disposition_process_count || '0'}</td>
                            <td>${element.certificate_request_completed_count || '0'}</td>
                            <td>${element.certificate_request_disposisition_count || '0'}</td>
                        </tr>`;
                        index_loop++;
                    }
                } else {
                    appendHtml = `
                        <tr>
                            <th class="text-center" colspan="${$('.nk-tb-head th').length}"> Tidak ada data. </th>
                        </tr>`;
                }
                $('#listData').html(appendHtml);
            }
        }

        async function getListDataReport(defaultLimitPageReport, currentPageReport, defaultAscendingReport,
            defaultSearchReport) {
            let params = {
                page: currentPageReport,
                limit: defaultLimitPageReport,
                ascending: defaultAscendingReport,
                search: defaultSearchReport
            };

            let getDataRest = await fetchData(
                '{{ url('') }}/api/internal/admin-panel/dashboard/listYearly', params
            );

            if (getDataRest.status === 200) {
                let data = getDataRest.data.data;
                let totalItems = getDataRest.data.pagination.total;
                totalPagesReport = getDataRest.data.pagination.total_pages;

                if (totalItems === 0) {
                    $('#pagination-js-report').hide();
                } else {
                    $('#pagination-js-report').show();
                }

                let display_from = (data.length > 0) ? ((defaultLimitPageReport * (currentPageReport - 1)) + 1) : 0;
                let display_to = (data.length > 0) ?
                    Math.min(display_from + data.length - 1, totalItems) : 0;

                $('#totalPageReport').text(totalItems);
                $('#countPageReport').text(`${display_from} - ${display_to}`);

                let appendHtml = "";
                let index_loop = display_from;

                if (data.length > 0) {
                    for (let index = 0; index < data.length; index++) {
                        let element = data[index];
                        let companyName = element.company ? element.company.name : '-';
                        let nib = element.company ? element.company.nib : '-';

                        appendHtml += `
                            <tr>
                                <td>${index_loop}.</td>
                                <td>
                                    <div class="row align-items-center">
                                        <div class="row">
                                            <h6 class="mb-2"><span class="text-truncate w-100">${companyName}</span>
                                            </h6>
                                            <p class="text-muted f-12 mb-0"><span class="text-truncate w-100">
                                                    NIB: ${nib}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td>${element.year || 'N/A'}</td>
                                <td>${element.due_date || 'N/A'}</td>
                                <td>
                                    <a type="button" href="/admin/perusahaan/detail?id=${element.company.id}" class="avtar avtar-s btn-link-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>`;
                        index_loop++;
                    }
                } else {
                    appendHtml = `
                        <tr>
                            <th class="text-center" colspan="5"> Tidak ada data. </th>
                        </tr>`;
                    $('#countPageReport').text("0 - 0");
                }

                $('#listData2').html(appendHtml);
            }
        }

        async function performSearch() {
            defaultSearch = $('.search-input').val();
            defaultLimitPage = $("#limitPage").val();
            currentPage = 1;
            await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
        }

        async function initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
            await paginationDataOnTable(defaultLimitPage);
        }
        async function manipulationDataOnTable() {
            $(document).on("change", "#limitPage", async function() {
                defaultLimitPage = $(this).val();
                currentPage = 1;
                await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                await paginationDataOnTable(defaultLimitPage);
            });

            $(document).on("input", ".search-input", debounce(performSearch, 500));
            await paginationDataOnTable(defaultLimitPage);
        }

        function paginationDataOnTable(isPageSize) {
            $('#pagination-js').pagination({
                dataSource: Array.from({
                    length: totalPage
                }, (_, i) => i + 1),
                pageSize: isPageSize,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
                afterPageOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
                afterNextOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
            });
        }

        function debounce(func, wait, immediate) {
            let timeout;
            return function() {
                let context = this,
                    args = arguments;
                let later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                let callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        async function performSearchReport() {
            defaultSearchReport = $('.search-input-report').val();
            defaultLimitPageReport = $("#limitPageReport").val();
            currentPage = 1;
            await initDataOnTableReport(defaultLimitPageReport, currentPageReport, defaultAscendingReport,
                defaultSearchReport);
        }

        async function initDataOnTableReport(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            await getListDataReport(defaultLimitPageReport, currentPageReport, defaultAscendingReport,
                defaultSearchReport);
            await paginationDataOnTableReport(defaultLimitPageReport);
        }
        async function manipulationDataOnTableReport() {
            $(document).on("change", "#limitPageReport", async function() {
                defaultLimitPageReport = $(this).val();
                currentPageReport = 1;
                await getListDataReport(defaultLimitPageReport, currentPageReport, defaultAscendingReport,
                    defaultSearchReport);
                await paginationDataOnTableReport(defaultLimitPage);
            });

            $(document).on("input", ".search-input-report", debounceReport(performSearchReport, 500));
            await paginationDataOnTableReport(defaultLimitPageReport);
        }

        function paginationDataOnTableReport(isPageSize) {
            $('#pagination-js-report').pagination({
                dataSource: Array.from({
                    length: totalPageReport
                }, (_, i) => i + 1),
                pageSize: isPageSize,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListDataReport(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
                afterPageOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListDataReport(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
                afterNextOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListDataReport(defaultLimitPage, currentPage, defaultAscending, defaultSearch);
                },
            });
        }

        function debounceReport(func, wait, immediate) {
            let timeout;
            return function() {
                let context = this,
                    args = arguments;
                let later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                let callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        function initializeDateRangePicker() {
            let today = moment();
            let last30Days = moment().subtract(30, 'days');

            $('#daterange').daterangepicker({
                startDate: last30Days,
                endDate: today,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#daterange').val(last30Days.format('YYYY-MM-DD') + ' - ' + today.format('YYYY-MM-DD'));

            return $('#daterange');
        }

        async function customFilterTable() {
            let dateRangePicker = initializeDateRangePicker();

            document.getElementById('btn-find').addEventListener('click', async function(e) {
                e.preventDefault();

                let startDate = dateRangePicker.data('daterangepicker')?.startDate;
                let endDate = dateRangePicker.data('daterangepicker')?.endDate;

                startDate = moment(startDate).startOf('day').format('YYYY-MM-DD');
                endDate = moment(endDate).endOf('day').format('YYYY-MM-DD');

                customFilter = {
                    'start_date': startDate,
                    'end_date': endDate
                };

                currentPage = 1;

                await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
                await getDataAllCompany(customFilter);
                await getDataPenilaian(customFilter);
                await initDataOnTableReport(defaultLimitPageReport, currentPageReport,
                    defaultAscendingReport,
                    defaultSearchReport);
            });

            document.getElementById('resetCustomFilter').addEventListener('click', async function() {
                window.location.reload();
            });
        }


        async function initPageLoad() {
            await customFilterTable();
            await getUserData();
            await getDataAllCompany();
            await getDataPenilaian();

            await Promise.all([
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
                manipulationDataOnTable(),
                initDataOnTableReport(defaultLimitPageReport, currentPageReport, defaultAscendingReport,
                    defaultSearchReport),
                manipulationDataOnTableReport(),
            ]);
        }
    </script>
@endsection
