@extends('...Company.index', ['title' => 'Tambah Element SMK | Master Data Element'])
@section('asset_css')
    <link rel="stylesheet" href="{{ asset('assets') }}/js/libs/filepond/filepond.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/js/libs/filepond-plugin-pdf-preview/filepond-plugin-pdf-preview.min.css">
        <link rel="stylesheet" href="{{ asset('assets//js/plugins/yearpicker/yearpicker.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">




@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/company/dashboard-company">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/company/yearly-report/list">Laporan Tahunan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Buat Laporan Tahunan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Laporan Tahunan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form id="fCreate">
                <div class="mb-4">
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <label class="form-label" for="iReportYear"
                            style="font-size: 1rem; font-weight: 500; margin-bottom: 0.5rem; display: block;">
                            Tahun Laporan
                        </label>
                        <div class="col-3 md-3">
                            <input type="text" class="flatpickr-input form-control text-center" name="report_year"
                                id="iReportYear" placeholder="Pilih tahun" readonly="readonly" required>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="analytics-tab-1-pane" role="tabpanel"
                                aria-labelledby="analytics-tab-1" tabindex="0">
                                <div class="accordion accordion-flush" id="accordionFlushExample">

                                </div>
                                <div class="mt-4 text-center col-12">
                                    <button type="submit" class="btn btn-primary"
                                        style="padding: 0.5rem; font-size: 1rem; border-radius: 0.375rem; border: 1px solid #ced4da; width: 100%; text-align: center; line-height: 1.5; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                        <em class="icon ni ni-save" style="margin-right: 2px;"></em>Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets') }}/js/plugins/wizard.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/moment.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/yearpicker/yearpicker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


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
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs/dist/parsley.min.js"></script>
@endsection

