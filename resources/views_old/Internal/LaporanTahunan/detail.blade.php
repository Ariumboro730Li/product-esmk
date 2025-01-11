@extends('...Internal.index', ['title' => 'Detail | Detail Laporan Tahunan'])
@section('asset_css')
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
                        <li class="breadcrumb-item"><a href="/internal/dashboard-internal">Home</a></li>
                        <li class="breadcrumb-item"><a href="/internal/laporan-tahunan/list">Laporan Tahunan</a></li>
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
                                        <p class="mb-0"><i class="fa-solid fa-circle-user me-2"></i><span id="u_name"></span></p>
                                        <p class="mb-0"><i class="fa-solid fa-phone me-2"></i><span id="u_phone"></span></p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-0"><i class="fa-solid fa-envelope me-2"></i><span id="u_email"></span>
                                        </p>
                                        <p class="mb-0"><i class="fa-solid fa-calendar-day me-2"></i><span id="establish_date"></span></p>
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
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets') }}/js/plugins/apexcharts.min.js"></script>
    <script src="../assets/js/plugins/datepicker-full.min.js"></script>
    <script src="../assets/js/pages/ac-datepicker.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('page_js')
@section('page_js')
    <script>
        let env = '{{ env('ESMK_SERVICE_BASE_URL') }}';
        let menu = 'Detail Laporan Tahunan';
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


        async function getYearlyReportByID() {
            loadingPage(true);
            try {
                const baseUrl = `{{ url('') }}/api/internal/admin-panel/laporan-tahunan/detail`;
                const getDataRest = await CallAPI('GET', baseUrl);

                if (getDataRest?.status === 200) {
                    const responseData = getDataRest.data;
                    const monitoringElement = responseData.data.monitoring_elements;
                    const elementProperties = responseData.data.element_properties;
                    const questionSchema = elementProperties.question_schema.properties;
                    const uiSchema = elementProperties.ui_schema;
                    const answers = responseData.data.answers;
                    const assessments = responseData.data.assessments;
                    const assessmentStatus = responseData.data.status;

                    $('#reportYear').text(responseData.data.year);
                    const mappingStatus = mappingYearlyReportStatus[assessmentStatus];
                    const spanStatus =
                        `<span class="badge ${mappingStatus.bgColor} ${mappingStatus.textColor}">${mappingStatus.status}</span>`;
                    $('#reportStatus').append(spanStatus);

                    let accordionHTML = '';
                    let numbering = 1;
                    let isNeedSubmitButton = false;

                    for (const [elementKey, elementValue] of Object.entries(uiSchema)) {
                        const sortableSubElement = sortableSubElementByUiOrder(uiSchema, elementKey);
                        const panelId = `panel-${elementKey}`;
                        const isFirst = numbering === 1;
                        accordionHTML += `
                            <div class="accordion-item shadow-sm border-0 mb-4">
                                <h2 class="accordion-header" id="heading-${elementKey}">
                                    <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#${panelId}"
                                        aria-expanded="true"
                                        aria-controls="${panelId}"
                                        style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%); color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                        ${numbering}. ${questionSchema[elementKey]?.title || 'No Title'}
                                    </button>
                                </h2>
                                <div id="${panelId}" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Uraian Element</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawaban</th>
                                                        <th>Kesesuaian</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                        let rowIndex = 1;
                        sortableSubElement.forEach(function(subElement) {
                            const newAssessment =
                                assessments?.[elementKey]?.[subElement[0]] || null;

                            const subElementSchema = {
                                elementKey,
                                subElementKey: subElement[0],
                                questionProperties: questionSchema[elementKey]?.properties?.[subElement[0]],
                                monitoringProperties: monitoringElement[elementKey]?.[subElement[0]],
                                answers: answers?.[elementKey]?.[subElement[0]],
                                assessments: newAssessment,
                                inputType: subElement[1]?.['ui:widget'],
                            };

                            accordionHTML += mappingColumnOfRow(
                                subElementSchema,
                                assessmentStatus,
                                `${numbering}.${rowIndex}`
                            );

                            rowIndex++;
                        });

                        accordionHTML += `</tbody></table></div></div></div>`;
                        numbering++;
                    }

                    if (assessmentStatus === 'request' || assessmentStatus === 'revision') {
                        isNeedSubmitButton = true;
                    }

                    buildSubmitButton(isNeedSubmitButton);
                    $('#accordionFlushExample').html(accordionHTML);

                    mappingCompanyInformation(responseData.data);
                } else {
                    const errorMessage =
                        getDataRest?.data?.message || 'Terjadi kesalahan';
                    console.error('API Error:', errorMessage);
                }
            } catch (error) {
                const resp = error.response || {};
                const errorMessage =
                    resp.data?.message || error.message || 'Terjadi kesalahan';
            } finally {
                loadingPage(false);
            }
        }



        function mappingCompanyInformation(data) {
            console.log(data)
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

            $('#c_name').text(`${data.company.name} |`)
            $('#c_nib').text(data.company.nib)
            // $('#c_nib_file').append(nibPreview)
            $('#c_address').text(
                `${data.company.address} ${data.company.city.name} ${data.company.province.name}`)
            $('#c_phone').text(data.company.company_phone_number)
            $('#c_email').text(data.company.email)
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
                            if (subElementSchema.assessments.assessmentValue === true || subElementSchema.assessments
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
                        console.log(subElementSchema.assessments.assessmentValue)
                        if (typeof subElementSchema.assessments.assessmentValue !== 'undefined') {
                            if (subElementSchema.assessments.assessmentValue === true || subElementSchema.assessments
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

                    let question = smkElements['question_schema']['properties'][elementKey]['properties'][
                            subElementKey
                        ],
                        assessments

                    if (question['items']) {
                        let newData = []

                        for (let i in question['items']) {
                            let itemKey = Object.keys(question['items'][i])[0],
                                assessmentButtonValue = $(`input:radio[name=assessment-${itemKey}]:checked`)
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
                        $('.view-document-print').attr('src', response.data.certificate_file_base64);
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
            await getYearlyReportByID();
            $('.filepond--credits').remove();
        }
    </script>
@endsection
@endsection
