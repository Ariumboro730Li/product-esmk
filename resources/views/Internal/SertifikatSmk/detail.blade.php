@extends('Internal.index', ['title' => 'Detail | Data Perusahaan'])
@section('asset_css')
    <style>
        .table th.sticky-end,
        .table td.sticky-end {
            position: sticky;
            right: 0;
            background-color: #fff;
            /* Warna background agar cocok */
            z-index: 1;
            /* Prioritaskan di atas elemen lain */
            border-left: 1px solid #dee2e6;
            /* Tambahkan garis batas */
        }

        .accordion-button {
            color: white !important;
        }

        .accordion-button::after {
            filter: brightness(0) invert(1);
        }

        .accordion-button:not(.collapsed)::after {
            filter: brightness(0) invert(1);
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
                        <li class="breadcrumb-item"><a href="/internal/sertifikat/list">Sertifikat SMK</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail SMK</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Detail Permohonan Penilaian E-SMK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="col-sm-auto mb-3 mb-sm-0 me-3">
                                            <div class="d-sm-inline-block d-flex align-items-center" id="c_color">
                                                <div
                                                    class="wid-60 hei-60 rounded-circle bg-success d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-building text-white fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex flex-column flex-sm-row align-items-start">
                                                <h4 class="d-inline-block mb-0 me-2" id="c_name">PT TRISTAR JAVA
                                                    TRANSINDO |</h4>
                                                <p class="mb-0"><b id="c_nib"> NIB : 9120109831421</b></p>
                                            </div>
                                            <div class="help-sm-hidden">
                                                <ul class="list-unstyled mt-0 mb-0 text-muted">
                                                    <li class="d-sm-inline-block d-block mt-1 me-3" id="c_phone">
                                                        <i class="fa-solid fa-phone me-1"></i>
                                                        +6289 4562 8963
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3" id="c_email">
                                                        <i class="fa-regular fa-envelope me-1"></i>
                                                        tristarjava@mail.com
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3" id="c_status">
                                                        <span class="badge bg-success">Penilaian Lulus</span>
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3" id="c_address">
                                                        <i class="fa-solid fa-location-dot me-1"></i>
                                                        Street 110-B Kalians Bag, Dewan, M.P. New York
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Detail Pengajuan</h5>
                                <p class="mb-0"><i class="fa-solid fa-building-user me-2"></i> Dispo oleh <b
                                        id="internal" name="internal">Joko</b></p>
                                <p class="mb-0"><i class="fa-solid fa-user-tie me-3"></i>Dispo ke <b id="penilai">Iqbal
                                        Firmansyah</b></p>
                                <p class="mb-0"><i class="fa-solid fa-calendar-day me-3"></i>Diperbarui <b
                                        id="tanggal_diperbarui">12
                                        Desember 2024</b></p>
                                <p class="mb-0"><i class="fa-solid fa-user-large me-3"></i>Dibutuhkan Aksi
                                    <b id="internal-jabatan">Ketua Tim</b>
                                </p>
                                <p class="mb-0"><i class="fa-regular fa-note-sticky me-3"></i><a href="">Lihat
                                        Catatan</a></p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Surat Permohonan</h5>
                                <div class="row">
                                    <p class="mb-0" id="numberOfApplicationLetter"><i
                                            class="fa-solid fa-file me-2"></i>SRT-242024</p>
                                    <p class="mb-0" id="dateOfApplicationLetter"><i
                                            class="fa-solid fa-calendar me-2"></i>12 Desember 2023</p>
                                    <a href="">
                                        <p class="mb-0"><i class="fa-regular fa-file-pdf me-2"></i>Lihat Dokumen</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Jenis Pelayanan</h5>
                                <ol id="service_type">
                                    <li>AJAP</li>
                                    <li>Angkutan barang umum</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="navTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="task-tab" data-bs-toggle="tab" href="#task" role="tab"
                                aria-controls="task" aria-selected="true">Riwayat Pengajuan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="task-tab" data-bs-toggle="tab" href="#info" role="tab"
                                aria-controls="task" aria-selected="true">Informasi Pengguna</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="navTabsContent">
                        <div class="tab-pane fade show active" id="task" role="tabpanel"
                            aria-labelledby="task-tab">
                            <div class="task-card p-3" style="max-height: 200px; overflow-y: auto;">
                                <ul class="list-unstyled task-list">
                                    <li>
                                        <i class="feather icon-check f-w-600 task-icon bg-success"></i>
                                        <p class="m-b-5">8:50</p>
                                        <h5 class="text-muted">Call to customer <span class="text-primary"> <a
                                                    href="#!" class="text-primary">Jacob</a> </span> and discuss the
                                        </h5>
                                    </li>
                                    <li>
                                        <i class="task-icon bg-primary"></i>
                                        <p class="m-b-5">Sat, 5 Mar</p>
                                        <h5 class="text-muted">Design mobile Application</h5>
                                    </li>
                                    <li>
                                        <i class="task-icon bg-danger"></i>
                                        <p class="m-b-5">Sun, 17 Feb</p>
                                        <h5 class="text-muted"><span class="text-primary"><a href="#!"
                                                    class="text-primary">Jeny</a></span> assign you a task <span
                                                class="text-primary"><a href="#!" class="text-primary">Mockup
                                                    Design.</a></span></h5>
                                    </li>
                                    <li>
                                        <i class="task-icon bg-warning"></i>
                                        <p class="m-b-5">Sat, 18 Mar</p>
                                        <h5 class="text-muted">Design logo</h5>
                                    </li>
                                    <li class="p-b-15 m-b-10">
                                        <i class="task-icon bg-success"></i>
                                        <p class="m-b-5">Sat, 22 Mar</p>
                                        <h5 class="text-muted">Design mobile Application</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="info" role="tabpanel" aria-labelledby="task-tab">
                            <div class="task-card" style="max-height: 280px; overflow-y: auto;">
                                <h5>Penanggung Jawab</h5>
                                <p class="mb-0" id="pic_name"><i class="fa-solid fa-user me-2"></i>Ang Hoey Tiong</p>
                                <p class="mb-0" id="pic_phone"><i class="fa-solid fa-phone me-2"></i>(970) 982-3353</p>
                                <h5 class="mt-4">Informasi Pengguna</h5>
                                <p class="mb-0" id="u_name"><i class="fa-solid fa-circle-user me-2"></i>Anghoey</p>
                                <p class="mb-0" id="u_phone"><i class="fa-solid fa-phone me-2"></i>(970) 982-3353</p>
                                <p class="mb-0" id="u_email"><i
                                        class="fa-solid fa-envelope me-2"></i>anghoey.conn@borer.com
                                </p>
                                <p class="mb-0" id="request_date"><i class="fa-solid fa-calendar-day me-2"></i>25 Maret
                                    2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- You can add more tab panes here -->
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-primary">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Total Dokumen Penilaian</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2 total-document">10</h4>
                                <span class="fw-bold f-16 ket_penilaian">Dokumen</span>
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
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-success">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Lulus Penilaian</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2 passed-document">4</h4>
                                <span class="fw-bold f-16 ket_lulus">Lulus</span>
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
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-danger">
                                <i class="fa-solid fa-file-circle-exclamation"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Tidak Lulus Penilaian</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2 not-passed-document">3</h4>
                                <span class="fw-bold f-16 ket_tidak_lulus">Tidak Lulus</span>
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
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-primary">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">Presentase Penilaian Lulus</p>
                            <div class="d-flex align-items-start">
                                <h4 class="mb-0 me-2 percentage-passed">12%</h4>
                                <span class="fw-bold f-16 "></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">
                            <div class="datatable-top">
                                <div class="datatable-dropdown">
                                    <label>
                                        <select class="datatable-selector" style="width: auto;min-width: unset;"
                                            id="limitPage">
                                            <option value="5">5</option>
                                            <option value="10" selected="">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="datatable-search">
                                    <input class="datatable-input" placeholder="Cari..." type="search"
                                        title="Search within table" aria-controls="pc-dt-simple-1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                            aria-labelledby="analytics-tab-1" tabindex="0">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        let env = '{{ env('ESMK_SERVICE_BASE_URL') }}';
        let menu = 'Detail Penilaian Sertifikat SMK';
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let referenceId = urlParams.get('id');
        let companyID = urlParams.get('companyID');
        var smkElements
        var answerSchema
        var prevAssessmentSchema
        var monitoringElement
        let responseData;
        let resp;
        var pathname = window.location.pathname.split('/')

        async function getHistoryPengajuan() {
            loadingPage(true);

            const getDataRest = await CallAPI(
                    'GET',
                    `/dummy/internal/sertifikat/riwayat_pengajuan.json`,
                )
                .then(response => response)
                .catch(error => {
                    loadingPage(false);
                    let resp = error.response;
                    Swal.fire({
                        icon: 'info',
                        title: 'Pemberitahuan',
                        text: resp.data.message,
                        confirmButtonColor: '#28a745',
                    });
                    return resp;
                });

            if (getDataRest.status === 200) {
                loadingPage(false);
                let data = getDataRest.data.data;
                const statusLabels = {
                    'draft': 'Draft',
                    'request': 'Pengajuan',
                    'disposition': 'Disposisi',
                    'not_passed_assessment': 'Tidak lulus penilaian',
                    'submission_revision': 'Revisi pengajuan',
                    'passed_assessment': 'Lulus penilaian',
                    'not_passed_assessment_verification': 'Penilaian tidak lulus verifikasi',
                    'assessment_revision': 'Revisi penilaian',
                    'passed_assessment_verification': 'Penilaian terverifikasi',
                    'scheduling_interview': 'Penjadwalan wawancara',
                    'scheduled_interview': 'Wawancara Terjadwal',
                    'not_passed_interview': 'Tidak lulus wawancara',
                    'completed_interview': 'Wawancara selesai',
                    'verification_director': 'Validasi direktur',
                    'certificate_validation': 'Pengesahan sertifikat',
                    'rejected': 'Pengajuan ditolak',
                    'cancelled': 'Pengajuan dibatalkan',
                    'expired': 'Pengajuan kedaluwarsa'
                };

                const taskListElement = document.querySelector('.task-list');
                taskListElement.innerHTML = '';

                if (data) {
                    data.forEach(item => {
                        const {
                            status,
                            created_at, updated_by
                        } = item;
                        const label = statusLabels[status] || 'Status Tidak Diketahui';

                        let colorBage = 'primary';
                        if (status.includes('draft')) {
                            colorBage = 'secondary';
                        }
                        if (status.includes('not')) {
                            colorBage = 'warning';
                        }
                        if (status.includes('expired')) {
                            colorBage = 'dark';
                        }
                        if (status.includes('complete') || status.includes('passed_assessment_') ||
                            status == 'certificate_validation' || status == 'passed_assessment') {
                            colorBage = 'success';
                        }
                        if (status.includes('expired') ||
                            status.includes('cancelled') ||
                            status.includes('rejected')) {
                            colorBage = 'danger';
                        }

                        const taskItem = `
                    <li>
                        <i class="task-icon bg-${colorBage}"></i>
                        <p class="m-b-5">${new Date(created_at).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                        <h6 class="">${label}</h6>
                        <p class="fw-normal"><i class="fa-solid fa-user me-2"></i>${updated_by}</p>
                    </li>
                `;

                        taskListElement.insertAdjacentHTML('beforeend', taskItem);
                    });

                    const viewFriendList = ``;
                    taskListElement.insertAdjacentHTML('afterend', viewFriendList);

                } else {
                    console.error("Data is not an array", data);
                }
            }
        }


        async function getListData() {
            loadingPage(true);
            const baseUrl = `/dummy/internal/sertifikat/detail_sertifikat.json`;
            const response = await CallAPI('GET', baseUrl);
            loadingPage(true);
            if (response.status == 200) {
                loadingPage(false);
                dataComment = response.data.data.validation_notes;
                smkElements = response.data.data.element_properties;
                answerSchema = response.data.data.answers;
                prevAssessmentSchema = response.data.data.assessments || {}; // Berikan default nilai object kosong
                const assessor = response.data.data.assessor;
                const maxAssessments = response.data.data.element_properties.max_assesment;
                let isNeedSubmitButton = false;

                let accordionContent = '',
                    questionSchema = smkElements.question_schema.properties,
                    uiSchema = smkElements.ui_schema,
                    numbering = 1;


                for (const [elementKey, elementValue] of Object.entries(uiSchema)) {
                    const sortableSubElement = sortableSubElementByUiOrder(uiSchema, elementKey);
                    let rowIndex = 1;
                    const numberedElementKey = `${numbering}.${elementKey}`;

                    // Accordion item for each element
                    accordionContent += `
                            <div class="accordion-item shadow-sm border-0 mb-4">
                                <h2 class="accordion-header" id="heading-${elementKey}">
                                    <a class="accordion-button" href="#collapse${numberedElementKey}""
                                        data-bs-toggle="collapse"
                                        aria-expanded="true"
                                        aria-controls="collapse${numberedElementKey}"
                                        style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%); color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                        ${questionSchema[elementKey]?.title || 'No Title'}
                                    </a>
                                </h2>
                                <div id="collapse${numberedElementKey}" class="accordion-collapse collapse show" aria-labelledby="heading${numberedElementKey}">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Uraian</th>
                                                        <th>Unggahan Perusahaan</th>
                                                        <th>Nilai</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                    sortableSubElement.forEach(function(subElement) {

                        let templateAnswer = '';
                        const question = questionSchema[elementKey].properties[subElement[0]];


                        // Check if items exist
                        if (question.items) {
                            question.items.forEach((item, index) => {
                                const itemKey = Object.keys(item)[0];
                                templateAnswer += `
                                        <span class="form-label" style="margin-bottom: 0">File ${item[itemKey].name}</span>
                                        <a href="javascript:;" onClick="showViewDocument('${answerSchema[elementKey][subElement[0]][index][itemKey]}')">
                                            <p class="mb-0"><i
                                                    class="fa-regular fa-file-pdf me-2"></i><label
                                                    class="mb-0">Lihat Dokumen</label></p>
                                        </a>
                                    `;
                            });
                        } else {
                            templateAnswer += `
                                    <span class="form-label" style="margin-bottom: 0">File ${question.title}</span>
                                    <a href="javascript:;" onClick="showViewDocument('${answerSchema[elementKey][subElement[0]]}')">
                                        <p class="mb-0"><i
                                                class="fa-regular fa-file-pdf me-2"></i><label
                                                class="mb-0">Lihat Dokumen</label></p>
                                    </a>
                                `;
                        }

                        // Handling assessments
                        let assessmentValue = '',
                            assessmentReason = '',
                            rowClassName = '';

                        // Cek jika prevAssessmentSchema ada dan berisi data untuk elemen yang sesuai
                        if (response.data.data.assessments) {
                            rowClassName = response.data.data.assessments[elementKey][subElement[0]][
                                    'reason'
                                ] !=
                                null ? "table-warning" : "";
                            assessmentValue = response.data.data.assessments[elementKey][subElement[0]][
                                    'value'
                                ],
                                assessmentReason = response.data.data.assessments[elementKey][subElement[0]]
                                [
                                    'reason'
                                ] || '<span class="badge bg-success">Sesuai</span>'
                        }

                        // Modify assessment based on status and role
                        if (response.data.data.status === 'disposition' ||
                            (response.data.data.status === 'submission_revision' &&
                                prevAssessmentSchema[elementKey]?.[subElement[0]]?.reason !== null)) {

                            // Hanya menampilkan penilaian jika disposition_to.id sama dengan currentUser
                            if (response.data.data.disposition_to.id === currentUser) {
                                isNeedSubmitButton = true;

                                // Logika untuk status 'disposition'
                                if (response.data.data.status === 'disposition') {
                                    assessmentValue = `
                                            <div class="form-group row">
                                                <!-- For status 'disposition' -->
                                                <div class="col-sm-9">
                                                    <input type="text" min="0" id="value_${elementKey}_${subElement[0]}" step="0.1"
                                                        reason="reason_${elementKey}_${subElement[0]}"
                                                        max="${maxAssessments[elementKey][subElement[0]]}"
                                                        class="form-control nilai-sertifikat" required />
                                                    <small class="form-text text-muted">Bobot: ${maxAssessments[elementKey][subElement[0]]}</small>
                                                </div>
                                            </div>
                                        `;
                                    assessmentReason = `
                                            <textarea class="form-control" id="reason_${elementKey}_${subElement[0]}" disabled></textarea>
                                        `;
                                }
                                // Logika untuk status selain 'disposition'
                                else {
                                    let rawReason = response.data.data.assessments[elementKey][subElement[
                                        0]][
                                        'reason'
                                    ] ?? '';
                                    let processedReason = '';
                                    if (rawReason != '') {
                                        processedReason = `${rawReason}`
                                            .replace(/^\s+|\s+$/g, '')
                                            .replace(/[ \t]+/g, ' ');
                                    }

                                    assessmentValue = `
                                            <div class="form-group row">
                                                <div class="col-sm-9">
                                                    <input type="text" id="value_${elementKey}_${subElement[0]}"
                                                        reason="reason_${elementKey}_${subElement[0]}"
                                                        max="${maxAssessments[elementKey][subElement[0]]}"
                                                        value="${response.data.data.assessments[elementKey][subElement[0]]['value'] || ''}"
                                                        class="form-control nilai-sertifikat" required />
                                                    <small class="form-text text-muted">Bobot: ${maxAssessments[elementKey][subElement[0]]}</small>
                                                </div>
                                            </div>
                                        `;
                                    const isReasonAvailable = prevAssessmentSchema[elementKey]?.[subElement[
                                            0]]
                                        ?.reason ? '' : 'disabled';

                                    assessmentReason = `
                                            <textarea class="form-control" id="reason_${elementKey}_${subElement[0]}" ${isReasonAvailable}>${processedReason}</textarea>
                                        `;
                                }
                            }
                        }


                        if (response.data.data.status === 'not_passed_assessment_verification') {
                            if (response.data.data.disposition_to && response.data.data.disposition_to
                                .id ===
                                currentUser) {

                                assessmentValue = `<input type="text"
                                        id="value_${elementKey}_${subElement[0]}"
                                        reason="reason_${elementKey}_${subElement[0]}"
                                        max="${maxAssessments[elementKey][subElement[0]]}"
                                        value="${response.data.data.assessments[elementKey]?.[subElement[0]]?.['value'] || ''}"
                                        class="form-control nilai-sertifikat" required/>
                                        <span>Bobot: ${maxAssessments[elementKey][subElement[0]]}</span>`;

                                let rawReason = response.data.data.assessments[elementKey][subElement[0]][
                                    'reason'
                                ] ?? '';
                                let processedReason = '';
                                if (rawReason != '') {
                                    processedReason = `${rawReason}`
                                        .replace(/^\s+|\s+$/g, '')
                                        .replace(/[ \t]+/g, ' ');
                                }

                                assessmentReason =
                                    `<textarea class="form-control" id="reason_${elementKey}_${subElement[0]}" disabled>${processedReason}</textarea>`
                                isNeedSubmitButton = true;
                                if (response.data.data.assessment_status === 'submission_revision') {
                                    rowClassName = "table-warning";
                                }
                            }
                        }
                        // Table row generation
                        accordionContent += `
                                <tr class="${rowClassName}">
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${numbering}.${rowIndex}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${question.title}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${templateAnswer}</td>
                                    <td>${assessmentValue}</td>
                                    <td>${assessmentReason}</td>
                                </tr>
                            `;
                        rowIndex++;
                    });

                    accordionContent += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>`;
                    numbering++;
                }
                $('#accordionFlushExample').html(accordionContent);
                countAssessment(response.data.data.answers, response.data.data.assessments);

                // Panggil fungsi untuk mengatur ikon accordion
                setTimeout(() => initializeAccordionIcons(), 0);

                $('body').off('input', '.nilai-sertifikat').on('input', '.nilai-sertifikat', function() {
                    let val = $(this).val();
                    if (isNaN(val)) {
                        val = val.replace(/[^0-9\.]/g, '');
                        let parts = val.split('.');
                        if (parts.length > 2) {
                            val = parts[0] + '.' + parts.slice(1).join('');
                        }
                    }

                    $(this).val(val);

                    if (parseFloat(val) < 0) {
                        $(this).val(0);
                    }
                    let maxVal = parseFloat($(this).attr('max'));
                    let reasonField = $('#' + $(this).attr('reason'));

                    if (parseFloat(val) == maxVal || reasonField.val() !== "") {
                        reasonField.removeClass('is-invalid').next().remove();
                    }

                    if (parseFloat(val) >= maxVal) {
                        $(this).val(maxVal).removeClass('is-invalid').addClass('is-valid');
                        reasonField.val('').attr("disabled", true).attr('required', false);
                        if (parseFloat(val) > maxVal) {
                            notificationAlert('info', 'Pemberitahuan', `Poin maksimal ${maxVal}`);
                        }
                    } else if (val.length < 1 || parseFloat(val) < maxVal) {
                        reasonField.val('').attr("disabled", false).attr('required', true);
                    } else {
                        reasonField.attr("disabled", false).attr('required', true);
                    }
                });


                buildActionByRequestStatus(response.data.data.status, response.data.data.assessment_status, response
                    .data.data.disposition_to, response.data.data.disposition_by);
                mappingCompanyInformation(response.data.data);
                mappingCertificateRequestCard(response.data.data.status, response.data.data.disposition_by?.name,
                    response.data.data.disposition_to?.name, response.data.data.updated_at, response.data.data
                    .validation_notes);

                buildAnswerAsPDF();
                buildSubmitButton(isNeedSubmitButton);

                const applicationLetterData = {
                    'numberOfApplicationLetter': response.data.data.number_of_application_letter,
                    'dateOfApplicationLetter': response.data.data.date_of_application_letter,
                    'fileOfApplicationLetter': response.data.data.file_of_application_letter
                };
                buildApplicationLetterSection(applicationLetterData);

                const inInterviewStatus = ['scheduling_interview', 'scheduled_interview', 'completed_interview',
                    'verification_director', 'certificate_validation', 'expired'
                ];
                if (inInterviewStatus.includes(response.data.data.status)) {
                    const assessmentInterview = await getAssessmentInterview(id);
                    interviewDate = assessmentInterview.data.schedule;
                    interviewType = assessmentInterview.data.interview_type;
                    interviewAssessorhead = assessmentInterview.data.assessorHead;

                    const assessors = assessmentInterview.data.assessors?.map(assessor => assessor);
                    interviewAssessors = assessors;

                    mappingInterviewCard(response.data.data.status, interviewDate, interviewType,
                        interviewAssessorhead,
                        assessors);
                }


            }

        }

        function countAssessment(answerData, assessmentData) {
            let totalDocument = 0,
                passedDocument = '-',
                notPassedDocument = '-',
                percentagePassed = '-';

            // Hitung total dokumen
            Object.values(answerData).map(elementAnswers => {
                Object.values(elementAnswers).map(answers => {
                    totalDocument++;
                });
            });

            if (assessmentData) {
                passedDocument = 0;
                notPassedDocument = 0;

                // Hitung lulus dan tidak lulus
                Object.values(assessmentData).map(elementAssessments => {
                    Object.values(elementAssessments).map(assessments => {
                        if (assessments.reason) {
                            notPassedDocument++;
                        } else {
                            passedDocument++;
                        }
                    });
                });

                // Hitung persentase lulus
                if (totalDocument > 0) {
                    percentagePassed = Math.round((passedDocument / totalDocument) * 100) + '%';
                }
            }

            // Perbarui elemen HTML
            $('.total-document').text(totalDocument);
            $('.passed-document').text(passedDocument);
            $('.not-passed-document').text(notPassedDocument);
            $('.percentage-passed').text(percentagePassed);
        }

        async function showViewDocument(loc) {
            // $('.view-document-print').attr('src', loc);
            // await $('#view-document').modal('show')
            window.open(loc)
        }

        async function loadServiceTypes(id = "") {
            $(`${id}`).select2({
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                ajax: {
                    url: '{{ env('ESMK_SERVICE_BASE_URL') }}/internal/admin-panel/satuan-kerja/service',
                    dataType: 'json',
                    delay: 500,
                    headers: {
                        Authorization: `Bearer ${Cookies.get('auth_token')}`
                    },
                    processResults: function(res) {
                        let data = res.data
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                },
                allowClear: true,
                placeholder: 'Pilih Pelayanan',
                closeOnSelect: true,
            });
        }

        function initializeAccordionIcons() {
            document.querySelectorAll('.accordion-item').forEach(item => {
                const collapseElement = item.querySelector('.accordion-collapse');
                const button = item.querySelector('.accordion-btn');
                const icon = button.querySelector('.toggle-icon');

                // Event listener untuk saat accordion dibuka
                collapseElement.addEventListener('shown.bs.collapse', () => {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                });

                // Event listener untuk saat accordion ditutup
                collapseElement.addEventListener('hidden.bs.collapse', () => {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                });
            });
        }


        function generateRowOfElementTitle(colSpanTitle, title) {
            let $templateRow =
                `<tr>
                <td class="bg-primary" colspan="${colSpanTitle}">
                    <span style="color: #fff;">${title}</span>
                </td>
            </tr>`

            return $templateRow
        }

        async function accordionEffect(id) {
            $(`${id} .accordion-btn`).each(function() {
                const iconElement = $(this).find('.toggle-icon');
                const targetCollapse = $($(this).data('bs-target'));

                // Setup event listeners
                targetCollapse.off('shown.bs.collapse hidden.bs.collapse');

                iconElement.css({
                    'transition': 'transform 0.3s ease',
                    'transform-origin': 'center',
                });

                targetCollapse.on('shown.bs.collapse', function() {
                    iconElement.removeClass('fa-plus').addClass('fa-minus');
                    iconElement.css('transform', 'rotate(180deg)');
                });

                targetCollapse.on('hidden.bs.collapse', function() {
                    iconElement.removeClass('fa-minus').addClass('fa-plus');
                    iconElement.css('transform', 'rotate(0deg)');
                });

                // Membuka semua accordion secara default tanpa mengganggu toggle behavior-nya
                if (!targetCollapse.hasClass('show')) {
                    targetCollapse.collapse('show');
                }
            });
        }

        function sortableSubElementByUiOrder(uiSchema, elementKey) {
            let sortable = []

            for (let a in uiSchema[elementKey]) {
                sortable.push([a, uiSchema[elementKey][a]]);
            }

            sortable.sort(function(a, b) {
                return a[1]['ui:order'] - b[1]['ui:order'];
            });

            return sortable
        }

        function buildActionByRequestStatus(requestStatus, assessmentStatus, dispositionTo = '', dispositionBy = '') {
            let alertMessage, actionButton, htmlReject = '',
                isShowAlert = false

            // action for disposition
            if (assessmentStatus === 'request' && dispositionTo === null) {
                alertMessage = `<i class="fas fa-file-alt me-2"></i>Pengajuan baru`
                actionButton =
                    `<button class="btn w-100" style="background-color: #28a745; color: #ffffff;" onClick="showDisposition()">
                    <i class="fas fa-pen me-2" style="color: #ffffff;"></i>Disposisi
                </button>`
                isShowAlert = true

                htmlReject = `
                <button type="button" class="btn mt-3" style="background-color: #dc3545; font-weight: 600; width:100%; color: #ffffff" onClick="showConfirmationRejectRequest()">
                    <i class="fas fa-times me-2" style="color: #ffffff;"></i>Tolak pengajuan
                </button>`
            }

            if (requestStatus !== 'request' || requestStatus !== 'passed_assessment_verification' || requestStatus !== "") {
                // if (roleUser === 'ketua_tim') {
                //     htmlReject =
                //         `<button type="button" class="btn btn-primary mt-3" style="font-weight: 600; width: 100%;" onClick="showDispositionBy(${dispositionBy.id})">
            //             <i class="fas fa-sync-alt me-2" style="color: #ffffff;"></i> Ubah Ketua Tim
            //         </button>`;
                // }
                if (dispositionBy?.id === currentUser) {
                    htmlReject =
                        `<button type="button" class="btn btn-primary mt-3" style="font-weight: 600; width: 100%;" onClick="showDispositionBy(${dispositionBy?.id})">
                        <i class="fas fa-sync-alt me-2" style="color: #ffffff;"></i> Ubah Ketua Tim
                    </button>`;
                }
            }
            // action for change assessor

            // if (requestStatus === 'disposition' && userRole === 'ketua_tim') {
            //     isShowAlert = true
            //     alertMessage = `<p class="p-0 lead"><strong>Pengajuan baru</strong></p>`
            //     actionButton =
            //         `<button type="button" class="btn btn-primary" style="font-weight: 600; width: 100%;" onClick="showDisposition(${dispositionTo.id})">
        //             <i class="fas fa-sync-alt me-2" style="color: #ffffff;"></i> Ubah Penilai
        //         </button>
        //         `
            // }
            if (requestStatus === 'disposition') {
                isShowAlert = true
                alertMessage = `<p class="p-0 lead"><strong>Pengajuan baru</strong></p>`
                actionButton =
                    `<button type="button" class="btn btn-primary" style="font-weight: 600; width: 100%;" onClick="showDisposition(${dispositionTo.id})">
                    <i class="fas fa-sync-alt me-2" style="color: #ffffff;"></i> Ubah Penilai
                </button>
                `
            }

            // action for assessment verification
            if (requestStatus === 'passed_assessment') {
                alertMessage = `
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <p class="mb-0 lead">Pengajuan telah lulus penilaian!</p>
                    </div>
                </div>
            `;
                if (dispositionBy.id === currentUser) {
                    actionButton = `
                    <button type="button" class="btn btn-warning" style="font-weight: 600; width:100%; color: #333333;" onClick="showAssessmentValidation()">
                        <i class="fas fa-check-circle me-2" style="color: #333333;"></i>Verifikasi Penilaian
                    </button>
                `;
                } else {
                    actionButton = '';
                }

                isShowAlert = true;
            }

            if (assessmentStatus === 'not_passed_assessment_validation') {
                alertMessage = `<p class="p-0 lead">Validasi pengajuan ditolak</p>`;
                actionButton = '';
                isShowAlert = true;
            }


            // action for scheduling interview
            if (requestStatus === 'passed_assessment_verification') {

                alertMessage = `
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle me-2" style="font-size: 1.5rem;"></i>
                <div>
                    <p class="mb-0 lead">Pengajuan membutuhkan penjadwalan interview!</p>
                </div>
            </div>
            `

                if (dispositionBy.id === currentUser) {
                    actionButton =
                        `<button type="button" class="btn btn-warning" style="font-weight: 600; width:100%; color: #333333;" onClick="showSchedulingInterview()">
                    <i class="fas fa-calendar-alt me-2" style="color: #333333;"></i>Atur Interview
                </button>`
                } else {
                    actionButton = '';
                }

                isShowAlert = true
            }

            if (isShowAlert) {
                let $template =

                    `<div class="invoice-box p-3 rounded" style="background-color: #ffffff; color: #333;">
                    <h5 class="text-start mb-3">
                    ${alertMessage}
                    </h5>
                    ${actionButton}
                    ${htmlReject}
                </div>`

                $('#alertMessage').append($template)
            }

        }

        function mappingCompanyInformation(data) {
            let serviceTypes = '';
            data.company.service_types.forEach((serviceType) => {
                serviceTypes += `<li>${serviceType.name}</li>`;
            });

            const fileUrl = data.company.nib_file
            const splitFileURL = fileUrl.split('/')
            const fileName = splitFileURL[splitFileURL.length - 1]
            const fileExtension = fileUrl.substring(fileUrl.lastIndexOf("."))

            let nibPreview = ''
            let imageType = ['.jpeg', '.jpg', '.png']
            if (imageType.includes(fileExtension)) {
                nibPreview = `
                    <img class="img-fluid" src="${fileUrl}"/>
                `
            }

            // colorBridge(success)
            let color = ''
            if (data.status === 'active') {
                color = 'success'
            } else if (data.status === 'inactive') {
                color = 'danger'
            } else if (data.status === 'pending') {
                color = 'warning'
            } else if (data.status === 'cancelled') {
                color = 'info'
            }

            $('#c_color').html(`
                <div
                    class="wid-60 hei-60 rounded-circle bg-${color} d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-building text-white fa-2x"></i>
                </div>`);
            $('#c_status').text(data.status)

            $('#c_name').text(`${data.company.name} |`)
            $('#c_nib').text('NIB : ' + data.company.nib)
            $('#c_address').text(
                `${data.company.address} ${data.company.city.name} ${data.company.province.name}`)
            $('#c_phone').html(`<i class="fa-solid fa-phone me-1"></i> ${data.company.company_phone_number}`);
            $('#c_email').html(`<i class="fa-regular fa-envelope me-1"></i> ${data.company.company_phone_number}`);

            // pic
            $('#pic_name').html(`
                <i class="fa-solid fa-user me-2"></i>${data.company.pic_name}`);
            $('#pic_phone').html(`
                <i class="fa-solid fa-phone me-2"></i>${data.company.pic_phone}`);

            //user
            $('#u_name').html(`
                <i class="fa-circle-user me-2"></i>${data.company.username}`);
            $('#u_phone').html(`
                <i class="fa-solid fa-phone me-2"></i>${data.company.phone_number}`);
            $('#u_email').html(`
                <i class="fa-solid fa-envelope me-2"></i>${data.company.email}`);
            $('#request_date').html(`
                <i class="fa-solid fa-phone me-2"></i>${data.company.request_date}`);

            //disposisi
            $('#internal').text(data.disposition_by.name)
            $('#penilai').text(data.disposition_to.name)
            $('#tanggal_diperbarui').text(data.updated_at)
            $('#numberOfApplicationLetter').html(`
                <i class="fa-solid fa-file me-2"></i>${data.number_of_application_letter}`);
            $('#dateOfApplicationLetter').html(`
                <i class="fa-solid fa-calendar me-2"></i>${data.date_of_application_letter}`);

            $('#c_serviceType').append(serviceTypes)
            $('#pic_name').text(data.company.pic_name)
            $('#pic_phone').text(data.company.pic_phone)
            $('#u_name').text(data.company.username)
            $('#u_email').text(data.company.name)
            $('#u_phone').text(data.company.phone_number)
            $('#current_preview').text(data.company.id)
            $('#establish_date').text(data.company.establish ? moment(data.data.company.establish).format(
                'D/MM/YYYY') : '-')
            $('#request_date').text(moment(data.company.request_date).format('D/MM/YYYY'))
        }

        function sortableSubElementByUiOrder(uiSchema, elementKey) {
            let sortable = []

            for (let a in uiSchema[elementKey]) {
                sortable.push([a, uiSchema[elementKey][a]]);
            }

            sortable.sort(function(a, b) {
                return a[1]['ui:order'] - b[1]['ui:order'];
            });

            return sortable
        }

        function mappingColumnOfRow(
            subElementSchema,
            status,
            numberColumn
        ) {
            let $rowTable = ''

            if (subElementSchema.inputType === 'files') {
                for (let i in subElementSchema.monitoringProperties) {
                    let itemKey = Object.keys(subElementSchema.monitoringProperties[i])[0]

                    let newAssessment
                    if (typeof subElementSchema.assessments !== 'undefined') {
                        if (subElementSchema.assessments === null) {
                            newAssessment = null
                        } else {
                            newAssessment = subElementSchema.assessments[i][itemKey]
                        }
                    }

                    let newAnswer = null
                    if (typeof subElementSchema.answers[i][itemKey] !== 'undefined') {
                        newAnswer = subElementSchema.answers[i][itemKey]
                    }

                    let itemSubElementSchema = {
                        subElementSchema: subElementSchema.elementKey,
                        subElementKey: itemKey,
                        questionProperties: subElementSchema.questionProperties,
                        monitoringProperties: subElementSchema.monitoringProperties[i][itemKey],
                        answers: newAnswer,
                        assessments: newAssessment,
                        inputType: subElementSchema.inputType,
                        lengthOfItems: subElementSchema.monitoringProperties.length
                    }

                    let newNumber = numberColumn

                    if (i != 0) {
                        newNumber = ''
                    }

                    $rowTable += generateRowsTable(
                        itemSubElementSchema,
                        status,
                        newNumber
                    )

                }
            } else {
                $rowTable += generateRowsTable(
                    subElementSchema,
                    status,
                    numberColumn
                )
            }

            return $rowTable
        }

        function generateRowsTable(
            subElementSchema,
            status,
            numberOfColumn
        ) {
            let numberColumn = '',
                titleColumn = '',
                questionColumn = subElementSchema.monitoringProperties.questionValue ?
                `<td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${subElementSchema.monitoringProperties.questionValue}</td>` :
                '<td></td>',
                answerColumn = '',
                assessmentButtonColumn = '',
                assessmentReasonColumn = ''

            let buttonProperties = {
                yesOption: {
                    label: 'Ya',
                    id: `passed-${subElementSchema.subElementKey}`,
                    value: 'yes'
                },
                noOption: {
                    label: 'Tidak',
                    id: `notPassed-${subElementSchema.subElementKey}`,
                    value: 'no'
                },
            }

            if (numberOfColumn) {
                numberColumn =
                    `<td style="word-wrap: break-word; white-space: normal; max-width: 300px;" ${subElementSchema.lengthOfItems ?  `rowspan=${subElementSchema.lengthOfItems}` : ''}>${numberOfColumn}</td>`
                titleColumn =
                    `<td style="word-wrap: break-word; white-space: normal; max-width: 300px;" ${subElementSchema.lengthOfItems ?  `rowspan=${subElementSchema.lengthOfItems}` : ''}>${subElementSchema.questionProperties.title}</td>`
            }

            if (subElementSchema.monitoringProperties.isVisibilityValue) {
                answerColumn = subElementSchema.answers !== null ?
                    `<button type="button" id="${subElementSchema.answers}-answerFile" onClick="showViewDocument('${subElementSchema.answers}')" class="btn btn-light btn-sm">lihat dokumen</button>` :
                    'Tidak ada perubahan'

                if (status === 'request') {
                    if (subElementSchema.answers) {

                        assessmentButtonColumn = customRadioCheckHTML(
                            `assessment-${subElementSchema.subElementKey}`,
                            buttonProperties
                        )

                        assessmentReasonColumn = textInputHTML({
                            id: `assessment-reason-${subElementSchema.subElementKey}`,
                            name: `assessmentReason-${subElementSchema.subElementKey}`,
                            isDisabled: true
                        })
                    }

                } else if (status === 'revision') {
                    if (subElementSchema.answers) {
                        if (
                            typeof subElementSchema.assessments?.assessmentValue !== 'undefined' ||
                            subElementSchema.assessments?.assessmentValue === null
                        ) {
                            if (subElementSchema.assessments.assessmentValue === true || subElementSchema
                                .assessments
                                .assessmentReason === null) {
                                assessmentButtonColumn = '<span class="badge bg-success">Sesuai</span>'
                            } else {

                                assessmentButtonColumn = customRadioCheckHTML(
                                    `assessment-${subElementSchema.subElementKey}`,
                                    buttonProperties
                                )

                                assessmentReasonColumn = textInputHTML({
                                    id: `assessment-reason-${subElementSchema.subElementKey}`,
                                    name: `assessmentReason-${subElementSchema.subElementKey}`,
                                    isDisabled: true
                                })
                            }

                        }
                    }

                } else {
                    if (subElementSchema.answers) {
                        if (typeof subElementSchema.assessments.assessmentValue !== 'undefined') {
                            if (subElementSchema.assessments.assessmentValue === true || subElementSchema
                                .assessments
                                .assessmentReason === null) {
                                assessmentButtonColumn = '<span class="badge bg-success">Sesuai</span>'
                            } else {
                                assessmentButtonColumn = '<span class="badge bg-danger">belum Sesuai</span>'
                                assessmentReasonColumn = subElementSchema.assessments.assessmentReason
                            }

                        }
                    }
                }
            }

            let $templateRow = `
        <tr>
            ${numberColumn}
            ${titleColumn}
            ${questionColumn}
            <td>${answerColumn}</td>
            <td>${assessmentButtonColumn}</td>
            <td>${assessmentReasonColumn}</td>
        </tr>
        `

            $(document).on('change', `input:radio[name=assessment-${subElementSchema.subElementKey}]`, function() {
                let buttonValue = $(this).val()
                if (buttonValue === 'yes') {
                    $(`#assessment-reason-${subElementSchema.subElementKey}`).prop({
                        'disabled': true,
                        'required': false
                    })
                }

                if (buttonValue === 'no') {
                    $(`#assessment-reason-${subElementSchema.subElementKey}`).prop({
                        'disabled': false,
                        'required': true
                    })
                }
            })


            return $templateRow
        }

        function buildSubmitButton(isNeedSubmitButton) {
            if (isNeedSubmitButton) {
                $('.action-button').empty().append(`
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                            <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Simpan
                        </button>
                    </div>
                `)
            }
        }

        function customRadioCheckHTML(inputName, properties, defaultValue = 'yes') {

            let $customRadioButton =
                `<div class="gap-2 d-flex">
            <input
                type="radio"
                class="btn-check"
                name="${inputName}"
                value="${properties.yesOption.value}"
                id="${properties.yesOption.id}"
                ${defaultValue === 'yes' ? 'checked' : ''}>
            <label class="btn btn-outline-primary"
                for="${properties.yesOption.id}"
                style="width: 40%;">${properties.yesOption.label}</label>

            <input type="radio"
                class="btn-check"
                name="${inputName}"
                value="${properties.noOption.value}"
                id="${properties.noOption.id}"
                ${defaultValue === 'no' ? 'checked' : ''}>
            <label class="btn btn-outline-warning bg-opacity-50 bg-gradient"
                for="${properties.noOption.id}"
                style="width: 40%;">${properties.noOption.label}</label>
        </div>`

            return $customRadioButton
        }

        function textInputHTML(inputProperties) {
            let $templateInput = `
            <textarea class="form-control"
                id="${inputProperties.id}"
                name="${inputProperties.name}"
                ${inputProperties.required ? 'required' : ''}
                ${inputProperties.readonly ? 'readonly' : ''}
                ${inputProperties.isDisabled ? 'disabled' : ''}></textarea>
            `

            return $templateInput
        }

        const $form = document.getElementById('fCreate');
        // $form.addEventListener("submit", (e) => {
        //     e.preventDefault();
        //     const formParsley = $('#fCreate').parsley();

        //     formParsley.validate();

        //     if (!formParsley.isValid()) return false;


        //     let assessmentSchema = buildAssessmentSchema();

        //     let formData = {
        //         assessments: assessmentSchema.schema,
        //         assessment_status: assessmentSchema.nextStatus,
        //     };

        //     submitData(formData, 'Assessment Berhasil');
        // });

        // async function submitData(formData, successMessage) {
        //     console.log('formData', formData);
        //     loadingPage(true);
        //     try {
        //         const ajaxResponse = await CallAPI(
        //             'PUT',
        //             `{{ env('ESMK_SERVICE_BASE_URL') }}/internal/admin-panel/laporan-tahunan/update`, {
        //                 id: referenceId,
        //                 ...formData
        //             }
        //         );
        //         console.log(ajaxResponse, 'data');
        //         if (ajaxResponse.status === 200) {
        //             notificationAlert('success', 'Berhasil', ajaxResponse.data.message);
        //             Swal.fire({
        //                 title: 'Berhasil!',
        //                 text: successMessage,
        //                 icon: 'success',
        //                 timer: 5000,
        //                 timerProgressBar: true,
        //                 showConfirmButton: false,
        //             }).then(() => {
        //                 window.location.reload();
        //             });
        //         }
        //     } catch (error) {
        //         const message = error.response?.data?.message || 'An unknown error occurred';
        //         notificationAlert('error', 'Error', message);
        //     } finally {
        //         loadingPage(false);
        //     }
        // }


        function buildAssessmentSchema() {
            let elements = {},
                nextStatus = 'verified'

            $.each(answerSchema, function(elementKey, elementValue) {
                const rowData = {}

                $.each(elementValue, function(subElementKey) {

                    let question = smkElements['question_schema']['properties'][elementKey][
                            'properties'
                        ][
                            subElementKey
                        ],
                        assessments

                    if (question['items']) {
                        let newData = []

                        for (let i in question['items']) {
                            let itemKey = Object.keys(question['items'][i])[0],
                                assessmentButtonValue = $(
                                    `input:radio[name=assessment-${itemKey}]:checked`)
                                .val(),
                                assessmentReason = $(`#assessment-reason-${itemKey}`).val(),
                                assessmentValue = null

                            if (typeof assessmentButtonValue !== 'undefined') {
                                assessmentValue = assessmentButtonValue === 'yes'
                            }

                            let data = {
                                assessmentValue: assessmentValue,
                                assessmentReason: assessmentReason || null
                            }

                            if (!assessmentValue && assessmentReason) {
                                nextStatus = 'not_passed'
                            }

                            newData.push({
                                [itemKey]: data
                            })
                        }

                        assessments = newData
                    } else {
                        let assessmentButtonValue = $(
                                `input:radio[name=assessment-${subElementKey}]:checked`).val(),
                            assessmentReason = null,
                            assessmentValue = null,
                            answerFile = $(`#answerFile-${subElementKey}`)

                        if (
                            typeof assessmentButtonValue === 'undefined' &&
                            answerFile !== undefined
                        ) {
                            assessmentValue = true
                        }

                        if (typeof assessmentButtonValue !== 'undefined') {
                            assessmentValue = assessmentButtonValue === 'yes'
                            assessmentReason = $(`#assessment-reason-${subElementKey}`).val()
                        }

                        if (!assessmentValue && assessmentReason) {
                            nextStatus = 'not_passed'
                        }

                        assessments = {
                            assessmentValue: assessmentValue,
                            assessmentReason: assessmentReason
                        }
                    }

                    rowData[subElementKey] = assessments

                })

                elements[elementKey] = rowData
            })

            return {
                schema: elements,
                nextStatus: nextStatus,
            }
        }


        $('input[name="isValidAssessment"]').on('click', function() {
            let isValidAssessment = $(this).val() === 'yes'

            $('#validationReason').attr('disabled', isValidAssessment)
            $('#validationReason').prop('required', !isValidAssessment)
        })

        async function showViewDocument(loc) {
            $('.view-document-print').attr('src', loc);
            await $('#view-document').modal('show')
        }


        async function showViewDocument(loc) {
            const authToken = Cookies.get('auth_token');
            if (!authToken) {
                showAlert('error', 'Authentication token not found');
                return;
            }
            $.ajax({
                url: "{{ env('ESMK_SERVICE_BASE_URL') }}/internal/admin-panel/laporan-tahunan/getView",
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${authToken}`
                },
                data: {
                    url: loc
                },
                error: function(xhr) {
                    let message = xhr.responseJSON?.message || 'An error occurred';
                    showAlert('error', message);
                },
                success: async function(response) {

                    if (response.data && response.data.certificate_file_base64) {
                        $('.view-document-print').attr('src', response.data
                            .certificate_file_base64);
                        await $('#view-document').modal('show');
                    } else {
                        showAlert('error', 'Document not found');
                    }
                }
            });
        }

        const mappingRequestStatus = {
            'new_request': {
                status: 'Pengajuan',
                message: 'Pengajuan anda sedang diproses',
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            },
            'need_revision': {
                status: 'Penilaian Belum Sesuai',
                message: 'Pengajuan anda membutuhkan perbaikan data',
                bgColor: 'bg-warning-subtle',
                textColor: 'text-warning'
            },
            'revision': {
                status: 'Pengajuan Revisi',
                message: 'Pengajuan revisi anda sedang diproses',
                bgColor: 'bg-secondary-subtle',
                textColor: 'text-secondary'
            },
            'need_validation': {
                status: 'Verifikasi Penilaian',
                message: 'Pengajuan anda sedang diverifikasi oleh ketua tim',
                bgColor: 'bg-info-subtle',
                textColor: 'text-info'
            },
            'need_recheck_assessment': {
                status: 'Tinjau ulang penilaian',
                message: 'Pengajuan anda sedang ditinjau ulang oleh penilai',
                bgColor: 'bg-info-subtle',
                textColor: 'text-warning'
            },
            'need_interview': {
                status: 'Penjadwalan interview',
                message: 'Selamat! pengajuan anda lulus uji dan akan dijadwalkan untuk wawancara',
                bgColor: 'bg-info-subtle',
                textColor: 'text-info'
            },
            'scheduled_interview': {
                status: 'Interview Terjadwal',
                message: 'Interview sudah terjadwal',
                bgColor: 'bg-info',
                textColor: 'text-white'
            },
            'not_pass_interview': {
                status: 'Tidak Lulus interview',
                message: 'Interview anda tidak lulus',
                bgColor: 'bg-danger-subtle',
                textColor: 'text-danger'
            },
            'need_director_verification': {
                status: 'Butuh verifikasi direktur',
                message: 'Interview anda tidak lulus',
                bgColor: 'bg-info',
                textColor: 'text-white'
            },
            'need_signature': {
                status: 'Butuh tanda tangan',
                message: 'Interview anda tidak lulus',
                bgColor: 'bg-info',
                textColor: 'text-white'
            },
            'completed': {
                status: 'Lulus penilaian',
                message: 'Selamat! pengajuan anda lulus uji dan akan dijadwalkan untuk wawancara',
                bgColor: 'bg-success',
                textColor: 'text-white'
            },
            'rejected': {
                status: 'Pengajuan ditolak',
                message: 'Pengajuan anda ditolak!',
                bgColor: 'bg-danger',
                textColor: 'text-white'
            }
        }

        const mappingRequestStatusV2 = {
            'request': {
                status: 'Pengajuan',
                message: 'Berhasil melakukan pengajuan',
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            },
            'disposition': {
                status: 'Disposisi',
                message: 'Pengajuan sudah di disposisi dan akan segera dilakukan penilaian',
                bgColor: 'bg-warning-subtle',
                textColor: 'text-warning'
            },
            'not_passed_assessment': {
                status: 'Tidak lulus penilaian',
                message: 'Pengajuan tidak lulus penilaian dan dibutuhkan perbaikan dokumen',
                bgColor: 'bg-danger-subtle',
                textColor: 'text-danger'
            },
            'submission_revision': {
                status: 'Revisi pengajuan',
                message: 'Perbaikan dokumen pengajuan',
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            },
            'passed_assessment': {
                status: 'Lulus penilaian',
                message: 'Dokumen pengajuan sudah dinilai dan diteruskan untuk verifikasi penilaian',
                bgColor: 'bg-info-subtle',
                textColor: 'text-info'
            },
            'not_passed_assessment_verification': {
                status: 'Penilaian tidak lulus verifikasi',
                message: 'Penilaian tidak valid dan akan akan dilakukan penilaian ulang',
                bgColor: 'bg-danger-subtle',
                textColor: 'text-danger'
            },
            // 'assessment_revision' : {
            //     status : 'Revisi penilaian',
            //     message: 'Penilaian ulang oleh penilai',
            //     bgColor: 'bg-info-subtle',
            //     textColor: 'text-info'
            // },
            'passed_assessment_verification': {
                status: 'Penilaian terverifikasi',
                message: 'Selamat! pengajuan telah terverifikasi dan akan dijadwalkan untuk wawancara',
                bgColor: 'bg-info',
                textColor: 'text-white'
            },
            'scheduling_interview': {
                status: 'Penjadwalan wawancara',
                message: 'Selamat! pengajuan anda lulus uji dan akan dijadwalkan untuk wawancara',
                bgColor: 'bg-info-subtle',
                textColor: 'text-info'
            },
            'scheduled_interview': {
                status: 'Wawancara Terjadwal',
                message: 'Wawancara sudah terjadwal',
                bgColor: 'bg-info',
                textColor: 'text-white'
            },
            'not_passed_interview': {
                status: 'Tidak lulus wawancara',
                message: 'Tidak lulus wawancara',
                bgColor: 'bg-danger-subtle',
                textColor: 'text-danger'
            },
            'completed_interview': {
                status: 'Wawancara selesai',
                message: 'Wawancara telah berhasil',
                bgColor: 'bg-success-subtle',
                textColor: 'text-success'
            },
            'verification_director': {
                status: 'Validasi direktur',
                message: 'Pengajuan telah diverifikasi oleh direktur',
                bgColor: 'bg-success',
                textColor: 'text-white'
            },
            'certificate_validation': {
                status: 'Pengesahan sertifikat',
                message: 'Selamat! sertikat sudah diterbitkan',
                bgColor: 'bg-success',
                textColor: 'text-white'
            },
            'rejected': {
                status: 'Pengajuan ditolak',
                message: 'Pengajuan ditolak!',
                bgColor: 'bg-danger',
                textColor: 'text-white'
            },
            'cancelled': {
                status: 'Pengajuan dibatalkan',
                message: 'Pengajuan dibatalkan!',
                bgColor: 'bg-danger',
                textColor: 'text-white'
            },
            'expired': {
                status: 'Pengajuan Kedaluwarsa',
                message: 'Pengajuan Kedaluwarsa!',
                bgColor: 'bg-danger',
                textColor: 'text-white'
            },
            'draft': {
                status: 'Draft',
                message: 'Draft!',
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            }
        }

        const mappingAssessmentStatus = {
            'new_request': 'Pengajuan baru',
            'not_pass': 'Belum Sesuai',
            'revision': 'Revisi',
            'passed': 'Lulus penilaian',
            'need_validation': 'Verifikasi penilaian',
            'need_recheck_assessment': 'Assessment tidak valid'
        }

        const mappingAssessmentStatusV2 = {
            'draft': 'Draft',
            'request': 'Pengajuan',
            'not_passed_assessment': 'Tidak Lulus Penilaian',
            'submission_revision': 'Perbaikan Dokumen Pengajuan',
            'passed_assessment': 'Lulus Penilaian',
            'not_passed_assessment_verification': 'Tidak Lulus verifikasi Penilaian',
            'assessment_revision': 'Revisi Penilaian',
            'passed_assessment_verification': 'Lulus verifikasi Penilaian',
            'rejected': 'Ditolak',
            'cancelled': 'Dibatalkan',
            'expired': 'Kedaluwarsa'
        }

        const mappingYearlyReportStatus = {
            request: {
                status: 'Pengajuan',
                description: 'Perusahaan melakukan pengajuan laporan tahunan',
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            },
            disposition: {
                status: 'Disposisi',
                description: "Pengajuan sudah di disposisi ke penilai",
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            },
            not_passed: {
                status: 'Laporan belum sesuai',
                description: "Laporan dinilai belum sesuai",
                bgColor: 'bg-warning-subtle',
                textColor: 'text-warning'
            },
            revision: {
                status: 'Revisi laporan',
                description: "Laporan telah dilakukan perbaikan",
                bgColor: 'bg-dark-subtle',
                textColor: 'text-body'
            },
            verified: {
                status: 'Laporan terverifikasi',
                description: "Laporan telah terverifikasi oleh penilai",
                bgColor: 'bg-success',
                textColor: 'text-white'
            },
            cancelled: {
                status: 'Pengajuan dibatalkan',
                message: 'Pengajuan dibatalkan oleh perusahaan',
                bgColor: 'bg-danger',
                textColor: 'text-white'
            }
        }

        const mappingProcessBy = (status, dispositionBy) => {
            let prosessBy = '-'

            if (['request',
                    'revision',
                    'need_recheck_assessment'
                ].includes(status)) {

                if (dispositionBy) {
                    prosessBy = 'Penilai'
                } else {
                    prosessBy = 'Ketua Tim'
                }
            }

            if (['need_revision'].includes(status)) {
                prosessBy = 'Perusahaan'
            }

            if (['need_validation', 'need_interview'].includes(status)) {
                prosessBy = 'Ketua Tim'
            }

            return `<span>${prosessBy}</span>`
        }

        const mappingProcessByV2 = (status, dispositionBy) => {
            let prosessBy = '-'

            let processByCompany = ['not_passed_assessment'],
                processByAssessorHead = [
                    'request',
                    'passed_assessment',
                    'assessment_revision',
                    'passed_assessment_verification',
                    'scheduling_interview',
                    'scheduled_interview'
                ],
                processByAssessor = [
                    'disposition',
                    'submission_revision',
                    'not_passed_assessment_verification'
                ],
                processByDirector = ['completed_interview'],
                processByDirjen = ['verification_director']

            if (processByCompany.includes(status)) {
                prosessBy = 'Perusahaan'
            }

            if (processByAssessorHead.includes(status)) {
                prosessBy = 'Ketua tim'
            }

            if (processByAssessor.includes(status)) {
                prosessBy = 'Penilai'
            }

            if (processByDirector.includes(status)) {
                prosessBy = 'Direktur'
            }

            if (processByDirjen.includes(status)) {
                prosessBy = 'Dirjen'
            }

            if (status === 'certificate_validation') {
                prosessBy = 'Selesai'
            }

            return `<span>${prosessBy}</span>`
        }
        async function initPageLoad() {
            await getHistoryPengajuan();
            await getListData();
            $('.filepond--credits').remove();
        }
    </script>
@endsection