@section('page_js')
    <script>
        let monitoringElementID;
        let monitoringElement;
        let responseData;
        let resp;
        let elementProperties;

        function yearPicker(minYear, maxYear, isReportMonth, publishYear, latestReportYear, currentYear) {
            $('#iReportYear').yearpicker({
                startYear: minYear,
                endYear: maxYear,
                selectedClass: 'text-primary',
                disabled: !isReportMonth // Disable if not in the report month
            });

            $('#iReportYear').on('change', function() {
                let selectedYear = parseInt($(this).val());

                if (selectedYear === publishYear) {
                    notificationAlert('info', 'Pemberitahuan', 'Tahun pengesahan sertifikat tidak bisa dipilih!');
                    $('#iReportYear').val(''); // Reset selection
                } else if (selectedYear === latestReportYear) {
                    notificationAlert('info', 'Pemberitahuan', 'Sudah ada pengajuan laporan!');
                    $('#iReportYear').val(''); // Reset selection
                } else if (selectedYear > currentYear) {
                    notificationAlert('info', 'Pemberitahuan', 'Belum waktunya laporan tahunan!');
                    $('#iReportYear').val(''); // Reset selection
                } else if (selectedYear < publishYear) {
                    notificationAlert('info', 'Pemberitahuan', 'Tidak ada pengesahan sertifikat pada tahun ini!');
                    $('#iReportYear').val(''); // Reset selection
                }
            });

            if (!isReportMonth) {
                $('#iReportYear').prop('disabled', true); // Explicitly disable input
            } else {
                $('#iReportYear').prop('disabled', false); // Enable input when it's the report month
            }
        }


        async function setReportYear() {
            let smkCertificate = await getSmkCertificate(),
                currentYear = new moment().year(),
                currentMonth = new moment().month(), // Get current month (0-11)
                publishYear = moment(smkCertificate.data.data.publish_date).year(),
                reportMonth = moment(smkCertificate.data.data.publish_date).month(),
                minYear = currentYear,
                latestReportYear = null;

            if (smkCertificate.data.data !== null) {
                let latestReport = await getLatestReportYear();

                if (Object.keys(latestReport.data).length > 0) {
                    minYear = latestReport.data.year + 1;
                    latestReportYear = latestReport.data.year;
                } else {
                    minYear = publishYear + 1;
                }
            } else {
                minYear++;
            }

            // Check if it's the report month and the publish year is not the current year
            let isReportMonth = (currentMonth === reportMonth) && (publishYear < currentYear);
            toggleSubmitButton(isReportMonth);

            yearPicker(minYear, currentYear, isReportMonth, publishYear, latestReportYear, currentYear);
        }

        async function getSmkCertificate() {
            loadingPage(true);
            let getDataRest;

            try {
                getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/company/dashboard/company/getsmk`
                );
            } catch (error) {
                loadingPage(false);
                const resp = error.response;
                const errorMessage = resp?.data?.message;
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                return resp;
            }

            return getDataRest;
        }

        async function getLatestReportYear() {
            loadingPage(true);
            let getDataRest;

            try {
                getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/company/laporan-tahunan/latest`
                );
                loadingPage(false);

            } catch (error) {
                loadingPage(false);
                const resp = error.response;
                const errorMessage = resp?.data?.message || 'Terjadi kesalahan saat mengambil data laporan tahunan.';
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                return resp;
            }

            return getDataRest;
        }

        function toggleSubmitButton(isVisible) {
            const submitButton = document.querySelector('button[type="submit"]');
            if (isVisible) {
                submitButton.style.display = 'inline-flex'; // Tampilkan tombol
            } else {
                submitButton.style.display = 'none'; // Sembunyikan tombol
            }
        }
        async function getMonitoringElement() {
            loadingPage(true);
            let getDataRest;

            try {
                getDataRest = await CallAPI(
                    'GET',
                    `{{ url('') }}/api/company/laporan-tahunan/get-monitoring-element`
                );
            } catch (error) {
                loadingPage(false);
                let resp = error.response;
                let errorMessage = resp?.data?.message || 'Terjadi kesalahan';
                notificationAlert('info', 'Pemberitahuan', errorMessage);
                return;
            }

            loadingPage(false);
            if (getDataRest.status == 200) {
                responseData = getDataRest.data;
                monitoringElementID = responseData.data.id;
                monitoringElement = responseData.data.monitoring_elements;
                elementProperties = responseData.data.element_properties;
                let questionSchema = elementProperties.question_schema.properties;
                let uiSchema = elementProperties.ui_schema;

                let numbering = 1;
                let accordionHtml = '';

                for (let [elementKey, elementValue] of Object.entries(uiSchema)) {
                    let panelId = `panel-${elementKey}`;
                    accordionHtml += `
                        <div class="accordion-item shadow-sm border-0 mb-4">
                            <h2 class="accordion-header" id="heading-${elementKey}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#${panelId}" aria-expanded="true" aria-controls="${panelId}" style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%); color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                    ${numbering}. ${questionSchema[elementKey].title}
                                </button>
                            </h2>
                            <div id="${panelId}" class="accordion-collapse collapse show" aria-labelledby="heading-${elementKey}">
                                <div class="accordion-body">
                                    <div class="table-responsive py-4">
                                        <table class="table table-hover table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center" style="width: 5%;">No</th>
                                                    <th style="width: 35%; white-space: nowrap;">Uraian</th>
                                                    <th style="width: 30%; white-space: nowrap;">Pertanyaan</th>
                                                    <th style="width: 30%; white-space: nowrap;">Jawaban</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;



                    let sortableSubElement = [];
                    for (let subElement in uiSchema[elementKey]) {
                        sortableSubElement.push([subElement, uiSchema[elementKey][subElement]]);
                    }
                    sortableSubElement.sort((a, b) => a[1]['ui:order'] - b[1]['ui:order']);

                    let rowIndex = 1;

                    sortableSubElement.forEach(function(subElement) {
                        let questionProperties = questionSchema[elementKey]['properties'][subElement[0]];

                        if (questionProperties['items']) {
                            for (let i in questionProperties['items']) {
                                let isAnyChangedButton = '',
                                    itemKey = Object.keys(questionProperties['items'][i])[0],
                                    isMandatory = monitoringElement[elementKey][subElement[0]][i][itemKey][
                                        'isMandatoryValue'
                                    ],
                                    isVisibility = monitoringElement[elementKey][subElement[0]][i][itemKey][
                                        'isVisibilityValue'
                                    ],
                                    reportQuestion = monitoringElement[elementKey][subElement[0]][i][itemKey][
                                        'questionValue'
                                    ] || '';

                                if (isVisibility && !isMandatory) {
                                    isAnyChangedButton = customRadioCheckHTML(
                                        `isAnyChanged-${itemKey}`, {
                                            yesOption: {
                                                label: 'Ya',
                                                id: `changed-${itemKey}`,
                                                value: 'yes'
                                            },
                                            noOption: {
                                                label: 'Tidak',
                                                id: `noChanged-${itemKey}`,
                                                value: 'no'
                                            },
                                        },
                                        'no'
                                    );
                                }

                                let inputProperties = {
                                    id: `${elementKey}_${itemKey}`,
                                    name: `${elementKey}_${itemKey}`,
                                    inputType: subElement[1]['ui:widget']
                                };

                                let answerForm = '';

                                if (isVisibility) {
                                    answerForm = `${generateFormInput(inputProperties, isMandatory)}`;
                                }

                                if (i == 0) {
                                    accordionHtml += `
                                        <tr>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;" rowspan="${questionProperties['items'].length}">${numbering}.${rowIndex}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;" rowspan="${questionProperties['items'].length}">${questionSchema[elementKey]['properties'][subElement[0]]['title']}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;"><p>${reportQuestion}</p>${isAnyChangedButton}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${answerForm}</td>
                                        </tr>`;
                                } else {
                                    accordionHtml += `
                                        <tr>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;"><p>${reportQuestion}</p>${isAnyChangedButton}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${answerForm}</td>
                                        </tr>`;
                                }

                                $(document).on('change', `input:radio[name=isAnyChanged-${itemKey}]`,
                                    function() {
                                        let buttonValue = $(this).val();

                                        if (buttonValue === 'yes') {
                                            $(this).parent().parent().next().find(
                                                `#${elementKey}_${itemKey}File`).removeClass('d-none');
                                            $(this).parent().parent().next().find('.filepond--browser')
                                                .each(function() {
                                                    $(this).prop('required', true);
                                                });
                                        } else {
                                            $(this).parent().parent().next().find(
                                                `#${elementKey}_${itemKey}File`).addClass('d-none');
                                            $(this).parent().parent().next().find('.filepond--browser')
                                                .each(function() {
                                                    $(this).prop('required', false);
                                                });
                                        }
                                    });
                            }
                        } else {
                            let isAnyChangedButton = '',
                                isMandatory = monitoringElement[elementKey][subElement[0]]['isMandatoryValue'],
                                isVisibility = monitoringElement[elementKey][subElement[0]][
                                    'isVisibilityValue'
                                ],
                                reportQuestion = monitoringElement[elementKey][subElement[0]][
                                    'questionValue'
                                ] || '';


                            if (isVisibility && !isMandatory) {
                                isAnyChangedButton = customRadioCheckHTML(
                                    `isAnyChanged-${subElement[0]}`, {
                                        yesOption: {
                                            label: 'Ya',
                                            id: `changed-${subElement[0]}`,
                                            value: 'yes'
                                        },
                                        noOption: {
                                            label: 'Tidak',
                                            id: `noChanged-${subElement[0]}`,
                                            value: 'no'
                                        },
                                    },
                                    'no'
                                );
                            }

                            let inputProperties = {
                                id: `${elementKey}_${subElement[0]}`,
                                name: `${elementKey}_${subElement[0]}`,
                                inputType: subElement[1]['ui:widget']
                            };

                            let answerForm = '';

                            if (isVisibility) {
                                answerForm = `${generateFormInput(inputProperties, isMandatory)}`;
                            }

                            accordionHtml += `
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${numbering}.${rowIndex}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${questionSchema[elementKey]['properties'][subElement[0]]['title']}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;"><p>${reportQuestion}</p>${isAnyChangedButton}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${answerForm}</td>
                                </tr>`;

                            $(document).on('change', `input:radio[name=isAnyChanged-${subElement[0]}]`,
                                function() {
                                    let buttonValue = $(this).val();

                                    if (buttonValue === 'yes') {
                                        $(this).parent().parent().next().find(
                                            `#${elementKey}_${subElement[0]}File`).removeClass('d-none');
                                        $(this).parent().parent().next().find('.filepond--browser').each(
                                            function() {
                                                $(this).prop('required', true);
                                            });
                                    } else {
                                        $(this).parent().parent().next().find(
                                            `#${elementKey}_${subElement[0]}File`).addClass('d-none');
                                        $(this).parent().parent().next().find('.filepond--browser').each(
                                            function() {
                                                $(this).prop('required', false);
                                            });
                                    }
                                });
                        }

                        rowIndex++;
                    });


                    accordionHtml += `
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>`;
                    numbering++;
                }

                $('#accordionFlushExample').html(accordionHtml);
                $('.smk-element-file').each(function() {
                    uploadFile($(this).attr('id'), $(this).next().attr('id'), $(this).next().prop('required'));
                });
            }
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

        function customRadioCheckHTML(inputName, properties, defaultValue = 'yes') {
            let $customRadioButton = `
                    <div class="d-flex gap-2">
                        <input
                            type="radio"
                            class="btn-check"
                            name="${inputName}"
                            value="${properties.yesOption.value}"
                            id="${properties.yesOption.id}"
                            ${defaultValue === 'yes' ? 'checked' : ''}>
                        <label class="btn btn-outline-primary"
                            for="${properties.yesOption.id}"
                            style="width: 100px; text-align: center; padding: 0.5rem 1rem; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center;">
                            ${properties.yesOption.label}
                        </label>

                        <input
                            type="radio"
                            class="btn-check"
                            name="${inputName}"
                            value="${properties.noOption.value}"
                            id="${properties.noOption.id}"
                            ${defaultValue === 'no' ? 'checked' : ''}>
                        <label class="btn btn-outline-warning bg-opacity-50 bg-gradient"
                            for="${properties.noOption.id}"
                            style="width: 100px; text-align: center; padding: 0.5rem 1rem; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center;">
                            ${properties.noOption.label}
                        </label>
                    </div>`;

            return $customRadioButton;
        }

        function generateFormInput(inputProperties, isVisibility = false) {
            let $htmlInput = ''

            switch (inputProperties.inputType) {
                case 'files':
                    $htmlInput += `
            <input type="file"
                class="filepond form-control smk-element-file ${isVisibility ? '' : 'd-none'}"
                id="${inputProperties.id}File"
                accept="application/pdf">
            <input type="hidden"
                class="answer-element"
                name="${inputProperties.name}"
                id="${inputProperties.id}"
                ${isVisibility ? 'required' : ''}>
            `
                    break;
                case 'file':
                    $htmlInput += `
            <input type="file"
                class="filepond form-control smk-element-file ${isVisibility ? '' : 'd-none'}"
                id="${inputProperties.id}File"
                accept="application/pdf">
            <input type="hidden"
                class="answer-element"
                name="${inputProperties.name}"
                id="${inputProperties.id}"
                ${isVisibility ? 'required' : ''}>
            `
                    break;
                case 'image':
                    $htmlInput = `
                <input type="file"
                    class="filepond form-control smk-element-file ${isVisibility ? '' : 'd-none'}"
                    id="${inputProperties.id}File"
                    accept="image/png, image/jpeg"
                    required>
                <input type="hidden"
                    class="answer-element"
                    name="${inputProperties.name}"
                    id="${inputProperties.id}"
                    required>
            `
                    break;
                default:
                    $htmlInput = `
                <input type="text ${isVisibility ? '' : 'd-none'}"
                    class="form-control answer-element"
                    id="${inputProperties.id}"
                    name="${inputProperties.name}">
            `
                    break;
            }

            return $htmlInput

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
                        request.open('POST',
                            '{{ url('') }}/api/file/upload')
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

        const $form = document.getElementById('fCreate')
        $form.addEventListener("submit", (e) => {
            e.preventDefault()
            const formParsley = $('#fCreate').parsley()

            formParsley.validate()

            if (!formParsley.isValid()) return false


            let answerSchema = buildAnswerSchmema()

            let formData = {
                year: $('#iReportYear').val(),
                monitoring_element_id: monitoringElementID,
                answers: answerSchema,
            }

            submitData(formData)

        })

        async function submitData(formData) {
            loadingPage(true);
            try {
                const postData = await CallAPI(
                    'POST',
                    '{{ url('') }}/api/company/laporan-tahunan/store',
                    formData
                );

                if (postData.status === 200) {
                    notificationAlert('success', 'Berhasil', postData.data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                }
            } catch (error) {
                const resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
            } finally {
                loadingPage(false);
            }
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

        async function initPageLoad() {
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginImagePreview,
                FilePondPluginPdfPreview,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType
            )

            await Promise.all([
                getMonitoringElement(),
                setReportYear(),
            ])

            // Inisialisasi tombol submit
            $('#submitButton').on('click', async function() {
                await addData(); // Panggil addData saat tombol diklik
            });

            $('.filepond--credits').remove();
        }
    </script>
@endsection
