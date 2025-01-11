@extends('...Internal.index', ['title' => 'Detail | Data Perusahaan'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/flatpickr.min.css" />
    <style>
        .table th.sticky-end,
        .table td.sticky-end {
            position: sticky;
            right: 0;
            background-color: #fff;
            z-index: 1;
            border-left: 1px solid #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/internal/dashboard-internal">Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">Perusahaan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Daftar Perusahaan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body" style="padding-bottom: 10px;" >
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Perusahaan Terverifikasi</p>
                            <h4 id="total_perusahaan_terverifikasi">30</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="my-n4" style="width: 90px;">
                                <div id="total-earning-graph-1"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1 fw-medium text-muted">Total Perusahaan</p>
                            <h4 class="mb-1" id="total_perusahaan">980+</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-primary rounded-circle">
                                <i class="ph-duotone ph-buildings"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1 fw-medium text-muted">Terdaftar Spionam</p>
                            <h4 class="mb-1" id="terdaftar_spionam">1,563</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-success rounded-circle">
                                <i class="fa-solid fa-building-circle-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1 fw-medium text-muted">Belum Terdaftar Spionam</p>
                            <h4 class="mb-1" id="belum_terdaftar_spionam">42.6%</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-l bg-light-danger rounded-circle">
                                <i class="fa-solid fa-building-circle-xmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class=" col-12 mb-lg-0 mb-4">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Total Tiap Tipe Layanan</h5>
                    </div>
                    <div class="my-2" id="line-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="" id="collapseFilter">
        <div class="card card-body mb-3">
            <h5 class="card-title mt-1 mb-2"><i class="fa-solid fa-filter fa-20"></i> Filter Download</h5>
            <form id="custom-filter">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="fw-normal" for="daterange">Rentang Tanggal <sup
                                        class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" id="pc-date_range_picker-2" class="form-control"
                                        placeholder="Pilih rentang tanggal" />
                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="fw-normal" for="input-layanan">Jenis Layanan</label>
                                <select class="form-control" name="input_layanan" id="input-layanan"></select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="fw-normal" for="input-provinsi">Provinsi</label>
                                <select class="form-control" name="input_provinsi" id="input-provinsi"></select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="fw-normal" for="input-status">Status Sertifikat</label>
                                <select class="form-control " name="input_status" id="input-status"></select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <div class="row mt-md-0">
                            <div class="col-6 mb-2">
                                <button type="submit" id="btn-find"
                                    class="btn btn-primary hovering w-100 align-items-center justify-content-center">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i>Cari
                                </button>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="button" id="resetCustomFilter"
                                    class="btn btn-light hovering w-100 align-items-center justify-content-center">
                                    <i class="fa-solid fa-eraser me-2"></i>Reset
                                </button>
                            </div>
                            <div class="col-12 mb-2 mt-4">
                                <div id="download-container">
                                    <div class="dropdown w-100">
                                        <button class="btn w-100 dropdown-toggle align-items-center justify-content-center"
                                            type="button" id="downloadDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="cursor: pointer; font-weight: bold; padding: 10px 20px; border-radius: 8px; transition: all 0.3s ease-in-out; background-color: #28a745; color: white; text-align: center;">
                                            <i class="fa-solid fa-download me-2"></i>Download</span>
                                        </button>

                                        <!-- Opsi download dalam dropdown -->
                                        <ul class="dropdown-menu w-100" aria-labelledby="downloadDropdown">
                                            <li>
                                                <a class="dropdown-item" id="download-excel" href="#">
                                                    <i class="fas fa-file-excel me-1"></i><span>Download Excel</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="download-csv" href="#">
                                                    <i class="fas fa-file-csv me-1"></i><span>Download CSV</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" id="download-pdf" href="#">
                                                    <i class="fas fa-file-pdf me-1"></i><span>Download PDF</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row ">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                            aria-labelledby="analytics-tab-1" tabindex="0">
                            <div class="table-responsive">
                                <div
                                    class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
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
                                            <input class="datatable-input search-input" placeholder="Cari..."
                                                type="search" name="search" title="Search within table"
                                                aria-controls="pc-dt-simple">
                                        </div>
                                    </div>
                                    <div class="datatable-container">
                                        <table class="table table-hover datatable-table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Perusahaan</th>
                                                    <th>Terdaftar Spionam</th>
                                                    <th>Tipe Layanan</th>
                                                    <th>Alamat Perusahaan</th>
                                                    <th>Tanggal Bergabung</th>
                                                    <th class="text-end sticky-end">Aksi</th>
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
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script src="{{ asset('assets') }}/js/plugins/flatpickr.min.js"></script>
    <script src="{{ asset('assets/js/paginationjs/pagination.min.js') }}"></script>
    <script src="{{ asset('assets') }}/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/choices.min.js"></script>

    <script>
        let menu = 'List Perusahaan';
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';
        let customFilter = {};
        let getDataTable = '';
        let errorMessage = "Terjadi Kesalahan.";

        async function setChartPerusahaanTerverisikasi(data) {
            const {
                total_perusahaan_terverifikasi
            } = data;
            var options20 = {
                series: [total_perusahaan_terverifikasi],
                chart: {
                    height: 120,
                    type: 'radialBar'
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 0,
                            size: '60%',
                            background: 'transparent',
                            imageOffsetX: 0,
                            imageOffsetY: 0,
                            position: 'front'
                        },
                        track: {
                            background: '#28A74550', // Warna latar belakang track tetap merah muda
                            strokeWidth: '50%'
                        },

                        dataLabels: {
                            show: true,
                            name: {
                                show: false
                            },
                            value: {
                                formatter: function(val) {
                                    return parseInt(val);
                                },
                                offsetY: 7,
                                color: '#006400', // Ubah warna teks menjadi hijau tua
                                fontSize: '20px',
                                fontWeight: '700',
                                show: true
                            }
                        }
                    }
                },
                colors: ['#006400'], // Ubah warna grafik menjadi hijau tua
                fill: {
                    type: 'solid'
                },
                stroke: {
                    lineCap: 'round'
                }
            };
            var chart = new ApexCharts(document.querySelector('#total-earning-graph-1'), options20);
            chart.render();
        }
        async function setChartTipeLayanan(data) {
            const {
                series,
                categories
            } = data;

            var optionsLineChart = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#fd7e14', '#ffc107', '#28a745', '#20c997',
                    '#17a2b8'
                ],
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                markers: {
                    size: 5,
                    colors: ['#fff'],
                    strokeColors: ['#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#fd7e14', '#ffc107', '#28a745',
                        '#20c997', '#17a2b8'
                    ],
                    strokeWidth: 2,
                },
                dataLabels: {
                    enabled: false
                },
                series: series, // Data series dari JSON
                xaxis: {
                    categories: categories, // Data kategori dari JSON
                    axisBorder: {
                        show: true
                    },
                    axisTicks: {
                        show: true
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center'
                },
                grid: {
                    strokeDashArray: 4
                }
            };

            // Render chart
            var chartLine = new ApexCharts(document.querySelector('#line-chart'), optionsLineChart);
            chartLine.render();
        }
        async function getChartTipeLayanan() {
            loadingPage(true);
            let getDataRest = await CallAPI(
                'GET',
                `{{ asset('dummy/company/chart_tipe_layanan.json') }}`
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status == 200) {
                loadingPage(false);
                
                await setChartTipeLayanan(getDataRest.data.data);
            }
        }
        async function getTotalData() {
            loadingPage(true);
            let getDataRest = await CallAPI(
                'GET',
                `{{ asset('dummy/company/total_data.json') }}`
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status == 200) {
                loadingPage(false);
                await setChartPerusahaanTerverisikasi(getDataRest.data.data);
                document.getElementById('total_perusahaan_terverifikasi').innerText = getDataRest.data.data.total_perusahaan_terverifikasi || '-';
                document.getElementById('belum_terdaftar_spionam').innerText = getDataRest.data.data.belum_terdaftar_spionam || '-';
                document.getElementById('terdaftar_spionam').innerText = getDataRest.data.data.terdaftar_spionam || '-';
            }
        }
        async function getListData(limit = 10, page = 1, ascending = 0, search = '', customFilter) {
            loadingPage(true);

            const queryParams = new URLSearchParams({
                page: currentPage,
                limit: defaultLimitPage,
                ascending: defaultAscending,
                search: defaultSearch,
                // ...filterParams,
            }).toString();

            let getDataRest = await CallAPI(
                'GET',
                `{{ asset('dummy/company/list_perusahaan.json') }}`
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status == 200) {
                loadingPage(false);
                let handleDataArray = await Promise.all(
                    getDataRest.data.data.map(async item => await handleData(item))
                );
                document.getElementById('total_perusahaan').innerText = getDataRest.data.paginate.total || '-';
                await setListData(handleDataArray, getDataRest.data.paginate, customFilter);
            } else {
                getDataTable = `
                <tr>
                    <th class="text-center" colspan="${$('th').length}"> ${errorMessage} </th>
                </tr>`;
                $('#listData tr').remove();
                $('#listData').append(getDataTable);
            }
        }

        async function handleData(data) {
            const isActive = (data['is_active'] === true) || (data['is_active'] === 1);
            const existSpionam = (data['exist_spionam'] === true) || (data['exist_spionam'] === 1);

            let statusMapping = {
                request: 'Pengajuan',
                disposition: 'Disposisi',
                not_passed_assessment: 'Tidak lulus penilaian',
                submission_revision: 'Perbaikan dokumen',
                passed_assessment: 'Lulus penilaian',
                not_passed_assessment_verification: 'Tidak lulus verifikasi penilaian',
                assessment_revision: 'Perbaikan penilaian',
                passed_assessment_verification: 'Lulus verifikasi penilaian',
                scheduling_interview: 'Penjadwalan wawancara',
                scheduled_interview: 'Wawancara terjadwal',
                completed_interview: 'Wawancara selesai',
                verification_director: 'Verifikasi direktur',
                certificate_validation: 'Pengesahan Sertifikat',
                rejected: 'Ditolak',
                cancelled: 'Dibatalkan',
                expired: 'Kedaluarsa',
                draft: 'Draft'
            };

            let statusColors = {
                default: "bg-light-primary",
                success: "bg-light-success",
                danger: "bg-light-danger"
            };

            function getStatusColor(statusKey) {
                switch (statusKey) {
                    case 'not_passed_assessment':
                    case 'not_passed_assessment_verification':
                    case 'rejected':
                    case 'cancelled':
                    case 'expired':
                        return statusColors.danger;
                    case 'passed_assessment':
                    case 'passed_assessment_verification':
                    case 'certificate_validation':
                        return statusColors.success;
                    default:
                        return statusColors.default;
                }
            }

            let handleData = {
                id: data.id ?? '-',
                name: data['name'] ?? '-',
                nib: data['nib'] ?? '-',
                service_types: (data['service_types']?.map(service => service['name']).join(', ')) ?? '-',

                certificate_request_status: {
                    text: statusMapping[data['certificate_status']] ?? 'Belum ada pengajuan',
                    background: getStatusColor(data['certificate_status'] ?? '')
                },

                province_name: (data['province'] && data['province']['name']) ? data['province']['name'] : '-',
                city_name: (data['city'] && data['city']['name']) ? data['city']['name'] : '-',
                address: data['address'] ?? '-',

                exist_spionam: {
                    init: data['exist_spionam'] ?? '-',
                    background: data['exist_spionam'] ? "bg-success text-white" : "bg-danger text-white",
                    text_status: data['exist_spionam'] ? "Terdaftar" : "Belum Terdaftar",
                    icon_status: data['exist_spionam'] ? "fa fa-circle-check" : "fa fa-circle-xmark",
                },

                created_at: dateLanguageFormat(data['created_at']) ?? '-',

                is_active: {
                    init: data['is_active'] ?? '-',
                    background: data['is_active'] ? "bg-success text-white" : "bg-danger text-white",
                    text_status: data['is_active'] ? "Aktif" : "Tidak Aktif",
                    icon_status: data['is_active'] ? "fa fa-circle-check" : "fa fa-circle-xmark",
                },
            };
            console.log("🚀 ~ handleData ~ handleData.certificate_request_status.background:", handleData
                .certificate_request_status.background)
            console.log("🚀 ~ handleData ~ handleData.certificate_request_status.text:", handleData
                .certificate_request_status.text)


            return handleData;
        }

        async function setListData(dataList, pagination) {
            totalPage = pagination.total;
            let display_from = ((defaultLimitPage * pagination.current_page) + 1) - defaultLimitPage;
            let index_loop = display_from;
            let display_to = currentPage < pagination.total_pages ? dataList.length < defaultLimitPage ?
                dataList.length : (defaultLimitPage * pagination.current_page) : totalPage;

            let getDataTable = '';
            for (let index = 0; index < dataList.length; index++) {
                let element = dataList[index];
                const elementData = JSON.stringify(element);
                const spionamStatus = element.exist_spionam.text_status;
                const badgeClass = spionamStatus === 'Belum Terdaftar' ? 'bg-danger' :
                    'bg-success';
                const isActive = element.is_active === true;

                const actionButton = isActive ?
                    `<a class="avtar avtar-s btn-link-success" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Terverifikasi" data-id="${element.id}" data-status="terverifikasi">
                            <i class="fa-solid fa-square-check fa-lg"></i>
                        </a>` :
                    `<a class="avtar avtar-s btn-link-danger change-status" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Belum Terverifikasi" data-id="${element.id}" data-status="belum-terverifikasi">
                            <i class="fa-solid fa-square-xmark fa-lg"></i>
                        </a>`;


                getDataTable += `
                <tr class="nk-tb-item">
                    <td>${index_loop}.</td>
                    <td>
                        <div class="row align-items-center">
                            <div class="col-auto pe-0">
                                <div
                                    class="wid-40 hei-40 rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-building text-white"></i>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1"><span class="text-truncate w-100">${element.name}</span> </h6>
                                <p class="f-12 mb-0">
                                    <a href="#!" class="text-muted"><span
                                            class="text-truncate w-200">${element.nib}</span></a>
                                    | <a href="#!" class="text-muted">
                                        <span class="badge ${element.certificate_request_status.background}">${element.certificate_request_status.text}</span></a>
                                    
                                </p>
                            </div>
                        </div>
                    </td>
                    <td><a href="#!" class="text-muted"><span
                                            class="badge ${badgeClass}">${spionamStatus}</span></a></td>
                    <td>
                        <ul style="padding-left: 20px; margin: 0;">
                            ${Array.isArray(element.service_types)
                                ? element.service_types.map(type => `<li>${type}</li>`).join('')
                                : element.service_types
                                    ? element.service_types.split(',').map(type => `<li>${type.trim()}</li>`).join('')
                                    : '<li>Tidak ada layanan</li>'
                            }
                        </ul>
                    </td>

                    <td>
                        <div class="row align-items-center">
                            
                            <div class="col">
                                <h6 class="mb-1"><span class="text-truncate w-100">${element.province_name},
                                    ${element.city_name}i</span></h6>
                                <p class="f-12 mb-0 " style="word-wrap: break-word; white-space: normal; max-width: 300px;">${element.address}</p>
                            </div>
                        </div>
                    </td>
                    <td>${element.created_at ? new Date(element.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) : '-'}</td>
                    <td class="text-end sticky-end">
                        <li class="list-inline-item">
                            ${actionButton}
                        </li>
                        <li class="list-inline-item">
                            ${getDetailPage(element.id)}
                        </li>
                    </td>
                </tr>`;
                index_loop++;
            }
            $('#listData tr').remove();

            if (totalPage == 0) {
                getDataTable = `
                <tr class="nk-tb-item">
                    <th class="text-center" colspan="${$('th').length}"> Tidak ada data. </th>
                </tr>`;
                $('#countPage').text("0 - 0");
            }
            $('#listData').append(getDataTable);
            $('#totalPage').text(totalPage);
            $('#countPage').text(`${display_from} - ${display_to}`);
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        async function setStatus() {
            $(document).on("click", ".change-status", async function() {
                let id = $(this).attr("data-id");
                let status = $(this).attr("data-status");
                await setStatusAction(id, status);
            });
        }

        async function setStatusAction(id, status) {
            Swal.fire({
                icon: "info",
                title: "Verifikasi Perusahaan",
                text: "Apakah anda yakin ingin memverifikasi?",
                showCancelButton: true,
                confirmButtonText: "Ya, Verifikasi Perusahaan!",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(async (result) => {
                loadingPage(true)
                let postDataRest = console.log(id);
                loadingPage(false);
                if (result.isConfirmed == true) {
                    setTimeout(async () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pemberitahuan',
                            text: 'Perusahaan telah terverifikasi!',
                            confirmButtonText: 'OK'
                        }).then(async () => {
                            await initDataOnTable(defaultLimitPage,
                                currentPage,
                                defaultAscending, defaultSearch);
                        });
                    }, 100);
                }
            }).catch(swal.noop);
        }

        async function selectFilter(id, route, placeholder) {
            var multipleFetch = new Choices(id, {
                placeholder: placeholder,
                placeholderValue: placeholder,
                maxItemCount: 5
            }).setChoices(function() {
                return fetch(
                        route
                    )
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        return data.data.map(function(item) {
                            return {
                                value: item.id,
                                label: item.name
                            };
                        });
                    });
            });
        }

        async function selectFilterStatus(id, placeholder) {
            // Data didefinisikan langsung di dalam fungsi
            const data = {
                request: 'Pengajuan',
                disposition: 'Disposisi',
                not_passed_assessment: 'Tidak lulus penilaian',
                submission_revision: 'Perbaikan dokumen',
                passed_assessment: 'Lulus penilaian',
                not_passed_assessment_verification: 'Tidak lulus verifikasi penilaian',
                assessment_revision: 'Perbaikan penilaian',
                passed_assessment_verification: 'Lulus verifikasi penilaian',
                scheduling_interview: 'Penjadwalan wawancara',
                scheduled_interview: 'Wawancara terjadwal',
                completed_interview: 'Wawancara selesai',
                verification_director: 'Verifikasi direktur',
                certificate_validation: 'Pengesahan Sertifikat',
                rejected: 'Ditolak',
                cancelled: 'Dibatalkan',
                expired: 'Kedaluarsa',
                draft: 'Draft'
            };

            var multipleFetch = new Choices(id, {
                placeholder: placeholder,
                placeholderValue: placeholder,
                maxItemCount: 5
            }).setChoices(function() {
                // Mengonversi objek menjadi array untuk diolah oleh Choices.js
                const choicesArray = Object.entries(data).map(([key, value]) => ({
                    value: key,
                    label: value
                }));

                return Promise.resolve(choicesArray);
            });
        }


        async function customFilterTable() {

            document.getElementById('custom-filter').addEventListener('submit', async function(e) {
                e.preventDefault();

                let sourceType = document.getElementById('input-layanan').value;
                let status = document.getElementById('input-status').value;
                let province = document.getElementById('input-provinsi').value;

                customFilter = {
                    'service_type': sourceType,
                    'status': status,
                    'province': province,
                    'start_date': $("#daterange").val() != '' ? startDate : '',
                    'end_date': $("#daterange").val() != '' ? endDate : ''
                };

                if (dayDif > 31) {
                    notificationAlert('info', 'pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari'
                    );
                    return;
                }

                currentPage = 1;

                await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
            });

            document.getElementById('download-excel').addEventListener('click', async function() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                startDate = startDate.startOf('day').toISOString();
                endDate = endDate.endOf('day').toISOString();

                let sourceType = document.getElementById('input-layanan').value;
                let status = document.getElementById('input-status').value;
                let province = document.getElementById('input-provinsi').value;

                let startDateObj = new Date(startDate);
                let endDateObj = new Date(endDate);
                let timeDiff = endDateObj - startDateObj;
                let dayDiff = timeDiff / (1000 * 3600 * 24);

                customFilter = {
                    'service_type': sourceType,
                    'status': status,
                    'province': province,
                    'start_date': $("#daterange").val() != '' ? startDate : '',
                    'end_date': $("#daterange").val() != '' ? endDate : ''
                };

                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                let data = await getFilterDownload(customFilter, startDate, endDate, 'excel');
            });

            document.getElementById('download-csv').addEventListener('click', async function() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                startDate = startDate.startOf('day').toISOString();
                endDate = endDate.endOf('day').toISOString();

                let sourceType = document.getElementById('input-layanan').value;
                let status = document.getElementById('input-status').value;
                let province = document.getElementById('input-provinsi').value;

                let startDateObj = new Date(startDate);
                let endDateObj = new Date(endDate);
                let timeDiff = endDateObj - startDateObj;
                let dayDiff = timeDiff / (1000 * 3600 * 24);

                customFilter = {
                    'service_type': sourceType,
                    'status': status,
                    'province': province,
                    'start_date': $("#daterange").val() != '' ? startDate : '',
                    'end_date': $("#daterange").val() != '' ? endDate : ''
                };

                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                let data = await getFilterDownload(customFilter, startDate, endDate, 'csv');
            });

            document.getElementById('download-pdf').addEventListener('click', async function() {
                let startDate = dateRangePicker.data('daterangepicker').startDate;
                let endDate = dateRangePicker.data('daterangepicker').endDate;

                startDate = startDate.startOf('day').toISOString();
                endDate = endDate.endOf('day').toISOString();

                let sourceType = document.getElementById('input-layanan').value;
                let status = document.getElementById('input-status').value;
                let province = document.getElementById('input-provinsi').value;

                let startDateObj = new Date(startDate);
                let endDateObj = new Date(endDate);
                let timeDiff = endDateObj - startDateObj;
                let dayDiff = timeDiff / (1000 * 3600 * 24);

                customFilter = {
                    'service_type': sourceType,
                    'status': status,
                    'province': province,
                    'start_date': $("#daterange").val() != '' ? startDate : '',
                    'end_date': $("#daterange").val() != '' ? endDate : ''
                };

                if (dayDiff > 31) {
                    notificationAlert('info', 'Pemberitahuan',
                        'Rentang tanggal tidak boleh lebih dari 31 hari');
                    return;
                }

                if (!customFilter['start_date'] || !customFilter['end_date']) {
                    notificationAlert('info', 'Pemberitahuan', 'Download Membutuhkan Rentang Tanggal!');
                    return;
                }

                let data = await getFilterDownload(customFilter, startDate, endDate, 'pdf');
            });

            document.getElementById('resetCustomFilter').addEventListener('click', async function() {
                $('.select2').val('').trigger('change');
                $('#daterange').val('');
                $('.search-input').val('');

                customFilter = {};
                defaultSearch = '';
                defaultLimitPage = 10;
                currentPage = 1;

                await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
            });
        }

        async function getFilterDownload(filter = {}, startDate, endDate, format) {
            loadingPage(true);
            let params = {
                limit: defaultLimitPage,
                service_type: filter['service_type'] || '',
                status: filter['status'] || '',
                province: filter['province'] || ''
            };

            if (filter['start_date']) params['fromdate'] = filter['start_date'];
            if (filter['end_date']) params['duedate'] = filter['end_date'];

            let getDataRest = await CallAPI('GET',
                    `{{ env('ESMK_SERVICE_BASE_URL') }}/internal/admin-panel/perusahaan/list`, params)
                .then(function(response) {
                    return response;
                })
                .catch(function(error) {
                    loadingPage(false);
                    let resp = error.response;
                    notificationAlert('warning', 'Error', 'Tidak dapat memuat data');
                    return resp;
                });

            if (getDataRest.status == 200) {
                loadingPage(false);
                let data = getDataRest.data.data;

                if (data && data.length > 0) {
                    let handleDataArray = await Promise.all(
                        getDataRest.data.data.map(async item => await handleData(item))
                    );
                    if (format === 'excel') {
                        await downloadToExcel(handleDataArray, startDate, endDate);
                    }
                    if (format === 'csv') {
                        await downloadToCSV(handleDataArray, startDate, endDate);
                    }
                    if (format === 'pdf') {
                        await downloadToPDF(handleDataArray, startDate, endDate);
                    }
                    notificationAlert('success', 'Berhasil', 'Silahkan periksa file anda');
                } else {
                    notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
                }
            } else {
                notificationAlert('info', 'Pemberitahuan', 'Data tidak ada');
            }
        }

        function dateLanguageFormat(date) {
            if (date.includes('/') && /^\d{2}\/\d{2}\/\d{4}$/.test(date)) {
                const [day, month, year] = date.split('/');

                date = `${year}-${month}-${day}`;
            }

            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };

            return new Date(date).toLocaleDateString('id-ID', options);
        }

        async function downloadToExcel(data, fromDate, toDate) {
            let selectedData = data.map((item, index) => ({
                No: index + 1,
                Header1: item.name || '-',
                Header2: item.nib || '-',
                Header3: item.service_types || '-',
                Header4: item.certificate_request_status || '-',
                Header5: item.province_name || '-',
                Header6: item.city_name || '-',
                Header7: item.address || '-',
                Header8: item.exist_spionam.text_status || '-',
                Header9: item.created_at || '-',
            }));

            let header = [
                'No.',
                'Nama Perusahaan',
                'NIB',
                'Jenis Layanan',
                'Status Sertifikat',
                'Provinsi',
                'Kota',
                'Alamat',
                'Terdaftar Spionam',
                'Tanggal Bergabung',
            ];

            let formattedFromDate = await dateLanguageFormat(fromDate);
            let formattedToDate = await dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            let fileName;
            if (sameDate) {
                title = `Perusahaan e-SMK TANGGAL ${formattedFromDate}`.toUpperCase();
                fileName = `Perusahaan e-SMK (${formattedFromDate}).xlsx`;
            } else {
                title = `Perusahaan e-SMK DARI TANGGAL ${formattedFromDate} - ${formattedToDate}`
                    .toUpperCase();
                fileName = `Perusahaan e-SMK (${formattedFromDate} - ${formattedToDate}).xlsx`;
            }

            try {
                let workbook = await XlsxPopulate.fromBlankAsync();
                let sheet = workbook.sheet(0);
                sheet.name("Data");

                let lastColumn = String.fromCharCode(64 + header.length);
                let titleRange = `A1:${lastColumn}1`;
                sheet.range(titleRange).merged(true).value(title).style({
                    horizontalAlignment: "center",
                    bold: true,
                    fontSize: 12
                });

                header.forEach((title, index) => {
                    let cell = sheet.cell(3, index + 1);
                    cell.value(title);
                    cell.style({
                        bold: true,
                        fill: "CCCCCC",
                        border: true,
                        horizontalAlignment: "center"
                    });
                });

                selectedData.forEach((row, rowIndex) => {
                    Object.values(row).forEach((value, colIndex) => {
                        let cell = sheet.cell(rowIndex + 4, colIndex + 1);
                        cell.value(value);
                        cell.style({
                            border: true
                        });
                    });
                });

                header.forEach((title, index) => {
                    sheet.column(index + 1).width(Math.max(...[title, ...selectedData.map(row => row[Object
                        .keys(row)[index]])].map(text => text.toString().length)) * 1.2);
                });

                let blob = await workbook.outputAsync();
                saveAs(blob, fileName);
            } catch (error) {
                notificationAlert('warning', 'Error',
                    'Periksa Jaringan Anda.');
                return
            }
        }

        async function downloadToPDF(data, fromDate, toDate) {
            const {
                jsPDF
            } = window.jspdf;

            let selectedData = data.map((item, index) => ({
                No: index + 1,
                Header1: item.name || '-',
                Header2: item.nib || '-',
                Header3: item.service_types || '-',
                Header4: item.certificate_request_status || '-',
                Header5: item.province_name || '-',
                Header6: item.city_name || '-',
                Header7: item.address || '-',
                Header8: item.exist_spionam.text_status || '-',
                Header9: item.created_at || '-',
            }));

            let header = [
                'No.',
                'Nama Perusahaan',
                'NIB',
                'Jenis Layanan',
                'Status Sertifikat',
                'Provinsi',
                'Kota',
                'Alamat',
                'Terdaftar Spionam',
                'Tanggal Bergabung',
            ];

            let formattedFromDate = await dateLanguageFormat(fromDate);
            let formattedToDate = await dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            if (sameDate) {
                title = `Perusahaan e-SMK TANGGAL ${formattedFromDate}`.toUpperCase();
            } else {
                title = `Perusahaan e-SMK DARI TANGGAL ${formattedFromDate} - ${formattedToDate}`.toUpperCase();
            }

            let doc = new jsPDF({
                orientation: 'landscape',
                unit: 'pt',
                format: 'a4'
            });

            doc.setFontSize(12);
            doc.text(title, doc.internal.pageSize.getWidth() / 2, 30, {
                align: 'center'
            });

            doc.autoTable({
                head: [header],
                body: selectedData.map(Object.values),
                startY: 50,
                styles: {
                    fontSize: 9,
                    cellPadding: 4
                },
                headStyles: {
                    fillColor: [204, 204, 204],
                    textColor: 0,
                    halign: 'center'
                },
                bodyStyles: {
                    valign: 'middle'
                },
                columnStyles: {
                    0: {
                        halign: 'center',
                        cellWidth: 30
                    }
                }
            });

            doc.save(`Perusahaan e-SMK (${formattedFromDate} - ${formattedToDate}).pdf`);
        }

        async function downloadToCSV(data, fromDate, toDate) {
            let formattedFromDate = dateLanguageFormat(fromDate);
            let formattedToDate = dateLanguageFormat(toDate);
            let sameDate = moment(fromDate).isSame(moment(toDate), 'day');

            let title;
            if (sameDate) {
                title = `Perusahaan e-SMK TANGGAL ${formattedFromDate}`.toUpperCase();
            } else {
                title = `Perusahaan e-SMK DARI TANGGAL ${formattedFromDate} - ${formattedToDate}`.toUpperCase();
            }

            // Prepare the headers
            let headers = [
                'No.',
                'Nama Perusahaan',
                'NIB',
                'Jenis Layanan',
                'Status Sertifikat',
                'Provinsi',
                'Kota',
                'Alamat',
                'Terdaftar Spionam',
                'Tanggal Bergabung'
            ];

            // Convert the data to CSV format
            let csvContent = headers.join(',') + '\n'; // Add headers

            data.forEach((item, index) => {
                let row = [
                    index + 1,
                    item.name || '-',
                    item.nib || '-',
                    item.service_types || '-',
                    item.certificate_request_status || '-',
                    item.province_name || '-',
                    item.city_name || '-',
                    item.address || '-',
                    item.exist_spionam?.text_status || '-',
                    item.created_at || '-'
                ];
                csvContent += row.join(',') + '\n';
            });

            let blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            let link = document.createElement('a');
            let fileName = `Perusahaan e-SMK (${formattedFromDate} - ${formattedToDate}).csv`;

            if (navigator.msSaveBlob) { // For IE 10+
                navigator.msSaveBlob(blob, fileName);
            } else {
                let url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', fileName);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        function getDetailPage(elementID) {
            return `
            <a href="/internal/perusahaan-internal/detail" data-id="${elementID}"
                class="avtar avtar-s btn-link-info btn-pc-default detail-data"
                data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Detail Data">
                <i class="fa fa-eye me-1"></i>
            </a>`;
        }

        async function performSearch() {
            defaultSearch = $('.search-input').val();
            defaultLimitPage = $("#limitPage").val();
            currentPage = 1;
            await initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
        }

        async function initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter) {
            await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
            await paginationDataOnTable(defaultLimitPage);
        }

        async function manipulationDataOnTable() {
            $(document).on("change", "#limitPage", async function() {
                defaultLimitPage = $(this).val();
                currentPage = 1;
                await getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch,
                    customFilter);
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
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                },
                afterPageOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
                },
                afterNextOnClick: function(e) {
                    currentPage = parseInt(e.currentTarget.dataset.num);
                    getListData(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter);
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

        async function initPageLoad() {
            flatpickr(document.querySelector('#pc-date_range_picker-2'), {
                mode: 'range'
            });
            $(document).on("click", ".collapse-filter", function() {
                let $searchInput = $('.search-input');
                $("#collapseFilter").toggle(500); // Animasi toggle

                if ($searchInput.is(':disabled')) {
                    $searchInput.removeAttr('disabled'); // Aktifkan input jika disabled
                } else {
                    $searchInput.attr('disabled', true); // Disable input jika aktif
                }
                $searchInput.val(''); // Reset nilai input
            });

            await Promise.all([
                initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch, customFilter),
                manipulationDataOnTable(),
                getTotalData(),
                customFilterTable(),
                setStatus(),
                getChartTipeLayanan(),
                selectFilter('#input-layanan',
                    '{{ asset('dummy/company/select_jenis_layanan.json') }}',
                    'Pilih jenis layanan'),
                selectFilter('#input-provinsi',
                    '{{ asset('dummy/company/select_provinsi.json') }}',
                    'Pilih provinsi'),
                selectFilterStatus('#input-status', 'Pilih status sertifikat'),
            ])
        }
    </script>
@endsection
