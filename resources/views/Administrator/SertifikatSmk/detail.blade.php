@extends('Administrator.index', ['title' => 'SMK-TD | Pengajuan Sertifikat SMK'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/js/libs/filepond/filepond.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/select2.min.css" />
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-pdf-preview/filepond-plugin-pdf-preview.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        #alertMessage:empty {
            display: none;
        }

        #interviewInformation:empty {
            display: none;
        }

        /* Default margin for request information */
        #requestInformation {
            margin-top: 0;
            /* Default margin */
        }

        /* Default margin for interview information */
        #interviewInformation {
            margin-top: 0;
            /* Default margin */
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/sertifikat/list">Sertifikat SMK</a></li>
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
                    </div>
                    <div class="row g-3">
                        <!-- Detail Pengajuan -->
                        <div class="col-12">
                            <div id="detailPengajuan"></div>
                        </div>

                        <!-- Surat Permohonan -->
                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Surat Permohonan</h5>
                                <div class="row">
                                    <p class="mb-0" id="numberOfApplicationLetter"><i
                                            class="fa-solid fa-file me-2"></i>SRT-242024</p>
                                    <p class="mb-0" id="dateOfApplicationLetter"><i
                                            class="fa-solid fa-calendar me-2"></i>12 Desember 2023</p>

                                    <a href="" id="application-letter-link" target="_blank">
                                        <p class="mb-0">
                                            <i class="fa-regular fa-file-pdf me-2"></i>Lihat Dokumen
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Informasi Pengguna -->
                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Jenis Pelayanan</h5>
                                <div style="max-height: 100px; overflow-y: auto; padding: 10px; border-radius: 5px;">
                                    <ul id="c_serviceTypeList" class="mb-3"
                                        style="margin: 0; padding: 0; list-style: none;">
                                        <!-- Hasil serviceTypes akan masuk di sini -->
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Informasi Pengguna</h5>
                                <p class="mb-0"><i class="fa-solid fa-user me-2"></i>Nama Pengguna: <b
                                        id="u_name">-</b></p>
                                <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i>Email: <b id="u_email">-</b>
                                </p>
                                <p class="mb-0"><i class="fa-solid fa-phone me-2"></i>No. Telepon: <b id="pic_phone">-</b>
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card">
                <div class="card-body">
                    <h3>Informasi Pengajuan</h3>
                    <div id="alertMessage" class="mb-4 rounded-lg border-0"></div>
                    <div id="interviewInformation" class="mb-4 rounded-lg border-0"></div>
                    <div id="requestInformation" class="shadow rounded-lg border-0"></div>
                </div>
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
                    <form id="fCreate">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                                aria-labelledby="analytics-tab-1" tabindex="0">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                </div>
                            </div>

                            <div class="mb-4 actionButton"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CONTENT --}}
    <div class="modal fade" id="full-content-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade form-dirjen" id="add-disposition" data-bs-keyboard="false" data-bs-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="justify-content: center;">
            <form id="fCreateAssessor" onsubmit="submitAssessor(event)">
                <div class="modal-content modal-form" style="min-width: 500px">
                    <div class="modal-header" style="border-bottom: 1px solid #e9ebec; padding: 1.25rem">
                        <h5 class="modal-title modal-form-dirjen-title">Disposisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label for="signer_id" class="form-label">Disposisi Ke :</label>
                            <select class="form-control form-select form-name" id="iAssessor" name="assessor"
                                required></select>
                            {{-- <div class="invalid-feedback" id="user_id_error"></div> --}}
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e9ebec; padding: 1rem">
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                <span class="flex-grow-1">Lanjutkan</span>
                            </span>
                        </button>

                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade form-dirjen" id="change-assessor-head" data-bs-keyboard="false" data-bs-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="justify-content: center;">
            <form id="fCreateAssessorHead" onsubmit="submitAssessorHead(event)">
                <div class="modal-content modal-form" style="min-width: 500px">
                    <div class="modal-header" style="border-bottom: 1px solid #e9ebec; padding: 1.25rem">
                        <h5 class="modal-title modal-form-dirjen-title">Ubah Ketua tim</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label for="signer_id" class="form-label">Ubah ketua tim Ke :</label>
                            <select class="form-control form-select form-name" id="iAssessorHeadChange"
                                name="assessor_head" required></select>
                            {{-- <div class="invalid-feedback" id="user_id_error"></div> --}}
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e9ebec; padding: 1rem">
                        <button type="submit" class="btn btn-primary" id="submitBtnKetua" disabled>
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                <span class="flex-grow-1">Lanjutkan</span>
                            </span>
                        </button>

                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- modal assessment validation -->
    <div class="modal fade modal-lg" id="request-validation" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="#" id="fCreateValidation" onsubmit="submitAssessmentValidation(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi Penilaian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5">
                        <div class="row align-items-center mb-2">

                            <span class="col-8">Apakah penilaian sesuai? </span>
                            <div class="col-4">
                                <div class="text-end">
                                    <input type="radio" class="btn-check" name="isValidAssessment"
                                        id="validAssessment" value="yes" required>
                                    <label class="btn btn-success" for="validAssessment">
                                        <span class="d-flex align-items-center gap-2 text-dark">
                                            <i class="fas fa-check" style="font-size: 16px;"></i>
                                            <span class="flex-grow-1">Iya</span>
                                        </span>
                                    </label>

                                    <input type="radio" class="btn-check" name="isValidAssessment"
                                        id="invalidAssessment" value="no" required>
                                    <label class="btn btn-danger" for="invalidAssessment">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="fas fa-times" style="font-size: 16px;"></i>
                                            <span class="flex-grow-1">Tidak</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="validationReason" style="height: 350px;" name="validation_notes" disabled></textarea>
                                    <!-- <label for="validationReason">Alasan</label> -->
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="wordCount">Terdapat 0 paragraf dan 0 kata</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer px-5">
                        <button type="submit" class="btn btn-primary btn-load waves-effect waves-light">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Simpan</span>
                            </span>
                        </button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>

            </form>
        </div>
    </div>
    </div>

    <!-- modal rejected assessment -->
    <div class="modal fade modal-lg" id="request-rejected" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="justify-content: center;">

            <form action="#" id="fCreateRejected">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control w-100" id="rejectedNotes" style="height: 350px;" name="rejected_note" required></textarea>
                                    <label for="rejectedNotes">Alasan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="submitBtnAlasan" class="btn btn-primary">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Simpan</span>
                            </span>
                        </button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- modal scheduling interview -->
    <div class="modal fade" id="scheduling-interview" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="#" id="fCreateScheduleInterview" onsubmit="submitSchedulingInterview(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Penjadwalan Verifikasi Lapangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5">
                        <div class="mb-3">

                            <div class="form-floating">
                                <select class="form-control d-block" id="iInterviewType" name="interview_type" required>
                                    <option value="">Pilih tipe wawancara</option>
                                    <option value="offline">Lapangan</option>
                                    <option value="online">Daring</option>
                                </select>
                                <label for="iInterviewType" class="form-label">Tipe wawancara</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control flatpickr-input" name="schedule"
                                    id="interview_date" placeholder="Tanggal wawancara" readonly="readonly">
                                <label for="interview_date" class="form-label">Waktu wawancara</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="iAssessorHead" class="form-label">Ketua Penilai</label>
                            <select class="form-control d-block" id="iAssessorHead" name="assessor_head" required>
                                <option value="">Pilih Ketua penilai</option>
                            </select>
                        </div>
                        <div>
                            <label for="iAssessors" class="form-label">Penilai</label>
                        </div>
                        <div class="mb-3">
                            <select class="form-control d-block" id="iAssessors" data-choices multiple>
                                <option placeholder value="">Pilih penilai</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer px-5">
                        <button type="submit" class="btn btn-primary btn-load waves-effect waves-light">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Simpan</span>
                            </span>
                        </button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>

            </form>
        </div>
    </div>
    </div>


    <!-- modal edit assessment interview -->
    <div class="modal fade" id="edit-assessment-interview" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="justify-content: center;">

            <form action="#" id="fEditAssessmentInterview" onsubmit="submitEditAssessmentInterview(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Verifikasi lapangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-5">
                        <div class="mb-3">
                            <b><u>Ubah Ketua Penilai dan atau Penilai untuk merubah data verifikasi lapangan.</u></b>
                        </div>

                        <div class="mb-3">

                            <div class="form-floating">
                                <select class="form-control d-block" id="iEditInterviewType" name="interview_type"
                                    required>
                                    <option value="">Pilih tipe wawancara</option>
                                    <option value="offline">Lapangan</option>
                                    <option value="online">Daring</option>
                                </select>
                                <label for="iEditInterviewType" class="form-label">Tipe wawancara</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control flatpickr-input" name="schedule"
                                    id="iEditInterview_date" placeholder="Tanggal wawancara" readonly="readonly"
                                    required>
                                <label for="iEditInterview_date" class="form-label">Waktu wawancara</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="iEditAssessorHead" class="form-label">Ketua Penilai</label>
                            <select class="form-control d-block" id="iEditAssessorHead" name="assessor_head" required>
                                <option placeholder value="">Pilih Ketua penilai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="iEditAssessors" class="form-label">Penilai</label>
                            <select class="form-control d-block" name="assessors" id="iEditAssessors" data-choice
                                multiple>
                                <option placeholder value="">Pilih penilai</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer px-5">
                        <button type="submit" class="btn btn-primary btn-load waves-effect waves-light">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Simpan</span>
                            </span>
                        </button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>

            </form>
        </div>
    </div>
    </div>

    <!-- modal Record of Verfication interview -->
    <div class="modal fade" id="create-record-of-verification" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createRoVLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoVLabel">Buat Berita Acara</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" id="fCreateRoV" onsubmit="submitCreateRoV(event)">
                        <div class="mb-4">
                            <label class="form-label" for="photos_of_event">Upload Foto Kegiatan</label>
                            <input type="file" class="filepond filepond-input-multiple photos_of_event"
                                id="photos_of_event" name="photos_of_event_show"
                                accept="image/jpeg, image/jpg, image/png" multiple data-max-file-size="5MB"
                                data-max-files="5"
                                data-file-validate-type-label="Hanya file gambar (JPEG/PNG) yang diperbolehkan"
                                data-file-validate-type-message="Tipe file tidak valid. Harap unggah file gambar."
                                required />
                            <input type="hidden" class="filepond" name="photos_of_event" id="photos_of_event_hide"
                                required />
                        </div>

                        <!-- Upload Foto Daftar Peserta -->
                        <div class="mb-4">
                            <label class="form-label" for="photos_of_attendance_list_show">Upload Foto Daftar
                                Peserta</label>
                            <input type="file" class="filepond filepond-input-multiple photos_of_attendance_list"
                                id="photos_of_attendance_list" data-allow-reorder="true"
                                accept="image/jpeg, image/jpg, image/png" multiple data-max-file-size="5MB"
                                data-max-files="5"
                                data-file-validate-type-label="Hanya file gambar (JPEG/PNG) yang diperbolehkan"
                                data-file-validate-type-message="Tipe file tidak valid. Harap unggah file gambar."
                                required />
                            <input type="hidden" class="filepond" name="photos_of_attendance_list"
                                id="photos_of_attendance_list_hide" required />
                        </div>


                        <!-- Footer Modal dengan Tombol Simpan dan Tutup -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-save" style="font-size: 16px;"></i>
                                    <span class="flex-grow-1">Simpan</span>
                                </span>
                            </button>
                            <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                                <span class="d-flex align-items-center gap-2">
                                    <i class="fas fa-times" style="font-size: 16px;"></i>
                                    <span class="flex-grow-1">Tutup</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show-record-of-verification" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createRoVLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showROVlabel">Berita Acara</h5>
                    <!-- Tombol close bawaan Bootstrap -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Isi modal -->
                </div>
                <div class="modal-footer">
                    <!-- Tombol tutup modal -->
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fas fa-times" style="font-size: 16px;"></i>
                            <span class="flex-grow-1">Tutup</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal upload certificate -->
    <div class="modal fade" id="create-pengajuan-selesai" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="#" id="formPengajuanSelesai" onsubmit="pengajuanSelesaiSubmit(event)">
                <div class="modal-content">
                    <div class="modal-header border-bottom p-3">
                        <h5 class="modal-title">Pengajuan Selesai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-3 px-5">
                        <div class="mb-3">
                            <label for="number_of_certificate" class="form-label">Nomor Sertifikat</label>
                            <input type="text" class="form-control" id="number_of_certificate"
                                name="number_of_certificate" placeholder="Nomor Sertifikat" required />
                        </div>

                        <div class="mb-3">
                            <label for="publish_date" class="form-label">Tanggal Rilis Sertifikat</label>
                            <input type="text" class="form-control" id="publish_date" name="publish_date"
                                placeholder="Tanggal Rilis Sertifikat" required />
                        </div>

                        <div class="mb-3">
                            <label for="certificate_file" class="form-label">Upload Sertifikat <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="certificate_file" name="certificate_file"
                                accept="application/pdf" data-max-file-size="5MB" required>
                        </div>

                        <div class="mb-3">
                            <label for="sk_file" class="form-label">Upload Surat Keputusan <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="sk_file" name="sk_file"
                                accept="application/pdf" data-max-file-size="5MB" required>
                        </div>

                        <div class="mb-3">
                            <label for="rov_file" class="form-label">Upload Berita Acara <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="rov_file" name="rov_file"
                                accept="application/pdf" data-max-file-size="5MB" required>
                        </div>

                        <div class="mb-3">
                            <label for="sign_by" class="form-label">Tanda Tangan Dirjen</label>
                            <select class="form-control form-select signby-name" id="sign_by" name="sign_by">
                            </select>
                            <div class="invalid-feedback" id="sign_by_error">
                            </div>
                        </div>

                        <p class="text-danger m-0 mt-4" style="font-size: 0.75rem">* Pastikan dokumen yang di unggah sudah
                            sesuai dengan ketentuan.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Simpan</span>
                            </span>
                        </button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- modal View of Document interview -->
    <div class="modal fade" id="view-document" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <embed class="view-document-print" src="" frameborder="0" width="100%" height="700px">
            </div>
        </div>
    </div>

    <!-- modal sign by dirjen to SK dirjen -->
    <div class="modal fade form-dirjen" id="modal-signby-dirjen" data-bs-keyboard="false" data-bs-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="justify-content: center;">
            <form id="form-signby-dirjen" onsubmit="NextStepSignbyDirector(event)">
                <div class="modal-content modal-form" style="min-width: 500px">
                    <div class="modal-header" style="border-bottom: 1px solid #e9ebec; padding: 1.25rem">
                        <h5 class="modal-title modal-form-dirjen-title">Tanda Tangan Dirjen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-3">
                        <div class="mb-3">
                            <label for="signer_id" class="form-label">Nama Dirjen</label>
                            <select class="form-control form-select form-name" id="signer_id" name="user_id"></select>
                            <div class="invalid-feedback" id="user_id_error"></div>
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: 1px solid #e9ebec; padding: 1rem">
                        <button type="submit" id="generate-sk-btn"
                            class="btn btn-primary btn-load waves-effect waves-ligh btn-form-dirjen-submit"
                            style="display: flex" disabled>
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Lanjutkan</span>
                            </span>
                        </button>

                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span class="d-flex align-items-center gap-2">
                                <i class="fas fa-times" style="font-size: 16px;"></i>
                                <span class="flex-grow-1">Tutup</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- modal to show comment -->
    <div class="modal fade" id="showCommentModal">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Catatan Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="dataCatatanVerifikasi"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

    <script src="{{ asset('assets/js/date/moment.js') }}"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.full.min.js"></script>
    <script src="{{ asset('assets') }}/js/select2/select2.min.js"></script>
    <script src="{{ asset('assets') }}/js/libs/filepond/filepond.min.js"></script>
    <script src="{{ asset('assets') }}/js/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
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
        let dataComment
        let historyData
        let smkElements
        let prevAssessmentSchema = {};
        let assessor
        let interviewDate
        let interviewType
        let interviewAssessorhead
        let interviewAssessors
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let id = urlParams.get('r');
        let currentUser = @json(request()->user['id']);



        async function getDetailData() {
            loadingPage(true);
            let response = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/detail`, {
                        id: id
                    }
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
                                <a class="accordion-button" href="#collapse${numberedElementKey}"
                                    data-bs-toggle="collapse"
                                    aria-expanded="true"
                                    aria-controls="collapse${numberedElementKey}"
                                    style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%); color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                    ${numbering}. ${questionSchema[elementKey]?.title || 'No Title'}
                                </a>
                            </h2>
                            <div id="collapse${numberedElementKey}" class="accordion-collapse collapse show" aria-labelledby="heading-${numberedElementKey}">
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
                            if (response.data.data.disposition_to?.id === currentUser) {
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
                                    const isReasonAvailable = prevAssessmentSchema[elementKey]?.[subElement[0]]
                                        ?.reason ? '' : 'disabled';

                                    assessmentReason = `
                                            <textarea class="form-control" id="reason_${elementKey}_${subElement[0]}" ${isReasonAvailable}>${processedReason}</textarea>
                                        `;
                                }
                            }
                        }


                        if (response.data.data.status === 'not_passed_assessment_verification') {
                            if (response.data.data.disposition_to && response.data.data.disposition_to.id ==
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
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${assessmentValue}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${assessmentReason}</td>
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
                // setTimeout(() => initializeAccordionIcons(), 0);

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
                    response.data.data.disposition_to, response.data.data.updated_at, response.data.data
                    .validation_notes, response.data.data);

                buildAnswerAsPDF();
                buildSubmitButton(isNeedSubmitButton);

                const applicationLetterData = {
                    'numberOfApplicationLetter': response.data.data.number_of_application_letter,
                    'dateOfApplicationLetter': response.data.data.date_of_application_letter,
                    'fileOfApplicationLetter': response.data.data.file_of_application_letter
                };

                // Masukkan tautan file ke elemen <a>
                const linkElement = document.getElementById('application-letter-link');
                if (applicationLetterData.fileOfApplicationLetter) {
                    linkElement.href = applicationLetterData.fileOfApplicationLetter; // Mengatur URL file
                    linkElement.style.display = 'block'; // Pastikan link terlihat
                } else {
                    linkElement.style.display = 'none'; // Sembunyikan jika tidak ada file
                }


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

        async function getRequestHistory() {
            loadingPage(true);

            const getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/history`, {
                        id: id
                    }
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
                return getDataRest.data.data
            } else {
                const errorMessage = getDataRest?.data?.message || 'Data tidak ditemukan.';
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                return null; // Jika respons tidak sesuai, kembalikan null
            }
        }


        function countAssessment(answerData, assessmentData) {
            let totalDocument = 0,
                passedDocument = 0,
                notPassedDocument = 0,
                percentagePassed = 0;

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
            window.open(loc)
        }

        function buildAnswerAsPDF() {
            $('.pdf-preview').each(function() {
                PDFObject.embed(`${$(this).attr('location')}`, `#${$(this).attr('id')}`, {
                    height: '32em',
                    width: '50em'
                });
            })
        }

        async function loadServiceTypes(id = "#c_serviceType", selectedTypes = []) {
            $(id).select2({
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                ajax: {
                    url: '{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/serviceType',
                    dataType: 'json',
                    delay: 500,
                    headers: {
                        Authorization: `Bearer ${Cookies.get('auth_token')}`
                    },
                    processResults: function(res) {
                        let data = res.data;
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                };
                            })
                        };
                    },
                },
                allowClear: true,
                placeholder: 'Pilih Pelayanan',
                closeOnSelect: true,
            });

            // Tambahkan opsi default untuk `selectedTypes`
            if (selectedTypes.length > 0) {
                selectedTypes.forEach(type => {
                    // Tambahkan opsi secara manual ke Select2
                    let option = new Option(type.name, type.id, true, true);
                    $(id).append(option).trigger('change');
                });
            }
        }


        // function initializeAccordionIcons() {
        //     document.querySelectorAll('.accordion-item').forEach(item => {
        //         const collapseElement = item.querySelector('.accordion-collapse');
        //         const button = item.querySelector('.accordion-btn');
        //         const icon = button.querySelector('.toggle-icon');

        //         // Event listener untuk saat accordion dibuka
        //         collapseElement.addEventListener('shown.bs.collapse', () => {
        //             icon.classList.remove('fa-plus');
        //             icon.classList.add('fa-minus');
        //         });

        //         // Event listener untuk saat accordion ditutup
        //         collapseElement.addEventListener('hidden.bs.collapse', () => {
        //             icon.classList.remove('fa-minus');
        //             icon.classList.add('fa-plus');
        //         });
        //     });
        // }

        async function getAssessmentInterview(id) {
            let response;
            try {
                loadingPage(true);
                const getDataRest = await CallAPI('GET',
                    '{{ url('') }}/api/internal/admin-panel/jadwal/getJadwal', {
                        id: id
                    });

                response = getDataRest.data;
            } catch (error) {
                loadingPage(false);
                console.error('Error fetching assessment interview data:', error);
                return;
            }

            // Return the fetched response
            return response;
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

        async function mappingInterviewCard(status, schedule, interviewType, assessorHead, assessors) {
            let $assessorsHtml = '';
            let canEdit = false;

            // Check if the current user can edit
            if (assessorHead.id !== null) {
                canEdit = true;
            }

            assessors.forEach((assessor, index) => {
                if (currentUser === assessor.id) {
                    canEdit = true;
                }

                $assessorsHtml +=
                    `<div class="d-flex justify-content-between assessor_interview_row mb-2">
                    <h6 class="fw-bold">Penilai ${index + 1}:</h6>
                    <span class="fw-normal" id="i_assessor_${index}">${assessor.name}</span>
                </div>`;
            });

            // Generate interview details with consistent spacing
            let $informationTemplate =
                `<div class="row mb-2">
                    <div class="col-6">
                        <h6 class="fw-bold">Jadwal Wawancara:</h6>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-normal" id="i_schedule">${formatTanggalIndo(schedule)}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <h6 class="fw-bold">Tipe Wawancara:</h6>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-normal" id="i_type">${interviewType === 'offline' ? 'Kunjungan lapangan' : interviewType}</span>
                    </div>
                </div>
                <div class="row mb-2" id="interview_assessor_head_row">
                    <div class="col-6">
                        <h6 class="fw-bold">Ketua Penilai:</h6>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-normal" id="i_assessorHead">${assessorHead.name}</span>
                    </div>
                </div>

            ${$assessorsHtml}`;

            // Add action buttons depending on the status and permissions
            let editButton = '';
            if (status === 'scheduled_interview' && canEdit) {
                editButton =
                    `<button class="btn btn-primary w-100 mt-2"
                    type="button"
                    onClick="showEditAssessmentInterview()">
                    Ubah Data
                </button>`;
            }

            let rovButton = '';
            if (canEdit && ['scheduling_interview', 'scheduled_interview'].includes(status)) {
                rovButton =
                    `<button class="btn btn-success w-100 mt-2"
                    type="button"
                    onClick="showCreateRecordOfVerification()">
                    Buat Berita Acara
                </button>`;
            }

            if (status === 'completed_interview') {
                rovButton =
                    `<div class="d-flex flex-column">
                    <div class="d-flex">
                        <button class="btn btn-primary w-100 mt-2 me-2" type="button" onClick="showPrintRecordOfVerification()">
                            <i class="fas fa-file-alt align-bottom me-2"></i> Cetak BA
                        </button>
                        <button class="btn btn-info w-100 mt-2 text-white" type="button" onClick="lihatBeritaAcara()">
                            <i class="fas fa-eye align-bottom me-2"></i> Lihat BA
                        </button>

                    </div>
                    <button class="btn btn-primary w-100 mt-2" type="button" id="btn_generate_sk" onClick="signByDirector()">
                        <i class="fas fa-print me-2"></i> Cetak SK
                    </button>
                    <button class="btn btn-success w-100 mt-2 text-light" type="button" onClick="pengajuanSelesai()">
                        <i class="fas fa-folder-open align-bottom me-2"></i> Pengajuan Selesai
                    </button>
                </div>

                `;
            }

            // Combine the interview information and action buttons into the final template
            let $template =
                `<div class="invoice-box p-4 rounded shadow" style="background-color: #ffffff; color: #333;">
                ${$informationTemplate}
                ${editButton}
                ${rovButton}
            </div>`;

            // Append the generated template to the container
            $('#interviewInformation').html($template);
            adjustLayout();
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

        function buildActionByRequestStatus(requestStatus, assessmentStatus, dispositionTo, dispositionBy) {
            let alertMessage, actionButton, htmlReject = '',
                isShowAlert = false
            // console.log(assessmentStatus)
            // action for disposition
            if ((requestStatus === 'request' || requestStatus === 'submission_revision') && dispositionTo === null) {
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
                        `<button type="button" class="btn btn-primary mt-3" style="font-weight: 600; width: 100%;" onClick="showDispositionBy('${dispositionBy?.id}')">
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
                    `<button type="button" class="btn btn-primary" style="font-weight: 600; width: 100%;" onClick="showDisposition('${dispositionTo?.id}')">
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

                console.log(dispositionBy)
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
                        </button>
                        `
                } else {
                    actionButton = '';
                }

                isShowAlert = true
            }

            if (isShowAlert) {
                let $template = `
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                ${actionButton ? `<div class="mb-2">${actionButton}</div>` : ''}
                                ${htmlReject ? `<div>${htmlReject}</div>` : ''}
                            </div>
                        </div>

                `;
                $('#alertMessage').append($template);
            }

        }

        function adjustLayout() {
            const alertMessage = document.getElementById('alertMessage');
            const interviewInformation = document.getElementById('interviewInformation');
            const requestInformation = document.getElementById('requestInformation');

            const isAlertMessageEmpty = !alertMessage.innerHTML.trim();
            const isInterviewInformationEmpty = !interviewInformation.innerHTML.trim();

            // Hide alertMessage if empty and move interviewInformation up
            if (isAlertMessageEmpty) {
                alertMessage.classList.add('hidden');
                interviewInformation.classList.add('top');
            }

            // Hide interviewInformation if empty and move requestInformation up
            if (isInterviewInformationEmpty) {
                interviewInformation.classList.add('hidden');
                requestInformation.classList.add(isAlertMessageEmpty ? 'top' : 'moved-up');
            }

            // If both alertMessage and interviewInformation are empty, move requestInformation to the top
            if (isAlertMessageEmpty && isInterviewInformationEmpty) {
                requestInformation.classList.add('top');
            }
        }



        function mappingCompanyInformation(data) {
            let serviceTypes = '';
            data.company.service_types.forEach((serviceType) => {
                serviceTypes += `<li>${serviceType.name}</li>`;
            });

            // const fileUrl = data.company?.nib_file;

            // if (fileUrl) {
            //     const splitFileURL = fileUrl.split('/');
            //     const fileName = splitFileURL[splitFileURL.length - 1];
            //     const fileExtension = fileUrl.substring(fileUrl.lastIndexOf('.'));
            // }

            // let nibPreview = '';
            // const imageType = ['.jpeg', '.jpg', '.png'];
            // if (imageType.includes(fileExtension)) {
            //     nibPreview = `<img class="img-fluid" src="${fileUrl}"/>`;
            // }

            const mappingStatusToReadable = {
                'assessment_revision': 'Revisi Penilaian',
                'passed_assessment_verification': 'Verifikasi Penilaian Lulus',
                'scheduling_interview': 'Penjadwalan Wawancara',
                'scheduled_interview': 'Wawancara Terjadwal',
                'not_passed_interview': 'Wawancara Tidak Lulus',
                'completed_interview': 'Wawancara Selesai',
                'verification_director': 'Verifikasi Direktur',
                'certificate_validation': 'Validasi Sertifikat',
                'rejected': 'Ditolak',
                'cancelled': 'Dibatalkan',
                'expired': 'Kedaluwarsa',
                'draft': 'Draf',
                'request': 'Permintaan',
                'disposition': 'Disposisi',
                'not_passed_assessment': 'Penilaian Tidak Lulus',
                'passed_assessment': 'Penilaian Lulus',
                'submission_revision': 'Revisi Pengajuan',
                'not_passed_assessment_verification': 'Verifikasi Penilaian Tidak Lulus',
                'active': 'Aktif',
                'inactive': 'Tidak Aktif',
                'pending': 'Menunggu Persetujuan'
            };

            const statusColorMapping = {
                'assessment_revision': 'warning',
                'passed_assessment_verification': 'success',
                'scheduling_interview': 'info',
                'scheduled_interview': 'primary',
                'not_passed_interview': 'danger',
                'completed_interview': 'success',
                'verification_director': 'info',
                'certificate_validation': 'primary',
                'rejected': 'danger',
                'cancelled': 'secondary',
                'expired': 'dark',
                'draft': 'secondary',
                'request': 'info',
                'disposition': 'primary',
                'not_passed_assessment': 'danger',
                'passed_assessment': 'success',
                'submission_revision': 'warning',
                'not_passed_assessment_verification': 'danger',
                'active': 'success',
                'inactive': 'danger',
                'pending': 'warning'
            };

            // Tentukan warna berdasarkan status
            const statusColor = statusColorMapping[data.status] || 'secondary';

            // Update elemen c_color
            $('#c_color').html(`
                <div
                    class="wid-60 hei-60 rounded-circle bg-${statusColor} d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-building text-white fa-2x"></i>
                </div>
            `);

            // Update elemen c_status
            $('#c_status').html(`
                <span class="badge bg-${statusColor}">${mappingStatusToReadable[data.status] || 'Status Tidak Diketahui'}</span>
            `);

            // Update informasi lainnya
            $('#c_name').text(`${data.company.name} |`);
            $('#c_nib').text('NIB : ' + data.company.nib);
            $('#c_address').text(
                `${data.company.address || "-"} ${data.company.city.name} ${data.company.province.name}`
            );
            $('#c_phone').html(`<i class="fa-solid fa-phone me-1"></i> ${data.company.company_phone_number}`);
            $('#c_email').html(`<i class="fa-regular fa-envelope me-1"></i> ${data.company.email}`);

            // PIC
            $('#pic_name').html(`<i class="fa-solid fa-user me-2"></i>${data.company.pic_name}`);
            $('#pic_phone').html(`${data.company.pic_phone}`);
            // User
            $('#u_name').html(`${data.company.username ?? '-'}`);
            $('#u_phone').html(`${data.company.phone_number ?? '-'}`);
            $('#u_email').html(`${data.company.email ?? '-'}`);
            $('#request_date').html(
                `<i class="fa-solid fa-calendar-day me-2"></i>${moment(data.company.request_date).format('D/MM/YYYY')}`);

            // Disposisi
            $('#internal').text(data?.disposition_by?.name || "-");
            $('#penilai').text(data?.disposition_to?.name || "-");

            $('#tanggal_diperbarui').text(moment(data.updated_at).format('D/MM/YYYY'));
            $('#numberOfApplicationLetter').html(`
                    <i class="fa-solid fa-file me-2"></i>${data.number_of_application_letter}`);
            $('#dateOfApplicationLetter').html(
                `
                 <i class="fa-solid fa-calendar me-2"></i>${moment(data.date_of_application_letter).format('D/MM/YYYY')}`
            );

            $('#c_serviceTypeList').append(serviceTypes);
            $('#current_preview').text(data.company.id);
            $('#establish_date').text(data.company.establish ? moment(data.company.establish).format('D/MM/YYYY') : '-');
        }

        async function mappingCertificateRequestCard(status, dispositionBy, dispositionTo, updateAt, validationReason,
            data) {
            dataComment = '';
            rowDispositionBy = '';
            rowDispositionTo = '';
            rowValidationReason = '';
            rowStatus = '';
            let serviceTypeValidation = '';

            console.log(dispositionBy)

            const mappingStatusToReadable = {
                'assessment_revision': 'Revisi Penilaian',
                'passed_assessment_verification': 'Verifikasi Penilaian Lulus',
                'scheduling_interview': 'Penjadwalan Wawancara',
                'scheduled_interview': 'Wawancara Terjadwal',
                'not_passed_interview': 'Wawancara Tidak Lulus',
                'completed_interview': 'Wawancara Selesai',
                'verification_director': 'Verifikasi Direktur',
                'certificate_validation': 'Validasi Sertifikat',
                'rejected': 'Ditolak',
                'cancelled': 'Dibatalkan',
                'expired': 'Kedaluwarsa',
                'draft': 'Draf',
                'request': 'Permintaan',
                'disposition': 'Disposisi',
                'not_passed_assessment': 'Penilaian Tidak Lulus',
                'passed_assessment': 'Penilaian Lulus',
                'submission_revision': 'Revisi Pengajuan',
                'not_passed_assessment_verification': 'Verifikasi Penilaian Tidak Lulus'
            };
            rowUpdatedAt = `
                <div class="row">
                    <span class="col-5">Terakhir diperbarui :</span>
                    <span class="col-7">${formatTanggalIndo(updateAt)}</span>
                </div>`;

            rowProcessBy = `
                <div class="row align-items-center">
                    <span class="col-5">Dibutuhkan Aksi :</span>
                    <div class="col-7 d-flex align-items-center">
                        <span class="text-danger fw-bold me-2">${mappingProcessByV2(status, dispositionBy)}</span>
                    </div>
                </div>`;

            if (dispositionTo?.name) {
                rowDispositionTo = `
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Dispo ke:</span>
                        <span class="col-7">${dispositionTo?.name}</span>
                    </div>`;
            }

            if ((validationReason || validationReason !== '') && status !== 'scheduled_interview') {
                dataComment = validationReason;

                buttonComment = validationReason ?
                    `<a href="javascript:void(0);" class="btn btn-sm btn-info" id="btnShowModalValidationReason">Tampilkan catatan</a>` :
                    '-';

                rowValidationReason = `
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Catatan verifikasi:</span>
                        <span class="col-7">${buttonComment}</span>
                    </div>`;
            }
            const existingServiceTypes = data.company.service_types || [];
            if ((status !== 'disposition' || status !== 'not_passed_assessment_verification') && dispositionTo?.id !==
                currentUser) {
                serviceTypeValidation = ``;
            } else {

                serviceTypeValidation = `
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Jenis Pelayanan:</span>
                        <span class="col-7">
                            <select class="form-control select2" multiple
                            name="c_serviceType" id="c_serviceType"
                            required></select></span>
                    </div>`;
            }


            detailPengajuan = `
                <div class="border rounded p-3 w-100">
                    <h5>Detail Pengajuan</h5>
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Dispo oleh:</span>
                        <span class="col-7">${dispositionBy || '-'}</span>
                    </div>
                    ${rowDispositionTo}
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Diperbarui:</span>
                        <span class="col-7">${formatTanggalIndo(updateAt)}</span>
                    </div>
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Dibutuhkan Aksi:</span>
                        <span class="col-7 text-primary fw-bold">${mappingProcessByV2(status, dispositionBy)}</span>
                    </div>
                    ${rowValidationReason}
                    <div class="row mb-2">
                        <span class="col-5 fw-bold">Status:</span>
                        <span class="col-7">${mappingStatusToReadable[status] || status}</span>
                    </div>
                    ${serviceTypeValidation}
                </div>`;

            $('#detailPengajuan').html(detailPengajuan)


            let uniqueId = `requestInfo-${status}-${Date.now()}`;

            // Template for the task list
            let taskListTemplate = `
                <div class="card mb-4" id="${uniqueId}" style="border: none;">
                    <div class="task-card p-3" style="max-height: 400px; overflow-y: auto;">
                        <h5 class="mb-3">Riwayat Pengajuan</h5>
                        <ul class="list-unstyled task-list" id="taskList-${uniqueId}" style="list-style: none; padding: 0; max-height: 210px; overflow-y: auto;">
                            <!-- Task items will be appended here -->
                        </ul>
                    </div>
                </div>
            `;


            // Append the task list template to the container
            $('#requestInformation').append(taskListTemplate);

            // Load request history data and render it
            let historyData = await getRequestHistory();

            let taskListElement = document.querySelector(`#taskList-${uniqueId}`);
            let prevDate;

            const mappingAssessmentStatusV2 = {
                "request": {
                    text: "Permintaan Diajukan",
                    icon: "📩", // Ikon amplop untuk permintaan
                    color: "primary" // Warna biru untuk permintaan
                },
                "passed_assessment": {
                    text: "Penilaian Lulus",
                    icon: "✅", // Ikon centang hijau untuk lulus penilaian
                    color: "success" // Warna hijau untuk lulus penilaian
                },
                "passed_assessment_verification": {
                    text: "Verifikasi Penilaian Lulus",
                    icon: "🔍", // Ikon kaca pembesar untuk verifikasi
                    color: "success" // Warna oranye untuk verifikasi
                },
                "submission_revision": {
                    text: "Revisi Pengajuan",
                    icon: "✏️", // Ikon pensil untuk revisi
                    color: "secondary" // Warna merah untuk revisi
                },
                "rejected": {
                    text: "Pengajuan Ditolak",
                    icon: "❌", // Ikon silang merah untuk ditolak
                    color: "danger" // Warna merah gelap untuk penolakan
                },
                // Status tambahan
                "assessment_revision": {
                    text: "Revisi Penilaian",
                    icon: "✏️", // Ikon pensil untuk revisi
                    color: "secondary" // Warna merah untuk revisi penilaian
                },
                "scheduling_interview": {
                    text: "Penjadwalan Wawancara",
                    icon: "📅", // Ikon kalender untuk penjadwalan wawancara
                    color: "primary" // Warna ungu untuk penjadwalan
                },
                "scheduled_interview": {
                    text: "Wawancara Terjadwal",
                    icon: "📆", // Ikon kalender terjadwal
                    color: "primary" // Warna biru gelap untuk wawancara terjadwal
                },
                "not_passed_interview": {
                    text: "Wawancara Tidak Lulus",
                    icon: "❌", // Ikon silang merah untuk tidak lulus
                    color: "danger" // Warna merah gelap untuk wawancara gagal
                },
                "completed_interview": {
                    text: "Wawancara Selesai",
                    icon: "🎤", // Ikon mikrofon untuk wawancara selesai
                    color: "success" // Warna hijau untuk wawancara selesai
                },
                "verification_director": {
                    text: "Verifikasi Direktur",
                    icon: "🕴️", // Ikon orang berjas untuk direktur
                    color: "primary" // Warna abu-abu untuk verifikasi direktur
                },
                "certificate_validation": {
                    text: "Validasi Sertifikat",
                    icon: "📜", // Ikon sertifikat untuk validasi
                    color: "success" // Warna hijau toska untuk validasi sertifikat
                },
                "cancelled": {
                    text: "Dibatalkan",
                    icon: "🚫", // Ikon tanda larangan untuk dibatalkan
                    color: "danger" // Warna abu-abu untuk pembatalan
                },
                "expired": {
                    text: "Kedaluwarsa",
                    icon: "⏳", // Ikon jam pasir untuk kedaluwarsa
                    color: "danger" // Warna abu-abu terang untuk kedaluwarsa
                },
                "draft": {
                    text: "Draf",
                    icon: "📝", // Ikon catatan untuk draf
                    color: "secondary" // Warna abu-abu muda untuk draf
                },
                "disposition": {
                    text: "Disposisi",
                    icon: "📜", // Ikon dokumen untuk disposisi
                    color: "sencondary" // Warna oranye untuk disposisi
                },
                "not_passed_assessment": {
                    text: "Penilaian Tidak Lulus",
                    icon: "❌", // Ikon silang merah untuk tidak lulus penilaian
                    color: "danger" // Warna merah untuk penilaian tidak lulus
                },
                "not_passed_assessment_verification": {
                    text: "Verifikasi Penilaian Tidak Lulus",
                    icon: "🚫", // Ikon larangan untuk tidak lulus verifikasi penilaian
                    color: "danger" // Warna merah untuk tidak lulus verifikasi
                }
            };

            if (Array.isArray(historyData)) {
                historyData.forEach((requestHistory) => {
                    const currentDate = moment
                        .utc(requestHistory["created_at"])
                        .utcOffset("+07:00");

                    let durationMinutes = 0;
                    if (prevDate) {
                        durationMinutes = currentDate.diff(prevDate, "minutes");
                    }

                    const statusInfo = mappingAssessmentStatusV2[requestHistory["status"]] || {
                        text: "Status Tidak Diketahui",
                        icon: "❓",
                        color: "secondary"
                    };

                    const taskItem = `
                        <li>
                            <i class="task-icon bg-${statusInfo.color}"></i>

                            <h6 class="fw-bold mb-1">${statusInfo.icon} ${statusInfo.text}</h6>

                            <p class="text-muted mb-0">${currentDate.format("D MMM YYYY HH:mm")}</p>
                                ${
                                    durationMinutes > 0
                                        ? `<p class="text-muted small">Durasi: ${convertMinutesToDhhmm(durationMinutes)}</p>`
                                        : ""
                                }
                        </li>
                    `;

                    taskListElement.insertAdjacentHTML("beforeend", taskItem);
                    prevDate = currentDate;
                });
            } else {
                console.error("History data is not an array", historyData);
            }

            loadServiceTypes('#c_serviceType', existingServiceTypes)
        }

        function mappingColumnOfRow(
            subElementSchema,
            status,
            numberColumn) {
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
            numberOfColumn) {
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
            console.log(isNeedSubmitButton)
            // condition to show submit button
            $templateButton = ''

            if (isNeedSubmitButton) {
                $templateButton = `
            <div class="row justify-content-md-center">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" style="width:100%;">
                        <i class="fas fa-paper-plane align-middle lh-1" style="margin-right:8px;"></i>Kirim pengajuan
                    </button>
                </div>
            </div>
            `
            }

            $('.actionButton').append($templateButton)
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
        $form.addEventListener("submit", (e) => {
            e.preventDefault();

            const formParsley = $('#fCreate').parsley();

            formParsley.validate();

            if (!formParsley.isValid()) return false;

            loadingPage(true);

            let assessmentSchema = buildAssessmentSchema();

            // Ambil nilai-nilai dari Select2 dan konversi ke integer
            let selectedServices = $('#c_serviceType').val().map(value => parseInt(value,
                10)); // Konversi ke integer

            let formData = {
                element_properties: smkElements,
                answers: answerSchema,
                assessments: assessmentSchema.schema,
                status: assessmentSchema.status,
                service_types: selectedServices // Tambahkan data dari #c_serviceType
            };

            updateCertificateRequest(formData, 'Berhasil Memberikan Penilaian');
        });


        function buildAssessmentSchema() {
            let elements = {},
                nextStatus = 'not_passed_assessment'; // Default status
            let totalSubElements = 0, // Total semua sub-element
                emptyReasonCount = 0; // Total sub-element dengan reason kosong

            // Iterasi melalui smkElements.max_assesment
            $.each(smkElements.max_assesment, function(elementKey, elementValue) {
                const rowData = {};

                $.each(elementValue, function(subElementKey) {
                    totalSubElements++; // Hitung total sub-element
                    let reasonValue = $(`#reason_${elementKey}_${subElementKey}`).val();

                    // Jika reason kosong (null atau empty string), tambahkan ke counter
                    if (!reasonValue) {
                        emptyReasonCount++;
                    }

                    rowData[subElementKey] = {
                        value: $(`#value_${elementKey}_${subElementKey}`).val() ||
                            prevAssessmentSchema[elementKey][subElementKey]['value'],
                        reason: reasonValue
                    };
                });

                elements[elementKey] = rowData;
            });

            // Hitung persentase alasan kosong
            const emptyReasonPercentage = (emptyReasonCount / totalSubElements) * 100;

            if (emptyReasonPercentage >= 40) {
                nextStatus = 'passed_assessment';
            }

            return {
                schema: elements,
                status: nextStatus,
            };
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

        function showConfirmationRejectRequest() {
            $('#request-rejected').modal('show')
        }
        async function showCreateRecordOfVerification() {
            renderListAssessor('iEditAssessorHead', 'Ketua Tim', interviewAssessorhead.id)

            await $('#create-record-of-verification').modal('show')
        }



        async function showViewDocument(loc) {

            // $('.view-document-print').attr('src', loc);
            //             await $('#view-document').modal('show');
            $.ajax({
                url: "{{ url('') }}/api/internal/admin-panel/laporan-tahunan/getView",
                method: 'GET',
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

        // MODAL SECTION
        async function showDisposition(id = '') {
            loadingPage(true);

            await renderListAssessor('iAssessor', 'Assessor', id);
            await Swal.close();

            // Show the modal
            $('#add-disposition').modal('show');

            const assessorSelect = document.querySelector('#iAssessor');
            const submitBtn = document.querySelector('#submitBtn');

            // Disable/enable submit button based on selection
            assessorSelect.addEventListener('change', function() {
                submitBtn.disabled = !assessorSelect.value;
            });
            // Validate form when modal is submitted
            document.querySelector('#add-disposition').addEventListener('submit', function(e) {
                if (!assessorSelect.value) {
                    assessorSelect.setCustomValidity('Silakan pilih penilai.');
                } else {
                    assessorSelect.setCustomValidity('');
                }

                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                this.classList.add('was-validated');
            }, false);

            $('#add-disposition').on('hidden.bs.modal', function() {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            });
        }
        async function showDispositionBy(id = '') {
            loadingPage(true);

            renderListAssessor('iAssessorHeadChange', 'Ketua Tim', id);
            await Swal.close();

            // Show the modal
            $('#change-assessor-head').modal('show');

            const assessorSelect = document.querySelector('#iAssessorHeadChange');
            const submitBtn = document.querySelector('#submitBtnKetua');

            // Disable/enable submit button based on selection
            assessorSelect.addEventListener('change', function() {
                submitBtn.disabled = !assessorSelect.value;
            });

            // Validate form when modal is submitted
            const form = document.querySelector('#fCreateAssessorHead');
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Add validation
                if (!assessorSelect.value) {
                    assessorSelect.setCustomValidity('Silakan pilih Ketua Tim.');
                } else {
                    assessorSelect.setCustomValidity('');
                }

                // Check validity and handle submission if valid
                if (form.checkValidity()) {
                    form.classList.remove('was-validated');
                } else {
                    form.classList.add('was-validated');
                }
            });
        }

        async function showAssessmentValidation() {

            await $('#request-validation').modal('show')
        }

        async function pengajuanSelesai() {
            $("#create-pengajuan-selesai").modal("show");

            flatpickr("#publish_date", {
                altInput: true,
                dateFormat: "YYYY-MM-DD",
                altFormat: "DD MMMM YYYY",
                parseDate: (datestr, format) => moment(datestr, format, true).toDate(),
                formatDate: (date, format) => moment(date).format(format),
            });

            $("#certificate_file,#sk_file,#rov_file").on("change", async function(e) {
                loadingPage(true)
                const id = $(`#${$(this).attr("id")}`);
                const formFile = new FormData();

                formFile.append("file", id.prop("files")[0]);

                const response = await fetch(
                    "{{ url('') }}/api/internal/admin-panel/upload-file", {
                        method: "POST",
                        body: formFile,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            Accept: "application/json",
                            Authorization: `Bearer ${Cookies.get('auth_token')}`

                        },
                    });

                if (response.ok) {
                    loadingPage(false)
                    const data = await response.json();
                    id.attr("data-value", data.file_url || "");
                } else {
                    loadingPage(false)
                    id.attr("data-value", "");
                }
            });

            const response = await CallAPI(
                "GET",
                `{{ url('') }}/api/internal/admin-panel/signer`
            );

            if (response.status == 200) {
                loadingPage(false)
                $(".signby-name").html(`
                <option value="" selected disabled>Silahkan pilih</option>
                ${response.data.data
                    .map(
                        (data) =>
                            `<option value="${data.id}">${data.name}</option>`
                    )
                    .join(" ")}
            `);
            }
        }


        // ASSESSOR SECTION
        async function renderListAssessor(sourceElement, role, selectedValue = []) {
            const element = document.getElementById(`${sourceElement}`);
            const assessrOpt = new Choices(element, {
                placeholder: 'Pilih penilai',
                removeItemButton: true,
                maxItemCount: 2
            });

            await assessrOpt.setChoices(async () => {
                const items = await getAssessorList('', role);
                let isItems = [];
                let isSelected = false;
                let arraySelect = [];

                if (Array.isArray(items)) {
                    if (Array.isArray(selectedValue)) {
                        if (role == 'Ketua Tim') {
                            arraySelect = Object.values(selectedValue);
                        }
                        if (role != 'Ketua Tim') {
                            arraySelect = selectedValue.map(item => item.id);
                        }
                    }

                    items.map((item) => {
                        isSelected = arraySelect.includes(item.id);
                        isItems.push({
                            value: item.id,
                            label: item.name,
                            selected: isSelected
                        });
                    });

                    return isItems;
                } else {
                    console.error('Items is not an array', items);
                    return [];
                }
            });

            if (selectedValue.length > 0) {
                await assessrOpt.setChoiceByValue(selectedValue);
            }

            // Check to enable or disable the save button based on selected values
            element.addEventListener('change', function() {
                $('#fEditAssessmentInterview button[type="submit"]').prop(
                    'disabled',
                    !$('#iEditAssessorHead').val() && !$('#iEditAssessors').val().length
                );
            });

            $("#edit-assessment-interview, #scheduling-interview, #add-disposition, #change-assessor-head").on(
                "hidden.bs.modal",
                function() {
                    assessrOpt.destroy();
                });
        }

        async function showEditAssessmentInterview() {
            $('#iEditInterviewType').val(interviewType).change();
            scheduleEdit.setDate(moment(interviewDate).format('YYYY-MM-DD'));
            renderListAssessor('iEditAssessorHead', 'Ketua Tim', interviewAssessorhead);
            renderListAssessor('iEditAssessors', 'Assessor', interviewAssessors);

            await $('#edit-assessment-interview').modal('show');
            $('#fEditAssessmentInterview button[type="submit"]').prop('disabled', !$('#iEditAssessorHead').val() && !$(
                '#iEditAssessors').val().length);


        }

        async function lihatBeritaAcara() {
            loadingPage(true);
            let getDataRest = await CallAPI(
                'GET',
                '{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/show-record-of-vertification', {
                    id: id
                }
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest.status === 200) {
                loadingPage(false);

                let data = getDataRest.data.data;

                let attendancePhotoUrls = data.photos_of_attendance_list || [];
                let eventPhotoUrls = data.photos_of_event || [];

                let modalBody = document.querySelector("#show-record-of-verification .modal-body");

                // Membuat struktur tab
                modalBody.innerHTML = `
            <ul class="nav nav-tabs" id="photoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="event-photos-tab" data-bs-toggle="tab" data-bs-target="#event-photos" type="button" role="tab" aria-controls="event-photos" aria-selected="true">Foto Kegiatan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="attendance-photos-tab" data-bs-toggle="tab" data-bs-target="#attendance-photos" type="button" role="tab" aria-controls="attendance-photos" aria-selected="false">Foto Kehadiran</button>
                </li>
            </ul>
            <div class="tab-content" id="photoTabsContent">
                <div class="tab-pane fade show active" id="event-photos" role="tabpanel" aria-labelledby="event-photos-tab"></div>
                <div class="tab-pane fade" id="attendance-photos" role="tabpanel" aria-labelledby="attendance-photos-tab"></div>
            </div>
        `;

                // Menambahkan konten gambar ke tab
                let eventPhotosContainer = document.getElementById("event-photos");
                let attendancePhotosContainer = document.getElementById("attendance-photos");

                eventPhotosContainer.innerHTML = eventPhotoUrls.map((url) => `
                    <a href="${url}" target="_blank">
                        <img src="${url}" alt="Foto Kegiatan" style="width: 100%; max-height: 100vh; object-fit: contain; margin-bottom: 15px;" />
                    </a>
                `).join("");

                attendancePhotosContainer.innerHTML = attendancePhotoUrls.map((url) => `
                    <a href="${url}" target="_blank">
                        <img src="${url}" alt="Foto Kehadiran" style="width: 100%; max-height: 100vh; object-fit: contain; margin-bottom: 15px;" />
                    </a>
                `).join("");

                // Inisialisasi modal setelah konten dimuat
                const myModal = new bootstrap.Modal(document.getElementById('show-record-of-verification'));
                myModal.show();

                // Opsi untuk mengganti ikon X dengan ikon download
                FilePond.setOptions({
                    fileActionButtons: {
                        removeItem: {
                            label: "Download",
                            icon: '<i class="fa fa-download"></i>',
                            action: (file) => window.open(file.getMetadata("downloadUrl"), "_blank"),
                        },
                    },
                });
            }
        }

        async function submitEditAssessmentInterview(e) {
            e.preventDefault();

            const $form = $('#fEditAssessmentInterview'),
                formParsley = $form.parsley(),
                formObject = {};

            formParsley.validate();

            if (!formParsley.isValid()) return false;

            loadingPage(true);

            const formArrayData = $form.serializeArray();
            formArrayData.forEach(function(item) {
                formObject[item.name] = item.value;
            });

            const assessorSelect = document.getElementById('iEditAssessors');
            const assessors = [];

            for (const option of assessorSelect.options) {
                if (option.selected) {
                    assessors.push(option.value);
                }
            }

            formObject['assessors'] = assessors;
            try {
                const postData = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/internal/admin-panel/jadwal/updateJadwal`, {
                        id: id,
                        ...formObject
                    }
                );

                if (postData.status === 200) {
                    loadingPage(false);
                    const response = postData.data.data;

                    $('#i_schedule').text(
                        moment(response.assessment_interview.schedule).format('D MMM YYYY')
                    );
                    $('#i_type').text(
                        response.assessment_interview.interview_type === 'offline' ? 'Kunjungan lapangan' : response
                        .assessment_interview.interview_type
                    );
                    $('#i_assessorHead').text(response.assessment_interview.assessor_head.name);
                    interviewAssessorhead = response.assessment_interview.assessor_head;

                    // Remove existing rows
                    $('.assessor_interview_row').remove();

                    let assessors = [],
                        assessorHtml = '';

                    response.assessment_interview.assessors.forEach((assessor, i) => {
                        assessors.push(assessor.id);
                        assessorHtml +=
                            `<div class="row assessor_interview_row">
                        <small class="text-muted col-5">Penilai ${i + 1} :</small>
                        <span class="col-7" id="i_assessor_${i}">${assessor.name}</span>
                    </div>`;
                    });

                    interviewAssessors = assessors;
                    $(assessorHtml).insertAfter('#interview_assessor_head_row');

                    $('#edit-assessment-interview').modal('hide');
                    notificationAlert('success', 'Pemberitahuan', 'Berhasil mengubah jadwal interview.');

                    // Refresh the page after successful update
                    window.location.reload();
                } else {

                    loadingPage(false);
                    $('#edit-assessment-interview').modal('hide');
                    notificationAlert('info', 'Pemberitahuan', postData.message || 'Terjadi kesalahan.');
                    window.location.reload();
                }
            } catch (error) {
                loadingPage(false);
                $('#edit-assessment-interview').modal('hide');
                const resp = error.response;
                console.error('Error:', error);
                notificationAlert('info', 'Pemberitahuan', resp?.data?.message || 'Gagal memproses permintaan.');
                window.location.reload();
            }
        }


        async function submitAssessmentValidation(e) {
            e.preventDefault();
            loadingPage(true)
            const $form = $('#fCreateValidation'),
                formParsley = $form.parsley();

            formParsley.validate();

            if (!formParsley.isValid()) return false;

            const formArrayData = $form.serializeArray();
            let formObject = {};
            if (formObject !== null || status_code === 200) {
                formArrayData.forEach(function(item) {
                    formObject[item.name] = item.value;
                });
                if ($('input[name="isValidAssessment"]:checked').val() == 'no') {
                    formObject['validation_notes'] = $('#validationReason').summernote('code');
                }


                $('#request-validation').modal('hide');
                updateCertificateRequest(formObject, 'Berhasil melakukan validasi penilaian');
            }
        }

        async function submitSchedulingInterview(e) {
            e.preventDefault();
            loadingPage(true);

            const $form = $('#fCreateScheduleInterview'),
                formParsley = $form.parsley();

            formParsley.validate();

            if (!formParsley.isValid()) {
                loadingPage(false);
                return false;
            }

            const formObject = {};

            // Serialize form data
            const formArrayData = $form.serializeArray();
            formArrayData.forEach(function(item) {
                formObject[item.name] = item.value;
            });

            // Collect assessors' values
            const assessorSelect = document.getElementById('iAssessors');
            const assessors = [];

            for (const option of assessorSelect.options) {
                if (option.selected) {
                    assessors.push(option.value);
                }
            }
            formObject['assessors'] = assessors;
            try {
                const postData = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/internal/admin-panel/jadwal/storeJadwal`, {
                        id: id,
                        ...formObject
                    }
                );

                if (postData.status === 200) {
                    loadingPage(false);
                    $('#scheduling-interview').modal('hide');
                    notificationAlert('success', 'Pemberitahuan', 'Berhasil mengatur jadwal interview');

                    // Redirect after success
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    $('#scheduling-interview').modal('hide');
                    loadingPage(false);
                    notificationAlert('info', 'Pemberitahuan', postData.message || 'Terjadi kesalahan.');
                }
            } catch (error) {
                loadingPage(false);
                $('#scheduling-interview').modal('hide');
                let resp = error.response;
                console.error('Error:', error); // Logging the error for debugging
                notificationAlert('info', 'Pemberitahuan', resp?.data?.message || 'Gagal memproses permintaan.');
            }
        }

        async function showPrintRecordOfVerification() {
            loadingPage(true);
            // Memanggil API menggunakan fetch
            const response = await fetch(
                `{{ url('') }}/api/internal/admin-panel/pengesahan-sertifikat/generate-official-report?id=${id}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${Cookies.get('auth_token')}`
                    }
                });

            if (response.ok) {
                loadingPage(false)
                const blob = await response.blob();
                const newWindow = window.open();
                const pdfUrl = URL.createObjectURL(blob);
                newWindow.document.write('<iframe src="' + pdfUrl +
                    '" frameborder="0" style="width:100%;height:100%;"></iframe>');
            } else {
                console.error('Error:', response.status);
            }

        }

        async function NextStepSignbyDirector(e) {
            e.preventDefault();

            const form = $('#form-signby-dirjen');
            const user_id = form.find('#signer_id').val();
            const sk_number = 1;
            loadingPage(true);
            try {
                // Memanggil API menggunakan fetch
                const response = await fetch(
                    `{{ url('') }}/api/internal/admin-panel/pengesahan-sertifikat/generate-sk?id=${id}&signer=${user_id}&sk_number=${sk_number}`, {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${Cookies.get('auth_token')}`
                        }
                    });

                if (response.ok) {
                    const blob = await response.blob(); // Mengubah response menjadi blob
                    const newWindow = window.open();
                    const pdfUrl = URL.createObjectURL(blob);

                    // Tampilkan PDF dalam iframe
                    newWindow.document.write('<iframe src="' + pdfUrl +
                        '" frameborder="0" style="width:100%;height:100%;"></iframe>');
                } else {
                    console.error('Error:', response.status);
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                // Stop loading state
                loadingPage(false);
                $("#modal-signby-dirjen").modal("hide");
            }
        }


        async function signByDirector(e) {

            loadingPage(true)
            $("#modal-signby-dirjen").modal("show");

            try {
                response = await CallAPI('GET', `{{ url('') }}/api/internal/admin-panel/signer`);

                if (response.status == 200) {
                    loadingPage(false)
                    $(".form-name").html(`
                <option value="" selected disabled>Silahkan pilih</option>
                ${response.data.data
                    .map(
                        (data) =>
                            `<option value="${data.id}">${data.name}</option>`
                    )
                    .join(" ")}
            `);
                }
            } catch (error) {
                loadingPage(false);
                const resp = error.response;
                errorMessage = resp?.data?.message;
                return; // Stop execution if error occurs
            }

        }

        function submitAssessor(e) {
            e.preventDefault();

            const $form = $('#fCreateAssessor'),
                formParsley = $form.parsley();

            formParsley.validate();

            if (!formParsley.isValid()) return false;
            loadingPage(true)

            // Mengubah form data menjadi object tanpa AjaxHelper
            const formArrayData = $form.serializeArray();
            const formObject = {};

            formArrayData.forEach(field => {
                formObject[field.name] = field.value;
            });

            console.log(formObject)

            // Tambahkan field 'status' ke object
            formObject['status'] = 'disposition';
            $('#add-disposition').modal('hide');

            updateCertificateRequest(formObject, 'Pengajuan akan ditugaskan kepada penilai');
        }

        async function submitCreateRoV(e) {
            e.preventDefault();
            loadingPage(true);

            const $form = $('#fCreateRoV'),
                formParsley = $form.parsley();

            formParsley.validate();

            if (!formParsley.isValid()) {
                loadingPage(false);
                return false;
            }

            // Mengambil data form dalam bentuk objek
            const formArrayData = $form.serializeArray();
            const formObject = {};
            formArrayData.forEach(item => {
                formObject[item.name] = item.value;
            });


            // Mengirim request menggunakan Axios
            let postData = await CallAPI(
                'POST',
                "{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/record-of-verification", {
                    id,
                    ...formObject
                }
            );
            if (postData.data.error === true) {
                loadingPage(false);
                $('#create-record-of-verification').modal('hide');
                notificationAlert('error', 'Pemberitahuan', postData.data.message);
                return;
            }

            // Jika berhasil, lakukan operasi lain sebelum pengalihan
            if (postData.status === 200) {
                loadingPage(false);
                notificationAlert('success', 'Pemberitahuan', 'Berhasil Membuat Berita Acara');

                // Memperbarui konten halaman
                $('#i_schedule').text(moment(postData.data.data.assessment_interview.schedule).format('D MMM YYYY'));
                $('#i_type').text(postData.data.data.assessment_interview.interview_type === 'offline' ?
                    'Kunjungan lapangan' : postData.data.data.assessment_interview.interview_type);
                $('#i_assessorHead').text(postData.data.data.assessment_interview.assessor_head.name);

                let assessors = [],
                    assessorHtml = '';

                postData.data.data.assessment_interview.assessors.forEach((assessor, index) => {
                    assessors.push(assessor.id);
                    assessorHtml += `
                        <div class="row assessor_interview_row">
                            <small class="text-muted col-5">Penilai ${index + 1} :</small>
                            <span class="col-7" id="i_assessor_${index}">${assessor.name}</span>
                        </div>`;
                });

                // Memperbarui daftar penilai di tampilan
                $('.assessor_interview_row').remove();
                $(assessorHtml).insertAfter('#interview_assessor_head_row');

                // Tutup modal
                $('#create-record-of-verification').modal('hide');

                // Penundaan 300ms sebelum pengalihan ke halaman lain
                setTimeout(() => {
                    window.location.reload();
                }, 1500); // Penambahan jeda 300ms
            } else {
                loadingPage(false);
                notificationAlert('error', 'Pemberitahuan', 'Gagal membuat Berita Acara. Silakan coba lagi.');
            }
        }

        const scheduleEdit = flatpickr("#iEditInterview_date", {
            altInput: true,
            dateFormat: "YYYY-MM-DD",
            altFormat: 'DD MMMM YYYY',
            minDate: 'today',
            parseDate: (datestr, format) => {
                return moment(datestr, format, true).toDate();
            },
            formatDate: (date, format, locale) => {
                return moment(date).format(format);
            },
        });


        flatpickr("#interview_date", {
            allowInput: true,
            altInput: true,
            dateFormat: "YYYY-MM-DD",
            altFormat: 'DD MMMM YYYY',
            minDate: 'today',
            parseDate: (datestr, format) => {
                return moment(datestr, format, true).toDate();
            },
            formatDate: (date, format, locale) => {
                return moment(date).format(format);
            },
        });

        async function updateCertificateRequest(formData, successMessage) {
            loadingPage(true);

            try {

                let postData = await CallAPI(
                    'POST',
                    "{{ url('') }}/api/internal/admin-panel/pengajuan-sertifikat/update", {
                        id,
                        ...formData
                    }
                );
                if (postData.status === 200) {
                    loadingPage(false);
                    notificationAlert('success', 'Pemberitahuan', successMessage || postData.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            } catch (error) {
                loadingPage(false);
                let resp = error.response || {
                    data: {
                        message: 'Terjadi kesalahan'
                    }
                };
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
            }
        }

        async function showSchedulingInterview() {
            renderListAssessor('iAssessorHead', 'Ketua Tim')
            renderListAssessor('iAssessors', 'Assessor')

            await $('#scheduling-interview').modal('show')
        }

        async function submitRejectRequest() {
            $(document).on("submit", "#fCreateRejected", function(e) {
                e.preventDefault()

                const $form = $('#fCreateRejected'),
                    formParsley = $form.parsley()

                formParsley.validate()

                if (!formParsley.isValid()) return false

                loadingPage(true)

                const formArrayData = $form.serializeArray();
                const formObject = {};

                formArrayData.forEach(field => {
                    let isValue = field.value;
                    if (field.name == 'rejected_note') {
                        isValue = sanitizeInput(field.value);
                    }
                    formObject[field.name] = isValue;
                });

                formObject['status'] = 'rejected'

                $('#request-rejected').modal('hide');
                updateCertificateRequest(formObject, 'Berhasil menolak pengajuan')
            })
        }

        function submitAssessorHead(e) {
            e.preventDefault();

            const $form = $('#fCreateAssessorHead'),
                formParsley = $form.parsley();

            formParsley.validate();

            if (!formParsley.isValid()) return false;
            loadingPage(true);

            // Mengubah form data menjadi object dengan tipe data yang sesuai
            const formArrayData = $form.serializeArray();
            const formObject = {};

            formArrayData.forEach(field => {


                formObject[field.name] = field.value
            });


            $('#change-assessor-head').modal('hide');
            updateCertificateRequest(formObject, 'Pengajuan akan ditugaskan kepada ketua tim baru');
        }


        function uploadFile(sourceElement, inputTarget, sourceFiles = []) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content')
            const uploadedFiles = []

            // Jika ada file awal, tambahkan ke FilePond
            const initialFiles = sourceFiles.map(file => ({
                source: file
            }))

            const pond = FilePond.create(
                document.querySelector(`#${sourceElement}`), {
                    files: initialFiles, // Menambahkan file yang sudah ada (jika ada)
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                            $('#submitRequestBtn').prop('disabled', true)
                            $('#submitDraftRequestBtn').prop('disabled', true)

                            const formData = new FormData()
                            formData.append('file', file, file.name)

                            const request = new XMLHttpRequest()
                            request.open('POST',
                                '{{ url('') }}/api/internal/admin-panel/upload-file')
                            request.setRequestHeader('X-CSRF-TOKEN', csrfToken)
                            request.setRequestHeader('Accept', 'application/json')
                            request.setRequestHeader('Authorization', `Bearer ${Cookies.get('auth_token')}`)
                            request.responseType = 'json'

                            request.onload = function() {
                                if (request.status >= 200 && request.status < 300) {
                                    const resp = request.response
                                    load(resp)

                                    // Tambahkan URL ke array uploadedFiles
                                    uploadedFiles.push(resp.file_url)

                                    // Update nilai inputTarget dengan URL yang dipisahkan koma
                                    $(`#${inputTarget}`).val(uploadedFiles.join(','))
                                } else {
                                    error('oh no, Internal Server Error')
                                }

                                $('#submitRequestBtn').prop('disabled', false)
                                $('#submitDraftRequestBtn').prop('disabled', false)
                            }

                            request.send(formData)

                            return {
                                abort: () => {
                                    request.abort()
                                    abort()
                                }
                            }
                        },
                        revert: (uniqueFileId, load, error) => {
                            // Hapus file dari uploadedFiles saat dihapus
                            const fileIndex = uploadedFiles.indexOf(uniqueFileId)
                            if (fileIndex > -1) {
                                uploadedFiles.splice(fileIndex, 1)
                            }

                            // Update inputTarget
                            $(`#${inputTarget}`).val(uploadedFiles.join(','))

                            error('oh my goodness')
                            load()
                        }
                    },
                    labelIdle: '<span class="filepond--label-action"> Pilih File </span>',
                    allowMultiple: true, // Mengizinkan upload multiple file
                    maxFiles: 5, // Atur jumlah maksimum file yang bisa di-upload
                    required: true,
                    checkValidity: true,
                    maxFileSize: '5MB',
                    labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
                    labelMaxFileSize: 'Maksimal ukuran file 5MB'
                }
            )
        }


        async function pengajuanSelesaiSubmit(e) {
            e.preventDefault();

            const $form = $('#formPengajuanSelesai'),
                formParsley = $form.parsley();

            // Validate form
            formParsley.validate();
            if (!formParsley.isValid()) return false;

            // Show loading state
            loadingPage(true)

            // Serialize form data to object
            const formData = $form.serializeArray();
            const formObject = {};
            formData.forEach(item => {
                formObject[item.name] = item.value;
            });
            // Add additional fields
            formObject['number_of_certificate'] = $('#number_of_certificate').val();
            formObject['publish_date'] = $('#publish_date').val();
            formObject['certificate_file'] = $('#certificate_file').attr('data-value');
            formObject['sk_file'] = $('#sk_file').attr('data-value');
            formObject['rov_file'] = $('#rov_file').attr('data-value');
            formObject['sign_by'] = $('#sign_by').val();

            try {
                // Submit form data via API
                const response = await CallAPI(
                    'POST',
                    "{{ url('') }}/api/internal/admin-panel/pengesahan-sertifikat/certificate-release", {
                        id: id,
                        ...formObject
                    }

                );

                // Handle success response
                if (response.status === 200) {
                    $('#create-pengajuan-selesai').modal('hide');
                    notificationAlert('success', 'Pemberitahuan', 'Berhasil mengesahkan sertifikat');
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500);
                }
            } catch (error) {
                // Handle error response
                $('#create-pengajuan-selesai').modal('hide');
                const resp = error.response;
                const errorMessage = resp?.data?.message || "An error occurred";
                notificationAlert('info', 'Pemberitahuan', errorMessage);
            } finally {
                // Always hide loading state
                loadingPage(false);
            }
        }



        async function getAssessorList(keyword, role) {
            loadingPage(true);
            try {
                const response = await CallAPI(
                    'GET',
                    '{{ url('') }}/api/internal/admin-panel/assessor-list', {
                        keyword: keyword,
                        role: role
                    }
                );
                loadingPage(false);
                if (response && Array.isArray(response.data.data)) {
                    return response.data.data;
                } else {
                    console.error('Unexpected response format:', response);
                    return [];
                }
            } catch (error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data ? resp.data.message : 'Terjadi kesalahan');
                return []; // Kembalikan array kosong jika terjadi error
            }
        }

        function updateWordAndParagraphCount(contents) {
            var contentElement = $('<div>').html(contents);

            // Hitung paragraf dengan elemen <p> atau <div>
            var paragraphs = contentElement.find('p, div').filter(function() {
                return $(this).text().trim().length > 0;
            }).length;

            // Hitung paragraf berdasarkan <br> yang mengawali baris baru
            contentElement.find('br').each(function() {
                var nextText = $(this).next().text().trim();
                if (nextText.length > 0) {
                    paragraphs++;
                }
            });

            // Ambil teks mentah dan hitung kata
            var plainText = contentElement.text().trim();

            // Pecah teks ke dalam kata-kata berdasarkan spasi
            var words = plainText.split(/\s+/).filter(function(word) {
                return word.length > 0;
            });

            // Periksa apakah teks kosong
            if (plainText === '') {
                paragraphs = 0;
            }

            var wordCount = words.length;

            // Update elemen DOM untuk menampilkan jumlah paragraf dan kata
            $('#wordCount').html(`Terdapat ${paragraphs} paragraf dan ${wordCount} kata`);
        }

        // const scheduleEdit = flatpickr("#iEditInterview_date", {
        //     altInput: true,
        //     dateFormat: "YYYY-MM-DD",
        //     altFormat: 'DD MMMM YYYY',
        //     minDate: 'today',
        //     parseDate: (datestr, format) => {
        //         return moment(datestr, format, true).toDate();
        //     },
        //     formatDate: (date, format, locale) => {
        //         return moment(date).format(format);
        //     },
        // });

        $(document).ready(function() {
            $('#validationReason').summernote({
                placeholder: 'Masukkan Alasan',
                tabsize: 2,
                height: 450,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        updateWordAndParagraphCount(
                            contents); // Hitung kata dan paragraf saat konten berubah
                    }
                }
            });

            // Inisialisasi hitungan pertama kali
            updateWordAndParagraphCount($('#validationReason').summernote('code'));

            // Event handler untuk validasi input
            $('input[name="isValidAssessment"]').on('click', function() {
                let isValidAssessment = $(this).val() === 'yes';
                if (!isValidAssessment) {
                    $('#validationReason').summernote('enable'); // Aktifkan editor
                } else {
                    $('#validationReason').summernote('disable'); // Nonaktifkan editor
                    $('#validationReason').summernote('code', ''); // Kosongkan konten
                    $('#wordCount').html(''); // Kosongkan hitungan kata dan paragraf
                }
            });
        });


        $(document).on('change', '#signer_id', function() {
            $('#generate-sk-btn').prop('disabled', true)

            if ($(this).val() !== '') {
                $('#generate-sk-btn').prop('disabled', false)
            }
        })

        $("#modal-signby-dirjen").on("hidden.bs.modal", function() {
            $('#generate-sk-btn').prop('disabled', true)
        })

        function sanitizeInput(input) {
            var sanitized = input.replace(/<script[^>]*>(.*?)<\/script>/gi, '');
            return sanitized;
        }


        async function initPageLoad() {
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginImagePreview,
                FilePondPluginPdfPreview,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType
            )
            $('#validationReason').summernote({
                placeholder: 'Masukkan Alasan',
                tabsize: 2,
                height: 450,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        updateWordAndParagraphCount(contents);
                    }
                }
            });



            $('#validationReason').summernote('disable');
            updateWordAndParagraphCount($('#validationReason').summernote('code'));

            $(document).on("click", "#btnShowModalValidationReason", function() {
                $("#showCommentModal").modal('show')
                let decodedString = $("<div>").html(dataComment).text();
                $("#dataCatatanVerifikasi").html(decodedString)
            });

            document.getElementById('edit-assessment-interview').addEventListener('hidden.bs.modal', function() {
                location.reload();
            });

            $('.photos_of_event').each(function() {
                uploadFile($(this).attr('id'), $(this).next().attr('id'))
            })

            $('.photos_of_attendance_list').each(function() {
                uploadFile($(this).attr('id'), $(this).next().attr('id'))
            })
            await Promise.all([
                getDetailData(),
                submitRejectRequest(),
            ]);
            $('.filepond--credits').remove();
        }
    </script>
@endsection
