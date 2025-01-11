@extends('...Administrator.index', ['title' => 'Tambah Element SMK | Master Data Element'])
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
            width: 40px;
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
            font-size: 1.2rem;
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
                        <li class="breadcrumb-item"><a href="/admin/element-pemantauan/list">Master Data Elemen</a></li>
                        <li class="breadcrumb-item" aria-current="page">Tambah Data Element Pemantauan</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Tambah Data Element Pemantauan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="basicWizard" class="form-wizard row justify-content-center">
        <div class="col-12">
            <div class="card" style="border: 1px solid #ddd; margin-bottom: 20px;">
                <div class="card-body p-3">
                    <ul class="nav nav-pills nav-justified" id="wizardTabs"
                        style="display: flex; overflow-x: auto; white-space: nowrap; gap: 10px; border-bottom: 1px solid #ddd; padding: 10px; scrollbar-width: thin; -ms-overflow-style: none;">
                    </ul>
                </div>
            </div>
            <div class="card" style="border: 1px solid #ddd;">
                <div class="card-body">
                    <div class="tab-content" id="wizardTabContent" style="padding: 15px;"></div>
                </div>
            </div>
            <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                 <!-- Tombol Previous -->
                 <button type="button" class="btn btn-secondary" id="previousStep"
                 style="margin-right: 10px;">Sebelumnya</button>
                <!-- Tombol Simpan Draft -->
                <button type="button" class="btn btn-outline-success" id="saveDraft" style="margin-right: 10px;">Simpan
                    Draft</button>

                <!-- Tombol Next -->
                <button type="button" class="btn btn-primary" id="nextStep" style="margin-right: 10px;">Selanjutnya</button>
                <!-- Tombol Simpan (hanya tampil di akhir) -->
                <button type="button" class="btn btn-success" id="saveStep"
                    style="display: none;">Simpan</button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets') }}/js/plugins/wizard.min.js"></script>
    <script>
        async function getListData() {
            loadingPage(true);

            // Memanggil API
            const getDataRest = await CallAPI(
                'GET',
                `{{ url('') }}/api/internal/admin-panel/smk-element/get-smk-element`, {}
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            loadingPage(false);

            if (getDataRest.status === 200) {
                smkElements = getDataRest.data.data.element_properties;

                let wizardTabs = ``,
                    wizardContent = ``,
                    numbering = 1;

                let questionSchema = smkElements.question_schema.properties,
                    uiSchema = smkElements.ui_schema;

                for (const [elementKey, elementValue] of Object.entries(uiSchema)) {
                    let sortableSubElement = [];

                    for (let a in uiSchema[elementKey]) {
                        sortableSubElement.push([a, uiSchema[elementKey][a]]);
                    }

                    sortableSubElement.sort(function(a, b) {
                        return a[1]['ui:order'] - b[1]['ui:order'];
                    });

                    wizardTabs += `
                        <li class="nav-item" style="flex: 0 0 auto; margin-right: 20px; white-space: nowrap;">
                            <a class="nav-link" id="step-${elementKey}" data-bs-toggle="tab" href="#stepContent-${elementKey}"
                                style="padding: 10px 20px; text-align: center;">
                                <div class="d-flex align-items-center">
                                    <span class="number-box me-1">${numbering}.</span>
                                    <span class="fw-bold f-16 ms-2">${questionSchema[elementKey]['title']}</span>
                                </div>
                            </a>
                        </li>
                    `;

                    wizardContent += `
                        <div class="tab-pane fade" id="stepContent-${elementKey}" role="tabpanel" aria-labelledby="step-${elementKey}">
                            <form>
                                <div class="text-center">
                                    <h3 class="mb-2">${questionSchema[elementKey]['title']}</h3>
                                </div>
                                <div class="table-responsive py-5">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Uraian</th>
                                                <th>Pertanyaan Monitoring</th>
                                                <th>Ditampilkan</th>
                                                <th>Wajib Diisi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                    `;

                    let rowIndex = 1;
                    sortableSubElement.forEach(function(subElement) {
                        let question = questionSchema[elementKey]['properties'][subElement[0]],
                            attachmentDoc = '',
                            reportQuestionInput = '';

                        // Check if the question has 'items'
                        if (question['items']) {
                            question['items'].forEach((item, i) => {
                                let itemKey = Object.keys(item)[0];
                                attachmentDoc =
                                    `<div style="padding: 15px;">${item[itemKey]['name']}</div>`;

                                let isMandatoryRadioButton = customRadioCheckHTML(
                                    `isMandatory-${itemKey}`, {
                                        yesOption: {
                                            label: 'Ya',
                                            id: `mandatory-${itemKey}`,
                                            value: 'yes'
                                        },
                                        noOption: {
                                            label: 'Tidak',
                                            id: `notMandatory-${itemKey}`,
                                            value: 'no'
                                        }
                                    });

                                let isVisibilityRadioButton = customRadioCheckHTML(
                                    `isVisibility-${itemKey}`, {
                                        yesOption: {
                                            label: 'Ya',
                                            id: `visibility-${itemKey}`,
                                            value: 'yes'
                                        },
                                        noOption: {
                                            label: 'Tidak',
                                            id: `notVisibility-${itemKey}`,
                                            value: 'no'
                                        }
                                    });

                                reportQuestionInput = textInputHTML(`report-question-${itemKey}`,
                                    `reportQuestion-${itemKey}`);

                                // First row handling for the question
                                if (i === 0) {
                                    wizardContent += `
                                        <tr>
                                            <td rowspan=${question['items'].length}>${numbering}.${rowIndex}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 200px;" rowspan=${question['items'].length}>${question['title']}</td>
                                            <td style="padding: 0; word-wrap: break-word; white-space: normal; max-width: 150px;">${attachmentDoc}</td>
                                            <td>${isVisibilityRadioButton}</td>
                                            <td>${isMandatoryRadioButton}</td>
                                            <td>${reportQuestionInput}</td>
                                        </tr>
                                    `;
                                } else {
                                    // Additional rows for remaining items
                                    wizardContent += `
                                        <tr>
                                            <td style="padding: 0; word-wrap: break-word; white-space: normal; max-width: 150px;">${attachmentDoc}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${isVisibilityRadioButton}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${isMandatoryRadioButton}</td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${reportQuestionInput}</td>
                                        </tr>
                                    `;
                                }

                                // Add event listeners for visibility and mandatory logic
                                $(document).on('change', `input:radio[name=isVisibility-${itemKey}]`,
                                    function() {
                                        if ($(this).val() === 'no') {
                                            $(`#notMandatory-${itemKey}`).prop('checked', true)
                                            $(`#reportQuestion-${itemKey}`).val('').prop('required',
                                                false)

                                            $(this).parent().parent().next().children().addClass(
                                                'd-none')
                                            $(this).parent().parent().next().next().children()
                                                .addClass('d-none')
                                        } else {
                                            $(`#reportQuestion-${itemKey}`).prop('required', true)
                                            $(this).parent().parent().next().children().removeClass(
                                                'd-none')
                                            $(this).parent().parent().next().next().children()
                                                .removeClass('d-none')
                                        }
                                    });
                            });
                        } else {
                            // Handling when no 'items' present
                            attachmentDoc = `<div style="padding: 15px;">${question['attachmentName']}</div>`;
                            reportQuestionInput = textInputHTML(`report-question-${subElement[0]}`,
                                `reportQuestion-${subElement[0]}`);

                            let isMandatoryRadioButton = customRadioCheckHTML(
                                `isMandatory-${subElement[0]}`, {
                                    yesOption: {
                                        label: 'Ya',
                                        id: `mandatory-${subElement[0]}`,
                                        value: 'yes'
                                    },
                                    noOption: {
                                        label: 'Tidak',
                                        id: `notMandatory-${subElement[0]}`,
                                        value: 'no'
                                    }
                                });

                            let isVisibilityRadioButton = customRadioCheckHTML(
                                `isVisibility-${subElement[0]}`, {
                                    yesOption: {
                                        label: 'Ya',
                                        id: `visibility-${subElement[0]}`,
                                        value: 'yes'
                                    },
                                    noOption: {
                                        label: 'Tidak',
                                        id: `notVisibility-${subElement[0]}`,
                                        value: 'no'
                                    }
                                });

                            // Single row rendering for no 'items' case
                            wizardContent += `
                                <tr>
                                    <td>${numbering}.${rowIndex}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">${question['title']} (${smkElements.max_assesment[elementKey][subElement[0]]})</td>
                                    <td style="padding: 0; word-wrap: break-word; white-space: normal; max-width: 150px;">${attachmentDoc}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${isVisibilityRadioButton}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${isMandatoryRadioButton}</td>
                                    <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${reportQuestionInput}</td>
                                </tr>
                            `;

                            // Event listener for visibility
                            $(document).on('change', `input:radio[name=isVisibility-${subElement[0]}]`,
                                function() {
                                    if ($(this).val() === 'no') {
                                        $(`#notMandatory-${subElement[0]}`).prop('checked', true)
                                        $(`#reportQuestion-${subElement[0]}`).val('').prop('required',
                                            false)

                                        $(this).parent().parent().next().children().addClass('d-none')
                                        $(this).parent().parent().next().next().children().addClass(
                                            'd-none')
                                    } else {
                                        $(`#reportQuestion-${subElement[0]}`).val('').prop('required', true)
                                        $(this).parent().parent().next().children().removeClass('d-none')
                                        $(this).parent().parent().next().next().children().removeClass(
                                            'd-none')
                                    }
                                });
                        }

                        rowIndex++;
                    });

                    wizardContent += `
                        <tr>
                            <td style="word-wrap: break-word; white-space: normal; max-width: 200px;" colspan="2">Pertanyaan tambahan</td>
                            <td colspan="4">
                                <textarea class="form-control" id="additional_${elementKey}"></textarea>
                            </td>
                        </tr>
                    `;

                    wizardContent += `
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    `;

                    numbering++;
                }

                // Render wizard tabs and content
                document.getElementById('wizardTabs').innerHTML = wizardTabs;
                document.getElementById('wizardTabs').setAttribute(
                    'style',
                    'display: flex; overflow-x: auto; white-space: nowrap; padding: 10px;'
                );
                document.getElementById('wizardTabContent').innerHTML = wizardContent;

                let currentStep = 0;
                const steps = Object.keys(uiSchema);

                document.getElementById('nextStep').addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        updateWizardStep();
                    }

                    // Menampilkan tombol Simpan di wizard terakhir
                    if (currentStep === steps.length - 1) {
                        document.getElementById('nextStep').style.display = 'none';
                        document.getElementById('saveStep').style.display = 'inline-block';
                    }
                });

                document.getElementById('previousStep').addEventListener('click', () => {
                    if (currentStep > 0) {
                        currentStep--;
                        updateWizardStep();
                    }

                    // Sembunyikan tombol Simpan jika tidak di wizard terakhir
                    if (currentStep < steps.length - 1) {
                        document.getElementById('nextStep').style.display = 'inline-block';
                        document.getElementById('saveStep').style.display = 'none';
                    }
                });

                function updateWizardStep() {
                    const activeTab = document.getElementById(`step-${steps[currentStep]}`);
                    const activeContent = document.getElementById(`stepContent-${steps[currentStep]}`);

                    activeTab.classList.add('active');
                    activeContent.classList.add('show', 'active');

                    steps.forEach((step, index) => {
                        if (index !== currentStep) {
                            document.getElementById(`step-${step}`).classList.remove('active');
                            document.getElementById(`stepContent-${step}`).classList.remove('show', 'active');
                        }
                    });
                }

                updateWizardStep();
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
                        style="width: 45%;">${properties.yesOption.label}</label>

                    <input type="radio"
                        class="btn-check"
                        name="${inputName}"
                        value="${properties.noOption.value}"
                        id="${properties.noOption.id}"
                        ${defaultValue === 'no' ? 'checked' : ''}>
                    <label class="btn btn-outline-warning bg-opacity-50 bg-gradient"
                        for="${properties.noOption.id}"
                        style="width: 45%;">${properties.noOption.label}</label>
                </div>`

            return $customRadioButton
        }

        function textInputHTML(name, id) {
            let $templateInput = `<textarea class="form-control" id="${id}" name="${name}" required></textarea>`

            return $templateInput
        }


        document.addEventListener("click", (e) => {
            if (e.target.classList.contains('selanjutnya')) {
                let currentTab = document.querySelector('.tab-pane.active');
                let nextTab = currentTab.nextElementSibling;

                if (nextTab) {
                    currentTab.classList.remove('show', 'active');
                    nextTab.classList.add('show', 'active');
                }
            }

            if (e.target.classList.contains('kembali')) {
                let currentTab = document.querySelector('.tab-pane.active');
                let prevTab = currentTab.previousElementSibling;

                if (prevTab) {
                    currentTab.classList.remove('show', 'active');
                    prevTab.classList.add('show', 'active');
                }
            }
            if (e.target.classList.contains("btn-yes") || e.target.classList.contains("btn-no")) {
                const yesButton = e.target.closest(".btn-group").querySelector(".btn-yes");
                const noButton = e.target.closest(".btn-group").querySelector(".btn-no");
                const hiddenInput = e.target.closest("td").querySelector(".response-value");

                if (e.target.classList.contains("btn-yes")) {
                    yesButton.classList.add("active");
                    noButton.classList.remove("active");
                    hiddenInput.value = "Iya";
                } else if (e.target.classList.contains("btn-no")) {
                    noButton.classList.add("active");
                    yesButton.classList.remove("active");
                    hiddenInput.value = "Tidak";
                }
            }
            if (e.target.classList.contains("btn-yes2") || e.target.classList.contains("btn-no2")) {
                const yesButton = e.target.closest(".btn-group").querySelector(".btn-yes2");
                const noButton = e.target.closest(".btn-group").querySelector(".btn-no2");
                const hiddenInput = e.target.closest("td").querySelector(".response-value2");

                if (e.target.classList.contains("btn-yes2")) {
                    yesButton.classList.add("active");
                    noButton.classList.remove("active");
                    hiddenInput.value = "Iya";
                } else if (e.target.classList.contains("btn-no2")) {
                    noButton.classList.add("active");
                    yesButton.classList.remove("active");
                    hiddenInput.value = "Tidak";
                }
            }
        });


        async function generateSchema() {
            const elements = {}
            const additionalQuestions = {}
            $.each(smkElements.max_assesment, function(elementKey, elementValue) {
                const rowData = {}

                $.each(elementValue, function(subElementKey) {
                    let question = smkElements['question_schema']['properties'][elementKey][
                            'properties'
                        ][subElementKey],
                        monitoringValue

                    // check if sub element has a item
                    if (question['items']) {
                        let newData = []

                        for (let i in question['items']) {
                            let itemKey = Object.keys(question['items'][i])[0],
                                isVisibilityValue = $(
                                    `input:radio[name=isVisibility-${itemKey}]:checked`).val() ===
                                'yes',
                                isMandatoryValue = $(`input:radio[name=isMandatory-${itemKey}]:checked`)
                                .val() === 'yes',
                                questionValue = $(`#reportQuestion-${itemKey}`).val()

                            let data = {
                                isVisibilityValue: isVisibilityValue,
                                isMandatoryValue: isMandatoryValue,
                                questionValue: questionValue
                            }

                            newData.push({
                                [itemKey]: data
                            })
                        }

                        monitoringValue = newData

                    } else {
                        let isVisibilityValue = $(`input:radio[name=${$.escapeSelector(`isVisibility-${subElementKey}`)}]:checked`).val() === 'yes',
                            isMandatoryValue = $(`input:radio[name=${$.escapeSelector(`isMandatory-${subElementKey}`)}]:checked`).val() === 'yes',
                            questionValue = $(`#reportQuestion-${$.escapeSelector(subElementKey)}`).val();

                        monitoringValue = {
                            isVisibilityValue: isVisibilityValue,
                            isMandatoryValue: isMandatoryValue,
                            questionValue: questionValue
                        };


                    }

                    rowData[subElementKey] = monitoringValue
                })

                elements[elementKey] = rowData
                additionalQuestions[elementKey] = $(`#additional_${elementKey}`).val()

            })

            return {
                elements,
                additionalQuestions
            }
        }

        async function submitElement() {
            // Attach form submit event
            $(document).on('click', '#saveStep', async function(e) {
                e.preventDefault();
                let monitoringElements = await generateSchema();
                let uniqueTitle = `monitoring_elements_${Date.now()}`;
                console.log(monitoringElements.additionalQuestions)

                let formData = {
                    title: uniqueTitle,
                    element_properties: smkElements,
                    monitoring_elements: monitoringElements.elements,
                    additional_questions: monitoringElements.additionalQuestions
                };

                loadingPage(true);
                CallAPI('POST',
                        `{{ url('') }}/api/internal/admin-panel/monitoring-element/create`,
                        formData)
                    .then(response => {
                        if (response.status === 201) {
                            loadingPage(false);
                            notificationAlert('success', 'Pemberitahuan', response.data.message);
                            setTimeout(() => {
                                window.location.href =
                                    "/admin/element-pemantauan/list";
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        loadingPage(false); // Hide loading in case of an error
                        const resp = error.response;
                        notificationAlert('info', 'Pemberitahuan', resp ? resp.data.message :
                            'Terjadi kesalahan');
                    });
            });
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(),
            ]);
            submitElement();
        }
    </script>
@endsection
