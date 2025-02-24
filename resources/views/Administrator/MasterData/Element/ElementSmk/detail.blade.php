@extends('...Administrator.index', ['title' => 'Detail Data Element SMK'])
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
                        <li class="breadcrumb-item" aria-current="page">Detail Data Element SMK</li>
                    </ul>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="page-header-title">
                        <h2 class="mb-0">Detail Data Element SMK</h2>
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

        let queryString         = window.location.search;
        let urlParams           = new URLSearchParams(queryString);
        let referenceId         = urlParams.get('id');

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
                let data = getDataRest.data.data.element_properties;
                let elements = data.question_schema.properties;
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
                                    <i class="fa-regular fa-file-lines me-2"></i>
                                    <span class="fw-bold me-2 me-lg-0">${subCounter + 1}. ${element.title}</span>
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

                                    let filesHtml = '';

                                    // Handle type "array"
                                    if (detail.type === "array" && Array.isArray(detail.items)) {
                                        let itemObjects = detail.items;
                                        for (let item of itemObjects) {
                                            // Loop through dynamic keys in each item
                                            for (let key in item) {
                                                if (item[key].name) {
                                                    filesHtml += `<li>${item[key].name}</li>`;
                                                }
                                            }
                                        }
                                        filesHtml = `<ul>${filesHtml}</ul>`;
                                    } else if (detail.type === "string") {
                                        // Handle type "string"
                                        filesHtml = detail.attachmentName || '-';
                                    }

                                    appendHtml += `
                            <tr>
                                <td>${subCounter + 1}.${subNumber}</td>
                                <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${detail.title || ''}</td>
                                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">${detail.description || ''}</td>
                                <td style="word-wrap: break-word; white-space: normal; max-width: 300px;">${filesHtml}</td>
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

                $('#accordionExample').html(appendHtml);

            }
        }

        async function initPageLoad() {
            await Promise.all([
                getListData(referenceId),
                // initDataOnTable(defaultLimitPage, currentPage, defaultAscending, defaultSearch),
            ]);
        }
    </script>
    @include('Administrator.partial-js')
@endsection
