<script>
    async function manipulationDataTable(paramsTable = {}, idPagination = '#pagination', limitPage = '#limitPage',
        searchInput = '#searchInput', dataFetcher, enableCustomFilter = false, customFilter = "#custom-filter") {
        // Default table parameters
        paramsTable = {
            defaultLimitPage: paramsTable.defaultLimitPage || 10,
            currentPage: paramsTable.currentPage || 1,
            totalPage: paramsTable.totalPage || 0,
            defaultAscending: paramsTable.defaultAscending || 1,
            defaultSearch: paramsTable.defaultSearch || '',
            filter: paramsTable.filter || {},
        };

        $(document).on("change", `${limitPage}`, async function() {
            paramsTable.defaultLimitPage = parseInt($(this).val());
            paramsTable.currentPage = 1;
            await initDataOnTable(paramsTable, idPagination, dataFetcher);
        });

        async function performSearch() {
            paramsTable.defaultSearch = $(`${searchInput}`).val().trim();
            paramsTable.currentPage = 1;
            await initDataOnTable(paramsTable, idPagination, dataFetcher);
        }

        $(document).on("input", `${searchInput}`, debounceSearch(performSearch, 500));

        async function paginationDataOnTable(paramsTable = {}, idPagination = '#paginationJs') {
            $(`${idPagination}`).pagination({
                dataSource: Array.from({
                    length: paramsTable.totalPage
                }, (_, i) => i + 1),
                pageSize: paramsTable.defaultLimitPage,
                className: 'paginationjs-theme-blue',
                afterPreviousOnClick: async function(e) {
                    paramsTable.currentPage = parseInt(e.currentTarget.dataset.num);
                    await dataFetcher(paramsTable);
                },
                afterPageOnClick: async function(e) {
                    paramsTable.currentPage = parseInt(e.currentTarget.dataset.num);
                    await dataFetcher(paramsTable);
                },
                afterNextOnClick: async function(e) {
                    paramsTable.currentPage = parseInt(e.currentTarget.dataset.num);
                    await dataFetcher(paramsTable);
                },
            });
        }

        async function customFilterTable() {
            $(document).on("submit", `${customFilter}`, async function(e) {
                e.preventDefault();
                paramsTable.defaultLimitPage = $(`${limitPage}`).val();
                paramsTable.currentPage = 1;
                paramsTable.defaultAscending = 1;
                paramsTable.defaultSearch = $(`${searchInput}`).val();

                let formData = $(`${customFilter}`).serializeArray();
                formData.map(function(el) {
                    paramsTable.filter[el.name] = el.value;
                });

                await initDataOnTable(paramsTable, idPagination, dataFetcher);
            });

            $(document).on("click", "#resetCustomFilter", async function() {
                $(`${customFilter} input, ${customFilter} select, ${customFilter} textarea`).val('')
                    .prop('checked', false).prop('selected', false).trigger('change');
                await $(`${searchInput}`).val('');

                paramsTable.defaultLimitPage = $(`${limitPage}`).val();
                paramsTable.currentPage = 1;
                paramsTable.defaultAscending = 1;
                paramsTable.defaultSearch = '';
                paramsTable.filter = {}; // Clear filter

                await initDataOnTable(paramsTable, idPagination, dataFetcher);
            });
        }

        // Initialize table data and pagination
        async function initDataOnTable(paramsTable, idPagination, dataFetcher) {
            await dataFetcher(paramsTable);
            await paginationDataOnTable(paramsTable, idPagination);
        }

        // Call init function for first load
        await initDataOnTable(paramsTable, idPagination, dataFetcher);

        // Initialize custom filter only if enabled
        if (enableCustomFilter) {
            await customFilterTable();
        }
    }

    function debounceSearch(func, wait, immediate) {
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

    function formatTanggalIndo(dateString) {
        const date = new Date(dateString);
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return new Intl.DateTimeFormat('id-ID', options).format(date);
    }

    function nl2br(str) {
        return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
    }
</script>
