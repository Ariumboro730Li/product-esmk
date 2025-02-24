@extends('...Administrator.index', ['title' => 'Perbarui Data Element SMK'])
@section('asset_css')
    <style>
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
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/element-smk/list">Master Data Element SMK</a></li>
                        <li class="breadcrumb-item" aria-current="page">Perbarui Data Element SMK</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Perbarui Data Element SMK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="accordionExample" class="accordion"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- [Page Specific JS] start -->
@endsection

@section('page_js')
    <script>
        let defaultLimitPage = 10;
        let currentPage = 1;
        let totalPage = 1;
        let defaultAscending = 0;
        let defaultSearch = '';

        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let referenceId = urlParams.get('id');
        let titleElement = "";

        async function getListData(id) {
            loadingPage(true);
            const getDataRest = await CallAPI(
                'GET',
                `{{ url('') }}/api/internal/admin-panel/smk-element/detail?id=${id}`, {}
            ).then(function(response) {
                return response;
            }).catch(function(error) {
                loadingPage(false);
                let resp = error.response;
                notificationAlert('info', 'Pemberitahuan', resp.data.message);
                return resp;
            });

            if (getDataRest && getDataRest.data) {
                loadingPage(false);
                titleElement = getDataRest.data.data.title;
                let data = getDataRest.data.data.element_properties;
                let elements = data.question_schema.properties;
                let bobotElements = data.max_assesment;
                let uiSchema = data.ui_schema;

                // Paginate the data
                let elementKeys = Object.keys(elements);
                let totalData = elementKeys.length;
                let totalPage = Math.ceil(totalData / defaultLimitPage);
                let startIndex = (currentPage - 1) * defaultLimitPage;
                let endIndex = Math.min(startIndex + defaultLimitPage, totalData);
                let paginatedKeys = elementKeys.slice(startIndex, endIndex);

                let display_from = startIndex + 1;
                let display_to = endIndex;

                $('#totalPage').text(totalData);
                $('#countPage').text(`${display_from} - ${display_to}`);

                let appendHtml = "";
                let subCounter = startIndex;

                // Generate accordion structure with the updated style
                for (let elementKey of paginatedKeys) {
                    let element = elements[elementKey];
                    let bobot = bobotElements[elementKey];
                    let id = `element${subCounter}`;
                    let ariaExpanded = subCounter === startIndex ? "true" : "false";
                    let expandedClass = subCounter === startIndex ? "show" : "";

                    appendHtml += `
                        <div class="accordion-item shadow-sm border-0 mb-4">
                            <h2 class="accordion-header" id="flush-heading${id}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse${id}" aria-expanded="${ariaExpanded}" aria-controls="flush-collapse${id}"
                                    style="background: linear-gradient(90deg, rgb(4, 60, 132) 0%, rgb(69, 114, 184) 100%);
                                    color: white; border-radius: 8px; font-weight: bold; padding: 12px 20px;
                                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                    <i class="fa-regular fa-file-lines me-2 title-icon-file" data-key="${elementKey}"></i>
                                    <span class="fw-bold me-2 me-lg-0 title-text" data-key="${elementKey}">
                                        ${subCounter + 1}. ${element.title}
                                    </span>
                                    <i class="fa-solid fa-edit edit-icon ms-4 text-warning" data-key="${elementKey}" style="cursor: pointer;"></i>

                                    <textarea class="edit-accordion-title element-name"
                                        data-key="${elementKey}"
                                        style="display: none; background: transparent; border: none; color: white; font-weight: bold; width: 80%; min-height: 30px; resize: none;">${element.title}</textarea>
                                </button>
                            </h2>
                            <div id="flush-collapse${id}" class="accordion-collapse collapse ${expandedClass}" aria-labelledby="flush-heading${id}">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Uraian Element</th>
                                                    <th>Dokumen / Bukti Dukung Jawaban</th>
                                                    <th>Bobot</th>
                                                    <th>File Yang Dilampirkan</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                    let subNumber = 1;

                    // Loop through the uiSchema to get sub-elements
                    let sortableSubElement = [];
                    for (let a in uiSchema[elementKey]) {
                        sortableSubElement.push([a, uiSchema[elementKey][a]]);
                    }
                    sortableSubElement.sort((a, b) => a[1]['ui:order'] - b[1]['ui:order']);

                    for (let subElement of sortableSubElement) {
                        let subElementKey = subElement[0];
                        let detail = elements[elementKey].properties[subElementKey];
                        let bobotMaks = bobot[subElementKey];

                        let filesHtml = '';

                        // Handle type "array"
                        if (detail.type === "array" && Array.isArray(detail.items)) {
                            let itemObjects = detail.items;
                            for (let item of itemObjects) {
                                // Loop through dynamic keys in each item
                                for (let key in item) {
                                    if (item[key].name) {
                                        filesHtml += `<li><textarea class="edit-textarea documentAttachments" data-subkey="${subElementKey}" 
                                                                    data-key="${elementKey}" data-field="file_name_array" data-type="array"
                                                                    style="width: 100%; min-height: 50px; resize: vertical;">${item[key].name}</textarea>
                                                                </li>`;
                                    }
                                }
                            }
                            filesHtml = `<ul style="list-style: none;padding-left: 0px;">${filesHtml}</ul>`;
                        } else if (detail.type === "string") {
                            // Handle type "string"
                            filesHtml =
                                `<textarea class="edit-textarea" data-subkey="${subElementKey}"
                                                        data-key="${elementKey}" data-field="file_name" data-type="string"
                                                        style="width: 100%; min-height: 50px; resize: vertical;">${detail.attachmentName || '-'}</textarea>`
                        }
                        // ${detail.title || ''}

                        appendHtml += `
                                    <tr class="smk-element">
                                        <td>${subCounter + 1}.${subNumber}</td>
                                        <td style="word-wrap: break-word; white-space: normal;">
                                            <textarea class="edit-textarea"
                                                data-id="${subNumber}" 
                                                data-key="${elementKey}" 
                                                data-subkey="${subElementKey}" 
                                                data-field="title"
                                                style="width: 100%; min-height: 50px; resize: vertical;">${detail.title || '-'}
                                            </textarea>
                                        </td>
                                        <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">
                                            <textarea class="edit-textarea"
                                                data-id="${subNumber}" 
                                                data-key="${elementKey}" 
                                                data-subkey="${subElementKey}" 
                                                data-field="description"
                                                style="width: 100%; min-height: 50px; resize: vertical;">${detail.description || '-'}
                                            </textarea>
                                        </td>
                                        <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">
                                            <input type="number" class="form-control maxAssesment"
                                            placeholder="Bobot Maksimal"  data-id="${subNumber}" data-key="${elementKey}" data-subkey="${subElementKey}" 
                                            data-field="maxAssesment"
                                            step="0.1" required value="${bobotMaks}">
                                        </td>
                                        <td style="word-wrap: break-word; white-space: normal;">
                                            ${filesHtml}
                                        </td>
                                    </tr>`;
                        subNumber++;
                    }

                    appendHtml += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    subCounter++;
                }

                if (totalData === 0) {
                    appendHtml = `
                        <div class="accordion-item">
                            <div class="accordion-header text-center" colspan="4">Tidak ada data.</div>
                        </div>
                    `;
                    $('#countPage').text("0 - 0");
                }
                // Tambahkan tombol simpan di luar loop
                $('#accordionExample').after(`
                    <div class="text-center mt-5 mb-3">
                        <button class="btn px-4 py-2 fw-bold w-100 text-white simpan" style="border-radius: 8px;background: linear-gradient(90deg, rgb(4 132 38) 0%, rgb(69 184 85) 100%);">
                            Simpan Semua Perubahan
                        </button>
                    </div>
                `);

                $('#accordionExample').html(appendHtml);

            }
        }

        async function handleTextAccordion() {
            $(document).on("click", ".edit-icon", function() {
                let key = $(this).data("key");
                let titleText = $(`.title-text[data-key='${key}']`);
                let titleIconFile = $(`.title-icon-file[data-key='${key}']`);
                let textArea = $(`.edit-accordion-title[data-key='${key}']`);

                titleText.hide();
                titleIconFile.hide();
                $(this).hide();
                textArea.show().focus();
            });

            // $(document).on("blur", ".edit-accordion-title", function() {
            //     let key = $(this).data("key");
            //     let newTitle = $(this).val();
            //     let titleText = $(`.title-text[data-key='${key}']`);
            //     let titleIconFile = $(`.title-icon-file[data-key='${key}']`);
            //     let editIcon = $(`.edit-icon[data-key='${key}']`);

            //     let subCounter = titleText.text().split(". ")[0];
            //     let updatedTitle = `${subCounter}. ${newTitle}`;

            //     titleText.text(updatedTitle).show();
            //     editIcon.show();
            //     titleIconFile.show();
            //     $(this).hide();

            //     // elements[key].title = newTitle;
            //     // console.log("Title updated:", newTitle);
            // });
            $(document).on("blur", ".edit-accordion-title", function() {
                let key = $(this).data("key");
                let newTitle = $(this).val().trim();
                let titleText = $(`.title-text[data-key='${key}']`);
                let titleIconFile = $(`.title-icon-file[data-key='${key}']`);
                let editIcon = $(`.edit-icon[data-key='${key}']`);

                if (newTitle !== "") {
                    let subCounter = titleText.text().split(". ")[0]; // Ambil angka sebelum titik
                    let updatedTitle = `${subCounter}. ${newTitle}`;
                    titleText.text(updatedTitle);
                }

                titleText.show();
                editIcon.show();
                titleIconFile.show();
                $(this).hide();

            });
        }

        function getTitleValue(key) {
            let textArea = $(`.edit-accordion-title[data-key='${key}']`);
            let titleText = $(`.title-text[data-key='${key}']`);

            let rawTitle = textArea.is(":visible") ? textArea.val().trim() : titleText.text().trim();
            let updatedTitle = rawTitle.replace(/^\d+\.\s*/, "");

            return updatedTitle;
        }

        async function editData() {
            $(document).on("click", ".simpan", async function() {
                let editedData = {
                    question_schema: {
                        properties: {}
                    },
                    ui_schema: {},
                    max_assesment: {}
                };

                let orderCounter = {}; // Menyimpan counter untuk urutan setiap key

                $(".edit-textarea").each(function() {
                    let key = $(this).data("key");
                    let subkey = $(this).data("subkey");
                    let field = $(this).data("field");
                    let value = $(this).val();
                    let type = $(this).data("type") || "string";
                    let format = $(this).data("format") || "data-url";

                    let namaElement = getTitleValue(key);

                    // Inisialisasi jika belum ada
                    if (!editedData.question_schema.properties[key]) {
                        editedData.question_schema.properties[key] = {
                            type: "object",
                            title: namaElement,
                            required: [],
                            properties: {}
                        };
                    }

                    let cleanTitle = subkey.replace(/_/g, ' ').replace(/\s\d+(\s\d+)*$/, '');

                    if (!editedData.question_schema.properties[key].properties[subkey]) {
                        editedData.question_schema.properties[key].properties[subkey] = {
                            title: cleanTitle,
                            description: cleanTitle,
                            type: "array",
                            items: {
                                type: "object",
                                properties: {}
                            }
                        };
                    }

                    editedData.question_schema.properties[key].required = Object.keys(
                        editedData.question_schema.properties[key].properties
                    );

                    if (type === "array" && field === "file_name_array") {
                        let itemData = [];
                        $('.documentAttachments').each(function(attachmentIndex) {
                            let attachmentName = $(this).val();
                            let attachmentId = generateSequentialId(attachmentName,
                                `${attachmentIndex}`);

                            itemData.push({
                                [attachmentId]: {
                                    name: attachmentName,
                                    type: "string",
                                    format: "data-url",
                                }
                            });
                        });

                        editedData.question_schema.properties[key].properties[subkey].items = itemData;
                        editedData.question_schema.properties[key].properties[subkey].type =
                            'array';
                        delete editedData.question_schema.properties[key].properties[subkey].format;
                    } else {
                        editedData.question_schema.properties[key].properties[subkey][field] =
                            value;
                        editedData.question_schema.properties[key].properties[subkey].type =
                            'string';
                        editedData.question_schema.properties[key].properties[subkey].format =
                            format;
                        delete editedData.question_schema.properties[key].properties[subkey].items;
                    }

                    // Inisialisasi ui_schema jika belum ada
                    if (!editedData.ui_schema[key]) {
                        editedData.ui_schema[key] = {};
                        orderCounter[key] = 0; // Set order mulai dari 0
                    }

                    // Pastikan `ui:order` selalu berurutan dari 0
                    editedData.ui_schema[key][subkey] = {
                        "ui:widget": "file",
                        "ui:options": {
                            "accept": ".pdf"
                        },
                        "ui:order": orderCounter[key]++ // Gunakan dan naikkan orderCounter[key]
                    };

                    Object.keys(editedData.ui_schema).forEach(key => {
                        let orderCounter = 0; // Reset setiap element_X
                        Object.keys(editedData.ui_schema[key]).forEach(subkey => {
                            editedData.ui_schema[key][subkey]["ui:order"] =
                                orderCounter++;
                        });
                    });
                });

                $(".maxAssesment").each(function() {
                    let key = $(this).data("key");
                    let subkey = $(this).data("subkey");
                    let value = $(this).val();

                    if (!editedData.max_assesment[key]) {
                        editedData.max_assesment[key] = {};
                    }

                    editedData.max_assesment[key][subkey] = parseFloat(value) > 0 ? value : "5";
                });

                let formData = {
                    id: referenceId,
                    title: titleElement,
                    element_properties: editedData
                };

                // // Kirim data ke API
                let postDataRest = await CallAPI(
                    'POST',
                    `{{ url('') }}/api/internal/admin-panel/smk-element/update`,
                    formData
                );

                if (postDataRest.status == 200 || postDataRest.status == 201) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pemberitahuan',
                        text: 'Data berhasil diperbarui!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = `/admin/element-smk/list`;
                    });
                }
            });
        }

        function sanitizeSelectorName(name) {
            // Menghilangkan karakter yang tidak valid untuk CSS selector dan mengganti spasi dengan underscore
            return name.replace(/[^a-zA-Z0-9-_]/g, "_");
        }

        function generateSequentialId(baseName, index) {
            // Menggabungkan nama yang disanitasi dengan indeks untuk menjaga ID tetap unik dan terurut
            return `${sanitizeSelectorName(baseName)}_${index}`;
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(referenceId),
                handleTextAccordion(),
                editData()
                // initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch),
            ]);
        }
    </script>
    @include('Administrator.partial-js')
@endsection
