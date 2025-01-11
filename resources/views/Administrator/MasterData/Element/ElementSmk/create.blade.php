@extends('...Administrator.index', ['title' => 'Tambah Element SMK | Master Data Element'])

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/element-smk/list">Master Data Elemen</a></li>
                        <li class="breadcrumb-item" aria-current="page">Tambah Data Element SMK</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Tambah Data Element SMK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="form-data" class="mt-3">
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-add" id="add-element">Tambah Element</button>
            <button type="submit" class="btn btn-success" id="submit-button">Simpan</button>
        </div>
    </form>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let fileDokumenSuratPermohonan = '';
        let queryString = window.location.search;
        let urlParams = new URLSearchParams(queryString);
        let referenceId = urlParams.get('id');
        let uuid_patterns = {
            1: /^[0-9A-F]{8}-[0-9A-F]{4}-1[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i,
            2: /^[0-9A-F]{8}-[0-9A-F]{4}-2[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i,
            3: /^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i,
            4: /^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,
            5: /^[0-9A-F]{8}-[0-9A-F]{4}-5[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i
        };

        function randomNumber() {
            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        }

        function guidGenerator() {
            return (
                randomNumber() +
                randomNumber() +
                "-" +
                randomNumber() +
                "-" +
                randomNumber()
            ).toString();
        }

        function htmlElement(value = "") {
            let elementID = guidGenerator();
            let elementNumber = $(".smk-element").length + 1;

            let $template = $(
                `
        <div class="card smk-element mt-2 mb-5" id="${elementID}" style="box-shadow: 0px -1px 5px 1px rgba(56,65,74,.15);">
            ` +
                htmlElementHeader(elementID, elementNumber) +
                `
            ` +
                htmlElementBody(elementID) +
                `
        </div>
    `
            );

            return $template.prop("outerHTML");
        }

        function htmlElementHeader(elementID, elementNumber) {
            let $template = $(`
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="card-title mb-0">
                        Elemen <span class="text-secondary element-number">${elementNumber}</span>
                    </h6>
                </div>
                <div class="flex-shrink-0">
                    <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                        <li class="list-inline-item">
                            <a class="align-middle minimize-card"
                                data-bs-toggle="collapse"
                                href="#collapseElement${elementID}"
                                role="button"
                                aria-expanded="true"
                                aria-controls="collapseElement${elementID}">
                                <i class="mdi mdi-plus align-middle plus"></i>
                                <i class="mdi mdi-minus align-middle minus"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <button type="button" class="btn-close fs-10 align-middle remove-element"></button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    `);

            return $template.prop("outerHTML");
        }

        function htmlElementBody(elementID) {
            let $template = $(`
        <div class="card-body collapse show" id="collapseElement${elementID}">
            <div class="mb-3">

                <label for="elementName${elementID}" class="form-label">
                    Nama Elemen
                </label>
                <input type="text" class="form-control element-name"
                    placeholder="Nama Element"
                    id="elementName${elementID}"
                    required>
            </div>

            <div class="mb-3">
                <label for="elementDescription${elementID}" class="form-label">
                    Deskripsi Element
                </label>
                <input type="text" class="form-control element-description"
                    placeholder="Deskripsi Element"
                    id="elementDescription${elementID}"
                    required>
            </div>

            ${htmlSubElement(elementID)}

            <div class="text-end">
                <button type="button" class="btn btn-primary add-sub-element">
                    Tambah Sub Element
                </button>
            <div>
        </div>
    `);

            return $template.prop("outerHTML");
        }

        function htmlSubElement(elementID) {
            let countSubElement = $(`#${elementID}`).find(".sub-element").length + 1;
            let subElementID = `${elementID}-${guidGenerator()}`;

            let $template = $(`
            <div class="card sub-element my-4" id="${subElementID}" style="box-shadow: 0px -1px 5px 1px rgba(56,65,74,.15);">
                ${htmlSubElementHeader(subElementID, countSubElement)}

                <div class="card-body collapse show" id="collapseElement${subElementID}">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="${subElementID}-subElementName" class="form-label">
                                Nama Sub Elemen
                            </label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control subElementName"
                                placeholder="Sub elemen"
                                id="${subElementID}-subElementName"
                                value=""
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="${subElementID}-subElementType" class="form-label">
                                Tipe Sub Elemen
                            </label>
                        </div>
                        <div class="col-9">
                            <select class="form-select subElementType" aria-label="Tipe Sub Elemen"
                                id="${subElementID}-subElementType" required>
                                <option value="">Pilih Tipe Sub Elemen </option>
                                <option value="multiple_files">Upload Multiple File</option>
                                <option value="file">Upload File</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="${subElementID}-subElementDescription" class="form-label">
                                Deskripsi
                            </label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control subElementDescription"
                                placeholder="Deskripsi sub elemen"
                                id="${subElementID}-subElementDescription"
                                step="0.1"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="${subElementID}-maxAssesment" class="form-label">
                                Bobot Maksimal
                            </label>
                        </div>
                        <div class="col-9">
                            <input type="number" class="form-control maxAssesment"
                                placeholder="Bobot Maksimal"
                                id="${subElementID}-maxAssesment"
                                step="0.1"
                                required>
                        </div>
                    </div>
                </div>
            </div>
        `);

            return $template.prop("outerHTML");
        }

        function htmlSubElementHeader(elementID, subElementNumber) {
            let $template = $(`
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">
                                <i class="ri-gift-line align-middle me-1 lh-1"></i>
                                Sub Elemen <span class="text-secondary sub-element-number">${subElementNumber}</span>
                            </h6>
                        </div>
                        <div class="flex-shrink-0">
                            <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                <li class="list-inline-item">
                                    <a class="align-middle minimize-card"
                                        data-bs-toggle="collapse"
                                        href="#collapseElement${elementID}"
                                        role="button"
                                        aria-expanded="true"
                                        aria-controls="collapseElement${elementID}">
                                        <i class="mdi mdi-plus align-middle plus"></i>
                                        <i class="mdi mdi-minus align-middle minus"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <button type="button" class="btn-close fs-10 align-middle remove-sub-element"></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            `);

            return $template.prop("outerHTML");
        }

        // add smk element
        $("#submit-button").hide();

        // Fungsi untuk menambahkan elemen baru
        $("#add-element").on("click", function() {
            // Tambahkan elemen baru (misalnya input text) sebelum tombol tambah
            $(htmlElement()).insertBefore($(this));

            // Cek jika ada elemen dengan class .smk-element
            reorderElementNumbering();
        });

        // Remove smk element
        $(document).on("click", ".remove-element", async function() {
            await $(this).parents(".smk-element").remove();

            reorderElementNumbering();
        });

        // add smk sub element
        $(document).on("click", ".add-sub-element", function() {
            let elementID = $(this).parents(".smk-element").attr("id");

            $(htmlSubElement(elementID)).insertBefore($(this).parent());
        });

        // remove smk sub element
        $(document).on("click", ".remove-sub-element", async function() {
            let parentID = $(this).parents(".smk-element").attr("id");
            await $(this).parents(".sub-element").remove();

            reorderSubElementNumbering(parentID);
        });

        function reorderElementNumbering() {
            const elements = $(`.smk-element`);

            // Update numbering
            elements.each(function(index) {
                $(this)
                    .find(".element-number")
                    .text(index + 1);
            });

            if (elements.length < 1) {
                $("#submit-button").hide();
            } else {
                $("#submit-button").show();
            }
        }

        function reorderSubElementNumbering(elementID) {
            $(`#${elementID}`)
                .find(`.sub-element`)
                .each(function(index) {
                    $(this)
                        .find(".sub-element-number")
                        .text(index + 1);
                });
        }

        function htmlAttachmentFile(isFirstElement = false, isMultiple = false) {
            let $template = $(`
                <div class="row mb-3 attachmentFiles">
                    <div class="col-3">
                        <label class="form-label">
                            Dokumen yang dilampirkan
                        </label>
                    </div>
                    <div class="col-9">
                        ${htmlAttachmentFileInput(isFirstElement, isMultiple)}
                    </div>
                </div>
            `);

            return $template.prop("outerHTML");
        }

        function htmlAttachmentFileInput(isFirstElement, isMultiple) {
            let buttonRemove =
                `<button class="btn btn-danger remove-attachment d-flex align-items-center justify-content-center" type="button" style="margin-left: 10px;">
            <em class="fa fa-trash fa-lg"></em>
        </button>`;
            let buttonAdd =
                `<button class="btn btn-primary add-attachment d-flex align-items-center justify-content-center" type="button" style="margin-left: 10px;">
            <em class="fa fa-plus fa-lg"></em>
        </button>`;

            let $template = $(`
        <div class="row mb-3 align-items-center">
            <div class="col-12 d-flex">
                <input type="text" class="form-control documentAttachments"
                    placeholder="Dokumen yang dilampirkan"
                    style="width: 80%;"
                    required>
                ${isMultiple ? buttonAdd : ""}
                ${!isFirstElement ? buttonRemove : ""}
            </div>
        </div>
    `);

            return $template.prop("outerHTML");
        }

        // trigger for change input type
        $(document).on("change", ".subElementType", function() {
            const inputType = $(this).val(),
                parentID = $(this).parent().parent().parent().attr("id");

            $(`#${parentID}`).find(".attachmentFiles").remove();

            if (inputType === "multiple_files" || inputType === "file") {
                let isMultiple = false;
                if (inputType === "multiple_files") {
                    isMultiple = true;
                }
                $(`#${parentID}`).append(htmlAttachmentFile(true, isMultiple));
            }
        });

        $(document).on("click", ".add-attachment", function() {
            $(this)
                .parent()
                .parent()
                .parent()
                .append(htmlAttachmentFileInput(false, true));
        });

        $(document).on("click", ".remove-attachment", function() {
            $(this).parent().parent().remove();
        });


        // async function submitElement(e) {
        //     // Attach form submit event
        //     $('#form-data').on('submit', async function(e) {
        //         e.preventDefault();
        //         let smkElements = await generateSchema();

        //         let uniqueTitle = `smk_elements_${Date.now()}`;


        //         let formData = {
        //             title: uniqueTitle,
        //             element_properties: smkElements
        //         };


        //         loadingPage(true);
        //         CallAPI('POST',
        //                 `{{ env('ESMK_SERVICE_BASE_URL') }}/internal/admin-panel/smk-element/create`,
        //                 formData)
        //             .then(response => {
        //                 if (response.status === 201) {
        //
        //                     notificationAlert('success', 'Pemberitahuan', response.data.message);
        //                 }
        //             })
        //             .catch(error => {
        //               // Hide loading in case of an error
        //                 const resp = error.response;

        //                 notificationAlert('info', 'Pemberitahuan', resp ? resp.message :
        //                     'Terjadi kesalahan');
        //             });
        //     });
        // }

        function sanitizeSelectorName(name) {
            // Menghilangkan karakter yang tidak valid untuk CSS selector dan mengganti spasi dengan underscore
            return name.replace(/[^a-zA-Z0-9-_]/g, "_");
        }

        function generateSequentialId(baseName, index) {
            // Menggabungkan nama yang disanitasi dengan indeks untuk menjaga ID tetap unik dan terurut
            return `${sanitizeSelectorName(baseName)}_${index}`;
        }

        async function generateSchema() {
            let questionSchema = {},
                uiSchema = {},
                maxAssesmentValue = {};

            questionSchema["properties"] = {};

            let smkElements = $(".smk-element");

            // Iterasi elemen utama sesuai urutan di DOM
            smkElements.each(function(index) {
                let element = $(this);

                // Generate unique ID menggunakan indeks
                let uniqueId = generateSequentialId("element", index);
                let elementName = uniqueId;

                // Use user input for title and description
                let elementTitle = element.find(".element-name").val();
                let elementDescription = element.find(".element-description").val();

                questionSchema["properties"][elementName] = {
                    type: "object",
                    title: elementTitle,
                    description: elementDescription,
                    required: [],
                    properties: {},
                };

                uiSchema[elementName] = {};
                maxAssesmentValue[elementName] = {};

                let subElements = element.find(".sub-element");

                let orderCounter = 0; // Explicit order counter to track positions accurately

                // Iterasi sub-elemen sesuai urutan di DOM
                subElements.each(function(subIndex) {
                    let subElement = $(this);

                    // Generate unique ID untuk sub-element menggunakan kombinasi indeks utama dan sub-indeks
                    let subElementName = subElement.find(".subElementName").val();
                    let uniqueSubElementId = generateSequentialId(subElementName,
                        `${index}_${subIndex}`);

                    // Use user input for title and description
                    let subElementDescription = subElement.find(".subElementDescription").val();
                    let subElementType = subElement.find(".subElementType").val();
                    let subElementMaxAssesment = subElement.find(".maxAssesment").val();

                    let subElementProperties = {};
                    let UIProperty = {};
                    let dataType, dataFormat, dataItems = undefined,
                        dataAttachment;

                    if (subElementType === "multiple_files") {
                        dataType = "array";
                        let itemData = [];

                        subElement.find(".documentAttachments").each(function(attachmentIndex) {
                            let attachmentName = $(this).val();
                            let attachmentId = generateSequentialId(attachmentName,
                                `${index}_${subIndex}_${attachmentIndex}`);

                            itemData.push({
                                [attachmentId]: {
                                    name: attachmentName,
                                    type: "string",
                                    format: "data-url",
                                },
                            });
                        });

                        dataItems = itemData;

                        UIProperty = {
                            "ui:widget": "files",
                            "ui:options": {
                                accept: ".pdf",
                            },
                        };
                    } else if (subElementType === "file") {
                        dataType = "string";
                        dataFormat = "data-url";

                        let attachmentName = subElement.find(".documentAttachments").val();
                        let attachmentId = generateSequentialId(attachmentName, `${index}_${subIndex}`);

                        dataAttachment = attachmentName;

                        UIProperty = {
                            "ui:widget": "file",
                            "ui:options": {
                                accept: ".pdf",
                            },
                        };
                    } else if (subElementType === "image") {
                        dataType = "string";
                        dataFormat = "data-url";

                        UIProperty = {
                            "ui:widget": "photo",
                            "ui:options": {
                                accept: ".jpg, .jpeg, .png",
                            },
                        };
                    } else if (subElementType === "text") {
                        dataType = "string";
                        UIProperty = {
                            "ui:widget": "text",
                        };
                    }

                    subElementProperties = {
                        title: subElementName,
                        description: subElementDescription,
                        type: dataType,
                        format: dataFormat,
                        attachmentName: dataAttachment,
                        items: dataItems,
                    };

                    questionSchema["properties"][elementName]["properties"][
                        uniqueSubElementId
                    ] = subElementProperties;

                    questionSchema["properties"][elementName]["required"].push(
                        uniqueSubElementId
                    );

                    UIProperty["ui:order"] = orderCounter++; // Explicitly track order incrementally
                    uiSchema[elementName][uniqueSubElementId] = UIProperty;
                    maxAssesmentValue[elementName][uniqueSubElementId] = subElementMaxAssesment;
                });
            });

            return {
                question_schema: questionSchema,
                ui_schema: uiSchema,
                max_assesment: maxAssesmentValue,
            };
        }





        function stringToCamelCase(string) {
            let arrayString = string.split(" ");
            let arrayResult = [];

            arrayString.map((word) => {
                if (word !== "") {
                    if (arrayString.indexOf(word) === 0) {
                        arrayResult.push(word[0].toLowerCase() + word.substring(1));
                    } else {
                        arrayResult.push(word[0].toUpperCase() + word.substring(1));
                    }
                }
            });

            let result = arrayResult.join(""),
                removeComa = result.replaceAll(",", ""),
                removeOpenParenthesis = removeComa.replaceAll("(", ""),
                removeCloseParenthesis = removeOpenParenthesis.replaceAll("(", "");

            return removeCloseParenthesis;
        }

        // async function initPageLoad() {
        //     await Promise.all([
        //         submitElement(),
        //     ]);
        // }

        $(document).ready(async function() {
            // Inisialisasi halaman
            loadingPage(true);

            loadingPage(false)
            await initPageLoad();



            // Attach event listener untuk submit
            $('#form-data').off('submit').on('submit', async function(e) {
                e.preventDefault(); // Mencegah reload halaman

                    // Generate schema dari elemen yang ada
                    let smkElements = await generateSchema();

                    // Membuat judul unik
                    let uniqueTitle = `smk_elements_${Date.now()}`;

                    // Menggabungkan data form
                    let formData = {
                        title: uniqueTitle,
                        element_properties: smkElements
                    };
                    
                    const postDataRest = await CallAPI(
                        'POST',
                        `{{ env("SERVICE_BASE_URL") }}/internal/admin-panel/smk-element/create`,
                        formData
                    ).then(function(response) {
                        return response;
                    }).catch(function(error) {
                        loadingPage(false);
                        let resp = error.response;
                        notificationAlert('warning', 'Pemberitahuan', resp.data.message);
                        return resp;
                    });
    
                    if (postDataRest.status == 200 || postDataRest.status == 201) {
                        loadingPage(false);
                        $("form").find("input, select, textarea").val("").prop("checked", false)
                            .trigger("change");
                        Swal.fire({
                            icon: 'success',
                            title: 'Pemberitahuan',
                            text: 'Data berhasil disimpan!',
                            confirmButtonText: 'OK'
                        }).then(async () => {
                            window.location.href = `/admin/element-smk/list`; 
                        });
                    }
                    

            });
        });

        // Fungsi initPageLoad untuk inisialisasi halaman
        async function initPageLoad() {
            console.log('Halaman berhasil dimuat.');
        }
    </script>
@endsection
