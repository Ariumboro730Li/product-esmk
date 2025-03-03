@extends('...Company.index', ['title' => 'Detail | Data Perusahaan'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/datepicker-bs5.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/style.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/js/libs/filepond/filepond.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-pdf-preview/filepond-plugin-pdf-preview.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .custom-icon {
            font-size: 30px !important;
        }

        .custom-text {
            text-align: -webkit-left;
        }

        .number-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 40px;
            background-color: #6c757d;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }

        .nav-link .fw-bold {
            font-size: 16px;
            font-weight: bold;
        }

        .nav-link.active .number-box {
            background: none;
            font-size: 1.5rem;
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
                        <li class="breadcrumb-item"><a href="/company/dashboard-company">Home</a></li>
                        <li class="breadcrumb-item"><a href="/company/yearly-report/list">Laporan Tahunan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail Laporan Tahunan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Detail Laporan Tahunan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row align-items-center g-3">
                                <div class="col-lg-8 col-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="col-sm-auto mb-3 mb-sm-0 me-3">
                                            <div class="d-sm-inline-block d-flex align-items-center">
                                                <div
                                                    class="wid-60 hei-60 rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fa-solid fa-building text-white fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex flex-column flex-sm-row align-items-start">
                                                <h4 class="d-inline-block mb-0 me-2" id="c_name"></h4>
                                                <p class="mb-0"><b> NIB : <span id="c_nib"></span></b></p>
                                            </div>
                                            <div class="help-sm-hidden">
                                                <ul class="list-unstyled mt-0 mb-0 text-muted">
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fa-solid fa-phone me-1" id="company_phone"></i>
                                                        <span id="c_phone"></span>
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fa-regular fa-envelope me-1" id="company_email"></i>
                                                        <span id="c_email"></span>
                                                    </li>
                                                    <li class="d-sm-inline-block d-block mt-1 me-3">
                                                        <i class="fa-solid fa-location-dot me-1" id="company_address"></i>
                                                        <span id="c_address"></span>
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
                                <h5>Jenis Pelayanan</h5>
                                <div style="max-height: 80px; overflow-y: scroll;">
                                    <ol id="c_serviceType">

                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Penanggung Jawab</h5>
                                <p class="mb-0"><i class="fa-solid fa-user me-2"></i><span id="pic_name"></span></p>
                                <p class="mb-0"><i class="fa-solid fa-phone me-2"></i><span id="pic_phone"></span></p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-12 d-flex">
                            <div class="border rounded p-3 w-100">
                                <h5>Informasi Pengguna</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="mb-0"><i class="fa-solid fa-circle-user me-2"></i><span
                                                id="u_name"></span></p>
                                        <p class="mb-0"><i class="fa-solid fa-phone me-2"></i><span id="u_phone"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i><span
                                                id="u_email"></span>
                                        </p>
                                        <p class="mb-0"><i class="fa-solid fa-calendar-day me-2"></i><span
                                                id="establish_date"></span></p>
                                    </div>
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
                            </div>
                            <div class="mt-4 text-center col-12">
                                <div class="text-center action-button">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view-document" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <embed class="view-document-print" src="" frameborder="0" width="100%" height="700px">
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets') }}/js/plugins/moment.js"></script>
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
    <!-- [Page Specific JS] start -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs/dist/parsley.min.js"></script>
@endsection

@section('page_js')
    <script>
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let referenceId = urlParams.get('id');
        let companyID = urlParams.get('company_id');
        let elementProperties;
        let monitoringElement;
        let assessmentColumn;
        let formInputColumn = '';

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

        async function getMonitoringElement() {
            loadingPage(true);
            let getDataRest;

            try {

                const baseUrl = `{{ url('') }}/api/company/laporan-tahunan/detail`;
                getDataRest = await CallAPI('GET', baseUrl, {
                    id: referenceId,
                    companyID: companyID
                });
            } catch (error) {
                loadingPage(false);
                const errorMessage = error.response?.data?.message || 'Terjadi kesalahan';
                console.error('Error response:', error);
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                return;
            }

            loadingPage(false);

            if (getDataRest?.status === 200) {
                const responseData = getDataRest.data;
                mappingCompanyInformation(getDataRest.data.data);
                monitoringElement = responseData.data.monitoring_elements
                elementProperties = responseData.data.element_properties


                const {
                    monitoring_elements: monitoringElements,
                    element_properties: elementProps,
                    assessmentStatus = responseData.data.status,
                    answers,
                    assessments,
                    status
                } = responseData.data;
                const {
                    question_schema: questionSchema,
                    ui_schema: uiSchema
                } = elementProps;


                const mappingStatus = mappingYearlyReportStatus[status]?.status || 'Unknown';
                const spanStatus = `
                    <span class="badge ${mappingYearlyReportStatus[status]?.bgColor || ''} ${mappingYearlyReportStatus[status]?.textColor || ''}">
                        ${mappingStatus}
                    </span>`;

                $('#iReportYear').text(responseData.data.year || '-');
                $('#reportStatus').append(spanStatus);

                let accordionHTML = '';
                let numbering = 1;

                for (const [elementKey, elementValue] of Object.entries(uiSchema || {})) {
                    const sortableSubElement = sortableSubElementByUiOrder(uiSchema, elementKey);
                    const panelId = `panel-${elementKey}`;
                    accordionHTML += `
                        <div class="accordion-item shadow-sm border-0 mb-4">
                            <h2 class="accordion-header" id="heading-${elementKey}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#${panelId}" aria-expanded="true" aria-controls="${panelId}" style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%); color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                    ${numbering}. ${questionSchema.properties[elementKey]?.title || 'No Title'}
                                </button>
                            </h2>
                            <div id="${panelId}" class="accordion-collapse show" data-bs-parent="#accordionMonitoring">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Uraian Element</th>
                                                    <th>Pertanyaan</th>
                                                    <th>Jawaban</th>
                                                    ${status === 'not_passed' ? '<th>Status Verifikasi</th><th>Revisi Jawaban</th>' : ''}
                                                </tr>
                                            </thead>
                                            <tbody>`;


                    let rowIndex = 1;
                    (sortableSubElement || []).forEach(subElement => {
                        const subElementSchema = {
                            elementKey,
                            subElementKey: subElement[0],
                            questionProperties: questionSchema.properties[elementKey]?.properties?.[subElement[0]],
                            monitoringProperties: monitoringElements[elementKey]?.[subElement[0]],
                            answers: answers[elementKey]?.[subElement[0]],
                            assessments: assessments?.[elementKey]?.[subElement[0]] || null,
                            inputType: subElement[1]['ui:widget']
                        };

                        accordionHTML += mappingColumnOfRow(subElementSchema, status,
                            `${numbering}.${rowIndex}`);
                        rowIndex++;
                    });

                    accordionHTML += `</tbody></table></div></div></div>`;
                    numbering++;
                }

                $('#accordionFlushExample').html(accordionHTML);

                $('.pdf-preview').each(function() {
                    PDFObject.embed(`${$(this).attr('location')}`, `#${$(this).attr('id')}`, {
                        height: '20em'
                    });
                });

                $('.smk-element-file').each(function() {
                    uploadFile($(this).attr('id'), $(this).next().attr('id'), $(this).next().prop('required'));
                });

                let isNeedSubmitButton = false
                if (assessmentStatus === 'not_passed') {
                    isNeedSubmitButton = true
                }

                buildSubmitButton(isNeedSubmitButton);
            }
        }

        function mappingCompanyInformation(data) {
            let serviceTypes = '';
            if (data.company_info?.service_types?.length > 0) {
                data.company_info.service_types.forEach((serviceType) => {
                    serviceTypes += `<li>${serviceType?.name || '-'}</li>`;
                });
            } else {
                serviceTypes = '-';
            }

            const fileUrl = data.company_info?.nib_file || '';
            let fileName = '-';
            let fileExtension = '';
            if (fileUrl) {
                const splitFileURL = fileUrl.split('/');
                fileName = splitFileURL[splitFileURL.length - 1] || '-';
                fileExtension = fileUrl.substring(fileUrl.lastIndexOf('.')) || '';
            }

            let nibPreview = '';
            const imageType = ['.jpeg', '.jpg', '.png'];
            if (imageType.includes(fileExtension)) {
                nibPreview = `<img class="img-fluid" src="${fileUrl}"/>`;
            } else {
                nibPreview = '-';
            }

            $('#c_name').text(`${data.company_info?.name || '-'} |`);
            $('#c_nib').text(data.company_info?.nib || '-');
            $('#c_address').text(
                `${data.company_info?.address || ''} ${data.company_info?.city?.name || ''} ${data.company_info?.province?.name || ''}`
                .trim() || '-'
            );
            $('#c_phone').text(data.company_info?.company_phone_number || '-');
            $('#c_email').text(data.company_info?.email || '-');
            $('#c_serviceType').empty().append(serviceTypes);
            $('#pic_name').text(data.company_info?.pic_name || '-');
            $('#pic_phone').text(data.company_info?.pic_phone || '-');
            $('#u_name').text(data.company_info?.username || '-');
            $('#u_email').text(data.company_info?.email || '-');
            $('#u_phone').text(data.company_info?.phone_number || '-');
            $('#current_preview').text(data.company_info?.id || '-');
            $('#establish_date').text(
                data.company_info?.establish ? moment(data.company_info.establish).format('D/MM/YYYY') : '-'
            );
            $('#request_date').text(
                data.company_info?.request_date ? moment(data.company_info.request_date).format('D/MM/YYYY') : '-'
            );
        }

        function generateRowOfElementTitle(colSpanTitle, numbering, title) {
            let $templateRow = `
                    <div class="accordion-item shadow-sm border-0 mb-4">
                        <h2 class="accordion-header" id="flush-heading-${numbering}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse-${numbering}" aria-expanded="false" aria-controls="flush-collapse-${numbering}"
                                style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%);
                                color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px;
                                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                <i class="fa-regular fa-file-lines me-2"></i>
                                <span class="fw-bold me-2 me-lg-0">${numbering}. ${title}</span>
                            </button>
                        </h2>
                        <div id="flush-collapse-${numbering}" class="accordion-collapse collapse" aria-labelledby="flush-heading-${numbering}">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Uraian</th>
                                                <th>Pertanyaan</th>
                                                <th>Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body-${numbering}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>`

            return $templateRow;
        }

        async function showViewDocument(loc) {
            $.ajax({
                url: "{{ env('SERVICE_BASE_URL') }}/api/company/laporan-tahunan/getView",
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
                        $('.view-document-print').attr('src', response.data.certificate_file_base64);
                        await $('#view-document').modal('show');
                    } else {
                        showAlert('error', 'Document not found');
                    }
                }
            });
        }

        function mappingColumnOfRow(subElementSchema, status, numberColumn) {
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



                    let newAnswer
                    if (typeof subElementSchema.answers[i][itemKey] !== 'undefined') {
                        newAnswer = subElementSchema.answers[i][itemKey]
                    }

                    let itemSubElementSchema = {
                        elementKey: subElementSchema.elementKey,
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

        const $form = document.getElementById('fCreate');
        $form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formParsley = $('#fCreate').parsley();
            formParsley.validate();

            if (!formParsley.isValid()) return false;

            let answerSchema = buildAnswerSchmema();

            let formData = {
                year: $('#iReportYear').val(),
                answers: answerSchema,
            };

            await submitData(formData);
        });

        async function submitData(formData) {
            loadingPage(true); // Menampilkan loading

            try {
                const ajaxResponse = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/company/laporan-tahunan/update`, {
                        id: referenceId,
                        companyID: companyID,
                        ...formData
                    }
                );

                if (ajaxResponse.status === 200) {
                    notificationAlert('success', 'Berhasil', ajaxResponse.data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                }
            } catch (error) {
                const message = error.response?.data?.message || 'Terjadi kesalahan yang tidak diketahui';
                notificationAlert('error', 'Error', message);
            } finally {
                loadingPage(false); // Menyembunyikan loading
            }
        }

        function generateRowsTable(subElementSchema, status, numberOfColumn) {
            let numberColumn = '',
                titleColumn = '',
                questionColumn = subElementSchema.monitoringProperties.questionValue ?
                `<td style="word-wrap: break-word; white-space: normal; max-width: 200px;">${subElementSchema.monitoringProperties.questionValue}</td>` :
                '<td></td>',
                answerColumn, assessmentColumn, formInputColumn

            if (numberOfColumn) {
                numberColumn =
                    `<td ${subElementSchema.lengthOfItems ?  `rowspan=${subElementSchema.lengthOfItems}` : ''}>${numberOfColumn}</td>`
                titleColumn =
                    `<td style="word-wrap: break-word; white-space: normal; max-width: 200px;" ${subElementSchema.lengthOfItems ?  `rowspan=${subElementSchema.lengthOfItems}` : ''}>${subElementSchema.questionProperties['title']}</td>`
            }

            if (subElementSchema.monitoringProperties.isVisibilityValue) {
                answerColumn = subElementSchema.answers !== null ?
                    `<td><button type="button" onClick="showViewDocument('${subElementSchema.answers}')" class="btn btn-light btn-sm">lihat dokumen</button></td>` :
                    '<td>Tidak ada perubahan</td>'

                if (status === 'not_passed') {
                    assessmentColumn = generateAssessmentColumn(subElementSchema.assessments)
                    formInputColumn = generateInputColumn(subElementSchema.assessments, subElementSchema)

                    $(document).on('change', `input:radio[name=isAnyChanged-${subElementSchema.subElementKey}]`,
                        function() {
                            let buttonValue = $(this).val()

                            if (buttonValue === 'yes') {
                                $(this).parent().next().removeClass('d-none')
                                $(this).parent().next().find('.filepond--browser ').each(function() {
                                    $(this).prop('required', true)
                                })
                            } else {
                                $(this).parent().next().addClass('d-none')
                                $(this).parent().next().find('.filepond--browser ').each(function() {
                                    $(this).prop('required', false)
                                })
                            }
                        })
                }
            } else {
                answerColumn = '<td></td>'

                if (status === 'not_passed') {
                    assessmentColumn = '<td></td>'
                    formInputColumn = '<td></td>'
                }
            }

            let $templateRow = `
                <tr>
                    ${numberColumn}
                    ${titleColumn}
                    ${questionColumn}
                    ${answerColumn}
                    ${assessmentColumn ?? ""}
                    ${formInputColumn ?? ""}
                </tr>
            `

            return $templateRow
        }

        function buildAnswerSchmema() {
            let elements = {}
            $.each(elementProperties.max_assesment, function(elementKey, elementValue) {
                const rowData = {}

                $.each(elementValue, function(subElementKey) {
                    let newData, question = elementProperties['question_schema']['properties'][elementKey][
                        'properties'
                    ][subElementKey]

                    if (question['items']) {
                        newData = []

                        for (let i in question['items']) {

                            let itemKey = Object.keys(question['items'][i])[0],
                                answerValue = $(`#${elementKey}_${itemKey}`).val()

                            newData.push({
                                [itemKey]: answerValue
                            })
                        }
                        rowData[subElementKey] = newData
                    } else {
                        rowData[subElementKey] = $(`#${elementKey}_${subElementKey}`).val()
                    }

                })
                elements[elementKey] = rowData
            })

            return elements
        }



        function buildSubmitButton(isNeedSubmitButton) {
            if (isNeedSubmitButton) {
                $('.action-button').empty().append(`
                 <button type="submit" class="btn btn-primary"
                                style="padding: 0.5rem; font-size: 1rem; border-radius: 0.375rem; border: 1px solid #ced4da; width: 100%; text-align: center; line-height: 1.5; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <em class="icon ni ni-save" style="margin-right: 2px;"></em>Simpan
                            </button>
        `)
            }
        }

        function generateAssessmentColumn(assessmentProperties) {

            if (typeof assessmentProperties === undefined) {
                return
            }

            if (assessmentProperties.assessmentValue === null) {
                assessmentColumn = '<td></td>'

                return assessmentColumn
            }

            if (assessmentProperties.assessmentValue) {
                assessmentColumn = `<td><span class="badge bg-success">Sesuai</span></td>`
            } else {
                assessmentColumn = `<td><span>${nl2br(assessmentProperties.assessmentReason)}</span></td>`
            }

            return assessmentColumn
        }

        function generateInputColumn(assessmentProperties, subElementSchema) {
            if (typeof assessmentProperties === 'undefined') {
                return '';
            }



            if (assessmentProperties.assessmentValue === null || assessmentProperties.assessmentValue) {
                assessmentColumn = `
                    <td>
                        <input type="hidden"
                            class="answer-element"
                            name="${subElementSchema.elementKey}_${subElementSchema.subElementKey}"
                            id="${subElementSchema.elementKey}_${subElementSchema.subElementKey}"
                            value="${subElementSchema.answers || ''}">
                    </td>`;
                return assessmentColumn;
            }

            if (!assessmentProperties.assessmentValue) {
                let formInput = generateFormInput(
                    `${subElementSchema.elementKey}_${subElementSchema.subElementKey}`,
                    subElementSchema.inputType,
                    subElementSchema.answers
                );

                let customRadioProperties = {
                    yesOption: {
                        label: 'Ada Perubahan',
                        id: `changed-${subElementSchema.subElementKey}`,
                        value: 'yes'
                    },
                    noOption: {
                        label: 'Sesuai',
                        id: `noChanged-${subElementSchema.subElementKey}`,
                        value: 'no'
                    }
                };

                let customRadioCheck = '';

                if (!subElementSchema.monitoringProperties.isMandatoryValue) {
                    customRadioCheck = customRadioCheckHTML(
                        `isAnyChanged-${subElementSchema.subElementKey}`,
                        customRadioProperties,
                        subElementSchema.answers ? 'yes' : 'no'
                    );
                }

                formInputColumn = `<td>${customRadioCheck} ${formInput}</td>`;
            }

            return formInputColumn;
        }

        function customRadioCheckHTML(inputName, properties, defaultValue = 'yes') {
            let $customRadioButton =
                `<div class="d-flex w-100 align-items-center">
                    <input
                        type="radio"
                        class="btn-check"
                        name="${inputName}"
                        value="${properties.yesOption.value}"
                        id="${properties.yesOption.id}"
                        ${defaultValue === 'yes' ? 'checked' : ''}>
                    <label class="btn btn-outline-primary d-flex justify-content-center align-items-center"
                        for="${properties.yesOption.id}"
                        style="flex: 1; padding: 8px; text-align: center; border-radius: 5px;">${properties.yesOption.label}</label>

                    <input type="radio"
                        class="btn-check"
                        name="${inputName}"
                        value="${properties.noOption.value}"
                        id="${properties.noOption.id}"
                        ${defaultValue === 'no' ? 'checked' : ''}>
                    <label class="btn btn-outline-warning d-flex justify-content-center align-items-center"
                        for="${properties.noOption.id}"
                        style="flex: 1; padding: 8px; text-align: center; border-radius: 5px;">${properties.noOption.label}</label>
                </div>`;

            return $customRadioButton;
        }

        function generateFormInput(propertiesName, inputType, isMandatory = false) {

            let $htmlInput = ''

            switch (inputType) {
                case 'files':
                    $htmlInput += `
            <input type="file"
                class="mt-1 filepond form-control smk-element-file ${isMandatory ? '' : 'd-none'}"
                id="${propertiesName}File"
                accept="application/pdf">
            <input type="hidden"
                class="answer-element"
                name="${propertiesName}"
                id="${propertiesName}"
                ${isMandatory ? 'required' : ''}>
            `
                    break;
                case 'file':
                    $htmlInput += `
            <input type="file"
                class="filepond form-control smk-element-file ${isMandatory ? '' : 'd-none'}"
                id="${propertiesName}File"
                accept="application/pdf">
            <input type="hidden"
                class="answer-element"
                name="${propertiesName}"
                id="${propertiesName}"
                ${isMandatory ? 'required' : ''}>
            `
                    break;
                case 'image':
                    $htmlInput = `
                <input type="file"
                    class="filepond form-control smk-element-file ${isMandatory ? '' : 'd-none'}"
                    id="${propertiesName}File"
                    accept="image/png, image/jpeg"
                    required>
                <input type="hidden"
                    class="answer-element"
                    name="${propertiesName}"
                    id="${propertiesName}"
                    required>
            `
                    break;
                default:
                    $htmlInput = `
                <input type="text ${isMandatory ? '' : 'd-none'}"
                    class="form-control answer-element"
                    id="${propertiesName}"
                    name="${propertiesName}">
            `
                    break;
            }

            return $htmlInput

        }

        function nl2br(str) {
            return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
        }

        function uploadFile(sourceElement, inputTarget, isRequired) {

            const csrfToken = $('meta[name="csrf-token"]').attr('content')

            let removeButton = $(`#${sourceElement}`).closest('td').prev().find("[type=radio]")
            if (removeButton[1]) {
                removeButton[1].addEventListener('click', () => {
                    customUpload.removeFiles();
                })
            }

            let customUpload = FilePond.create(
                document.querySelector(`#${sourceElement}`)
            );
            customUpload.setOptions({
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {

                        const formData = new FormData()
                        formData.append('file', file, file.name)

                        const request = new XMLHttpRequest()
                        request.open('POST', '{{ url('') }}/api/file/upload')
                        request.setRequestHeader('X-CSRF-TOKEN', csrfToken)
                        request.setRequestHeader('Accept', 'application/json')
                        request.setRequestHeader('Authorization', `Bearer ${Cookies.get('auth_token')}`);
                        request.responseType = 'json';

                        request.onload = function() {
                            if (request.status >= 200 && request.status < 300) {
                                const resp = request.response

                                load(request.response);

                                $(`#${inputTarget}`).val(resp.file_url)
                            } else {
                                error('oh no, Internal Server Error');
                            }
                        };

                        request.send(formData);

                        return {
                            abort: () => {
                                request.abort();

                                abort();
                            }
                        }
                    },
                    revert: (uniqueFileId, load, error) => {
                        $(`#${inputTarget}`).val('')

                        error('oh my goodness');

                        load();
                    }
                },
                labelIdle: '<span class="filepond--label-action"> Pilih File </span>',
                maxFiles: 1,
                required: isRequired,
                checkValidity: true,
            })

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

        async function initPageLoad() {
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginImagePreview,
                FilePondPluginPdfPreview,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType
            )
            await getMonitoringElement();
            $('.filepond--credits').remove();
        }
    </script>
    @include('Company.partial-js')
@endsection
